          <!-- / .main-navbar -->
          <div class="content-body">
              <!-- Page Header -->
              <div class="container-fluid">
                  <div class="row justify-content-center">
                      <h3 class="text-center">Laporan Rekap Minutasi Tenanan</h3>
                      <h3 class="text-center">Pengadilan Agama Ngawi</h3>
                      <div></div>
                      <strong class="text-center">Tanggal Laporan</strong>
                      <div class="form-group col-md-2">
                          <input type="date" class="tanggal form-control " id="tgl_start"
                              value="<?php echo date('d/m/Y'); ?>">
                      </div>
                      <div class="form-group col-md-2">
                          <input type="date" class="tanggal form-control " id="tgl_finish"
                              value="<?php echo date('d/m/Y'); ?>">
                      </div>
                      <div class="form-group col-md-1">
                          <button type="button" class="mb-2 btn btn-success mr-2"
                              onclick="tampil_data()">Tampil</button>
                      </div>

                      <div class="form-row justify-content-center">

                          <div class="form-group col-md-2">
                              <button id="cetak_btn" type="button" class="mb-2 btn btn-warning mr-2"
                                  style="display:none" onClick="window.print();return false">Cetak</button>
                          </div>

                      </div>
                      <div class="form-row justify-content-center">
                          <div id="isi" class="row justify-content-center">
                          </div>

                      </div>
                  </div>


              </div>


          </div>


          <script type="text/javascript">
function tampil_data() {

    var tgl_start = $('#tgl_start').val();
    var tgl_finish = $('#tgl_finish').val();
    $("#content").hide();
    $("#loading").show();
    $('#isi').html("");
    $.ajax({
        url: "<?php echo base_url(); ?>LapMinutasi/show_list",
        type: "POST",
        data: {
            "tgl_start": tgl_start,
            "tgl_finish": tgl_finish
        },
        dataType: "html",
        success: function(data) {
            $("#loading").hide();
            $('#isi').html(data);
            $("#cetak_btn").show();
            console.log(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(kategori);
            alert('Error get data from ajax');
        }
    });
}
          </script>