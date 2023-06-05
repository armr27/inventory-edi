<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct() {
    parent::__construct();
    $this->load->helper('url');
    $this->load->helper('download');
	$this->load->helper('cookie');
	$this->load->model('barang_model');
	$this->load->model('supplier_model');
	$this->load->model('user_model');
	$this->load->model('barangMasuk_model');
	$this->load->model('barangKeluar_model');
  }
	
	public function index()
	{
		$data['title'] = 'Dashboard';
		$data['jmlbarang'] = $this->db->query("SELECT Mat_Code FROM sparepart")->num_rows();
		$data['jmlsupplier'] = $this->supplier_model->data()->num_rows();
		$data['jmlStok'] = $this->barang_model->totalStok();
		$data['jmlUser'] = $this->user_model->data()->num_rows();
		$level = $this->session->userdata('login_session')['level'];
		// Logic buat nampilin barang keluar
		if ($level == 'admin' || $level == 'kepala gudang' ) {
			$data['bk5Terakhir'] = $this->db->query("SELECT * FROM barang_keluar ORDER BY tgl_keluar DESC limit 5 ")->result();
		} else if ($level == 'member') { 
			$id_user = $this->session->userdata('login_session')['id_user'];
			$data['bk5Terakhir'] = $this->db->query("SELECT * FROM barang_keluar WHERE id_user ='$id_user' ORDER BY tgl_keluar limit 5")->result();
		}
		$data['yearnow']=date('Y', strtotime('+0 year'));
		$data['previousyear']=date('Y', strtotime('-1 year'));
		$data['twoyearago']=date('Y', strtotime('-2 year'));

		$this->load->view('templates/header', $data);
		$this->load->view('home/index');
		$this->load->view('templates/footer');

	}

	public function getTotalTransaksi()
	{
		$tahun = $this->input->post('tahun');

		// Logic buat nampilin barang keluar
		if ($this->session->userdata('login_session')['level'] == 'admin') {
			$jmlBK = $this->db->query("SELECT * FROM barang_keluar")->num_rows();
		} else if ($this->session->userdata('login_session')['level'] == 'member') { 
			$id_user = $this->session->userdata('login_session')['id_user'];
			$jmlBK = $this->db->query("SELECT * FROM barang_keluar WHERE id_user='$id_user'")->num_rows();
		}
		$data = array('jmlbk'=>$jmlBK);
		echo json_encode($data);
	}

	public function getFilterTahun()
	{
		$tahun = $this->input->post('tahun');

		//Januari
		$januari = 'January';
		$last_januari = date('Y-m-t', strtotime($tahun.'-'.$januari.'-01'));
		$first_januari = date('Y-m-01', strtotime($tahun.'-'.$januari.'-01'));
		$bkJanuari = $this->barangKeluar_model->jmlperbulan($first_januari, $last_januari)->num_rows();

		//Februari
		$februari = 'February';
		$last_februari = date('Y-m-t', strtotime($tahun.'-'.$februari.'-01'));
		$first_februari = date('Y-m-01', strtotime($tahun.'-'.$februari.'-01'));
		$bkFebruari = $this->barangKeluar_model->jmlperbulan($first_februari, $last_februari)->num_rows();

		//Maret
		$maret = 'March';
		$last_maret = date('Y-m-t', strtotime($tahun.'-'.$maret.'-01'));
		$first_maret = date('Y-m-01', strtotime($tahun.'-'.$maret.'-01'));
		$bkMaret = $this->barangKeluar_model->jmlperbulan($first_maret, $last_maret)->num_rows();

		//april
		$april = 'April';
		$last_april = date('Y-m-t', strtotime($tahun.'-'.$april.'-01'));
		$first_april = date('Y-m-01', strtotime($tahun.'-'.$april.'-01'));
		$bkApril = $this->barangKeluar_model->jmlperbulan($first_april, $last_april)->num_rows();

		//mei
		$mei = 'May';
		$last_mei = date('Y-m-t', strtotime($tahun.'-'.$mei.'-01'));
		$first_mei = date('Y-m-01', strtotime($tahun.'-'.$mei.'-01'));
		$bkMei = $this->barangKeluar_model->jmlperbulan($first_mei, $last_mei)->num_rows();

		//juni
		$juni = 'June';
		$last_juni = date('Y-m-t', strtotime($tahun.'-'.$juni.'-01'));
		$first_juni = date('Y-m-01', strtotime($tahun.'-'.$juni.'-01'));
		$bkJuni = $this->barangKeluar_model->jmlperbulan($first_juni, $last_juni)->num_rows();

		//juli
		$juli = 'July';
		$last_juli = date('Y-m-t', strtotime($tahun.'-'.$juli.'-01'));
		$first_juli = date('Y-m-01', strtotime($tahun.'-'.$juli.'-01'));
		$bkJuli = $this->barangKeluar_model->jmlperbulan($first_juli, $last_juli)->num_rows();

		//agustus
		$agustus = 'August';
		$last_agustus = date('Y-m-t', strtotime($tahun.'-'.$agustus.'-01'));
		$first_agustus = date('Y-m-01', strtotime($tahun.'-'.$agustus.'-01'));
		$bkAgustus = $this->barangKeluar_model->jmlperbulan($first_agustus, $last_agustus)->num_rows();

		//september
		$september = 'September';
		$last_september = date('Y-m-t', strtotime($tahun.'-'.$september.'-01'));
		$first_september = date('Y-m-01', strtotime($tahun.'-'.$september.'-01'));
		$bkSeptember = $this->barangKeluar_model->jmlperbulan($first_september, $last_september)->num_rows();
		
		//oktober
		$oktober = 'October';
		$last_oktober = date('Y-m-t', strtotime($tahun.'-'.$oktober.'-01'));
		$first_oktober = date('Y-m-01', strtotime($tahun.'-'.$oktober.'-01'));
		$bkOktober = $this->barangKeluar_model->jmlperbulan($first_oktober, $last_oktober)->num_rows();

		//november
		$november = 'November';
		$last_november = date('Y-m-t', strtotime($tahun.'-'.$november.'-01'));
		$first_november = date('Y-m-01', strtotime($tahun.'-'.$november.'-01'));
		$bkNovember = $this->barangKeluar_model->jmlperbulan($first_november, $last_november)->num_rows();

		//desember
		$desember = 'December';
		$last_desember = date('Y-m-t', strtotime($tahun.'-'.$desember.'-01'));
		$first_desember = date('Y-m-01', strtotime($tahun.'-'.$desember.'-01'));
		$bkDesember = $this->barangKeluar_model->jmlperbulan($first_desember, $last_desember)->num_rows();


		$data = array(
			'bkJanuari' => $bkJanuari,
			'bkFebruari' => $bkFebruari,
			'bkMaret' => $bkMaret,
			'bkApril' => $bkApril,
			'bkMei' => $bkMei,
			'bkJuni' => $bkJuni,
			'bkJuli' => $bkJuli,
			'bkAgustus' => $bkAgustus,
			'bkSeptember' => $bkSeptember,
			'bkOktober' => $bkOktober,
			'bkNovember' => $bkNovember,
			'bkDesember' => $bkDesember,
		);
    	echo json_encode($data);
	}

}
