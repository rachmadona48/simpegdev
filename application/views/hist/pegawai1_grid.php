<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
        <h2>Pegawai 1</h2>
        <ol class="breadcrumb">
            <li>
                <a href="#">Hist</a>
            </li>
            <li class="active">
                <strong>Pegawai1</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<style type="text/css">
  
  input.form-control {
    width: auto;
  }

</style>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
        <div class="col-lg-12">
            <div class="contact-box">
              <div>
          <a href="<?php echo base_url(); ?>index.php/hist/pegawai1/doadd/" class="btn btn-success pull-right">
            <i class="glyphicon glyphicon-plus"></i> Tambah Pegawai 1
          </a>
          <input type="text" placeholder="NRK" id="cari" name="cari"></input>
          <button onclick="cari()">CARI</button>
        </div>
              <div>
                <div class="clearfix"></div>
                <div class="table-responsive">
                <table id="employee-grid" class="table table-striped table-bordered table-hover dt-responsive nowrap dataTables-example" cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
              <thead>
                <tr>
                  
                  <th>NIP</th>
                  <th>KLOGAD</th>
                  <th>KKLOGAD</th>
                  <th>NAMA</th>
                  <th>TITEL</th>
                  <th>PATHIR</th>
                  <th>TALHIR</th>
                  <th>AGAMA</th>
                  <th>JENKEL</th>
                  <th>STAWIN</th> 
                  <th>STAPEG</th>
                  <th>JENPEG</th>
                  <th>INDUK</th>
                  <th>MUANG</th>
                  <th>NOTUNGGU</th>
                  <th>TGTUNGGU</th>
                  <th>TGAKHTUNG</th>
                  <th>TBHTTMAS</th>
                  <th>TBHBBMAS</th>
                  <th>TUNDA</th>
                  <th>MPP</th>
                  <th>TMT_STAPEG</th> 
                  <th>NIP18</th>
                  <th>TMTPENSIUN</th>
                  <th>KDMATI</th>
                  <th>TGLAMPP</th>
                  <th>TGLEMPP</th>
                  <th>XPHOTO</th>
                  <th>PINDAHAN</th>
                  <th>TMTPINDAH</th>
                  
                  <th>Aksi</th>
                </tr>
              </thead>
              <thead>
                <tr>
                  <th><input type="text" data-column="0"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="1"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="2"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="3"  class="search-input-text form-control"></th>  
                  <th><input type="text" data-column="4"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="5"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="6"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="7"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="8"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="9"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="10"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="11"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="12"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="13"  class="search-input-text form-control"></th>  
                  <th><input type="text" data-column="14"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="15"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="16"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="17"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="18"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="19"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="20"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="21"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="22"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="23"  class="search-input-text form-control"></th>  
                  <th><input type="text" data-column="24"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="25"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="26"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="27"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="28"  class="search-input-text form-control"></th>
                  <th><input type="text" data-column="29"  class="search-input-text form-control"></th>
                 
                  
                                
                  <th></th>
                </tr>
              </thead>
          </table>
              </div>
                </div>
        <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

    <!-- Mainly scripts -->
        <script src="<?php echo base_url(); ?>assets/inspinia/js/jquery-2.1.1.js"></script>
        <script src="<?php echo base_url(); ?>assets/inspinia/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <!-- Mainly scripts -->        

        <!-- Data Tables -->
      <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/jquery.dataTables.js"></script>
      <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/dataTables.bootstrap.js"></script>
      <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/dataTables.responsive.js"></script>
      <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/dataTables.tableTools.min.js"></script>
      <!-- Data Tables -->

        <!-- Custom and plugin javascript -->
        <script src="<?php echo base_url(); ?>assets/inspinia/js/inspinia.js"></script>
        <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/pace/pace.min.js"></script>
        <!-- Custom and plugin javascript -->                

        <!-- Validation -->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/inspinia/boostrapvalidator/js/bootstrapValidator.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/lib-1.0.0.js"></script>    
        <!-- Validation -->
        
    <script type="text/javascript" language="javascript" >
      $(document).ready(function() {      

       /* var dataTable = $('#employee-grid').DataTable( {
          "aoColumns": [
                   
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                                                             
                      { "bSortable": false }
                    ],
          responsive: false,
          "processing": true,
          "serverSide": true,
          "language": {
              "processing": "<div></div><div></div><div></div><div></div><div></div>"
            },
          "ajax":{
            url :"<?php echo base_url(); ?>index.php/hist/pegawai1/data", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th>No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          }
        } );

        $("#employee-grid_filter").css("display","none");  // hiding global search box
        $('.search-input-text').on( 'keyup', function () {   // for text boxes
          var i =$(this).attr('data-column');  // getting column index
          var v =$(this).val();  // getting search input value
          dataTable.columns(i).search(v).draw();
        } );
        $('.search-input-select').on( 'change', function () {   // for select box
          var i =$(this).attr('data-column');  
          var v =$(this).val();  
          dataTable.columns(i).search(v).draw();
        } );   */             
        
      } );

      function cari()
        {
          //var dataTable = $('#employee-grid').DataTable();
          var cari=document.getElementById('cari').value;
          var dataTable = $('#employee-grid').DataTable( {
            "aoColumns": [
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                                                             
                        { "bSortable": false }
                      ],
            responsive: false,
            "processing": true,
            "serverSide": true,
            "destroy" : true,
            "language": {
                "processing": "<div></div><div></div><div></div><div></div><div></div>"
              },
            "ajax":{
              url :"<?php echo base_url(); ?>index.php/hist/pegawai1/data/"+cari, // json datasource
              type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".employee-grid-error").html("");
                $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th>No data found in the server</th></tr></tbody>');
                $("#employee-grid_processing").css("display","none");
                
              }
            }
          } );

          $("#employee-grid_filter").css("display","none");  // hiding global search box
          $('.search-input-text').on( 'keyup', function () {   // for text boxes
            var i =$(this).attr('data-column');  // getting column index
            var v =$(this).val();  // getting search input value
            dataTable.columns(i).search(v).draw();
          } );
          $('.search-input-select').on( 'change', function () {   // for select box
            var i =$(this).attr('data-column');  
            var v =$(this).val();  
            dataTable.columns(i).search(v).draw();
          } );    
        }

      function hapusData(id, action){
        var dataTable = $('#employee-grid').DataTable();
        //var formData = {name:"ravi",age:"31"}; --> Example
        var formData = {nrk:id};

        $.ajax({
                    url: action,
                    type: "post",                    
                    data: formData,
                    dataType: 'json',
                    beforeSend: function() {
                      var r = confirm("Yakin ingin menghapus data ???");
              if (r == true) {
                  blocklayar();
              } else {
                return false;
              }                        
                    },
                    success: function(data) {                        
                        if(data.response == 'GAGAL'){
                          alert('Data gagal dihapus');
                        }
                        // window.location.href = data.linkback;
                        dataTable.ajax.reload();
                    },
                    error: function(xhr) {  
                        unblocklayar();  
                        alert("Terjadi kesalahan. Silahkan coba kembali");
                    },
                    complete: function() {
                        unblocklayar();  
                    }
                });
      }     

      
    </script>


