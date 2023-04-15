<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="row">
    
    <?php if ($this->session->userdata('login_session')['level'] == 'admin') {?>
         <!-- Earnings (Monthly) Card Example -->
         <div class="col-xl-4 col-md-6 mb-4" id="barang">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Barang
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jmlbarang ?> Data</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4" id="stok">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Stok Barang
                            </div>
                            <?php  
                                $data3 = $this->db->select_sum('Stock')->from('sparepart')->get();
                                $b = $data3->row();
                                $hasil = $b->Stock ;
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $hasil ?> Data</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4" id="user">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total User
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jmlUser ?> Data</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } else {?>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-6 col-md-6 mb-4" id="barang">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Barang
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jmlbarang ?> Data</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-box fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-6 col-md-6 mb-4" id="stok">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Stok Barang
                            </div>
                            <?php  
                                $data3 = $this->db->select_sum('Stock')->from('sparepart')->get();
                                $b = $data3->row();
                                $hasil = $b->Stock ;
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $hasil ?> Data</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>


    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-8">
            <div class="card shadow mb-4" id="grafik">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-secondary">
                    <h6 class="m-0 font-weight-bold border-0 text-white">Total Transaksi Barang Perbulan</h6>
                    
                    <div class="col-lg-2">
                        <select name="tahun" id="tahun" class="form-control" onchange="filterTahun()">
                            <option value="<?= $yearnow ?>"><?= $yearnow ?></option>
                            <option value="<?= $previousyear ?>"><?= $previousyear ?></option>
                            <option value="<?= $twoyearago ?>"><?= $twoyearago ?></option>
                        </select>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area" id="chart">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-4 col-md-4 mb-4" id="bkterakhir">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-danger">
                <h6 class="m-0 font-weight-bold border-0 text-white">5 Barang Keluar Terakhir</h6>
                <?php if($this->session->userdata('login_session')['level'] == 'admin' || $this->session->userdata('login_session')['level'] == 'member'): ?>
                    <a href="<?= base_url() ?>barang_keluar" class="btn btn-danger btn-md btn-circle">
                        <i class="fa fa-arrow-right"></i>
                    </a>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <div class="row">

                    <?php foreach($bk5Terakhir as $bk): ?>
                        
                    <div class="col-lg-2 mb-2">
                        <img src="<?= base_url() ?>assets/upload/barang/box.png" alt="" width="100%" style="border-radius: 5px;">
                    </div>
                    <div class="col-lg-10">
                        <a href="<?= base_url() ?>barangKeluar/detail/<?=$bk->id_barang_keluar?>"><h5 class="h5 mb-0 text-gray-800"><b><?= $bk->id_barang_keluar   ?></b></h5></a>
                        <h6 class="h6 mb-0 text-gray-800"><?= $bk->tgl_keluar ?></h6>
                        <!-- <span class="badge badge-danger"> <i class="fa fa-minus"></i> <?= $bk->jumlah_keluar ?></span> -->
                    </div>

                    <div class="col-lg-12">
                        <!-- Divider -->
                        <hr class="sidebar-divider">
                    </div>

                    <?php endforeach; ?>

                </div>
            

            </div>
        </div>
    </div>

    </div>

    <div class="row">

        <!-- Pie Chart -->

    


    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<!-- Page level plugins -->
<script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/sbadmin/vendor/chart.js/Chart.min.js"></script>
<!-- Page level custom scripts -->
<script src="<?= base_url(); ?>assets/js/chart/chart-area.js"></script>
<script src="<?= base_url(); ?>assets/js/chart/pie-chart.js"></script>

<script src="<?= base_url(); ?>assets/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>assets/js/dashboard.js"></script>

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
        $("#barang").addClass("bounceIn");
        $("#supplier").addClass("bounceIn");
        $("#stok").addClass("bounceIn");
        $("#user").addClass("bounceIn");
        $("#grafik").addClass("bounceIn");
        $("#grafikpie").addClass("bounceIn");
        $("#bmterakhir").addClass("bounceIn");
        $("#bkterakhir").addClass("bounceIn");
    })
});
</script>
<?php endif; ?>