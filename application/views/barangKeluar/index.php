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
        <h1 class="h3 mb-0 text-gray-800">Barang Keluar</h1>
        <a href="<?= base_url() ?>barangKeluar/tambah" class="btn btn-sm btn-primary btn-icon-split">
            <span class="text text-white">Tambah Data</span>
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
        </a>

    </div>

    <div class="col-lg-12 mb-4" id="container">

        <!-- Illustrations -->
        <div class="card border-bottom-secondary shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="dtHorizontalExample" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th>No.Transaksi</th>
                                <th>Tgl Keluar</th>
                                <th>Nama Member</th>
                                <th>Status</th>
                                <th width="1%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <?php $no=1; foreach ($bk as $bk): ?>
                            <tr>
                                <td><?= $no++ ?>.</td>
                                <td><?= $bk->id_barang_keluar ?></td>
                                <td><?= tgl_indo($bk->tgl_keluar) ?></td>
                                <td><?= $bk->nama?></td>
                                <td>
                                    <?php if($bk->progress == "Proses") {?>
                                        <span class="badge badge-warning">Dalam Proses</span>
                                        <?php } else {?>
                                            <span class="badge badge-success">Selesai</span>
                                            <?php } ?>
                                </td>
                                <td>
                                    <center>
                                        <a href="<?= base_url() ?>barangKeluar/detail/<?= $bk->id_barang_keluar ?>"
                                            class="btn btn-circle btn-primary btn-sm">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </a>
                                        <?php if ($this->session->userdata('login_session')['level'] == 'admin') { ?>
                                        <a href="#"
                                        <?php if ($bk->progress == "Proses") {?>
                                        onclick="selesai('<?= $bk->id_barang_keluar ?>')"
                                        <?php } ?>
                                            class="btn btn-circle btn-success btn-sm">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </a>
                                        <a href="#"
                                        onclick="konfirmasi('<?= $bk->id_barang_keluar ?>')"
                                        class="btn btn-circle btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                        </a>
                                    <?php } ?>
                                    </center>
                                </td>
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

</div>
<!-- End of Main Content -->

<script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/js/barangKeluar.js"></script>

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
      
    })
});
</script>
<?php endif; ?>