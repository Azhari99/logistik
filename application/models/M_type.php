<?php

class M_type extends CI_Model
{
	private $_table = 'tbl_jenis_logistik';

	public function list()
	{
		return $this->db->get($this->_table)->result();
	}

	public function detail($id)
	{
		return $this->db->get_where($this->_table, array('tbl_jenis_id' => $id));
	}

	public function save()
	{
		$isactive = $this->input->post('istype');
		$post = $this->input->post();
		$this->createdby = $this->session->userdata('userid');
		$this->updatedby = $this->session->userdata('userid');
		$this->value = $post['code_type'];
		$this->name = $post['name_type'];
        if (isset($isactive)) {
            $this->isactive = 'Y';
        } else {
            $this->isactive = 'N';
        }
		$this->db->insert($this->_table, $this);
	}

	public function update()
	{
		$isactive = $this->input->post('istype');
		$post = $this->input->post();
		$this->updatedby = $this->session->userdata('userid');
		$this->value = $post['code_type'];
		$this->name = $post['name_type'];
        if (isset($isactive)) {
            $this->isactive = 'Y';
        } else {
            $this->isactive = 'N';
        }
        $this->updated = date('Y-m-d H:i:s');
        $where = array('tbl_jenis_id' => $post['id_jenis']);
		$this->db->where($where);
		$this->db->update($this->_table, $this);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('tbl_jenis_id' => $id));
	}

	public function generateCode() {		
		$firstCode = "TL"; //karakter depan kodenya
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

   	public function listType()
	{
		$this->db->select('tbl_jenis_id,
							name,
							isactive');
		$this->db->from($this->_table);
		$this->db->where('isactive', 'Y');
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get()->result();
		return $query;
	}
}