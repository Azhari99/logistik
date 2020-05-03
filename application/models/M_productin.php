<?php

class M_productin extends CI_Model
{
	private $_table = 'tbl_barangmasuk';

	public function list()
	{
		$this->db->select('tbl_barangmasuk.tbl_barangmasuk_id,
							tbl_barangmasuk.documentno,
							tbl_barang.value,
							tbl_barang.name,
							tbl_barangmasuk.datetrx,
							tbl_barangmasuk.qtyentered,
							tbl_barangmasuk.amount,
							tbl_barangmasuk.status,
							tbl_barangmasuk.keterangan,
							tbl_barangmasuk.file,
							tbl_barang.jenis_id');
		$this->db->from($this->_table);
		$this->db->join('tbl_barang', 'tbl_barang.tbl_barang_id = '.$this->_table.'.tbl_barang_id', 'Left');
		$query = $this->db->get()->result();
		return $query;
	}

	public function save($data)
	{		
		$this->db->insert($this->_table, $data);
	}

	public function update($data, $where)
	{
		$this->db->where($where);
		$this->db->update($this->_table, $data);
	}

	public function detail($id)
	{
		$this->db->select('tbl_barangmasuk.*,
							tbl_barang.name as barang');
		$this->db->from($this->_table);
		$this->db->join('tbl_barang', 'tbl_barang.tbl_barang_id = ' . $this->_table . '.tbl_barang_id', 'Left');
		$this->db->where('tbl_barangmasuk_id', $id);
		return $this->db->get();
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('tbl_barangmasuk_id' => $id));
	}

	public function generateCode() 
	{		
		$firstCode = "PIN"; //karakter depan kodenya
		$lastCode = ""; //kode awal
		$separtor = '-';
        $sql = $this->db->query("SELECT MAX(RIGHT(documentno,4)) AS maxcode 
        						FROM ".$this->_table);
        
        if( $sql->num_rows() > 0 ) {
            foreach($sql->result() as $value) {
                $intCode = ((int)$value->maxcode) + 1;
                $lastCode = sprintf("%04s", $intCode);
            }

        } else {
            $lastCode = "0001";
        }
        return $firstCode.$separtor.$lastCode;
   }

   public function totalQtyProductIn($id, $id_product, $datetrx) 
   {
	   	if ($id == null) {
			$sql = $this->db->query("SELECT sum(bm.amount) as amount,
									sum(bm.qtyentered) as qtyentered
									FROM tbl_barangmasuk bm
									WHERE bm.tbl_barang_id = $id_product
									AND YEAR(bm.datetrx) = $datetrx");
		} else {
			$sql = $this->db->query("SELECT sum(bm.amount) as amount,
									sum(bm.qtyentered) as qtyentered
									FROM tbl_barangmasuk bm
									WHERE bm.tbl_barang_id = $id_product
									AND YEAR(bm.datetrx) = $datetrx
									AND bm.tbl_barangmasuk_id != $id ");
		}
		return $sql->row();
   }
}