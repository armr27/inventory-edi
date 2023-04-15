$(document).ready(function () {
    $('#dtHorizontalExample').DataTable();
});


function filter() {
    var tglawal = $("[name='tglawal']").val();
    var tglakhir = $("[name='tglakhir']").val();
    if (tglawal != '' && tglakhir != '') {
        filterBk(tglawal, tglakhir);
    } else {
        validasi("Tanggal Filter wajib di isi!", "warning");
    }
}

function validasi(judul, status) {
    swal.fire({
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
    $("[name='tglawal']").val("");
    $("[name='tglakhir']").val("");
    ambilBk();
}


function filterBk(tglawal, tglakhir) {
    var link = $('#baseurl').val();
    var base_url = link + 'BarangKeluar/filterBarangKeluar/' + tglawal + '/' + tglakhir + '';


    var t = $('#dtHorizontalExample').DataTable({
        "processing": true,
        "info": false,

        "order": [
            [0, "desc"]
        ],
        lengthChange: false,
        "ajax": {
            "url": base_url,
            "dataSrc": ""
        },
        columns: [
            { "data": "id_barang_keluar" },
            { "data": "id_user" },
            { "data": "tgl_keluar" },
            { "data": "progress" },
            { "data": "id_detail" },
            { "data": "mat_code" },
            { "data": "jumlah_keluar" },
            { "data": "nama" },
            { "data": "Material_Description" }
        ],

        "destroy": true

    });

    t.on('order.dt search.dt', function () {
        t.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();


    $('.dataTables_length').addClass('bs-select');
}