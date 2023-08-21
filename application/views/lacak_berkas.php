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
                            <th>Perkara ID</th>
                            <th>Nomor Perkara</th>
                            <th>Tanggal BHT</th>
                            <th>Status Putusan</th>
                            <th>Status</th>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $('#example1').DataTable({
        "ajax": {
            "url": "<?php echo base_url('Berkas/get_data'); ?>",
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
                "data": "tanggal_bht",
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
                "data": "status_putusan"
            },
            {
                "data": "status_id",
                "render": function(data, type, row) {
                    if (row.status_putusan === null || row.status_putusan === "") {
                        return 'Perkara Belum Putus';

                    } else {
                        if (row.tanggal_bht === null || row.tanggal_bht === "") {
                            return 'Perkara Belum BHT';
                        } else {
                            if (data == 3) {
                                return 'Berkas Sudah BOX';
                            } else if (data == 4) {
                                return 'Berkas sedang diPinjam';
                            }

                        }

                    }


                    return data; // Jika nilai tidak sama dengan 1 atau 2, kembalikan nilai asli
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
</script>