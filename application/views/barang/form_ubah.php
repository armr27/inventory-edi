<?php foreach ($data as $d): ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <form action="<?= base_url() ?>barang/proses_ubah" name="myForm" method="POST" enctype="multipart/form-data"
        onsubmit="return validateForm()">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div class="d-sm-flex">
                <a href="<?= base_url() ?>barang" class="btn btn-md btn-circle btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                </a>
                &nbsp;
                <h1 class="h2 mb-0 text-gray-800">Ubah Barang</h1>
            </div>
            <button type="submit" class="btn btn-success btn-md btn-icon-split">
                <span class="text text-white">Simpan Perubahan</span>
                <span class="icon text-white-50">
                    <i class="fas fa-save"></i>
                </span>
            </button>

        </div>

        <div class="d-sm-flex  justify-content-between mb-0">
            <div class="col-lg-8 mb-4">
                <!-- Illustrations -->
                <div class="card border-bottom-secondary shadow mb-4">
                    <div class="card-header py-3 bg-secondary">
                        <h6 class="m-0 font-weight-bold text-white">Form Barang</h6>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-12">

                            <!-- Mat_Code -->
                            <div class="form-group"><label>Mat_Code</label>
                                <input class="form-control" name="mat_code" type="text" value="<?= $d->Mat_Code ?>" readonly>
                            </div>

                            <!-- Material Description -->
                            <div class="form-group"><label>Material Description</label>
                                <input class="form-control" name="material_description" type="text" value="<?= $d->Material_Description ?>">
                            </div>
                            
                            <!-- UOM -->
                            <div class="form-group"><label>UOM</label>
                                <input class="form-control" name="UOM" type="text" value="<?= $d->UOM ?>">
                            </div>

                            <!-- Location -->
                            <div class="form-group"><label>Location</label>
                                <input class="form-control" name="location" type="text" value="<?= $d->Location ?>">
                            </div>

                            <!-- Stock -->
                            <div class="form-group"><label>Stock</label>
                                <input class="form-control" name="stock" type="number" value="<?= $d->Stock?>">
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


<script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/js/barang.js"></script>
<script src="<?= base_url(); ?>assets/js/loading.js"></script>
<script src="<?= base_url(); ?>assets/js/validasi/formbarang.js"></script>
<script src="<?= base_url(); ?>assets/plugin/chosen/chosen.jquery.min.js"></script>

<script>
$('.chosen').chosen({
    width: '100%',

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

<?php endforeach; ?>