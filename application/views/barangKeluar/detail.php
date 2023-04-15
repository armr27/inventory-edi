<?php
function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);

	// variabel pecahkan 1 = tanggal
	// variabel pecahkan 0 = bulan
	// variabel pecahkan 2 = tahun

	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
            
        <h1 class="h3 mb-0 text-gray-800"><a href="<?= base_url() ?>barang_keluar"><i class="fa-solid fa-circle-left"></i></a> Detail Barang Keluar</h1>
        <?php if($progress) { ?>
            <?php foreach ($progress as $item) { ?>
                <?php if ($item->progress == "Proses") { ?>
                    <a href="" data-toggle="modal" data-target="#form" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="text text-white">Tambah Data</span>
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                    </a>
                <?php } ?>
            <?php } ?>
    <?php } ?>
    </div>
    <div class="col-lg-12 col-sm-6 mb-4" id="container">

        <!-- Illustrations -->
        <div class="card border-bottom-secondary shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="dtHorizontalExample" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th>Material Description</th>
                                <th>Jumlah Keluar</th>
                                <?php if($progress) { 
                                    foreach ($progress as $item) { 
                                        if ($item->progress == "Proses") { ?>
                                <th width="1%">Aksi</th>
                                     <?php } } } ?>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <?php $no=1; foreach ($bk as $bk): ?>
                            <tr>
                                <td><?= $no++ ?>.</td>
                                <td><?= $bk->Material_Description ?></td>
                                <td><?= $bk->jumlah_keluar ?></td>
                                <?php if($progress) { 
                                    foreach ($progress as $item ) { 
                                        if ($item->progress == "Proses") { ?>
                                    <td>
                                        <center>
                                            <!-- <a href="<?= base_url() ?>barangKeluar/detail/<?= $bk->id_detail ?>"
                                                class="btn btn-circle btn-primary btn-sm">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </a> -->
                                            <a href="#"
                                                onclick="konfirmasi('<?= $bk->id_detail ?>','<?= $this->uri->segment('3') ?>')"
                                                class="btn btn-circle btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </center>
                                    </td>
                                    <?php } } } ?>  
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid -->

<!-- form input -->
<div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form action="<?= base_url() ?>barangKeluar/proses_tambah_detail" name="myForm" method="POST" onsubmit="return validateDetail()">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white font-weight-bold" id="exampleModalLabel">Tambah barang</h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="col-lg-12">
                    <br>
                    <input type="hidden" value="<?= $this->uri->segment('3') ?>" name="kode">
                    <!-- Pilih barang -->
                    <div class="form-group"><label>Nama Barang</label>
                        <select name="barang" id="chosen" class="form-control chosen" Onchange="changeBarang(this.value)">
                             <option value="">--Pilih--</option>
                             <?php foreach ($barang as $b ) { ?>
                                <option value="<?= $b->Mat_Code ?>" id="chosen-option"><?= $b->Material_Description ?></option>
                             <?php } ?>                 
                        </select>
                    </div>

                    <!-- info Stok -->
                    <div class="form-group"><label>Stok Tersedia</label>
                        <input class="form-control" name="stok" type="number" id="stok" placeholder="" readonly >
                    </div>


                    <!-- Jumlah Barang -->
                    <div class="form-group"><label>Jumlah Barang</label>
                        <input class="form-control" name="jmlkeluar" type="number" placeholder="">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-save"></i>
                        </span>
                        <span class="text text-white">Simpan Data</span>
                    </button>
                    <button type="button" class="btn btn-secondary btn-icon-split" data-dismiss="modal">
                        <span class="icon text-white-50">
                            <i class="fas fa-times"></i>
                        </span>
                        <span class="text text-white">Batal</span>
                    </button>

                </div>
            </div>
        </div>
    </form>
</div>

</div>
<!-- End of Main Content -->

<script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/plugin/datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url(); ?>assets/plugin/chosen/chosen.jquery.min.js"></script>

<?php if($this->session->flashdata('Pesan')): ?>
<?= $this->session->flashdata('Pesan') ?>
<?php unset($_SESSION['Pesan']) ?>
<?php else: ?>
    

<script>
$(document).ready(function() {
    let timerInterval
    Swal.fire({
        title: 'Memuat...',
        timer: 1000,
        onBeforeOpen: () => {
            Swal.showLoading()
        },
        onClose: () => {
            clearInterval(timerInterval)
        }
    }).then((result) => {
      
    }),
    
});
</script>
<?php endif; ?>
<script>
      $('#chosen').chosen({
        enableTypingFilter: true
      });    
</script>
<script>
        function changeBarang(value) {
        $.ajax({
        url: "<?= base_url('barangKeluar/getStok') ?>",
        type: "GET",
        data: {
            'Mat_Code': value,
        },
        dataType: "JSON",
        success: function(data) {
            $('#stok').val(data.data[0].Stock);
    }
        });
};

function validateDetail() {
    console.log("Validating details...");
    var barang = document.forms["myForm"]["barang"].value;
    var jmlbarang = document.forms["myForm"]["jmlkeluar"].value;
    var stok = $('#stok').val();
    var total = parseInt(stok) - parseInt(jmlbarang);

    if (barang == '') {
        validasi('Barang wajib di isi!', 'warning');
        return false;
    } else if (jmlbarang == '') {
        validasi('Jumlah Keluar wajib di isi!', 'warning');
        return false;
    } else if (total < 0) {
        validasi('Jumlah melewati stok barang!', 'warning');
        return false;
    }

};

function validasi(judul, status) {
    swal.fire({
        title: judul,
        icon: status,
        confirmButtonColor: '#4e73df',
    });
};

function konfirmasi(id,kode) {
    var base_url = $('#baseurl').val();

    swal.fire({
        title: "Hapus Data ini?",
        icon: "warning",
        closeOnClickOutside: false,
        showCancelButton: true,
        confirmButtonText: 'Iya',
        confirmButtonColor: '#4e73df',
        cancelButtonText: 'Batal',
        cancelButtonColor: '#d33',
    }).then((result) => {
        if (result.value) {
            Swal.fire({
                title: "Memuat...",
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
                timer: 1000,
                showConfirmButton: false,
            }).then(
                function () {
                    window.location.href = base_url + "barangKeluar/proses_hapus_detail/" + id +"/" + kode;
                }
            );
        }
    });

}
</script>