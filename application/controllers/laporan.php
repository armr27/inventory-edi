<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->helper('download');
    $this->load->library('pagination');
    $this->load->helper('cookie');
    $this->load->model('barangMasuk_model');
    $this->load->model('barangKeluar_model');
  }

  public function barang_masuk_pdf()
  {
    $tglawal = $this->input->post('tglawal');
    $tglakhir = $this->input->post('tglakhir');

    if ($tglawal != '' && $tglakhir != '') {
      $data['data'] = $this->barangMasuk_model->lapdata($tglawal, $tglakhir)->result();
    } else {
      $data['data'] = $this->barangMasuk_model->dataJoin()->result();
    }

    $data['tglawal'] = $tglawal;
    $data['tglakhir'] = $tglakhir;

    $data['judul'] = 'Laporan Barang Masuk';
    $this->load->view('laporan/barang_masuk_pdf', $data);
    $tgl = date('Ymd_his');
    $namaFile = 'Barang_masuk_' . $tgl . '.pdf';
  }

  public function barang_keluar_cetak()
  {
    $tglawal = $this->input->get('tglawal');
    $tglakhir = $this->input->get('tglakhir');

    if ($tglawal != '' && $tglakhir != '') {
      $data['data'] = $this->barangKeluar_model->lapdata($tglawal, $tglakhir)->result();
    } else {
      $data['data'] = $this->db->query("SELECT barang_keluar.*, detail_barang_keluar.*, user.nama, sparepart.Material_Description FROM barang_keluar INNER JOIN user ON barang_keluar.id_user = user.id_user INNER JOIN detail_barang_keluar ON barang_keluar.id_barang_keluar = detail_barang_keluar.id_barang_keluar INNER JOIN sparepart ON detail_barang_keluar.mat_code = sparepart.Mat_Code WHERE barang_keluar.progress = 'Selesai'")->result();
    }

    $data['tglawal'] = $tglawal;
    $data['tglakhir'] = $tglakhir;

    $data['judul'] = 'Laporan Barang Keluar';
    $this->load->view('laporan/barang_keluar_pdf', $data);
  }
}
