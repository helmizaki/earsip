<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="table-responsive fs-14">
                    <table id="userTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Panitera ID</th>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                </div>

                <!-- Edit User Modal -->
                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editUserForm">
                                    <input type="hidden" id="editUserId" name="id">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="nama_gelar">Nama:</label>
                                            <input type="text" class="form-control" id="nama_gelar" name="nama_gelar" readonly>
                                            <input type="hidden" class="form-control" id="panitera_id" name="panitera_id" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="editNohp">Nomor HP:</label>
                                        <input type="text" class="form-control" id="editNohp" name="nohp" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="update_user">Update</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            "ajax": {
                "url": "<?php echo base_url('User/get_users'); ?>",
                "type": "POST",
                "dataSrc": "data"
            },
            "columns": [{
                    "data": "id",
                },
                {
                    "data": "nama_gelar",
                },
                {
                    "data": "nohp"
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        return '<center><button class="btn btn-primary btn-xs update editUserBtn" data-value="' +
                            row.id + '"> Edit</button> </center>';
                    }

                }
            ],
            "order": [
                [0, "asc"]
            ],
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false

        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        // Fungsi untuk menampilkan modal tambah user
        function addUserModal() {
            // Tampilkan modal tambah user di sini
        }

        $(document).on('click', '.editUserBtn', function() {
            var value = $(this).data('value');
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url('User/get_kolom'); ?>",
                data: {
                    value: value
                },
                success: function(data) {
                    $('#nama_gelar').val(data.nama_gelar);
                    $('#panitera_id').val(data.id);
                    $('#editModal').modal('show');
                }
            });

        });

        var update_user = document.getElementById("update_user");
        update_user.onclick = function() {
            var panitera_id = $("#panitera_id").val();
            var nohp = $("#editNohp").val();

            var formData = new FormData();

            formData.append("panitera_id", panitera_id);
            formData.append("nohp", nohp);

            $.ajax({
                type: "POST",
                url: "User/update_nohp",
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
                    alert("Error: " +
                        error); // Menampilkan pesan error jika terjadi masalah pada AJAX
                }
            });

        }
    });
</script>