<?php

class M_users extends CI_Model
{
	private $_table = 'tbl_user';

	public function list()
	{
		return $this->db->get($this->_table)->result();
	}

	public function detail($id)
	{
		return $this->db->get_where($this->_table, array('tbl_user_id' => $id));
	}

	public function save()
	{
		$isactive = $this->input->post('isuser');
		$post = $this->input->post();
		$this->createdby = $this->session->userdata('userid');
		$this->updatedby = $this->session->userdata('userid');
		$this->value = $post['username'];
		$this->name = $post['name'];
		$this->password = password_hash($post['password'], PASSWORD_BCRYPT);
		$this->level = $post['level'];
        if (isset($isactive)) {
            $this->isactive = 'Y';
        } else {
            $this->isactive = 'N';
        }
		$this->db->insert($this->_table, $this);
	}

	public function update()
	{
		$isactive = $this->input->post('isuser');
		$post = $this->input->post();
		$this->updatedby = $this->session->userdata('userid');
		$this->value = $post['username'];
		$this->name = $post['name'];
		if (!empty($post['password'])) {
			$this->password = password_hash($post['password'], PASSWORD_BCRYPT);
			$this->changedpassword = date('Y-m-d H:i:s');
		}
		$this->level = $post['level'];
        if (isset($isactive)) {
            $this->isactive = 'Y';
        } else {
            $this->isactive = 'N';
        }
        $this->updated = date('Y-m-d H:i:s');
        $where = array('tbl_user_id' => $post['id_user']);
		$this->db->where($where);
		$this->db->update($this->_table, $this);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('tbl_user_id' => $id));
	}

	public function checkLogin($post)
	{
		$this->db->where('value =', $post['username']);
		$sql = $this->db->get($this->_table)->row();
		if($sql) {
			// cek password
			$isPasswordTrue = password_verify($post['password'], $sql->password);
			if($isPasswordTrue) {
				$params = array(
					'userid'	=> $sql->tbl_user_id,
					'value'		=> $sql->value,
					'name'		=> $sql->name,
					'level'		=> $sql->level
				);
				$this->session->set_userdata($params);
				$this->updateLastLogin($sql->tbl_user_id);
				return true;
			}		
		}
		return false;
	}

	private function updateLastLogin($user_id) 
	{
		$sql = "UPDATE {$this->_table} SET lastlogin = now() WHERE tbl_user_id = {$user_id}";
		$this->db->query($sql);
	}

	public function updatePass($post)
	{
		$this->password = password_hash($post['pass_new'], PASSWORD_BCRYPT);
		$this->updated = date('Y-m-d H:i:s');
		$this->updatedby = $post['id_user'];
		$this->changedpassword = date('Y-m-d H:i:s');
		$where = array('tbl_user_id' => $post['id_user']);
		$this->db->where($where);
		$this->db->update($this->_table, $this);
	}
}