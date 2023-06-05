$(document).ready(function () {
    $('#dtHorizontalExample').DataTable();
});

function filter() {
    var tglawal = $("[name='tglawal']").val();
    var tglakhir = $("[name='tglakhir']").val();
    if (tglawal != '' && tglakhir != '') {
    } else {
        validasi("Tanggal Filter wajib di isi!", "warning");
        return false;
    }
}

function filterBulan() {
    let tglbulan = $("[name='bulan']").val();
    console.log(tglbulan);
    if (tglbulan !== '') {
        // Lakukan aksi yang diinginkan, seperti mengarahkan pengguna ke halaman yang ingin dicetak
    } else {
        validasi("Silahkan Pilih Bulan Terlebih Dahulu Sebelum Mencetak", "warning");
        return false;
    }
}


function validasi(judul, status) {
    Swal.fire({
        title: judul,
        icon: status,
        confirmButtonColor: '#4e73df',
    });
}



function refresh() {
    var t = $('#dtHorizontalExample').DataTable();
    t.ajax.reload();
}



function reset() {
    $("[name='cari']").val("");
}



