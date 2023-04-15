<?php
class barang_model extends ci_model{
  
//set nama tabel yang akan kita tampilkan datanya
var $table = 'sparepart';
//set kolom order, kolom pertama saya null untuk kolom edit dan hapus
var $column_order = array(null, 'Mat_Code', 'Material_Description', 'UOM', 'Location','Stock','Sloc','Batch', null);

var $column_search = array('Mat_Code', 'Material_Description', 'UOM', 'Location','Stock','Sloc','Batch');
// default order 
var $order = array('Mat_Code' => 'asc');

public function __construct(){
  parent::__construct();
        $this->load->database();
}

private function _get_datatables_query()
    {
        $this->db->from($this->table);
        $i = 0;
        foreach ($this->column_search as $item) // loop kolom 
        {
            if ($this->input->post('search')['value']) // jika datatable mengirim POST untuk search
            {
                if ($i === 0) // looping pertama
                {
                    $this->db->group_start();
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }
                if (count($this->column_search) - 1 == $i) //looping terakhir
                    $this->db->group_end();
            }
            $i++;
        }

        // jika datatable mengirim POST untuk order
        if ($this->input->post('order')) {
            $this->db->order_by($this->column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }



    


    function data()
    {
        $this->db->order_by('id_barang','DESC');
        return $query = $this->db->get('barang');
    }

    function dataSparepart() 
    {
      return $this->db->query("SELECT * FROM sparepart order by mat_code asc");
    }

    public function dataJoin()
    {
      $this->db->select('*');
      $this->db->from('barang as b');
      $this->db->join('jenis as j', 'j.id_jenis = b.id_jenis');
      $this->db->join('satuan as s', 's.id_satuan = b.id_satuan');

      $this->db->order_by('b.id_barang','DESC');
      return $query = $this->db->get();
    }
    

    public function totalStok()
    {
      $data=$this->db
    ->select_sum('Stock')
    ->from('sparepart')
    ->get();
      $Stock = $data->row();
      return $Stock->Stock;
    }

    public function detail_join($where)
    {
      $this->db->select('*');
      $this->db->from('barang as b');
      $this->db->where('b.id_barang', $where);
      $this->db->join('jenis as j', 'j.id_jenis = b.id_jenis');
      $this->db->join('satuan as s', 's.id_satuan = b.id_satuan');

      $this->db->order_by('b.id_barang','DESC');
      return $query = $this->db->get();
    }

    public function ambilFoto($where)
    {
      $this->db->order_by('Mat_Code','DESC');
      $this->db->limit(1);
      $query = $this->db->get_where('sparepart', $where);   
      
      $data = $query->row();
      $foto= $data->foto;
      
      return $foto;
    }

    public function ambil_stok($where){
      $this->db->order_by('id_barang','DESC');
      $this->db->limit(1);
      $query = $this->db->get_where('barang',$where);
      $data = $query->row();
      $stok = $data->stok;
      return $stok;
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
		  $this->db->select('RIGHT(barang.id_barang,4) as kode', FALSE);
		  $this->db->order_by('id_barang','DESC');
		  $this->db->limit(1);
		  $query = $this->db->get('barang');      //cek dulu apakah ada sudah ada kode di tabel.
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
		  $kodejadi = "BRG-".$kodemax;    
		  return $kodejadi;
	}





}
