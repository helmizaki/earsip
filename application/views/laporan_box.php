          <!-- / .main-navbar -->
          <div class="content-body">
              <!-- Page Header -->
              <div class="container-fluid">
                  <div class="row justify-content-center">
                      <h3 class="text-center">REKAP BOX PERKARA </h3>
                      <h3 class="text-center">PENGADILAN AGAMA NGAWI</h3>
                      <div></div>
                      <strong class="text-center">Tanggal Laporan</strong>
                      <div class="form-group col-md-2">
                          <input type="date" class="tanggal form-control " id="tgl_start" value="<?php echo date('d/m/Y'); ?>">
                      </div>
                      <div class="form-group col-md-2">
                          <input type="date" class="tanggal form-control " id="tgl_finish" value="<?php echo date('d/m/Y'); ?>">
                      </div>
                      <div class="form-group col-md-1">
                          <button type="button" class="mb-2 btn btn-success mr-2" onclick="tampil_data()">Tampil</button>
                      </div>

                      <div class="form-row justify-content-center">

                          <div class="form-group col-md-2">
                              <button id="cetak_btn" type="button" class="mb-2 btn btn-warning mr-2">Cetak</button>
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
                      url: "<?php echo base_url(); ?>LapBOX/show_list",
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

              var cetak_BAP = document.getElementById("cetak_btn");
              cetak_BAP.onclick = function() {
                  var tgl_start = $('#tgl_start').val();
                  var tgl_finish = $('#tgl_finish').val();
                  $.ajax({
                      url: "<?php echo base_url(); ?>Dashboard/cetak_laporan",
                      type: "POST",
                      data: {
                          "tgl_start": tgl_start,
                          "tgl_finish": tgl_finish
                      },
                      dataType: 'json',
                      success: function(response) {
                          if (response.success) {
                              var downloadURL = '<?php echo base_url("template/box/laporan_box.xlsx"); ?>';
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