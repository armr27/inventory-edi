

<!-- Begin Page Content -->
<div class="container-fluid">

    <form action="<?= base_url() ?>barangMasuk/proses_tambah" name="myForm" method="POST" enctype="multipart/form-data"
       onsubmit="return validateForm()">


        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div class="d-sm-flex">
                <a href="<?= base_url() ?>barang_masuk" class="btn btn-md btn-circle btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                </a>
                &nbsp;
                <h1 class="h2 mb-0 text-gray-800">Import Barang Masuk</h1>
            </div>

            <button type="submit" class="btn btn-primary btn-md btn-icon-split">
                <span class="text text-white">Simpan Data</span>
                <span class="icon text-white-50">
                    <i class="fas fa-save"></i>
                </span>
            </button>

        </div>

        <div class="d-sm-flex  justify-content-between mb-0">
            <div class="col-lg-12 mb-4">
                <!-- form -->
                <div class="card border-bottom-secondary shadow mb-4">
                    <div class="card-header py-3 bg-secondary">
                        <h6 class="m-0 font-weight-bold text-white">Form Barang Masuk</h6>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-12">

                            <!-- ID Transaksi -->
                            <div class="form-group"><label>ID Barang Masuk</label>
                                <input class="form-control" name="idbm" value="<?= $kode ?>" type="text" placeholder=""
                                    autocomplete="off" readonly>
                            </div>

                            <!-- Tgl Masuk -->
                            <div class="form-group"><label>Tanggal Import File</label>
                                <input class="form-control" name="tgl" id="" value="<?= $tglnow ?>" type="text" placeholder=""
                                    autocomplete="off" readonly>
                            </div>

                            <!-- file -->
                            <div class="form-group">
                                <span>Masukkan File Excel</span>
                            <div class="custom-file">
                                <input class="custom-file-input" type="file" id="GetFile" name="file"
                                    onchange="VerifyFileNameAndFileSize()" accept=".xls ,.xlsx ,.csv">
                                <label class="custom-file-label" for="customFile">Pilih File</label>
                            </div>
                        </div>
                            

                        

                        </div>


                        <br>
                    </div>
                </div>

            </div>

            
        </div>


    </form>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/js/barangMasuk.js"></script>
<script src="<?= base_url(); ?>assets/js/validasi/formbarangmasuk.js"></script>
<script src="<?= base_url(); ?>assets/plugin/datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url(); ?>assets/plugin/chosen/chosen.jquery.min.js"></script>


<script>
$('.chosen').chosen({
    width: '100%',

});

$('#datepicker').datepicker({
    autoclose: true,
    endDate: '+0d',
	todayHighlight	        : 'TRUE',
	todayBtn		: 'TRUE'

});
</script>
<?php if($this->session->flashdata('Pesan')): ?>
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

    })
});
</script>
<?php endif; ?>