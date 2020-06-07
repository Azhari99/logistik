<?php

use GuzzleHttp\Client;

class M_requestin extends CI_Model
{
	private $_table = 'tbl_permintaan';
	private $_client;

	public function __construct()
    {
        $this->_client = new Client([
            'base_uri'  => 'http://localhost/rest-api/wpu-rest-server-client/projectinventory/api/'
        ]);
    }

	public function list()
	{
		$this->db->select('tbl_permintaan.tbl_permintaan_id,
							tbl_permintaan.documentno,
							tbl_permintaan.datetrx,
							tbl_permintaan.status,
							tbl_permintaan.qtyentered,
							tbl_permintaan.keterangan,
							tbl_permintaan.created,
							tbl_barang.value,
							tbl_barang.name,							
							tbl_barang.jenis_id,
							tbl_instansi.value as code_institute,
							tbl_instansi.name as name_institute');
		$this->db->from($this->_table);
		$this->db->join('tbl_barang', 'tbl_barang.tbl_barang_id = '.$this->_table.'.tbl_barang_id', 'Left');
		$this->db->join('tbl_instansi', 'tbl_instansi.tbl_instansi_id = '.$this->_table.'.tbl_instansi_id', 'Left');
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
    
    public function updateApi($updateApi)
    {
        $response = $this->_client->request('PUT', 'permintaan', [
            'form_params' => $updateApi
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
		$this->db->select('tbl_permintaan.*,
							tbl_barang.name as barang,
							tbl_barang.jenis_id,
							tbl_instansi.name as instansi');
		$this->db->from($this->_table);
		$this->db->join('tbl_barang', 'tbl_barang.tbl_barang_id = ' . $this->_table . '.tbl_barang_id', 'Left');
		$this->db->join('tbl_instansi', 'tbl_instansi.tbl_instansi_id = ' . $this->_table . '.tbl_instansi_id', 'Left');
		$this->db->where('tbl_permintaan_id', $id);
		return $this->db->get();
	}

	public function countRequestIn()
	{
		$this->db->from($this->_table);
		$this->db->where('status', 'DR');
		return $this->db->count_all_results();
	}

	// public function delete($id)
	// {
	// 	return $this->db->delete($this->_table, array('tbl_permintaan_id' => $id));
	// }

// 	public function generateCode() 
// 	{		
// 		$firstCode = "POT"; //karakter depan kodenya
// 		$lastCode = ""; //kode awal
// 		$separtor = '-';
//         $sql = $this->db->query("SELECT MAX(RIGHT(documentno,4)) AS maxcode 
//         						FROM ".$this->_table);
        
//         if( $sql->num_rows() > 0 ) {
//             foreach($sql->result() as $value) {
//                 $intCode = ((int)$value->maxcode) + 1;
//                 $lastCode = sprintf("%04s", $intCode);
//             }

//         } else {
//             $lastCode = "0001";
//         }
//         return $firstCode.$separtor.$lastCode;
//    }

//    public function totalQtyProduct($id, $datetrx) 
//    {
//    		$param = array(
//    				'tbl_barang_id' => $id,
//    				'DATE_FORMAT(datetrx, "%Y") =' => $datetrx
//    			);
//    		$this->db->select_sum('qtyentered');
//    		$this->db->where($param);
//    		$this->db->from($this->_table);
//    		return $this->db->get()->row();
//    }

//    	public function totalProductOut()
// 	{
// 		$this->db->from($this->_table);
// 		$query = $this->db->count_all_results();
// 		return $query;
// 	}
}