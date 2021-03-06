<?php

class M_institute extends CI_Model
{
	private $_table = 'tbl_instansi';

	public function list()
	{
		return $this->db->get($this->_table)->result();
	}

	public function detail($id)
	{
		return $this->db->get_where($this->_table, array('tbl_instansi_id' => $id));
	}

	public function save()
	{
		$isactive = $this->input->post('isinsti');
		$post = $this->input->post();
		$this->createdby = $this->session->userdata('userid');
		$this->updatedby = $this->session->userdata('userid');
		$this->value = $post['code_ins'];
		$this->name = $post['name_ins'];
		$this->address = $post['address_ins'];
		$this->email = $post['email_ins'];
		$this->phone = $post['phone_ins'];
		$this->budget = changeFormat($post['budget_ins']);
        if (isset($isactive)) {
            $this->isactive = 'Y';
        } else {
            $this->isactive = 'N';
        }
		$this->db->insert($this->_table, $this);
	}

	public function update()
	{
		$isactive = $this->input->post('isinsti');
		$post = $this->input->post();
		$this->updatedby = $this->session->userdata('userid');
		$this->value = $post['code_ins'];
		$this->name = $post['name_ins'];
		$this->address = $post['address_ins'];
		$this->email = $post['email_ins'];
		$this->phone = $post['phone_ins'];
		$this->budget = changeFormat($post['budget_ins']);
        if (isset($isactive)) {
            $this->isactive = 'Y';
        } else {
            $this->isactive = 'N';
        }
        $this->updated = date('Y-m-d H:i:s');
        $where = array('tbl_instansi_id' => $post['id_instansi']);
		$this->db->where($where);
		$this->db->update($this->_table, $this);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('tbl_instansi_id' => $id));
	}

	public function generateCode() {		
		$firstCode = "IS"; //karakter depan kodenya
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

   	public function listInstitute()
	{
		$this->db->select('tbl_instansi_id,
							value,
							name,
							isactive');
		$this->db->from($this->_table);
		$this->db->where('isactive', 'Y');
		$this->db->order_by('value', 'ASC');
		$query = $this->db->get()->result();
		return $query;
	}

	public function getTotalBudget($id_institute)
	{
		if (!empty($id_institute)) {
			$this->db->select_sum('budget');
			$this->db->from($this->_table);
			$this->db->where('tbl_instansi_id !=', $id_institute)
					->where('isactive', 'Y');
			return $this->db->get()->row();
		} else {
			$this->db->select_sum('budget');
			$this->db->from($this->_table);
			$this->db->where('isactive', 'Y');
			return $this->db->get()->row();
		}		
	}

	public function totalInstituteBudget($id_institute)
	{
		if (!empty($id_institute)) {
			$this->db->select_sum('budget');
			$this->db->from($this->_table);
			$this->db->where('tbl_instansi_id', $id_institute)
					->where('isactive', 'Y');
			return $this->db->get()->row();
		} else {
			$this->db->select_sum('budget');
			$this->db->from($this->_table);
			$this->db->where('isactive', 'Y');
			return $this->db->get()->row();
		}		
	}
}