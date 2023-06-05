<!-- Begin Page Content -->

<div class="container-fluid">



    <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Barang</h1>
    </div>



    <div class="col-lg-12 mb-4" id="container">



        <!-- Illustrations -->

        <div class="card border-bottom-secondary shadow mb-4">
            <div class="card-body">
                <form action="<?= base_url() ?>lap_barang" name="myForm" method="POST">
                    <div class="row">
                        <div class="col-lg-3 ">
                            <div class="input-group">
                                <input name="cari" autocomplete="off" placeholder="Masukkan Nama Barang"
                                    class="form-control border-1 small" value="<?= @$cari ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button">
                                        <i class="fas fa-boxes"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 ">
                            <button type="submit" class="btn btn-md btn-primary btn-icon-split mb-4">
                                <span class="text text-white">Filter</span>
                                <span class="icon text-white-50">
                                    <i class="fa-solid fa-search"></i>
                                </span>
                            </button>

                            <a href="#" class="btn btn-md btn-secondary btn-icon-split mb-4" onclick="reset()">
                                <span class="text text-white">Reset</span>
                                <span class="icon text-white-50">
                                    <i class="fas fa-undo"></i>
                                </span>
                            </a>

                            <a href="<?= base_url('laporan/barang_cetak?cari=') . @$cari?>" class="btn btn-md btn-danger btn-icon-split mb-4" target="_blank">
                                <span class="text text-white">Cetak Laporan</span>
                                <span class="icon text-white-50">
                                    <i class="fas   fa-print"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </form>



                <div class="table-responsive">
                    <table class="table" id="dtHorizontalExample" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th>Mat Code</th>
                                <th>Material Description</th>
                                <th>UOM</th>
                                <th>Location</th>
                                <th>Stock</th>
                                <th>Sloc</th>
                                <th>Batch</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <?php $no = 1; foreach ($laporan as $key ) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $key->Mat_Code ?></td>
                                    <td><?= $key->Material_Description ?></td>
                                    <td><?= $key->UOM ?></td>
                                    <td><?= $key->Location ?></td>
                                    <td><?= $key->Stock ?></td>
                                    <td><?= $key->Sloc ?></td>
                                    <td><?= $key->Batch ?></td>
                                </tr>
                            <?php } ?>    
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.container-fluid -->



</div>

<!-- End of Main Content -->



<script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>

<script src="<?= base_url(); ?>assets/js/laporan/lap_barang.js"></script>

<script src="<?= base_url(); ?>assets/plugin/datepicker/dist/js/bootstrap-datepicker.min.js"></script>



<script>
$('#dtHorizontalExample').DataTable();
</script>



<?php if($this->session->flashdata('Pesan')): ?>
<?= $this->session->flashdata('Pesan') ?>
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