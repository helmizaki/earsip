<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="table-responsive fs-14">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>

                            </tr>
                            <th>Nomor</th>
                            <th>Tanggal Putusan</th>
                            <th>Tanggal Minutasi</th>
                            <th>Detail</th>
                        </thead>

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<style>
/* Gaya untuk modal */
.modal-content {
    border-radius: 0;
}

/* Gaya untuk tabel dalam modal */
.table {
    margin-bottom: 0;
}

/* Gaya untuk garis pada tabel */
.table-bordered {
    border: 2px solid #dee2e6;
}

/* Gaya untuk header tabel */
.table-bordered thead th {
    border-bottom: 2px solid #dee2e6;
}

/* Gaya untuk baris tabel */
.table-bordered tbody tr {
    border-bottom: 1px solid #dee2e6;
}

/* Gaya untuk baris terakhir dalam tabel */
.table-bordered tbody tr:last-child {
    border-bottom: none;
}

/* Gaya untuk baris tabel saat dihover */
.table-bordered tbody tr:hover {
    background-color: #f0f0f0;
}
</style>
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" id="modalDialog">
        <div class=" modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Perkara Putus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th><a href="javascript:pilihsemua()">Check All</a></th>
                                <th>Nomor Perkara</th>
                                <th>Tanggal Putusan</th>
                                <th>Tanggal Minutasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table rows will be inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>




<script>
$(function() {
    $("#example1").DataTable({

        "ajax": {
            "url": "<?php echo base_url('Minutasi/get_data'); ?>", // Ganti dengan URL yang sesuai
            "type": "POST",
            "dataSrc": ""
        },
        "columns": [{
                "targets": 0, // Kolom nomor urut
                "data": null,
                "render": function(data, type, full, meta) {
                    return meta.row + 1;
                }
            },
            {
                "data": "tanggal_putusan",
                "render": function(data, type, row) {
                    // Ubah format tanggal dari "YYYY-MM-DD" menjadi "DD-MM-YYYY"
                    var dateObj = new Date(data);
                    var formattedDate = (dateObj.getDate() < 10 ? '0' : '') + dateObj
                        .getDate() + '-' +
                        (dateObj.getMonth() + 1 < 10 ? '0' : '') + (dateObj.getMonth() +
                            1) + '-' +
                        dateObj.getFullYear();
                    return formattedDate;
                }
            }, {
                "data": "tanggal_minutasi",
                "render": function(data, type, row) {
                    // Ubah format tanggal dari "YYYY-MM-DD" menjadi "DD-MM-YYYY"
                    if (data == null) {
                        return data;
                    } else {
                        var dateObj = new Date(data);
                        var formattedDate = (dateObj.getDate() < 10 ? '0' : '') + dateObj
                            .getDate() + '-' +
                            (dateObj.getMonth() + 1 < 10 ? '0' : '') + (dateObj.getMonth() +
                                1) + '-' +
                            dateObj.getFullYear();
                        return formattedDate;

                    }

                }
            },
            {
                "data": "tanggal_putusan",
                "render": function(data, type, row) {
                    return '<center><button onclick="lihat_minutasi(this)" type="button" class="btn btn-primary btn-xs update"  value="' +
                        row.tanggal_putusan + '"> Detail</button> </center>';
                }
            }
            // Tambahkan kolom lainnya di sini
        ],
        "responsive": true,
        "lengthChange": false,
        "autoWidth": true,
        "order": [
            [0, "desc"]
        ],
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

});

function lihat_minutasi2(objButton) {
    var x = document.getElementById("tombol").value;
    alert(objButton.value);
}

function lihat_minutasi(button) {
    var value = button.value;
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo site_url('Minutasi/list_minutasi'); ?>",
        data: {
            value: value
        },
        success: function(data) {
            populateTable(data);

        }
    });

}


function populateTable(data) {
    var tableBody = $("#dataTable tbody");
    tableBody.empty(); // Clear existing rows

    // Loop through the data array and create table rows
    $.each(data, function(index, item) {
        var row = '<tr>' +
            '<td><input type="checkbox" name="perkara_id_putusan" value="' + item.perkara_id + '"></td>' +
            '<td>' + item.nomor_perkara + '</td>' +
            '<td>' + item.tanggal_putusan + '</td>' +
            '<td>' + item.tanggal_minutasi + '</td>' +
            '</tr>';

        tableBody.append(row);

    });



    $('#myModal').modal('show'); // Menampilkan modal

}

function pilihsemua() {
    var perkara_id = document.getElementsByName("perkara_id_putusan");
    var jml = perkara_id.length;
    var b = 0;
    for (b = 0; b < jml; b++) {
        perkara_id[b].checked = true;

    }
}
</script>