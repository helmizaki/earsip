<div class="content-body">
    <style>
    .matched {
        background-color: green;
        color: white;
    }

    .unmatched {
        background-color: red;
        color: white;
    }
    </style>
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
                            <th>Cetak BAP</th>
                        </thead>

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<style>
tr.unmatched {
    background-color: #ffe6e6;
}

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


<!-- Cetak BAP -->
<div class="modal fade" id="ModalBAP" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" id="modalDialog">
        <div class=" modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cetak BAP Penyerahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label for="tanggal_penyerahan" class="form-label">Tanggal Penyerahan</label>
                    <input style="width: 50%;" type="date" class="form-control" id="tanggal_penyerahan"
                        name="tanggal_penyerahan" required>
                </div>
                <div class="mb-3">
                    <label for="dari">Dari:</label>
                    <select id="dari" name="dari">
                        <option value="Panmud Hukum">Panmud Hukum</option>
                        <option value="Panmud Gugatan">Panmud Gugatan</option>
                        <option value="Panmud Permohonan">Panmud Permohonan</option>
                    </select>
                    <label for="menuju">Ke:</label>
                    <select id="menuju" name="menuju">
                        <option value="Panmud Hukum">Panmud Hukum</option>
                        <option value="Panmud Gugatan">Panmud Gugatan</option>
                        <option value="Panmud Permohonan">Panmud Permohonan</option>
                    </select>

                </div>

                <div class="table-responsive">
                    <form>
                        <table id="dataTableBAP" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><a href="javascript:pilihsemua()">Check All</a></th>
                                    <th>Nomor Perkara</th>
                                    <th>Tanggal Putusan</th>
                                    <th>Tanggal Minutasi</th>
                                    <th>Jenis Perkara</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Table rows will be inserted here -->
                            </tbody>
                        </table>
                        <!-- Tautan unduh ditempatkan di bawah tabel -->

                </div>
                <div id="downloadLinkContainer"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="cetak_BAP">Cetak</button>
            </div>
            </form>
        </div>
    </div>
</div>




<script>
$(document).ready(function() {
    $('#example1').DataTable({
        "ajax": {
            "url": "<?php echo base_url('BAPPenyerahan/get_data'); ?>",
            "type": "POST",
            "dataType": "json",
            "dataSrc": "data"
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
                    var formattedDate = (dateObj.getDate() < 10 ? '0' : '') +
                        dateObj
                        .getDate() + '-' +
                        (dateObj.getMonth() + 1 < 10 ? '0' : '') + (dateObj
                            .getMonth() +
                            1) + '-' +
                        dateObj.getFullYear();
                    return formattedDate;
                }
            },
            {
                "data": "tanggal_minutasi",
                "render": function(data, type, row) {
                    // Ubah format tanggal dari "YYYY-MM-DD" menjadi "DD-MM-YYYY"
                    if (data == null) {
                        return data;
                    } else {
                        var dateObj = new Date(data);
                        var formattedDate = (dateObj.getDate() < 10 ? '0' : '') +
                            dateObj
                            .getDate() + '-' +
                            (dateObj.getMonth() + 1 < 10 ? '0' : '') + (dateObj
                                .getMonth() +
                                1) + '-' +
                            dateObj.getFullYear();
                        return formattedDate;

                    }

                }
            },
            {
                "data": "tanggal_minutasi",
                "render": function(data, type, row) {
                    return '<center><button onclick="get_BAP(this)" type="button" class="btn btn-primary btn-xs update"  value="' +
                        row.tanggal_minutasi + '"> Cetak</button> </center>';
                }
            }

        ],
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "order": [
            [0, "desc"]
        ],
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
});




function get_BAP(button) {
    var value = button.value;
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo site_url('BAPPenyerahan/get_BAP'); ?>",
        data: {
            value: value
        },
        success: function(data) {
            populateTableBAP(data);

        }
    });

}

function populateTableBAP(data) {
    var tableBody = $("#dataTableBAP tbody");
    tableBody.empty(); // Clear existing rows

    // Loop through the data array and create table rows
    $.each(data, function(index, item) {
        var row = '<tr>' +
            '<td><input type="checkbox" class="checkbox_item" name="perkara_id_putusan" value="' +
            item
            .perkara_id + '"></td>' +
            '<td name="nomor_perkara">' + item.nomor_perkara + '</td>' +
            '<td name="tanggal_putusan">' + item.tanggal_putusan + '</td>' +
            '<td name="tanggal_minutasi">' + item.tanggal_minutasi + '</td>' +
            '<td name="jenis_perkara_nama">' + item.jenis_perkara_nama + '</td>' +
            '</tr>';

        tableBody.append(row);

    });
    $('#ModalBAP').modal('show'); // Menampilkan modal

}


function pilihsemua() {
    var perkara_id = document.getElementsByName("perkara_id_putusan");
    var jml = perkara_id.length;
    var b = 0;
    for (b = 0; b < jml; b++) {
        perkara_id[b].checked = true;

    }
}


var cetak_BAP = document.getElementById("cetak_BAP");
cetak_BAP.onclick = function() {
    Swal.fire({
        title: '<strong>Silahkan Di Download pada Link dibawah</u></strong>',
        icon: 'info',
        html: '<a href="<?php echo base_url("template/hasil.xlsx"); ?>">Download</a> ',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Great!',
        confirmButtonAriaLabel: 'Thumbs up, great!'
    })

    var dari = document.getElementById("dari");
    var pilih_dari = dari.value;
    var menuju = document.getElementById("menuju");
    var pilih_menuju = menuju.value;
    var selected_items = [];
    var tanggal_penyerahan = $("#tanggal_penyerahan").val();

    $('.checkbox_item:checked').each(function() {

        var perkara_id = $(this).val();
        var nomor_perkara = $(this).closest('tr').find('td[name="nomor_perkara"]').text();
        var tanggal_putusan = $(this).closest('tr').find('td[name="tanggal_putusan"]').text();
        var tanggal_minutasi = $(this).closest('tr').find('td[name="tanggal_minutasi"]').text();
        var jenis_perkara_nama = $(this).closest('tr').find('td[name="jenis_perkara_nama"]').text();
        selected_items.push({
            perkara_id: perkara_id,
            nomor_perkara: nomor_perkara,
            tanggal_putusan: tanggal_putusan,
            tanggal_minutasi: tanggal_minutasi,
            jenis_perkara_nama: jenis_perkara_nama

        });
    });
    var request_data = {
        pilih_dari: pilih_dari,
        pilih_menuju: pilih_menuju,
        tanggal_penyerahan: tanggal_penyerahan,
        selected_items: selected_items
    };

    if (selected_items.length > 0) {
        $.ajax({
            url: '<?php echo base_url("BAPPenyerahan/CetakKeWord"); ?>',
            type: 'POST',
            data: request_data,
            dataType: 'json',
            success: function(response) {


            }
        });

    } else {
        alert('Tidak ada data yang dipilih.');
    }

}
</script>