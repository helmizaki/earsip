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
                            <th>Nomor Perkara</th>
                            <th>Jenis Perkara</th>
                            <th>Tanggal Masuk SIPP</th>
                            <th>Tanggal Validasi Minutasi</th>
                            <th>Tanggal Box</th>
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
<div class="modal fade" id="ModalLaporan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" id="modalDialog">
        <div class=" modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cetak Laporan Validasi Minutasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <h3 class="text-center">Tanggal Validasi</h3>
                        <div></div>
                        <div></div>
                        <div class="form-group col-md-2">
                            <input type="date" class="tanggal form-control " id="tgl_start" value="<?php echo date('d/m/Y'); ?>">
                        </div>
                        <div class="form-group col-md-2">
                            <input type="date" class="tanggal form-control " id="tgl_finish" value="<?php echo date('d/m/Y'); ?>">
                        </div>

                        <div class="form-row justify-content-center">


                            <button id="cetak_btn" type="button" class="mb-2 btn btn-warning mr-2">Cetak</button>


                        </div>
                        <div class="form-row justify-content-center">
                            <div id="isi" class="row justify-content-center">
                            </div>

                        </div>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#example1').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                text: 'My button',
                action: function(e, dt, node, config) {
                    alert('Button activated');
                }
            }],
            "ajax": {
                "url": "<?php echo base_url('DaftarMinutasi/get_data'); ?>",
                "type": "POST",
                "dataSrc": ""
            },
            "columns": [{
                    "data": "nomor_perkara",
                },
                {
                    "data": "jenis_perkara_nama",
                },
                {
                    "data": "tanggal_masuk_arsip",
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
                    "data": "tanggal_validasi",
                    "render": function(data, type, row) {
                        if (data == null) {
                            return '<div class="text-danger"><i class="fas fa-times-circle"></i> Belum divalidasi </div>';
                        }
                        var dateObj = new Date(data); // Membuat objek Date dari timestamp
                        var day = dateObj.getDate();
                        var month = dateObj.getMonth() + 1; // Perhatikan bahwa bulan dimulai dari 0
                        var year = dateObj.getFullYear();
                        var hours = dateObj.getHours();
                        var minutes = dateObj.getMinutes();
                        var seconds = dateObj.getSeconds();

                        // Formatting dengan tambahan '0' jika diperlukan
                        if (day < 10) day = '0' + day;
                        if (month < 10) month = '0' + month;
                        if (hours < 10) hours = '0' + hours;
                        if (minutes < 10) minutes = '0' + minutes;
                        if (seconds < 10) seconds = '0' + seconds;

                        // Hasilkan format tanggal Indonesia (DD-MM-YYYY HH:mm:ss)
                        return day + '-' + month + '-' + year + ' ' + hours + ':' + minutes + ':' +
                            seconds;
                    }
                },
                {
                    "data": "tanggal_box",
                    "render": function(data, type, row) {
                        // Ubah format tanggal dari "YYYY-MM-DD" menjadi "DD-MM-YYYY"
                        if (data == null) {
                            return '<div class="text-danger"><i class="fas fa-times-circle"></i> Belum diisi </div>';
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
                }
            ],

            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "order": [
                [3, "desc"]
            ],
            "buttons": [{
                text: 'Cetak Laporan',
                action: function(e, dt, node, config) {
                    $('#ModalLaporan').modal('show');
                }
            }]

        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    var cetak_BAP = document.getElementById("cetak_btn");
    cetak_BAP.onclick = function() {
        var tgl_start = $('#tgl_start').val();
        var tgl_finish = $('#tgl_finish').val();
        $.ajax({
            url: "<?php echo base_url(); ?>LapMinutasi/cetak_laporan",
            type: "POST",
            data: {
                "tgl_start": tgl_start,
                "tgl_finish": tgl_finish
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var downloadURL = '<?php echo base_url("template/laporan/laporan_minutasi.xlsx"); ?>';
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

    }
</script>