<?php

use GuzzleHttp\Client;

class M_productout extends CI_Model
{
	private $_table = 'tbl_barangkeluar';
	private $_client;

	public function __construct()
	{
		$this->_client = new Client([
			'base_uri'  => 'http://localhost/rest-api/wpu-rest-server-client/projectinventory/api/'
		]);
	}

	public function list()
	{
		$this->db->select('tbl_barangkeluar.tbl_barangkeluar_id,
							tbl_barangkeluar.documentno,
							tbl_barangkeluar.datetrx,
							tbl_barangkeluar.status,
							tbl_barangkeluar.qtyentered,
							tbl_barangkeluar.amount,
							tbl_barangkeluar.keterangan,
							tbl_barangkeluar.created,
							tbl_barang.value,
							tbl_barang.name,							
							tbl_barang.jenis_id,
							tbl_instansi.value as code_institute,
							tbl_instansi.name as name_institute');
		$this->db->from($this->_table);
		$this->db->join('tbl_barang', 'tbl_barang.tbl_barang_id = ' . $this->_table . '.tbl_barang_id', 'Left');
		$this->db->join('tbl_instansi', 'tbl_instansi.tbl_instansi_id = ' . $this->_table . '.tbl_instansi_id', 'Left');
		$query = $this->db->get()->result();
		return $query;
	}

	public function save($data)
	{
		$this->db->insert($this->_table, $data);
	}

	public function saveApi($dataApi)
	{
		$response = $this->_client->request('POST', 'barangmasuk', [
			'form_params' => $dataApi
		]);

		$result = json_decode($response->getBody()->getContents(), true);

		return $result;
	}

	public function update($data, $where)
	{
		$this->db->where($where);
		$this->db->update($this->_table, $data);
	}

	public function detail($id)
	{
		$this->db->select('tbl_barangkeluar.*,
							tbl_barang.name as barang,
							tbl_barang.jenis_id,
							tbl_instansi.name as instansi');
		$this->db->from($this->_table);
		$this->db->join('tbl_barang', 'tbl_barang.tbl_barang_id = ' . $this->_table . '.tbl_barang_id', 'Left');
		$this->db->join('tbl_instansi', 'tbl_instansi.tbl_instansi_id = ' . $this->_table . '.tbl_instansi_id', 'Left');
		$this->db->where('tbl_barangkeluar_id', $id);
		return $this->db->get();
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('tbl_barangkeluar_id' => $id));
	}

	public function generateCode()
	{
		$firstCode = "POT"; //karakter depan kodenya
		$lastCode = ""; //kode awal
		$separtor = '-';
		$sql = $this->db->query("SELECT MAX(RIGHT(documentno,4)) AS maxcode 
        						FROM " . $this->_table);

		if ($sql->num_rows() > 0) {
			foreach ($sql->result() as $value) {
				$intCode = ((int) $value->maxcode) + 1;
				$lastCode = sprintf("%04s", $intCode);
			}
		} else {
			$lastCode = "0001";
		}
		return $firstCode . $separtor . $lastCode;
	}

	public function totalQtyProduct($id, $datetrx)
	{
		$param = array(
			'tbl_barang_id' => $id,
			'DATE_FORMAT(datetrx, "%Y") =' => $datetrx
		);
		$this->db->select_sum('qtyentered');
		$this->db->where($param);
		$this->db->from($this->_table);
		return $this->db->get()->row();
	}

	public function totalInstituteOut($id_institute, $datetrx)
	{
		$sql = $this->db->query("SELECT sum(bk.amount) as amount
								FROM tbl_barangkeluar bk
								WHERE bk.tbl_instansi_id = $id_institute
								AND YEAR(bk.datetrx) = $datetrx");
		return $sql->row();
	}

	public function totalQtyProductOut($id, $id_product, $datetrx)
	{
		if ($id == null) {
			$sql = $this->db->query("SELECT sum(bk.amount) as amount,
									sum(bk.qtyentered) as qtyentered
									FROM tbl_barangkeluar bk
									WHERE bk.tbl_barang_id = $id_product
									AND YEAR(bk.datetrx) = $datetrx");
		} else {
			$sql = $this->db->query("SELECT sum(bk.amount) as amount,
									sum(bk.qtyentered) as qtyentered
									FROM tbl_barangkeluar bk
									WHERE bk.tbl_barang_id = $id_product
									AND YEAR(bk.datetrx) = $datetrx
									AND bk.tbl_barangkeluar != $id ");
		}
		return $sql->row();
	}

	public function totalInstituteYear($institute, $datetrx)
	{
		$sql = $this->db->query("SELECT sum(bk.amount) as amount
									FROM tbl_barangkeluar bk
									WHERE YEAR(bk.datetrx) = $datetrx
									AND bk.tbl_instansi_id = $institute
									AND bk.status = 'CO'");
		return $sql->row();
	}

	public function invoicePOut($id)
	{
		$sql = $this->db->query("SELECT bk.tbl_barangkeluar_id,
								bk.documentno,
								bk.datetrx,
								b.value,
								b.name as barang,
								bk.qtyentered,
								bk.unitprice,
								bk.amount,
								bk.keterangan,
								bk.tbl_instansi_id,
								i.value as code_ins,
								i.name as instansi,
								i.phone,
								i.address,
								i.budget as budget_ins
								FROM tbl_barangkeluar bk
								INNER JOIN tbl_barang b ON bk.tbl_barang_id = b.tbl_barang_id
								INNER JOIN tbl_instansi i ON bk.tbl_instansi_id = i.tbl_instansi_id
								WHERE bk.tbl_barangkeluar_id = $id ");
		return $sql->row();
	}
}
