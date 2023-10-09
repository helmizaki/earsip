<div class="content-body">
    <!-- Page Header -->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <h3 class="text-center">Laporan Rekap Penataan Arsip Bulanan</h3>
            <h3 class="text-center">Pengadilan Agama Ngawi</h3>

            <div class="text-center">
                <strong>Tanggal Laporan</strong>
            </div>

            <div class="form-row align-items-center justify-content-center">
                <div class="form-group col-md-2">
                    <select class="form-select" aria-label="Default select example" id="bulan" name="bulan">
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <input type="text" id="tahun" name="tahun" class="form-control" placeholder="Tahun">
                </div>

                <div class="form-group col-md-1 text-center">
                    <button type="button" class="mb-2 btn btn-success mr-2" onclick="tampil_data()">Tampil</button>
                </div>





            </div>
            <div class="form-row justify-content-center">
                <div class="form-group col-md-2 text-center">
                    <button id="cetak_btn" type="button" class="mb-2 btn btn-warning mr-2" style="display:none"
                        onClick="window.location.href='<?php echo base_url("template/Laporan Arsip Bulanan.xlsx"); ?>'">Download</button>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
    // Fungsi untuk mengatur nilai tahun ke tahun saat ini
    function setDefaultYear() {
        var yearInput = document.getElementById("tahun");
        var currentYear = new Date().getFullYear();
        yearInput.value = currentYear;
    }

    // Panggil fungsi setDefaultYear saat halaman dimuat
    window.onload = setDefaultYear;

    function tampil_data() {

        var bulan = $('#bulan').val();
        var tahun = $('#tahun').val();
        $("#content").hide();
        $("#loading").show();
        $('#isi').html("");
        $.ajax({
            url: "<?php echo base_url(); ?>LapArsip/CetakKeWord",
            type: "POST",
            data: {
                "bulan": bulan,
                "tahun": tahun
            },
            dataType: "html",
            success: function(data) {
                $("#loading").hide();
                $('#isi').html(data);
                $("#cetak_btn").show();
            }
        });
    }
    </script>