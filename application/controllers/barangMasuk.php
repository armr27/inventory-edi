<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class BarangMasuk extends CI_Controller {

	public function __construct() {
    parent::__construct();
    $this->load->helper('url');
    $this->load->helper('download');
	$this->load->library('pagination');
	$this->load->helper('cookie');
	$this->load->model('supplier_model');
	$this->load->model('barang_model');
	$this->load->model('barangMasuk_model');
  }
	
	public function index()
	{
		$data['title'] = 'Barang Masuk';
		$data['bm'] = $this->barangMasuk_model->dataJoin()->result();

		$this->load->view('templates/header', $data);
		$this->load->view('barangMasuk/index');
		$this->load->view('templates/footer');
	}

	public function laporan()
	{
		$data['title'] = 'Laporan Barang Masuk';

		$this->load->view('templates/header', $data);
		$this->load->view('barangMasuk/laporan');
		$this->load->view('templates/footer');
	}

	public function getBarangMasuk()
	{
    	// $data = $this->barangMasuk_model->dataJoin()->result();
    	// echo json_encode($data);
		$data = $this->db->query("SELECT * FROM sparepart")->result();
		echo json_encode($data);
	}

	public function filterBarangMasuk($tglawal, $tglakhir)
	{
      	$data = $this->barangMasuk_model->lapdata($tglawal, $tglakhir)->result();
    	echo json_encode($data);
	}


	public function getBarang()
	{
		$id = $this->input->post('id');
    	$where = array('Mat_Code' => $id );
    	$data = $this->barang_model->detail_data($where, 'sparepart')->result();
    	echo json_encode($data);
	}

	public function getTotalStok()
	{
		$id = $this->input->post('id');
		// $where = array('id_barang'=>$id);
    	// $data = $this->db->select_sum('jumlah_masuk')->from('barang_masuk')->where($where)->get();
        // $data2 = $this->db->select_sum('jumlah_keluar')->from('barang_keluar')->where($where)->get();
		// $bm = $data->row();
		// $bk = $data2->row();
		// $hasil = intval($bm->jumlah_masuk) - intval($bk->jumlah_keluar);
		$data = $this->db->query("SELECT Stock FROM sparepart WHERE Mat_Code = '$id'")->row();
		$hasil = ($data->Stock);
		$total = array('Stock'=>$hasil);
		echo json_encode($total);
	}

	public function proses_hapus($id,$jml,$idb)
	{
		$where = array('id_barang_masuk'=>$id);
		$this->barang_model->hapus_data($where, 'barang_masuk');


		$this->session->set_flashdata('Pesan','
		<script>
		$(document).ready(function() {
			swal.fire({
				title: "Berhasil dihapus!",
				icon: "success",
				confirmButtonColor: "#4e73df",
			});
		});
		</script>
		');
		redirect('barang_masuk');
	}

	public function tambah()
	{
        $data['title'] = 'Barang Masuk';

        $data['kode'] = $this->barangMasuk_model->buat_kode();
        
		$data['barang'] = $this->db->query("SELECT * FROM sparepart")->result();
        // $data['jmlbarang'] = $this->barang_model->data()->num_rows();
        
        // $data['supplier'] = $this->supplier_model->data()->result();
        // $data['jmlsupplier'] = $this->supplier_model->data()->num_rows();
		$data['member'] = $this->db->query("SELECT * FROM user WHERE level='member' AND Status='Aktif'")->result();
        
		$data['tglnow'] = date('m/d/Y');



		$this->load->view('templates/header', $data);
		$this->load->view('barangMasuk/form_tambah');
		$this->load->view('templates/footer');
	}

	public function ubah($id)
	{
		$data['title'] = 'Barang Masuk';
		// $data['supplier'] = $this->supplier_model->data()->result();
		// $data['jmlsupplier'] = $this->supplier_model->data()->num_rows();
		$data['member'] = $this->db->query("SELECT * FROM user WHERE level='member' AND Status='Aktif'")->result();
		//menampilkan data berdasarkan id
		$data['data'] = $this->barangMasuk_model->detailJoin($id)->result();


		$this->load->view('templates/header', $data);
		$this->load->view('barangMasuk/form_ubah');
		$this->load->view('templates/footer');
	}

	public function proses_tambah()
	{
		$config['upload_path']   = './assets/upload/file/';
		$config['allowed_types'] = 'xls|xlsx|csv';
	
		$namaFile = $_FILES['file']['name'];
		$error = $_FILES['file']['error'];

		$this->load->library('upload', $config);
        $kode = $this->input->post('idbm');
        $tgl = $this->input->post('tgl');
        $usrinput = $this->session->userdata('login_session')['id_user'];

		$explode = explode("/", $tgl);
      	$tglmasuk = $explode[2].'-'.$explode[0].'-'.$explode[1];

		  if ($namaFile == '') {
			$ganti = 'null';
	  }else{
		  if (! $this->upload->do_upload('file')) {
			$error = $this->upload->display_errors();
			redirect('barangMasuk/tambah');
		  }
		  else{
			$data = array('file' => $this->upload->data());
			$nama_file= $data['file']['file_name'];
			$ganti = str_replace(" ", "_", $nama_file);
		  }

	  }
		// load Data Excel ke SQL 
	  $inputfileName = './assets/upload/file/'.$nama_file;
	  $inputTileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputfileName);
	  $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputTileType);
      $spreadsheet = $reader->load($inputfileName);
      $sheet = $spreadsheet->getSheet(0);
	  $count_Rows = 0;
	  $this->db->query("TRUNCATE TABLE Sparepart");
	  foreach ($sheet->getRowIterator() as $row) {
		if ($count_Rows > 0 ){
		$Mat_code = $spreadsheet->getActiveSheet()->getCell('B'.$row->getRowIndex());
		$Material_Description = $spreadsheet->getActiveSheet()->getCell('C'.$row->getRowIndex());
		$Uom = $spreadsheet->getActiveSheet()->getCell('D'.$row->getRowIndex());
		$Location = $spreadsheet->getActiveSheet()->getCell('E'.$row->getRowIndex());
		$Stock = $spreadsheet->getActiveSheet()->getCell('F'.$row->getRowIndex());
		$Sloc = $spreadsheet->getActiveSheet()->getCell('G'.$row->getRowIndex());
		$Batch = $spreadsheet->getActiveSheet()->getCell('H'.$row->getRowIndex());
		$data = array(
			'Mat_Code' => $Mat_code,
			'Material_Description' => $Material_Description,
			'UOM' => $Uom,
			'Location' => $Location,
			'Stock' => $Stock,
			'Sloc' => $Sloc,
			'Batch' => $Batch
		);
		$this->db->insert('sparepart',$data);
		$count_Rows++;
	} else {
		$count_Rows = 1;
	}
	  }

		$data=array(
			'id_barang_masuk'=>$kode,
            'tgl_masuk'=>$tglmasuk,
			'file'=>$ganti
		);


		$this->barangMasuk_model->tambah_data($data, 'barang_masuk');
		$this->session->set_flashdata('Pesan','
		<script>
		$(document).ready(function() {
			swal.fire({
				title: "Berhasil ditambahkan!",
				icon: "success",
				confirmButtonColor: "#4e73df",
			});
		});
		</script>
		');
    	redirect('barang_masuk');
	}
	

	public function proses_ubah()
	{
		$kode = $this->input->post('idbm');
		$barang = $this->input->post('barang');
		$id_user = $this->input->post('id$id_user');
		$tgl = $this->input->post('tgl');
		$jmlmasuk = $this->input->post('jmlmasuk');
		$jmlmasuklama = $this->input->post('jmlmasuklama');
		$explode = explode("/", $tgl);
      	$tglmasuk = $explode[2].'-'.$explode[0].'-'.$explode[1];
		$resetStok = $this->db->query("UPDATE sparepart set Stock=Stock-$jmlmasuklama WHERE Mat_Code='$barang'");
		$data=array(
			'Mat_Code'=> $barang,
			'id_user'=>$id_user,
			'jumlah_masuk'=>$jmlmasuk,
			'tgl_masuk'=>$tglmasuk
		);
		$where = array('id_barang_masuk'=>$kode);

		$this->barangMasuk_model->ubah_data($where, $data, 'barang_masuk');
		$this->db->query("UPDATE sparepart SET Stock=Stock + $jmlmasuk WHERE Mat_Code='$barang'");

		$this->session->set_flashdata('Pesan','
		<script>
		$(document).ready(function() {
			swal.fire({
				title: "Berhasil diubah!",
				icon: "success",
				confirmButtonColor: "#4e73df",
			});
		});
		</script>
		');
    	redirect('barang_masuk');
	}

	
}
