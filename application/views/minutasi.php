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
                            <th>Aksi</th>
                            <th>Validasi</th>
                            <th>Cetak BAP</th>
                        </thead>

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<style>
#ModalBAP .modal-dialog {
    max-width: 90%;
    /* Atur lebar maksimal modal sesuai kebutuhan */
    max-height: 90vh;
    /* Atur tinggi maksimal modal sesuai kebutuhan */
}

#ModalBAP .modal-body {
    max-height: 400px;
    /* Sesuaikan tinggi maksimal sesuai kebutuhan */
    overflow-y: auto;
}

#myModal .modal-dialog {
    max-width: 90%;
    /* Atur lebar maksimal modal sesuai kebutuhan */
    max-height: 90vh;
    /* Atur tinggi maksimal modal sesuai kebutuhan */
}

#myModal .modal-body {
    max-height: 400px;
    /* Sesuaikan tinggi maksimal sesuai kebutuhan */
    overflow-y: auto;
}



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
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" id="modalDialog">
        <div class=" modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Perkara Putus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="table-responsive">
                    <form action="<?php echo base_url(); ?>register_c/validasi/register_validasi_putusan_simpan"
                        method="post">
                        <table id="dataTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><a href="javascript:pilihsemua()">Check All</a></th>
                                    <th>Nomor Perkara</th>
                                    <th>Jenis Perkara</th>
                                    <th>PP</th>
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
                <button type="button" class="btn btn-primary" id="submit_minutasi">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>



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
                        <?php
                        foreach ($list_pp as $pp) {
                            echo '<option value="' . $pp->nama_gelar . '">' . $pp->nama_gelar . '</option>';
                        }
                        ?>
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
                                    <th>Tanggal Minutasi</th>
                                    <th>Panitera Pengganti</th>
                                    <th>Jenis Perkara</th>
                                    <th>Jenis Putusan</th>
                                    <th>Hapus</th>
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
            "url": "<?php echo base_url('Minutasi/get_data'); ?>",
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
                "data": "tanggal_putusan",
                "render": function(data, type, row) {
                    return '<center><button onclick="lihat_minutasi(this)" type="button" class="btn btn-primary btn-xs update"  value="' +
                        row.tanggal_putusan + '"> Validasi</button> </center>';
                }
            }, {
                "data": "matched", // Menggunakan kunci matched dari respons JSON
                "render": function(data, type, row) {
                    if (data == "matched") {
                        return '<div class="status matched">Sudah Validasi</div>';
                    } else {
                        return '<div class="status unmatched">Belum validasi</div>';
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
        "createdRow": function(row, data, dataIndex) {
            console.log('createdRow called for row ' + dataIndex);
            if (data.matched) {
                $(row).find('td:eq(4)').addClass(
                    'matched'); // Ganti '4' dengan indeks kolom "matched"
            } else {
                $(row).find('td:eq(4)').addClass(
                    'unmatched'); // Ganti '4' dengan indeks kolom "matched"
            }
        }
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

function get_BAP(button) {
    var value = button.value;
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo site_url('Minutasi/get_BAP'); ?>",
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
            '<td name="tanggal_minutasi">' + item.tanggal_minutasi + '</td>' +
            '<td name="pp">' + item.nama_gelar + '</td>' +
            '<td name="jenis_perkara_nama">' + item.jenis_perkara_nama + '</td>' +
            '<td name="jenis_putusan">' + item.nama + '</td>' +
            '<td><bu    tton data-perkara-id="' + item.perkara_id +
            '" onclick="hapusVD(this)" type="button" class="btn btn-primary btn-xs update"> Hapus</button></td>' +

            '</tr>';

        tableBody.append(row);

    });
    $('#ModalBAP').modal('show'); // Menampilkan modal

}


function populateTable(data) {
    var tableBody = $("#dataTable tbody");
    tableBody.empty(); // Clear existing rows

    // Loop through the data array and create table rows
    $.each(data, function(index, item) {
        var row = '<tr>' +
            '<td><input type="checkbox" class="checkbox_item" name="perkara_id_putusan" value="' +
            item
            .perkara_id + '"></td>' +
            '<td name="nomor_perkara">' + item.nomor_perkara + '</td>' +
            '<td name="jenis_perkara">' + item.jenis_perkara_nama + '</td>' +
            '<td name="pp">' + item.panitera_pengganti_text + '</td>' +
            '<td name="tanggal_putusan">' + item.tanggal_putusan + '</td>' +
            '</tr>';

        tableBody.append(row);

    });

    $('#myModal').modal('show'); // Menampilkan modal

}

function hapusVD(button) {
    var perkaraId = $(button).data('perkara-id');

    // Show a confirmation dialog before proceeding
    var confirmation = confirm("Are you sure you want to delete this item?");

    if (confirmation) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url('Minutasi/hapusVD'); ?>",
            data: {
                perkaraId: perkaraId
            },
            success: function(response) {

                location.reload(); // Reload halaman jika berhasil disimpan
                // Menampilkan pesan error jika terjadi masalah pada AJAX
            }
        });
    } else {
        // The user clicked Cancel in the confirmation dialog
        alert("Deletion canceled.");
    }
}



function pilihsemua() {
    var perkara_id = document.getElementsByName("perkara_id_putusan");
    var jml = perkara_id.length;
    var b = 0;
    for (b = 0; b < jml; b++) {
        perkara_id[b].checked = true;

    }
}

var submit_minutasi = document.getElementById("submit_minutasi");
submit_minutasi.onclick = function() {
    var messageDisplayed = false; // Flag to track if the message has been displayed
    var successMessages = [];
    var existsMessages = [];
    var selected_items = [];

    $('.checkbox_item:checked').each(function() {

        var perkara_id = $(this).val();
        var nomor_perkara = $(this).closest('tr').find('td[name="nomor_perkara"]').text();
        var tanggal_putusan = $(this).closest('tr').find('td[name="tanggal_putusan"]').text();
        var tanggal_minutasi = $(this).closest('tr').find('td[name="tanggal_minutasi"]').text();
        selected_items.push({
            perkara_id: perkara_id,
            nomor_perkara: nomor_perkara,
            tanggal_putusan: tanggal_putusan,
            tanggal_minutasi: tanggal_minutasi
        });
    });

    if (selected_items.length > 0) {
        $.ajax({
            url: '<?php echo base_url("Minutasi/insertToDatabase"); ?>',
            type: 'POST',
            data: {
                selected_items: selected_items
            },
            dataType: 'json',
            success: function(response) {
                for (var i = 0; i < response.length; i++) {
                    var itemStatus = response[i];
                    var nomor_perkara = itemStatus.nomor_perkara;
                    var status = itemStatus.status;

                    if (status === 'success') {
                        successMessages.push('Nomor Perkara ' + nomor_perkara +
                            ' Berhasil di submit.');
                    } else if (status === 'exists') {
                        existsMessages.push('Nomor Perkara ' + nomor_perkara +
                            ' sudah pernah di minutasi.');
                    }
                }
                if (!messageDisplayed) {
                    var finalMessage = "Data berhasil masuk !!!\n\n";
                    if (successMessages.length > 0) {
                        finalMessage += "Success:\n" + successMessages.join("\n") + "\n\n";
                        location.reload();
                    }
                    if (existsMessages.length > 0) {
                        finalMessage += "Exists:\n" + existsMessages.join("\n") + "\n\n";
                        location.reload();
                    }

                    alert(finalMessage); // Display the combined message
                    messageDisplayed = true; // Set the flag to true after displaying the message
                }
            },
            error: function() {
                console.log('Error occurred during AJAX request.');
            }
        });
    } else {
        alert('Tidak ada data yang dipilih.');
    }


}


var cetak_BAP = document.getElementById("cetak_BAP");
cetak_BAP.onclick = function() {

    var dari = document.getElementById("dari");
    var pilih_dari = dari.value;
    var menuju = document.getElementById("menuju");
    var pilih_menuju = menuju.value;
    var selected_items = [];
    var tanggal_penyerahan = $("#tanggal_penyerahan").val();

    $('.checkbox_item:checked').each(function() {

        var perkara_id = $(this).val();
        var nomor_perkara = $(this).closest('tr').find('td[name="nomor_perkara"]').text();
        var pp = $(this).closest('tr').find('td[name="pp"]').text();
        var tanggal_minutasi = $(this).closest('tr').find('td[name="tanggal_minutasi"]').text();
        var jenis_putusan = $(this).closest('tr').find('td[name="jenis_putusan"]').text();
        var jenis_perkara_nama = $(this).closest('tr').find('td[name="jenis_perkara_nama"]').text();
        selected_items.push({
            perkara_id: perkara_id,
            nomor_perkara: nomor_perkara,
            pp: pp,
            tanggal_minutasi: tanggal_minutasi,
            jenis_perkara_nama: jenis_perkara_nama,
            jenis_putusan: jenis_putusan
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
            url: '<?php echo base_url("Minutasi/CetakKeWord"); ?>',
            type: 'POST',
            data: request_data,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var downloadURL = '<?php echo base_url("template/hasil.xlsx"); ?>';
                    var downloadLink = '<a href="' + downloadURL + '" target="_blank">Download</a>';

                    Swal.fire({
                        title: '<strong>Silahkan Di Download pada Link dibawah</strong>',
                        icon: 'info',
                        html: downloadLink,
                        showCloseButton: true,
                        showCancelButton: true,
                        focusConfirm: false,
                        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Great!',
                        confirmButtonAriaLabel: 'Thumbs up, great!'
                    });
                } else {
                    // Jika respons bukan sukses, tangani sesuai kebutuhan Anda
                    alert('Gagal membuat file Excel: ' + response.message);
                }

            }
        });

    } else {
        alert('Tidak ada data yang dipilih.');
    }

}
</script>