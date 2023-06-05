<!-- Begin Page Content -->

<div class="container-fluid">



    <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <h1 class="h3 mb-0 text-gray-800">Laporan Barang Keluar</h1>

    </div>



    <div class="col-lg-12 mb-4" id="container">



        <!-- Illustrations -->

        <div class="card border-bottom-secondary shadow mb-4">
            <div class="card-body">
                <form action="<?= base_url() ?>lap_barang_keluar" name="myForm" method="POST">
                    <div class="row">
                        <div class="col-lg-3 ">
                            <div class="input-group">
                                <input name="tglawal" id="datepicker1" autocomplete="off" placeholder="tanggal mulai"
                                    class="form-control border-1 small" value="<?= @$tglawal ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button" id="date1">
                                        <i class="fas fa-calendar fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 ">
                            <div class="input-group">
                                <input name="tglakhir" id="datepicker2" autocomplete="off" placeholder="tanggal akhir"
                                    class="form-control border-1 small" value="<?= @$tglakhir ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button" id="date1">
                                        <i class="fas fa-calendar fa-sm"></i>
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

                            <a href="<?= base_url('laporan/barang_keluar_cetak?tglawal=') . @$tglawal . '&tglakhir=' . @$tglakhir . '&bulan' . @$bulan . '&tahun' . @$tahun ?>" class="btn btn-md btn-danger btn-icon-split mb-4" target="_blank">
                                <span class="text text-white">Cetak Laporan</span>
                                <span class="icon text-white-50">
                                    <i class="fas   fa-print"></i>
                                </span>
                            </a>
                        </div>

                        <div class="col-lg-2 mb-4">
                            <div class="input-group">
                                <input name="bulan" id="datepicker3" autocomplete="off" placeholder="Pilih Bulan"
                                    class="form-control border-1 small" value="<?= @$bulan ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button" id="date3">
                                        <i class="fas fa-calendar fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg ">
                        <button type="submit" class="btn btn-md btn-primary btn-icon-split mb-4">
                                <span class="text text-white">Filter</span>
                                <span class="icon text-white-50">
                                    <i class="fa-solid fa-search"></i>
                                </span>
                            </button>
                            <a href="<?= base_url('laporan/barang_keluar_cetak?tglawal=') . @$tglawal . '&tglakhir=' . @$tglakhir . '&bulan=' . @$bulan . '&tahun=' . @$tahun ?>" class="btn btn-md btn-danger btn-icon-split mb-4" target="_blank">
                            <span class="text text-white">Cetak Bulanan </span>
                                <span class="icon text-white-50">
                                    <i class="fas   fa-print"></i>
                                </span>
                            </a>
                        </div>

                        <div class="col-lg-2 mb-4">
                            <div class="input-group">
                                <input name="tahun" id="datepicker4" autocomplete="off" placeholder="Pilih Tahun"
                                    class="form-control border-1 small" value="<?= @$tahun ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button" id="date4">
                                        <i class="fas fa-calendar fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col ">
                        <button type="submit" class="btn btn-md btn-primary btn-icon-split mb-4">
                                <span class="text text-white">Filter</span>
                                <span class="icon text-white-50">
                                    <i class="fa-solid fa-search"></i>
                                </span>
                            </button>

                            <a href="<?= base_url('laporan/barang_keluar_cetak?tglawal=') . @$tglawal . '&tglakhir=' . @$tglakhir . '&bulan=' . @$bulan . '&tahun=' . @$tahun ?>" class="btn btn-md btn-danger btn-icon-split mb-4" target="_blank">
                                <span class="text text-white">Cetak Tahunan</span>
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

                                <th>Tgl Keluar</th>

                                <th>Nama Pengguna</th>

                                <th>Jumlah Keluar</th>

                            </tr>

                        </thead>

                        <tbody id="tbody">

                            <?php $no = 1; foreach ($laporan as $key ) { ?>

                                <tr>

                                    <td><?= $no++ ?></td>

                                    <td><?= $key->mat_code ?></td>

                                    <td><?= $key->Material_Description ?></td>

                                    <td><?= $key->tgl_keluar ?></td>

                                    <td><?= $key->nama ?></td>

                                    <td><?= $key->jumlah_keluar ?></td>

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

<script src="<?= base_url(); ?>assets/js/laporan/lap_barang_keluar.js"></script>

<script src="<?= base_url(); ?>assets/plugin/datepicker/dist/js/bootstrap-datepicker.min.js"></script>



<script>

$('#datepicker1').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
    endDate: new Date() // Tanggal akhir yang diizinkan
});



$('#datepicker2').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
    endDate: new Date() // Tanggal akhir yang diizinkan
});

$("#datepicker3").datepicker({
    autoclose: true,
    format: "yyyy-mm", // Menampilkan format bulan dan tahun (misalnya: 05/2023)
    minViewMode: "months", // Hanya menampilkan tampilan bulan
    startDate: new Date(2000, 0, 1), // Tanggal mulai yang diizinkan
    endDate: new Date() // Tanggal akhir yang diizinkan
  }).on("changeMonthYear", function(e) {
    $(this).datepicker("setDate", new Date(e.date.getFullYear(), e.date.getMonth(), 1));
  });
  
  $("#datepicker4").datepicker({
    autoclose: true,
    format: "yyyy", // Menampilkan format tahun saja
    minViewMode: "years", // Hanya menampilkan tampilan tahun
    endDate: new Date() // Tahun akhir yang diizinkan
  }).on("changeMonthYear", function(e) {
    $(this).datepicker("setDate", new Date(e.date.getFullYear(), 0, 1));
  });
  

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