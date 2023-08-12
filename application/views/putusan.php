<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row invoice-card-row">

            <!------------------MULAI TABEL -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="table-responsive fs-14">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>

                                </tr>
                                <th>Perkara ID</th>
                                <th>No Arsip</th>
                                <th>No Ruang</th>
                                <th>No Rak</th>
                                <th>No Laci</th>
                                <th>No Boks</th>
                                <th>Nomor Perkara</th>
                                <th>Tanggal Masuk</th>
                                <th>Status</th>
                            </thead>

                        </table>



                    </div>
                </div>
            </div>


        </div>






    </div>

    <script>
    $(function() {
        $("#example1").DataTable({
            "ajax": {
                "url": "<?php echo base_url('Putusan/get_data'); ?>", // Ganti dengan URL yang sesuai
                "type": "POST",
                "dataSrc": ""
            },
            "columns": [{
                    "data": "perkara_id"
                }, {
                    "data": "nomor_arsip"
                },
                {
                    "data": "no_ruang"
                },
                {
                    "data": "no_lemari"
                },
                {
                    "data": "no_rak"
                },
                {
                    "data": "no_berkas"
                },

                {
                    "data": "nomor_perkara"
                },
                {
                    "data": "tanggal_masuk_arsip",
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
                },
                {
                    "data": "status",
                    "render": function(data, type, row) {
                        return '<button class="action-button" data-perkara-id="' + data +
                            '">Action - ' + row.status + '</button>';
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
    </script>