          <!-- / .main-navbar -->
          <div class="main-content-container container-fluid px-4">
              <!-- Page Header -->
              <div class="page-header row no-gutters py-4">
                  <div class="col-sm-12 col-md-12 text-center">
                      <!-- <span class="text-uppercase page-subtitle">Overview</span> -->
                      <h3 class="page-title">Laporan Rekap Minutasi</h3>
                      <h3 class="page-title">Pengadilan Agama Ngawi</h3>

                      <br>
                      <strong class="text-muted d-block mb-2">Tanggal Laporan</strong>
                      <div class="form-row justify-content-center">
                          <div class="form-group col-md-2">
                              <input type="date" class="tanggal form-control is-valid" id="tgl_start"
                                  value="<?php echo date('d/m/Y'); ?>">
                          </div>
                          <div class="form-group col-md-2">
                              <input type="date" class="tanggal form-control is-valid" id="tgl_finish"
                                  value="<?php echo date('d/m/Y'); ?>">
                          </div>
                          <div class="form-group col-md-1">
                              <button type="button" class="mb-2 btn btn-success mr-2"
                                  onclick="tampil_data()">Tampil</button>
                          </div>
                      </div>
                      <div class="form-row justify-content-center">

                          <div class="form-group col-md-2">
                              <button id="cetak_btn" type="button" class="mb-2 btn btn-warning mr-2"
                                  style="display:none" onClick="window.print();return false">Cetak</button>
                          </div>

                      </div>
                  </div>
              </div>
              <!-- End Page Header -->
              <div class="row">
                  <div id="loading" style="display:none">
                      <ul class="bokeh">
                          <li></li>
                          <li></li>
                          <li></li>
                      </ul>
                      <h6 class="text-center">Sedang Proses...</h6>
                  </div>
              </div>
              <div id="isi" class="row justify-content-center">
              </div>

              <!-- End Default Light Table -->

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