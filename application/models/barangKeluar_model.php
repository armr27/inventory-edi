<?php
class barangKeluar_model extends ci_model{


    function data()
    {
        $this->db->order_by('id_barang_keluar','DESC');
        return $query = $this->db->get('barang_keluar');
    }

    public function dataJoin()
    {
      return $query = $this->db->query("SELECT * FROM barang_keluar INNER JOIN user ON barang_keluar.id_user = user.id_user");
    }

    public function dataJoinLike($tahun)
    {
      $this->db->select('*');
      $this->db->from('barang_keluar as bk');
      $this->db->like('bk.tgl_keluar', $tahun);
      $this->db->order_by('bk.id_barang_keluar','DESC');
      return $query = $this->db->get();
    }

    public function transaksiTerakhir()
    {
      return $query = $this->db->query("SELECT * FROM barang_keluar ORDER BY id_barang_keluar DESC LIMIT 5");
    }

    function lapdata($tglAwal, $tglAkhir)
    {
      $this->db->select('barang_keluar.*, detail_barang_keluar.*, user.nama, sparepart.Material_Description');
      $this->db->from('barang_keluar');
      $this->db->join('user', 'barang_keluar.id_user = user.id_user');
      $this->db->join('detail_barang_keluar', 'barang_keluar.id_barang_keluar = detail_barang_keluar.id_barang_keluar');
      $this->db->join('sparepart', 'detail_barang_keluar.mat_code = sparepart.Mat_Code');
      $this->db->where('barang_keluar.tgl_keluar >=', $tglAwal);
      $this->db->where('barang_keluar.tgl_keluar <=', $tglAkhir);
      $this->db->where('barang_keluar.progress', 'Selesai');
      return $query = $this->db->get();
    }

    function jmlperbulan($tglAwal, $tglAkhir)
    {
      $level = $this->session->userdata('login_session')['level'];
      if ($level == 'admin' || $level == 'kepala gudang'){
          $id_user = $this->session->userdata('login_session')['id_user'];
          $this->db->select('*');
          $this->db->from('barang_keluar');
          $this->db->where('tgl_keluar >=', $tglAwal);
          $this->db->where('tgl_keluar <=', $tglAkhir);
          return $query = $this->db->get();
      } else {
        $id_user = $this->session->userdata('login_session')['id_user'];
        $this->db->select('*');
        $this->db->from('barang_keluar');
        $this->db->where('tgl_keluar >=', $tglAwal);
        $this->db->where('tgl_keluar <=', $tglAkhir);
        $this->db->where('id_user ', $id_user);
        return $query = $this->db->get();
      }
    }


    public function detailJoin($where)
    {
      $this->db->select('*');
      $this->db->from('barang_keluar as bk');
      $this->db->join('sparepart as b', 'b.Mat_Code = bk.Mat_Code');
      $this->db->join('user as u', 'u.id_user = bk.id_user');
      $this->db->where('bk.id_barang_keluar',$where);
      $this->db->order_by('bk.id_barang_keluar','DESC');
      return $query = $this->db->get();
    }


    public function ambilId($table, $where)
   {
       return $this->db->get_where($table, $where);
    }

 

    public function hapus_data($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
         if ($this->db->affected_rows() == 1) {
            return TRUE;
        }
        return false;

    }


    public function detail_data($where, $table)
    {
       return $this->db->get_where($table,$where);
    }

    public function tambah_data($data, $table)
    {
       $this->db->insert($table, $data);
    }

    public function ubah_data($where, $data, $table)
    {
       $this->db->where($where);
       $this->db->update($table, $data);

    }


    public function buat_kode()   {
		  $this->db->select('RIGHT(barang_keluar.id_barang_keluar,4) as kode', FALSE);
		  $this->db->order_by('id_barang_keluar','DESC');
		  $this->db->limit(1);
		  $query = $this->db->get('barang_keluar');      //cek dulu apakah ada sudah ada kode di tabel.
		  if($query->num_rows() <> 0){
		   //jika kode ternyata sudah ada.
		   $data = $query->row();
		   $kode = intval($data->kode) + 1;
		  }
		  else {
		   //jika kode belum ada
		   $kode = 1;
		  }
		  $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
		  $kodejadi = "BRG-K-".$kodemax;    // hasilnya 
		  return $kodejadi;
	}





}
