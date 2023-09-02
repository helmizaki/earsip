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
                                <th>Jenis Perkara</th>
                                <th>Status Putusan</th>
                                <th>Pinjam</th>
                                <th>Tanggal Pinjam</th>
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
                <h5 class="modal-title" id="exampleModalLabel">Form Pinjam Berkas</h5>
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
                        <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                        <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                        <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali">
                    </div>
                    <div class="mb-3">
                        <label for="Keperluan" class="form-label">Keperluan</label>
                        <textarea class="form-control" id="keperluan" name="keperluan" rows="3"></textarea>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="Submit_Pinjam">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {

    $('#example1').DataTable({
        "ajax": {
            "url": "<?php echo base_url('Pinjam/get_data'); ?>",
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
                "data": "jenis_perkara_nama",

            },
            {
                "data": "status_putusan"
            },
            {
                "data": "perkara_id",
                "render": function(data, type, row) {
                    return '<center><button onclick="pinjam_arsip(this)" type="button" class="btn btn-primary btn-xs update"  value="' +
                        row.perkara_id + '"> Pinjam</button> </center>';
                }
            },
            {
                "data": "tanggal_pinjam",
                "render": function(data, type, row) {

                    if (data !== null && data !== "" && row
                        .tanggal_kembali === "0000-00-00") {
                        return '<div style="background-color: yellow;">' + data + '</div>';
                    } else if (row.tanggal_kembali !== null && row.tanggal_kembali !== "" && row
                        .tanggal_kembali !== "0000-00-00") {
                        return '<div style="background-color: green;">' + row.tanggal_kembali +
                            '</div>';
                    } else {
                        return data;
                    }
                }
            },
            {
                "data": "tanggal_kembali"
            }

        ],
        "order": [
            [0, "desc"]
        ],
        "columnDefs": [{
            "targets": [6], // Indeks kolom "jenis_perkara_nama"
            "visible": false,
        }],
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]

    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    // Kode untuk menampilkan keterangan
    var kuningCount = $(".has-tanggal-pinjam").length;
    var hijauCount = $(".has-kembali").length;
    console.log("Jumlah kuning:", kuningCount);
    console.log("Jumlah hijau:", hijauCount);

    var keteranganKuning = '<span class="keterangan-kuning"></span> Belum Dikembalikan (' + kuningCount + ')';
    var keteranganHijau = '<span class="keterangan-hijau"></span> Sudah Dikembalikan (' + hijauCount + ')';

    $("#keterangan-warna").html(keteranganKuning + ' | ' + keteranganHijau);


});




function pinjam_arsip(button) {
    var value = button.value;
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo site_url('Pinjam/get_kolom'); ?>",
        data: {
            value: value
        },
        success: function(data) {
            $('#nomor_perkara').val(data.nomor_perkara);
            $('#perkara_id').val(data.perkara_id);
            $('#nama_peminjam').val(data.nama_peminjam);
            $('#keperluan').val(data.keperluan);
            $('#tanggal_kembali').val(data.tanggal_kembali);
            $('#tanggal_pinjam').val(data.tanggal_pinjam);

            $('#myModal').modal('show');
        }
    });

}

var submit_pinjam = document.getElementById("Submit_Pinjam");
submit_pinjam.onclick = function() {
    var perkara_id = $("#perkara_id").val();
    var nomorPerkara = $("#nomor_perkara").val();
    var namaPeminjam = $("#nama_peminjam").val();
    var tanggalPinjam = $("#tanggal_pinjam").val();
    var tanggalKembali = $("#tanggal_kembali").val();
    var keperluan = $("#keperluan").val();

    $.ajax({
        type: "POST",
        url: "Pinjam/simpankedb",
        data: {
            perkara_id: perkara_id,
            nomor_perkara: nomorPerkara,
            nama_peminjam: namaPeminjam,
            tanggal_pinjam: tanggalPinjam,
            tanggal_kembali: tanggalKembali,
            keperluan: keperluan
        },
        dataType: "json",
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