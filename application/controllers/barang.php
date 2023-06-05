<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Barang extends CI_Controller {

	public function __construct() {
    parent::__construct();
    $this->load->helper('url');
    $this->load->helper('download');
	$this->load->library('pagination');
	$this->load->helper('cookie');
	$this->load->model('barang_model');
	$this->load->model('jenis_model');
	$this->load->model('satuan_model');
  }
	
	public function index()
	{
		$data['title'] = 'Barang';
		$data['barang'] = $this->barang_model->dataSparepart()->result();

		$this->load->view('templates/header', $data);
		$this->load->view('barang/index');
		$this->load->view('templates/footer');
    }




//method yang digunakan untuk request data mahasiswa
public function ajax_list()
{
	header('Content-Type: application/json');
	$list = $this->barang_model->get_datatables();
	$data = array();
	$no = $this->input->post('start');
	$base_url = base_url();
	//looping data mahasiswa
	foreach ($list as $Data_sparepart) {
		$no++;
		$row = array();
		//row pertama akan kita gunakan untuk btn edit dan delete
		$row[] = $no;
		$row[] = $Data_sparepart->Mat_Code;
		$row[] = $Data_sparepart->Material_Description;
		$row[] = $Data_sparepart->UOM;
		$row[] = $Data_sparepart->Location;
		$row[] = $Data_sparepart->Stock;
		$row[] = $Data_sparepart->Sloc;
		$row[] = $Data_sparepart->Batch;
		$row[] =  '<a href="'.$base_url.'barang/ubah/'.$Data_sparepart->Mat_Code.'"
		class="btn btn-circle btn-success btn-sm">
		<i class="fas fa-pen"></i>
	</a>
	<a href="#" onclick="konfirmasi('. $Data_sparepart->Mat_Code . ')"
		class="btn btn-circle btn-danger btn-sm">
		<i class="fas fa-trash"></i>
	</a>';
		$data[] = $row;
	}
	$output = array(
		"draw" => $this->input->post('draw'),
		"recordsTotal" => $this->barang_model->count_all(),
		"recordsFiltered" => $this->barang_model->count_filtered(),
		"data" => $data,
	);
	//output to json format
	$this->output->set_output(json_encode($output));
}


// function untuk menampilkan laporan barang
	public function laporan()
	{
		$data['title'] = 'Laporan Barang';
		$cari = $this->input->post('cari');
		if ($cari !== null){
			$data['laporan'] = $this->db->query("SELECT * FROM Sparepart WHERE Mat_Code LIKE '%$cari%' OR Material_Description LIKE '%$cari%' OR UOM LIKE '%$cari%' OR Location LIKE '%$cari%' OR Sloc LIKE '%$cari%' OR Batch LIKE '%$cari%'")->result();
		} else {
			$data['laporan'] = $this->db->query("SELECT * FROM Sparepart")->result();
		}
		$data['cari'] = $cari;
		$this->load->view('templates/header', $data);
		$this->load->view('barang/laporan');
		$this->load->view('templates/footer');
	}


    public function tambah()
	{
        $data['title'] = 'Barang';
        
        //data untuk select
		$data['jenis'] = $this->jenis_model->data()->result();
        $data['satuan'] = $this->satuan_model->data()->result();

        //jml
		$data['jmlJenis'] = $this->satuan_model->data()->num_rows();
		$data['jmlSatuan'] = $this->satuan_model->data()->num_rows();

		$this->load->view('templates/header', $data);
		$this->load->view('barang/form_tambah');
		$this->load->view('templates/footer');
    }
    
    public function ubah($id)
	{
        $data['title'] = 'Barang';

        //menampilkan data berdasarkan id
		$where = array('Mat_Code'=>$id);
        $data['data'] = $this->barang_model->detail_data($where, 'sparepart')->result();
        
        //data untuk select
		// $data['jenis'] = $this->jenis_model->data()->result();
        // $data['satuan'] = $this->satuan_model->data()->result();

        //jml
		$data['jmlJenis'] = $this->satuan_model->data()->num_rows();
		$data['jmlSatuan'] = $this->satuan_model->data()->num_rows();

		$this->load->view('templates/header', $data);
		$this->load->view('barang/form_ubah');
		$this->load->view('templates/footer');
	}

	public function detail($id)
	{
		$data['title'] = 'Barang';

        //menampilkan data berdasarkan id
        $data['data'] = $this->barang_model->detail_join($id, 'barang')->result();

		$this->load->view('templates/header', $data);
		$this->load->view('barang/detail');
		$this->load->view('templates/footer');
	}

	public function proses_tambah()
	{

        $config['upload_path']   = './assets/upload/barang/';
		$config['allowed_types'] = 'png|jpg|JPG|jpeg|JPEG|gif|GIF|tif|TIF||tiff|TIFF';
	
		$namaFile = $_FILES['photo']['name'];
		$error = $_FILES['photo']['error'];

        $this->load->library('upload', $config);
        
		$mat_code = 	$this->input->post('mat_code');
		$material_description = $this->input->post('material_description');
		$UOM = 	$this->input->post('UOM');
		$location = 	$this->input->post('location');
        $stock = 	$this->input->post('stock');
        
        if ($namaFile == '') {
            $ganti = 'box.png';
        }else{
          if (! $this->upload->do_upload('photo')) {
            $error = $this->upload->display_errors();
            redirect('barang/tambah');
          }
          else{
  
            $data = array('photo' => $this->upload->data());
            $nama_file= $data['photo']['file_name'];
            $ganti = str_replace(" ", "_", $nama_file);
  
  
          }

      }
		
		$data=array(
			'Mat_Code'=> $mat_code,
			'Material_Description'=> $material_description,
			'UOM'=> $UOM,
			'Location'=> $location,
            'Stock'=> $stock,
		);

		$this->barang_model->tambah_data($data, 'sparepart');
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
    	redirect('barang');
	}

	public function proses_ubah()
	{
        $config['upload_path']   = './assets/upload/barang/';
		$config['allowed_types'] = 'png|jpg|JPG|jpeg|JPEG|gif|GIF|tif|TIF||tiff|TIFF';
	
		$namaFile = $_FILES['photo']['name'];
		$error = $_FILES['photo']['error'];

        $this->load->library('upload', $config);
        
		$mat_code = $this->input->post('mat_code');
		$material_description = $this->input->post('material_description');
		$uom = $this->input->post('UOM');
		$location = $this->input->post('location');
		$stock = $this->input->post('stock');
        
        $flama = $this->input->post('fotoLama');

        if ($namaFile == '') {
            $ganti = $flama;
        }else{
          if (! $this->upload->do_upload('photo')) {
            $error = $this->upload->display_errors();
            redirect('barang/ubah/'.$kode);
          }
          else{
  
            $data = array('photo' => $this->upload->data());
            $nama_file= $data['photo']['file_name'];
            $ganti = str_replace(" ", "_", $nama_file);
            if($flama == 'box.png'){

            }else{
              unlink('./assets/upload/barang/'.$flama.'');
            }
  
          }

      }
		
		$data=array(
			'Mat_Code'=> $mat_code,
			'Material_Description'=> $material_description,
			'UOM'=> $uom,
            'Location'=> $location,
            'Stock' => $stock
		);

		$where = array(
			'Mat_Code'=>$mat_code
		);

		$this->barang_model->ubah_data($where, $data, 'sparepart');
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
    	redirect('barang');
	}

	public function proses_hapus($id)
	{
		// $where = array('Mat_Code' => $id );
		// $foto = $this->barang_model->ambilFoto($where);
		// if($foto){
		// 	if($foto == 'box.png'){

		// 	}else{
		// 		unlink('./assets/upload/barang/'.$foto.'');
		// 	}
			
			$this->db->query("DELETE FROM `sparepart` WHERE Mat_Code='$id'");
		// }

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
		redirect('barang');
	}

	public function getData()
	{
		$id = $this->input->post('id');
    	$where = array('id_barang' => $id );
    	$data = $this->barang_model->detail_data($where, 'barang')->result();
    	echo json_encode($data);
	}

}
