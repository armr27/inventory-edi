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

function bulan_indo($tglbulan)
{

  $nama_bulan = array(

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

  $pecahkan = explode('-', $tglbulan);
  $index_bulan = (int)$pecahkan[1];
  $nama_bulan_indo = $nama_bulan[$index_bulan];
  return $nama_bulan_indo . ' ' . $pecahkan[0];
}

?>



<!DOCTYPE html>

<html>

<head>

  <title><?= $judul ?></title>

  <style type="text/css">
        .style1 {
            font-size: 14px;
            font-weight: bold;
        }

        .style2 {
            font-size: 14px;
            padding-right: 70px;

        }

        .style4 {
            font-size: 12px;
            font-weight: bold;
        }

        .style6 {
            font-size: 24px;
            font-weight: bold;
            padding-right: 70px;
        }

        .tglfilter{
          font-size: 12px;

        }
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
        <table width="800" border="0" align="center" cellpadding="0" cellspacing="1">


            <tr class="brs_isi">
                <td valign="top">
                    <br>
                    <br>
                    <table width="650" border="0" align="center" cellpadding="2" cellspacing="1">

                        <tr align="center">
                            <td width="67" rowspan="5" align="left">
                                <div align="center">
                                </div>
                                <div align="left"></div>
                                <div align="center" class="style1"></div>
                                <div align="left">
                                    <input name="imageField" type="image" src="<?= base_url("assets/icon/R.png") ?>" width="120" height="30" >
                                </div>
                            </td>
                            <!-- <td align="left">
                                <div align="center" class="style4">YAYASAN PENDIDIKAN MAKMUR RIDAR (YPMR)</div>
                            </td>
                            <td align="left">&nbsp;</td> -->
                        </tr>
                        <tr align="center">
                            <td width="503" align="left">

                                <!-- <div align="center"><span class="style1">SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER</span></div>
                             -->
                             
                            </td>
                        </tr>
                        <tr align="center">
                            <td align="left">
                                <div align="center"><span class="style6">PT. ENERGI SEJAHTERA MAS </span></div>
                            </td>
                            <td align="left">&nbsp;</td>
                        </tr>
                        <tr align="center">
                            <td align="left">
                                <div align="center"> <span class="style2"> Telp. (+65)67158438, Email : inquiries@sinarmascepsa.com</span> </div>
                            </td>
                            <td align="left">&nbsp;</td>
                        </tr>
                        <tr align="center">
                            <td align="left">
                                <div align="center"> <span class="style2">Jln. Lubuk Gaung, Kec. Sungai Sembilan, Kota Dumai, Riau </span> </div>
                            </td>
                            <td align="left">&nbsp;</td>
                        </tr>
                        <tr align="center">
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
                        </tr>
                        <tr align="center">
                            <td colspan="3" align="left">
                                <div align="center" class="style1">LAPORAN BARANG KELUAR</div>
                                <div align="left"></div>
                            </td>
                        </tr>
                        <tr align="center">
                        <?php if ($tglbulan !== "" && $tgltahun == "" && $tglawal == "" && $tglakhir == "") { ?>
                            <td colspan="3" align="left">
                                <div align="center" class="tglfilter">Berikut Laporan Menyeluruh pada Bulan <?= bulan_indo($tglbulan);?>   </div>
                                <div align="left"></div>
                            </td>
                        <?php } else if ($tglbulan == "" && $tgltahun !== "" && $tglawal == "" && $tglakhir == "") { ?>
                            <td colspan="3" align="left">
                                <div align="center" class="tglfilter">Berikut Laporan Menyeluruh pada Tahun <?= $tgltahun ; ?>   </div>
                                <div align="left"></div>
                            </td>
                          <?php } else if ($tglawal == '' || $tglakhir == '' ){ ?>
                            <td colspan="3" align="left">
                                <div align="center" class="tglfilter">Semua</div>
                                <div align="left"></div>
                            </td>

                            <?php } else { ?>
                            <td colspan="3" align="left">
                                <div align="center" class="tglfilter">Berikut Laporan dimulai dari tanggal <?= tgl_indo($tglawal);?>  hingga <?= tgl_indo($tglakhir) ?>  </div>
                                <div align="left"></div>
                            </td>
                              <?php } ?>
                        </tr>
                    </table>
                    <table border="1" id="customers" class="keliling" width="650" align="center">
                      <tr class="batas" align="center">
                        <th width = "1%">No</th>
                        <th width = "10%">Mat Code</th>
                        <th width = "20%">Material Description</th>
                        <th width = "10%">Tanggal Keluar</th>
                        <th width = "15%">Nama Pengguna</th>
                        <th width = "6%">Jumlah Keluar</th>
                      </tr>

    <?php
    $no = 1;
    foreach ($data as $d) { ?>
      <tr class="batas2" align="center">
        <td><?= $no++ ?></td>
        <td><?= $d->mat_code ?></td>
        <td><?= $d->Material_Description ?></td>
        <td><?= tgl_indo($d->tgl_keluar)  ?></td>
        <td><?= $d->nama ?></td>
        <td><?= $d->jumlah_keluar ?></td>
      </tr>

    <?php } ?>


  </table>
                    <br>
                    <br>
                    <table align="center" width="800px">
                        <tr>
                            <td width="500px"> </td>
                            <td align="center">
                                Dumai, <?= tgl_indo(date("Y-m-d")); ?>
                                <br>
                                <br>
                                <br>
                                <br>
                                ___________________________
                            </td>
                        </tr>
                        <tr>
                            <td width="500px"> </td>
                            <td align="center"> Kepala Gudang</td>

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