<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('m_product');
        $this->load->model('m_type');
        $this->load->model('m_category');
        $this->load->model('m_budget');
    }

    public function index() 
    {
        $this->template->load('overview', 'product/vProduct');
    }

    public function getAll() 
    {
        $list = $this->m_product->list();
        $number = 1;
        $data = array();
        foreach ($list as $value) {
            $row = array();
            $currentYear = date('Y');
            $type_id = $value->jenis_id;
            $type = $value->code_type.'-'.$value->type;
            $category = $value->code_category.'-'.$value->category;
            $budgetOut = $this->m_product->productBudgetOut($value->tbl_barang_id, $type_id, $currentYear);
            $row[] = $number++;
            $row[] = $value->value;
            $row[] = $value->name;
            $row[] = $type;
            $row[] = $category;
            if ($type_id != 2) {
                $row[] = $value->qtyentered;
                $row[] = $value->qtyavailable;
                $row[] = rupiah($value->unitprice);
            } else {
                $row[] = "-";
                $row[] = "-";
                $row[] = "-";
            }
            $row[] = rupiah($value->budget - $budgetOut->budget_out);
            $row[] = rupiah($value->budget);
            $row[] = $value->keterangan;
            $row[] = $value->user;
            
            if($value->isactive == 'Y'){
                $row[] = '<center><span class="label label-success">Aktif</span></center>';
            } else {
                $row[] = '<center><span class="label label-danger">Nonaktif</span></center>';
            }

            $row[] = '<center>            
                <a class="btn btn-primary btn-xs" href="product/edit/'.$value->tbl_barang_id.'" title="Edit"><i class="fa fa-edit"></i></a>
            </center>';
            // $row[] = '<center>            
            //     <a class="btn btn-primary btn-xs" href="product/edit/'.$value->tbl_barang_id.'" title="Edit"><i class="fa fa-edit"></i></a>
            //     <a class="btn btn-danger btn-xs"  onclick="deleteProduct('."'".$value->tbl_barang_id."'".')"title="Delete"><i class="fa fa-trash-o"></i></a>
            // </center>';
            $data[] = $row;
        }
        $result = array('data' => $data );
        echo json_encode($result);
    }

    public function add() 
    {   
        $data['type'] = $this->m_type->listType();
        $data['code'] = $this->m_product->generateCode();
    	$this->template->load('overview', 'product/addProduct', $data);
    }

    public function actAdd()
    {
        $post = $this->input->post();
        $this->form_validation->set_rules('name_product','name', 
                                        'required|is_unique[tbl_barang.name]',
                                        array(
                                            'is_unique' => 'This %s already exists.'
                                        ));
        $this->form_validation->set_rules('typelog_product', 'type logistics', 'required');
        $this->form_validation->set_rules('budget_product', 'budget', 'required');

        if ($post['typelog_product'] != 2) { //jika tipe logistik bukan anggaran
            $this->form_validation->set_rules('qty_product', 'limit qty', 'required');
            $this->form_validation->set_rules('unitprice_product', 'unit price', 'required');
        }
        
        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>'); 

        if ($this->form_validation->run() == FALSE) {
            $data['type'] = $this->m_type->listType();
            $data['code'] = $this->m_product->generateCode();
            $this->template->load('overview', 'product/addProduct', $data);
            
        } else {
            $currentYear = date('Y');
            $budget_detail = $this->m_budget->getBudget($post['typelog_product'], $currentYear);
            $typeProduct = $this->m_product->totalTypeBudget(null, $post['typelog_product']);
            if ($budget_detail != null) { //cek set budget in master budget
                $annBudget = $budget_detail->budget;
                $status = $budget_detail->status;
                $year = $budget_detail->tahun;
                $budgetProduct = (changeFormat($post['budget_product']) + $typeProduct->typebudget_total);
                if ($budgetProduct <= $annBudget && $status == 'O') {
                    $this->m_product->save();
                    if ($this->db->affected_rows() > 0) {
                        $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                            'Data berhasil disimpan</div>');
                    }
                    echo "<script>window.location='" . site_url('product') . "';</script>";
                } else {
                    if ($status == 'C') {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                            'Closed period, silahkan buka periode budget '.$year. '!</div>');
                    } else if ($budgetProduct > $annBudget) {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                            'Budget yang dimasukan sudah melebihi anggaran pertahun : '.rupiah($annBudget).'</div>');
                    }
                    echo "<script>window.location='" . site_url('product/add') . "';</script>";
                }
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                    '</button>' .
                    'Silahkan buat budget tahunan terlebih dahulu !</div>');
                echo "<script>window.location='" . site_url('product') . "';</script>";
            }            
        }
    }

    public function edit($id)
    {
        $data['product_id'] = $id;
        $data['type'] = $this->m_type->listType();
        $get_data = $this->m_product->detail($id);
        if ($get_data->num_rows() > 0) {
            $row = $get_data->row_array();
            $data['kategori'] = $row['kategori_id'];
        }
        $this->template->load('overview', 'product/editProduct', $data);
    }

    function get_product_edit()
    {
        $product_id = $this->input->post('product_id');
        $data = $this->m_product->detail($product_id)->result();
        echo json_encode($data);
    }

    public function actEdit()
    {
        $id_barang = $this->input->post('id_barang');
        $isactive = $this->input->post('isproduct');
        $code = $this->input->post('code_product');
        $name = $this->input->post('name_product');
        $desc = $this->input->post('desc_product');
        $category = $this->input->post('category_product');
        $typelog = $this->input->post('typelog_product');
        $qty = $this->input->post('qty_product');
        $unitprice = $this->input->post('unitprice_product');
        $budget = $this->input->post('budget_product');

        $this->form_validation->set_rules('name_product','name','required');
        $this->form_validation->set_rules('typelog_product', 'type logistics', 'required');
        $this->form_validation->set_rules('budget_product', 'budget', 'required');
        if ($typelog != 2) {
            $this->form_validation->set_rules('qty_product', 'limit qty', 'required');
            $this->form_validation->set_rules('unitprice_product', 'unit price', 'required');
        }
        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>'); 

        if ($this->form_validation->run() == FALSE) {
            $data['product_id'] = $id_barang;
            $data['type'] = $this->m_type->listType();
            $get_data = $this->m_product->detail($id_barang);
            if ($get_data->num_rows() > 0) {
                $row = $get_data->row_array();
                $data['kategori'] = $row['kategori_id'];
            }
            $this->template->load('overview', 'product/editProduct', $data);

        } else {
            $currentYear = date('Y');
            $budget_total = $this->m_budget->getBudget($typelog, $currentYear);
            $typeProduct = $this->m_product->totalTypeBudget($id_barang, $typelog);
            if ($budget_total != null) { //cek set budget in master budget
                $annBudget = $budget_total->budget;
                $status = $budget_total->status;
                $year = $budget_total->tahun;
                $budgetProduct = (changeFormat($budget) + $typeProduct->typebudget_total);
                if ($budgetProduct <= $annBudget && $status == 'O') {
                    if (isset($isactive)) {
                        $isactive = 'Y';
                    } else {
                        $isactive = 'N';
                    }
                    if ($typelog == 2) {
                        $qty = $unitprice = 0;
                    }
                    $param = array(
                        'value'         => $code,
                        'name'          => $name,
                        'updatedby'     => $this->session->userdata('userid'),
                        'keterangan'    => $desc,
                        'jenis_id'      => $typelog,
                        'kategori_id'   => $category,
                        'isactive'      => $isactive,
                        'qtyentered'    => $qty,
                        'unitprice'     => changeFormat($unitprice),
                        'budget'        => changeFormat($budget),
                        'updated'       => date('Y-m-d H:i:s')
                    );
                    $where = array('tbl_barang_id' => $id_barang);
                    $this->m_product->update($param, $where);
                    if ($this->db->affected_rows() > 0) {
                        $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                            'Data berhasil diubah</div>');
                    }
                    echo "<script>window.location='" . site_url('product') . "';</script>";
                } else {
                    if ($status == 'C') {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                            'Closed period, silahkan buka periode budget ' . $year . '!</div>');
                    } else if ($budgetProduct > $annBudget) {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                            'Budget yang dimasukan sudah melebihi anggaran pertahun : ' . rupiah($annBudget) . '</div>');
                    }
                    echo "<script>window.location='" . site_url('product/edit/' . $id_barang) . "'</script>";
                }
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                    '</button>' .
                    'Silahkan buat budget tahunan terlebih dahulu !</div>');
                echo "<script>window.location='" . site_url('product') . "';</script>";
            }
            
        }
    }

    public function delete($id)
    {
        $data = $this->m_product->delete($id);
        echo json_encode($data);
    }

    public function getProductType()
    {
        $id = $this->input->post('id');
        $data = $this->m_product->detail($id)->row();
        echo json_encode($data);
    }

    public function getCategory()
    {
        $data = $this->m_category->listCategoryByJenis();
        echo json_encode($data);
    }
}