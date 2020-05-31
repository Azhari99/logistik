<?php

class M_submenu extends CI_Model
{
	private $_table = 'tbl_submenu';

	public function list()
	{
		$sql = $this->db->query("SELECT sb.tbl_submenu_id,
									sb.name,
									sb.url,
									sb.seqno,
									sb.isactive,
									m.name as name_menu
								FROM tbl_submenu sb
		 						LEFT JOIN tbl_menu m ON sb.tbl_menu_id = m.tbl_menu_id");
		return $sql->result();
	}

	public function save()
	{
		$isactive = $this->input->post('issub');
		$post = $this->input->post();
		$this->createdby = $this->session->userdata('userid');
		$this->updatedby = $this->session->userdata('userid');
		$this->name = $post['name_sub'];
		$this->tbl_menu_id = $post['menu_id'];
		$this->seqno = $post['line_sub'];
		$this->url = $post['url_sub'];
		if (isset($isactive)) {
			$this->isactive = 'Y';
		} else {
			$this->isactive = 'N';
		}
		$this->db->insert($this->_table, $this);
	}

	public function detail($id)
	{
		return $this->db->get_where($this->_table, array('tbl_submenu_id' => $id));
	}

	public function update()
	{
		$isactive = $this->input->post('issub');
		$post = $this->input->post();
		$this->updatedby = $this->session->userdata('userid');
		$this->name = $post['name_sub'];
		$this->tbl_menu_id = $post['menu_id'];
		$this->seqno = $post['line_sub'];
		$this->url = $post['url_sub'];
		if (isset($isactive)) {
			$this->isactive = 'Y';
		} else {
			$this->isactive = 'N';
		}
		$this->updated = date('Y-m-d H:i:s');
		$where = array('tbl_submenu_id' => $post['id_sub']);
		$this->db->where($where);
		$this->db->update($this->_table, $this);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('tbl_submenu_id' => $id));
	}
}
