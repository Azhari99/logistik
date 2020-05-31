<?php

class M_budget extends CI_Model
{
	private $_table = 'tbl_anggaran';

	public function list()
	{
		$this->db->select('tbl_anggaran.tbl_anggaran_id,
							tbl_anggaran.name,
							tbl_anggaran.jenis_id,
							tbl_jenis_logistik.name as type,
		                    tbl_anggaran.keterangan,
		                    tbl_anggaran.tahun,
		                    tbl_anggaran.budget,
		                    tbl_anggaran.status,
		                    tbl_anggaran.isactive');
		$this->db->from($this->_table);
		$this->db->join('tbl_jenis_logistik', 'tbl_jenis_logistik.tbl_jenis_id = '.$this->_table.'.jenis_id', 'Left');
		$query = $this->db->get()->result();
		return $query;
	}

	public function save()
	{
		$isactive = $this->input->post('isbudget');
		$post = $this->input->post();
		$this->createdby = $this->session->userdata('userid');
		$this->updatedby = $this->session->userdata('userid');
		$this->name = $post['name_budget'];
		$this->jenis_id = $post['typelog_budget'];
		$this->tahun = $post['year_budget'];
		$this->budget = changeFormat($post['an_budget']);
		$this->keterangan = $post['desc_budget'];
        if (isset($isactive)) {
            $this->isactive = 'Y';
        } else {
            $this->isactive = 'N';
        }
		$this->db->insert($this->_table, $this);
	}

	public function detail($id)
	{
		return $this->db->get_where($this->_table, array('tbl_anggaran_id' => $id));
	}
	
	public function update()
	{
		$isactive = $this->input->post('isbudget');
		$post = $this->input->post();
		$this->updatedby = $this->session->userdata('userid');
		$this->name = $post['name_budget'];
		$this->jenis_id = $post['typelog_budget'];
		$this->tahun = $post['year_budget'];
		$this->budget = changeFormat($post['an_budget']);
		$this->keterangan = $post['desc_budget'];
		if (isset($isactive)) {
			$this->isactive = 'Y';
		} else {
			$this->isactive = 'N';
		}
		$this->updated = date('Y-m-d H:i:s');
        $where = array('tbl_anggaran_id' => $post['id_budget']);
		$this->db->where($where);
		$this->db->update($this->_table, $this);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('tbl_anggaran_id' => $id));
	}

	public function updatePeriode($post)
	{
		$this->status = $post['status'];
		$this->updated = date('Y-m-d H:i:s');
		$where = array('tbl_anggaran_id' => $post['id']);
		$this->db->where($where);
		$this->db->update($this->_table, $this);
	}

	public function checkType($post, $uri)
	{
		if ($uri == 'add' || $uri == 'actAdd') {
			$sql = $this->db->query("SELECT count(a.jenis_id) as type,
									jl.name
									FROM tbl_anggaran a
									LEFT JOIN tbl_jenis_logistik jl ON jl.tbl_jenis_id = a.jenis_id
									WHERE a.tahun = $post[year_budget]
									AND a.jenis_id = $post[typelog_budget]");
		} else {
			$sql = $this->db->query("SELECT count(a.jenis_id) as type,
									jl.name
									FROM tbl_anggaran a
									LEFT JOIN tbl_jenis_logistik jl ON jl.tbl_jenis_id = a.jenis_id
									WHERE a.tahun = $post[year_budget]
									AND a.jenis_id = $post[typelog_budget] 
									AND a.tbl_anggaran_id != $post[id_budget]");
		}
		return $sql->row();
	}

	public function getBudget($id, $currentYear)
	{
		$data = $this->db->get_where($this->_table, array(
			'jenis_id' => $id,
			'tahun' =>  $currentYear
		));
		return $data->row();
	}
	
	public function getAllBudget($currentYear)
	{
		$this->db->select_sum('budget');
		$sql = $this->db->get_where($this->_table, array(
			'tahun' =>  $currentYear
		));		
		return $sql->row();
	}

	public function totalCurrentBudget()
	{
		$currentYear = date('Y');
		$sql = $this->db->query("SELECT sum(a.budget) as total_budget
								FROM tbl_anggaran a
								WHERE a.tahun = $currentYear ");
		return $sql->row();
	}

	public function budgetYear($start, $end)
	{
		$this->db->select_sum('budget');
		$this->db->from($this->_table);
		$this->db->where('tahun BETWEEN "' . $start . '"AND"' . $end . '"');
		$sql = $this->db->get();
		return $sql->row();
	}
}