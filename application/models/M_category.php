<?php

class M_category extends CI_Model
{
	private $_table = 'tbl_kategori';

	public function list()
	{
		$this->db->select('tbl_kategori.tbl_kategori_id,
		                    tbl_kategori.jenis_id,
		                    tbl_kategori.name as kategori,
		                    tbl_jenis_logistik.name as type,
		                    tbl_kategori.value,
		                    tbl_kategori.isactive,
		                    tbl_kategori.isdefault');
		$this->db->from($this->_table);
		$this->db->join('tbl_jenis_logistik', 'tbl_jenis_logistik.tbl_jenis_id = '.$this->_table.'.jenis_id', 'Left');
		$query = $this->db->get()->result();
		return $query;
	}

	public function detail($id)
	{
		return $this->db->get_where($this->_table, array('tbl_kategori_id' => $id));
	}

	public function save()
	{
		$isactive = $this->input->post('iscategory');
		// $isdefault = $this->input->post('isdefault');
		$post = $this->input->post();
		$this->createdby = $this->session->userdata('userid');
		$this->updatedby = $this->session->userdata('userid');
		$this->value = $post['code_cat'];
		$this->name = $post['name_cat'];
		$this->jenis_id = $post['typelog_cat'];
        if (isset($isactive)) {
            $this->isactive = 'Y';
        } else {
            $this->isactive = 'N';
        }
        // if (isset($isdefault)) {
        //     $this->isdefault = 'Y';
        // } else {
        //     $this->isdefault = 'N';
        // }
		$this->db->insert($this->_table, $this);
	}

	public function update()
	{
		$isactive = $this->input->post('iscategory');
		// $isdefault = $this->input->post('isdefault');
		$this->updatedby = $this->session->userdata('userid');
		$post = $this->input->post();
		$this->value = $post['code_cat'];
		$this->name = $post['name_cat'];
		$this->jenis_id = $post['typelog_cat'];
        if (isset($isactive)) {
            $this->isactive = 'Y';
        } else {
            $this->isactive = 'N';
        }        
        // if (isset($isdefault)) {
        //     $this->isdefault = 'Y';
        // } else {
        //     $this->isdefault = 'N';
        // }
        $this->updated = date('Y-m-d H:i:s');
        $where = array('tbl_kategori_id' => $post['id_kategori']);
		$this->db->where($where);
		$this->db->update($this->_table, $this);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('tbl_kategori_id' => $id));
	}

	public function generateCode() {		
		$firstCode = "CA"; //karakter depan kodenya
		$lastCode = ""; //kode awal
        $sql = $this->db->query("SELECT MAX(RIGHT(value,4)) AS maxcode 
        						FROM ".$this->_table);
        
        if( $sql->num_rows() > 0 ) {
            foreach($sql->result() as $value) {
                $intCode = ((int)$value->maxcode) + 1;
                $lastCode = sprintf("%04s", $intCode);
            }

        } else {
            $lastCode = "0001";
        }
        return $firstCode.$lastCode;
   }

   	public function listCategoryByJenis()
	{	
		$id = $this->input->post('id');
		$this->db->select('tbl_kategori_id,
							name,
							isactive,
							isdefault');
		$this->db->from($this->_table);
		$this->db->where('isactive', 'Y');
		$this->db->where('jenis_id', $id);
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get()->result();
		return $query;
	}

	public function listCategory()
	{
		$this->db->select('tbl_kategori_id,
							name,
							isactive');
		$this->db->from($this->_table);
		$this->db->where('isactive', 'Y');
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get()->result();
		return $query;
	}
}