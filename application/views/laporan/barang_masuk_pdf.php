<?php
function tgl_indo($tanggal)
{
  $bulan = array(
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

  // variabel pecahkan 0 = tanggal
  // variabel pecahkan 1 = bulan
  // variabel pecahkan 2 = tahun

  return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}
?>

<html>

<head>
  <title>Sinarmas Cepsa</title>
  <style type="text/css">
    <!--
    .style1 {
      font-size: 14px;
      font-weight: bold;
    }

    .style2 {
      font-size: 14px
    }

    .style4 {
      font-size: 12px;
      font-weight: bold;
    }

    .style6 {
      font-size: 24px;
      font-weight: bold;
    }
    -->
    .keliling
    {
    border-collapse:collapse;
    font-size:12px;
    }
    .keliling
    tr
    td
    {
    border:1px
    #000
    solid;
    }
    .atas
    {
    font-size:12px;
    }
    .bawah
    {
    font-size:12px;
    }

  </style>
</head>

<body>

  <form action="<?php $PHP_SELF; ?>" method="post" name="form1" target="_self">
    <table width="750" border="1" align="center" cellpadding="0" cellspacing="1">


      <tr class="brs_isi">
        <td valign="top">
          <br>
          <br>
          <table width="650" border="0" align="center" cellpadding="2" cellspacing="1">

            <!-- <tr align="center">
                            <td width="67" rowspan="4" align="left">
                                <div align="center">
                                </div>
                                <div align="left"></div>
                                <div align="center" class="style1"></div>
                                <div align="left">
                                    <input name="imageField" type="image" src="logo.png" width="80" height="80">
                                </div>
                            </td>
                            <td align="left">
                                <div align="center" class="style4">YAYASAN PENDIDIKAN MAKMUR RIDAR (YPMR)</div>
                            </td>
                            <td align="left">&nbsp;</td>
                        </tr>
                        <tr align="center">
                            <td width="503" align="left">
                                <div align="center"><span class="style1">SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER</span></div>
                            </td>
                            <td width="69" align="left">&nbsp;</td>
                        </tr>
                        <tr align="center">
                            <td align="left">
                                <div align="center"><span class="style6">[STMIK] DUMAI </span></div>
                            </td>
                            <td align="left">&nbsp;</td>
                        </tr>
                        <tr align="center">
                            <td align="left">
                                <div align="center">Jl. Sungai Rokan No. 95 Dumai, Riau, Indonesia 28814</div>
                            </td>
                            <td align="left">&nbsp;</td>
                        </tr> -->
            <!-- <tr align="center">
                            <td colspan="3" align="left">
                                <div align="left">
                                    <hr width="650" size="1px solid" noshade color="#CC6600">
                                </div>
                            </td>
                        </tr>
                        <tr align="center">
                            <td colspan="3" align="left">
                                <div align="left"></div>
                            </td>
                        </tr> -->
            <tr align="center">
              <td colspan="3" align="left">
                <div align="center" class="style1 style2">LAPORAN BARANG MASUK SINARMAS CEPSA</div>
                <div align="left"></div>
              </td>
            </tr>
            <tr>
              <td align="center">
                <?php if ($tglawal == '' || $tglakhir == '') : ?>
                  <h6>Semua Tanggal</h6>
                <?php else : ?>
                  <h6><?= tgl_indo($tglawal) ?> - <?= tgl_indo($tglakhir) ?></h6>
                <?php endif; ?>

              </td>
            </tr>
          </table>
          <br>

          <table width="650" border="0" align="center" cellpadding="2" cellspacing="1" class="keliling">
            <thead>
              <tr class="batas2" align="center">
                <td rowspan="2" width="2%"><b>NO.</b></td>
                <td rowspan="2" width="6%"><b>Tanggal Masuk</b></td>
                <td rowspan="2" width="6%"><b>No. Transaksi</b></td>
                <td rowspan="2" width="6%"><b>Suplier</b></td>
                <td rowspan="2" width="6%"><b>Nama Barang</b></td>
                <td rowspan="2" width="6%"><b>Jumlah Masuk</b></td>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($data as $d) { ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= tgl_indo($d->tgl_masuk) ?></td>
                  <td><?= $d->id_barang_masuk ?></td>
                  <td><?= $d->nama_supplier ?></td>
                  <td><?= $d->nama_barang ?></td>
                  <td><?= $d->jumlah_masuk ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
          <br>
          <br>
          <table align="center" width="800px">
            <tr>
              <td width="500px"> </td>
              <td align="center">
                Dumai, <?php echo date("d M Y"); ?>
                <br>
                <br>
                <br>
                <br>
                ___________________________
              </td>

            </tr>
          </table>
          <p>&nbsp;</p>
        </td>
      </tr>
    </table>
    <?php
    echo "<script language=javascript>
function printWindow() {
bV = parseInt(navigator.appVersion);
if (bV >= 4) window.print();}
printWindow();
</script>";
    ?>
  </form>
  <br>
  <br>
  <br>
</body>

</html>