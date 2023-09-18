<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div id="keterangan-warna">
                </div>

                <div class="table-responsive fs-14">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>

                                <th>Perkara ID</th>
                                <th>Nomor Perkara</th>
                                <th>Tanggal Putus</th>
                                <th>Buku Nikah </th>
                            </tr>
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
    border-radius: 10px;
}

.modal-header {
    background-color: #f8f9fa;
    border-bottom: none;
}

.modal-title {
    color: #333;
}

/* Gaya untuk form */
.form-label {
    font-weight: bold;
    color: #555;
}

.form-control {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
}

.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Gaya untuk tombol */
.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}
</style>
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" id="modalDialog">
        <div class=" modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Upload Buku Nikah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="nomor_perkara" class="form-label">Nomor Perkara</label>
                        <input type="text" class="form-control" id="nomor_perkara" name="nomor_perkara" readonly>
                        <input type="hidden" class="form-control" id="perkara_id" name="perkara_id" readonly>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="akta_nikah" id="buku_nikah"
                                value="buku_nikah" checked>
                            <label class="form-check-label" for="buku_nikah">
                                Buku Nikah
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="akta_nikah" id="suket_nikah"
                                value="suket_nikah">
                            <label class="form-check-label" for="suket_nikah">
                                Suket / Register Buku Nikah
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Pilih gambar</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="upload_buku_nikah">Upload</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {

    $('#example1').DataTable({
        "ajax": {
            "url": "<?php echo base_url('BukuNikah/get_data'); ?>",
            "type": "POST",
            "dataSrc": "data"
        },
        "columns": [{
                "data": "perkara_id",
            },
            {
                "data": "nomor_perkara",
            },
            {
                "data": "tanggal_putusan",
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
                "data": "url",
                "render": function(data, type, row) {
                    if (data) {
                        // Jika data gambar ada, tampilkan sebagai tautan (link)
                        return '<center><a href="' + data +
                            '" target="_blank">Lihat Gambar</a></center>';
                    } else {
                        // Jika data gambar tidak ada, tampilkan tombol "Upload"
                        return '<center><button onclick="upload_P(this)" type="button" class="btn btn-primary btn-xs update"  value="' +
                            row.perkara_id + '">Upload</button></center>';
                    }
                }
            }
        ],
        "order": [
            [0, "desc"]
        ],

        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]

    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');



});




function upload_P(button) {
    var value = button.value;
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo site_url('BukuNikah/get_kolom'); ?>",
        data: {
            value: value
        },
        success: function(data) {
            $('#nomor_perkara').val(data.nomor_perkara);
            $('#perkara_id').val(data.perkara_id);
            $('#myModal').modal('show');
        }
    });

}



var Upload_bukti = document.getElementById("upload_buku_nikah");
Upload_bukti.onclick = function() {
    var perkara_id = $("#perkara_id").val();
    var akta_nikah = $("input[name='akta_nikah']:checked").val();

    var formData = new FormData();

    formData.append("perkara_id", perkara_id);
    formData.append("akta_nikah", akta_nikah);
    formData.append("image", $("#image")[0].files[0]);

    $.ajax({
        type: "POST",
        url: "BukuNikah/upload",
        data: formData,
        dataType: "json",
        processData: false,
        contentType: false,
        success: function(response) {
            console.log(response); // Periksa respons di konsol
            alert(response.message); // Menampilkan pesan dari respons
            if (response.status === 'success') {
                location.reload(); // Reload halaman jika berhasil disimpan
            }

        },
        error: function(xhr, status, error) {
            alert("Error: " + error); // Menampilkan pesan error jika terjadi masalah pada AJAX
        }
    });

}
</script>