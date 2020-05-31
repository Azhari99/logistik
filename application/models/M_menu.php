<?php

class M_menu extends CI_Model
{
	private $_table = 'tbl_menu';

	public function list()
	{
		return $this->db->get($this->_table)->result();
	}

	public function save()
	{
		$isactive = $this->input->post('ismenu');
		$post = $this->input->post();
		$this->createdby = $this->session->userdata('userid');
		$this->updatedby = $this->session->userdata('userid');
		$this->name = $post['name_menu'];
		$this->seqno = $post['line_menu'];
		$this->url = $post['url_menu'];
		$this->icon = $post['icon_menu'];
		if (isset($isactive)) {
			$this->isactive = 'Y';
		} else {
			$this->isactive = 'N';
		}
		$this->db->insert($this->_table, $this);
	}

	public function detail($id)
	{
		return $this->db->get_where($this->_table, array('tbl_menu_id' => $id));
	}

	public function update()
	{
		$isactive = $this->input->post('ismenu');
		$post = $this->input->post();
		$this->updatedby = $this->session->userdata('userid');
		$this->name = $post['name_menu'];
		$this->seqno = $post['line_menu'];
		$this->url = $post['url_menu'];
		$this->icon = $post['icon_menu'];
		if (isset($isactive)) {
			$this->isactive = 'Y';
		} else {
			$this->isactive = 'N';
		}
		$this->updated = date('Y-m-d H:i:s');
		$where = array('tbl_menu_id' => $post['id_menu']);
		$this->db->where($where);
		$this->db->update($this->_table, $this);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('tbl_menu_id' => $id));
	}

	public function seqno()
	{
		$this->db->select('(count(tbl_menu_id)+1) as no');
		$this->db->from($this->_table);
		$query = $this->db->get()->row();
		return $query;
	}

	public function getMenu()
	{
		$this->db->select('*');
		$this->db->from($this->_table);
		$this->db->where('isactive', 'Y');
		$this->db->order_by('name', 'ASC');
		return $this->db->get()->result();
	}
}
