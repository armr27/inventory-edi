<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BarangKeluar extends CI_Controller {

	public function __construct() {
    parent::__construct();
    $this->load->helper('url');
    $this->load->helper('download');
	$this->load->library('pagination');
	$this->load->helper('cookie');
	$this->load->model('supplier_model');
	$this->load->model('barang_model');
	$this->load->model('barangKeluar_model');
  }
	
	public function index()
	{
		$data['title'] = 'Barang Keluar';
		if ($this->session->userdata('login_session')['level'] == 'admin'){
		$data['bk'] = $this->barangKeluar_model->dataJoin()->result();
		} else {
		$id_user = $this->session->userdata('login_session')['id_user'];
		$data['bk'] = $this->db->query("SELECT * FROM barang_keluar INNER JOIN user ON barang_keluar.id_user = user.id_user WHERE barang_keluar.id_user = '$id_user'")->result();
		}
		$this->load->view('templates/header', $data);
		$this->load->view('barangKeluar/index');
		$this->load->view('templates/footer');
	}
	
	public function detail()
	{
		$kode = $this->uri->segment('3');
		$data['title'] = 'Barang Keluar';
		$data['bk'] = $this->db->query("SELECT * FROM detail_barang_keluar INNER JOIN sparepart ON detail_barang_keluar.mat_code = sparepart.Mat_Code WHERE id_barang_keluar = '$kode'")->result();
		$data['progress'] = $this->db->query("SELECT progress FROM barang_keluar WHERE id_barang_keluar = '$kode'")->result();
		$data['barang'] = $this->db->query("SELECT Mat_Code, Material_Description FROM sparepart")->result();
		$this->load->view('templates/header', $data);
		$this->load->view('barangKeluar/detail');
		$this->load->view('templates/footer');
	}

	public function laporan()
	{
		$data['title'] = 'Laporan Barang Keluar';
		$tglawal = $this->input->post('tglawal');
		$tglakhir = $this->input->post('tglakhir');
		if ($tglawal && $tglakhir ){
			$data['tglawal'] = $tglawal;
            $data['tglakhir'] = $tglakhir;
			$data['laporan'] = $this->barangKeluar_model->lapdata($tglawal, $tglakhir)->result();
		} else {
			$data['laporan'] = $this->db->query("SELECT barang_keluar.*, detail_barang_keluar.*, user.nama, sparepart.Material_Description FROM barang_keluar INNER JOIN user ON barang_keluar.id_user = user.id_user INNER JOIN detail_barang_keluar ON barang_keluar.id_barang_keluar = detail_barang_keluar.id_barang_keluar INNER JOIN sparepart ON detail_barang_keluar.mat_code = sparepart.Mat_Code WHERE barang_keluar.progress = 'Selesai'")->result();
		}
		$this->load->view('templates/header', $data);
		$this->load->view('barangKeluar/laporan');
		$this->load->view('templates/footer');
	}

	public function getBarangKeluar()
	{
    	$data = $this->db->query("SELECT * FROM barang_keluar INNER JOIN detail_barang_keluar ON barang_keluar.id_barang_keluar = detail_barang_keluar.id_barang_keluar WHERE barang_keluar.progress = 'Selesai'")->result();
    	echo json_encode($data);
	}

	public function filterBarangKeluar($tglawal, $tglakhir)
	{
      	$data = $this->barangKeluar_model->lapdata($tglawal, $tglakhir)->result();
    	echo json_encode($data);
	}



	public function getBarang()
	{
		$id = $this->input->post('id');
    	$where = array('Mat_Code' => $id );
    	$data = $this->barang_model->detail_data($where, 'sparepart')->result();
    	echo json_encode($data);
	}

	public function getStok()
	{
		$Mat_Code = $this->input->get('Mat_Code');
    	$where = array('Mat_Code' => $Mat_Code );
    	$data = $this->db->query("SELECT Stock FROM sparepart WHERE Mat_Code='$Mat_Code'")->result_array();
    	echo json_encode(array('status' => 'success', 'data' => $data));
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


	public function proses_selesai($id)
	{
		$this->db->query("UPDATE barang_keluar set progress = 'Selesai' WHERE id_barang_keluar = '$id'");

		$this->session->set_flashdata('Pesan','
		<script>
		$(document).ready(function() {
			swal.fire({
				title: "Peminjaman Barang Berhasil Dilakukan",
				icon: "success",
				confirmButtonColor: "#4e73df",
			});
		});
		</script>
		');
		redirect('barang_keluar');
	}

	public function proses_hapus($id)
	{
		$where = array('id_barang_keluar'=>$id);
		$result = $this->db->query("SELECT mat_code, jumlah_keluar FROM detail_barang_keluar WHERE id_barang_keluar='$id'")->result();
		if ( $result != null ){
			foreach ($result as $result) {
				$mat_code = $result->mat_code;
				$jumlah_keluar = $result->jumlah_keluar;
				$this->db->query("UPDATE sparepart set Stock = Stock+$jumlah_keluar WHERE Mat_Code='$mat_code'");
			}
		} else {
			$mat_code = 0;
			$jumlah_keluar = 0;
			$this->db->query("UPDATE sparepart set Stock = Stock+$jumlah_keluar WHERE Mat_Code='$mat_code'");
		}
		$this->db->query("DELETE FROM detail_barang_keluar WHERE id_barang_keluar='$id'");
		$this->barang_model->hapus_data($where, 'barang_keluar');
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
		redirect('barang_keluar');
	}

	public function tambah()
	{
        $data['title'] = 'Barang Keluar';

        $data['kode'] = $this->barangKeluar_model->buat_kode();
		$data['barang'] = $this->barang_model->data()->result();
        $data['jmlbarang'] = $this->barang_model->data()->num_rows();

		$data['member'] = $this->db->query("SELECT * FROM user WHERE level='member' AND status='Aktif' ")->result();
        
		$data['tglnow'] = date('m/d/Y');

		$this->load->view('templates/header', $data);
		$this->load->view('barangKeluar/form_tambah');
		$this->load->view('templates/footer');
	}

	public function tambahDetail()
	{
        $data['title'] = 'Barang Keluar';

        $data['kode'] = $this->barangKeluar_model->buat_kode();
		$data['barang'] = $this->barang_model->data()->result();
        $data['jmlbarang'] = $this->barang_model->data()->num_rows();

		$data['member'] = $this->db->query("SELECT * FROM user WHERE level='member' AND status='Aktif' ")->result();
        
		$data['tglnow'] = date('m/d/Y');

		$this->load->view('templates/header', $data);
		$this->load->view('barangKeluar/form_tambah_detail');
		$this->load->view('templates/footer');
	}

	public function ubah($id)
	{
		$data['title'] = 'Barang Keluar';

		//menampilkan data berdasarkan id
		$data['data'] = $this->barangKeluar_model->detailJoin($id)->result();
		$data['member'] = $this->db->query("SELECT * FROM user WHERE level='member' AND Status='Aktif'")->result();

		$this->load->view('templates/header', $data);
		$this->load->view('barangKeluar/form_ubah');
		$this->load->view('templates/footer');
	}

	public function proses_tambah()
	{
        $kode = $this->input->post('idbk');
        $tgl = $this->input->post('tgl');
		$member = $this->input->post('member');
        $usrinput = $this->session->userdata('login_session')['id_user'];

		$explode = explode("/", $tgl);
      	$tglkeluar = $explode[2].'-'.$explode[0].'-'.$explode[1];
		
		$data=array(
			'id_barang_keluar'=>$kode,
            'tgl_keluar'=>$tglkeluar,
            'id_user'=>$member,
			'progress'=>'Proses'
		);

		$this->barangKeluar_model->tambah_data($data, 'barang_keluar');
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
    	redirect('barang_keluar');
	}

	public function proses_tambah_detail()
	{
		$kode = $this->input->post('kode');
        $Mat_Code = $this->input->post('barang');
        $jmlkeluar = $this->input->post('jmlkeluar');
		$data=array(
			'id_barang_keluar'=>$kode,
            'mat_code'=>$Mat_Code,
			'jumlah_keluar'=>$jmlkeluar
		);

		$this->barangKeluar_model->tambah_data($data, 'detail_barang_keluar');
		$this->db->query("UPDATE sparepart set Stock=Stock-'$jmlkeluar' WHERE Mat_Code='$Mat_Code'");
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
    	redirect('barang_keluar/detail/'.$kode.'');
	}
	
	public function proses_hapus_detail($id)
	{	
		$kode = $this->uri->segment('4');

		$where = array('id_detail'=>$id);
		$result = $this->db->query("SELECT mat_code, jumlah_keluar FROM detail_barang_keluar WHERE id_detail = '$id'")->row();
		$mat_code = $result->mat_code;
		$jumlah_keluar = $result->jumlah_keluar;
		$this->db->query("UPDATE sparepart set Stock = Stock+$jumlah_keluar WHERE Mat_Code='$mat_code'");
		$this->barang_model->hapus_data($where, 'detail_barang_keluar');
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
		redirect('barangKeluar/detail/'.$kode.'');
	}

	public function proses_ubah()
	{
		$kode = $this->input->post('idbk');
		$barang = $this->input->post('barang');
		$tgl = $this->input->post('tgl');
		$member = $this->input->post('member');
		$jmlkeluar = $this->input->post('jmlkeluar');
		$jmlkeluarlama = $this->input->post('jmlkeluarlama');

		$explode = explode("/", $tgl);
      	$tglkeluar = $explode[2].'-'.$explode[0].'-'.$explode[1];
		
		$data=array(
			'Mat_Code'=> $barang,
			'jumlah_keluar'=>$jmlkeluar,
			'tgl_keluar'=>$tglkeluar,
            'id_user'=>$member
		);
		$where = array('id_barang_keluar'=>$kode);
		$resetStok = $this->db->query("UPDATE sparepart set Stock=Stock+$jmlkeluarlama WHERE Mat_Code='$barang'");
		$this->barangKeluar_model->ubah_data($where, $data, 'barang_keluar');
		$this->db->query("UPDATE sparepart set Stock=Stock-$jmlkeluar WHERE Mat_Code='$barang'");
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
    	redirect('barang_keluar');
	}


	
}
