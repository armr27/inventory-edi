$(document).ready(function () {
    $('#dtHorizontalExample').DataTable({
        "scrollX": true
    });
    $('.dataTables_length').addClass('bs-select');

    ambilBarang();
});

function ambilBarang() {
    var link = $('#baseurl').val();
    var base_url = link + 'barangKeluar/getBarang';
    var barang = $('[name="barang"]').val();
    console.log(barang);
    if (barang == '') {
        $('#preview').attr("src", link + "assets/upload/barang/box.png");
        $('#judul').text("-");
        $('#stok').text("-");
    } else {
        $.ajax({
            type: 'POST',
            data: 'id=' + barang,
            url: base_url,
            dataType: 'json',
            success: function (hasil) {
                // $('#preview').attr("src", link + "assets/upload/barang/" + hasil[0].foto);
                $('#preview').attr("src", link + "assets/upload/barang/box.png");
                $('#judul').text(hasil[0].Material_Description);
                getTotalStok(hasil[0].Stock, hasil[0].Mat_Code);
            }
        });
    }
}



function getTotalStok(stok, id) {
    var link = $('#baseurl').val();
    var base_url = link + 'barangKeluar/getTotalStok';

    $.ajax({
        type: 'POST',
        data: {
            id: id
        },
        url: base_url,
        dataType: 'json',
        success: function (hasil) {
            $('#stok').text((hasil.Stock));
        }
    });

}


function detail(id) {
    var base_url = $('#baseurl').val();
    window.location.href = base_url + "barangKeluar/detail_data/" + id;

}

// selesai proses barang Keluar
function selesai(id) {
    var base_url = $('#baseurl').val();

    swal.fire({
        title: "Apakah Anda Yakin Proses Peminjaman Telah Selesai?",
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
                    window.location.href = base_url + "barangKeluar/proses_selesai/" + id;
                }
            );
        }
    });

}


function konfirmasi(id) {
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
                    window.location.href = base_url + "barangKeluar/proses_hapus/" + id;
                }
            );
        }
    });

}