<style type="text/css">
    .col-lg-4 .ibox .ibox-title{
        background-color: rgba(0,0,0,0.1);
    }
    .col-lg-4 .ibox .ibox-content{
        background-color: rgba(10,0,0,0.07);
    }
    #addMenu .modal-content .modal-header {
        padding: 10px 15px; 
        text-align: center;
    }
    #addMenu .ibox-content {
        background-color: #ffffff;
        color: inherit;
        padding: 0px 0px 0px 0px !important; 
        border-color: #e7eaec;
        border-image: none;
        border-style: solid solid none;
        border-width: 1px 0px;
    }

    .dd-item .pull-right button{
        margin-top: 5px;
        margin-right: 2px;
    }

    .sk-spinner-circle.sk-spinner {
            height: 22px;
            margin: 0 !important;
            position: relative;
            width: 22px;
        }

    .sk-spinner-three-bounce.sk-spinner {
            margin: 0 auto;
            text-align: center;
            width: 140px !important;
        }

    .dataTables_scroll .dataTables_scrollHeadInner{
        width: 100% !important;
    }

    .dataTables_scroll .dataTables_scrollHeadInner table{
        width: 100% !important;   
    }

    .dataTables_scroll .dataTables_scrollBody{
        width: 100% !important;
    }

    .dataTables_scroll .dataTables_scrollBody table{
        width: 100% !important;
    }

    .datepicker, .datepicker-dropdown{
        z-index: 999999999 !important;        
    }
    .pickerpicker .form-control-feedback {
        right: 55px !important;      
    }

    .pickerpicker .form-control-feedback {
        top: 0px !important;
    }

    .input-group[class*="col-"] {
        float: none;
        padding-left: -1px !important;
        padding-right: -1px !important;
    }

    .has-success .chosen-container{
   border: 1px solid #1ab394;
    }
 
  .has-error .chosen-container{
   border: 1px solid #ed5565;
    } 

</style>




<?php
	date_default_timezone_set('Asia/Jakarta');
    $date_now = date('Ym');
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Ttd Ka.BKD</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php">Home</a>
            </li>
            <li class="active">
                <strong>Ttd Ka.BKD</strong>
            </li>
        </ol>
         <small><i>(Menu untuk tanda tangan kepala bkd)</i></small>
    </div>
</div>




<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Kepala BKD</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">
                <div class='pull-right'><button type='button' class='btn btn-primary btn-sm btn-block m-t' onclick="form_tambah()"><i class='fa fa-plus'></i> Tambah Data</button></div>

                <div class="row" >
                    <div class="ibox-title">
                    </div>

                        <div class="row">
                            <div class="col-sm-12">
                                
                                <table id="tbl_ttd_ka_bkd" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <td align="left" width="5%"><b>No</b></td>
                                            <td align="left" width="15%"><b>NRK</b></td>
                                            <td align="left" width="30%"><b>Nama</b></td>
                                            <td align="left" width="30%"><b>Spesimen/Ttd</b></td>
                                            <td align="left" width="20%"><b>Aksi</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div id="spinner_tbl_ttd_ka_bkd"></div>
                                    </tbody>
                                </table>                                    
                                
                            </div>
                        </div>

                    <!-- </div> -->
                </div>

                
            </div> <!-- akhir div ibox content-->
        </div> <!-- akhir div ibox float e-margins -->

      </div> <!-- akhir div col lg 6 -->
    </div><!-- akhir div row -->




</div>


<!-- Start Modal -->


<div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document" >
    <!-- <div class="modal-content animated fadeInUp" id="modal_content"> -->
    <div class="modal-content animated fadeInUp" id="modal_content">

        <!-- <form id="defaultForm2" method="post" class="form-horizontal" role="form" enctype="multipart/form-data" > -->
        <form class="form-horizontal" id="defaultForm2" role="form" enctype="multipart/form-data">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Form Input Ttd Ka.BKD</h4>
        </div>
        <div class="modal-body">
            
                <div class="row">
                    <!-- START SIDE 1 -->
                    <div class="col-md-12">
                        <!-- <div class="form-group">
                            <label class="col-sm-4 control-label"><font color="blue">NRK</font></label>
                            <div class="col-sm-7">
                                <input type="text" id="nrk" name="nrk" placeholder="NRK" class="form-control" value="<?php echo isset($nrk) ? $nrk : '' ?>" readOnly="true">
                            </div>
                        </div> -->
                        <!-- <div class="hr-line-dashed"></div> -->

                        <div class="form-group pickerpicker" id="data_1">
                            <label class="col-sm-3 control-label"><font color="blue">NRK</font></label>
                            <div class="input-group col-sm-7">
                                <input class="form-control percent" type="text" id="nrk_input" name="nrk_input" placeholder="Nrk" onblur="cari_pgw()" />
                            </div>
                        </div>

                        <div class="form-group pickerpicker" id="data_1">
                            <label class="col-sm-3 control-label"><font color="blue">Nama</font></label>
                            <div class="input-group col-sm-7">
                                <input class="form-control percent" type="text" id="nama_input" name="nama_input" placeholder="Nama" readonly="" />
                            </div>
                        </div>

                        <div class="form-group pickerpicker" id="data_1">
                            <label class="col-sm-3 control-label"><font color="blue">Ttd</font></label>
                            <div class="input-group col-sm-7">
                                <input class="form-control percent" type="file" id="gambar" name="gambar" accept=".jpeg,.jpg" />
                            </div>
                        </div>

                        <div class="form-group pickerpicker" id="data_1">
                            <label class="col-sm-3 control-label"><font color="blue">Status</font></label>
                            <div class="input-group col-sm-7">
                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" checked class="onoffswitch-checkbox" id="status_input" name="status_input">
                                        <label class="onoffswitch-label" for="status_input">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- <div class="hr-line-dashed"></div> -->
                    </div>
                    <!-- END SIDE 1 -->            
                </div>                                                              
               
            
        </div>
        <div class="modal-footer">
            <span class="pull-left">
                <label class="msg text-success"></label>
                <label class="err text-danger"></label>
            </span>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
        
    </div>
  </div>
</div>



<div class="modal fade" id="modal_update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document" >
    <!-- <div class="modal-content animated fadeInUp" id="modal_content"> -->
    <div class="modal-content animated fadeInUp" id="modal_content">

        <form class="form-horizontal" id="defaultForm2_update" role="form" enctype="multipart/form-data">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Form Update Ttd Ka.BKD</h4>
        </div>
        <div class="modal-body">
            
                <div class="row">
                    <!-- START SIDE 1 -->
                    <div class="col-md-12">

                        <div class="form-group pickerpicker" id="data_1">
                            <label class="col-sm-3 control-label"><font color="blue">NRK</font></label>
                            <div class="input-group col-sm-7">
                                <input class="form-control percent" type="text" id="nrk_update" name="nrk_update" placeholder="Nrk"  readonly="" />
                            </div>
                        </div>

                        <div class="form-group pickerpicker" id="data_1">
                            <label class="col-sm-3 control-label"><font color="blue">Nama</font></label>
                            <div class="input-group col-sm-7">
                                <input class="form-control percent" type="text" id="nama_update" name="nama_update" placeholder="Nama" readonly="" />
                            </div>
                        </div>

                        <div class="form-group pickerpicker" id="data_1">
                            <label class="col-sm-3 control-label"><font color="blue">Ttd</font></label>
                            <div class="input-group col-sm-7">
                                <input class="form-control percent" type="file" id="gambar_update" name="gambar_update" accept=".jpeg,.jpg" />
                            </div>
                        </div>

                        <div class="form-group pickerpicker" id="data_1">
                            <label class="col-sm-3 control-label"><font color="blue">Status</font></label>
                            <div class="input-group col-sm-7">
                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" class="onoffswitch-checkbox" id="status_update" name="status_update">
                                        <label class="onoffswitch-label" for="status_update">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- <div class="hr-line-dashed"></div> -->
                    </div>
                    <!-- END SIDE 1 -->            
                </div>                                                              
               
            
        </div>
        <div class="modal-footer">
            <span class="pull-left">
                <label class="msg_update text-success"></label>
                <label class="err_update text-danger"></label>
            </span>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
        
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- END WRAPPER CONTENT -->
    
    <!-- Mainly scripts -->
    <script src="<?php echo base_url() ?>assets/inspinia/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url() ?>assets/inspinia/js/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url() ?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Nestable List -->
    <script src="<?php echo base_url() ?>assets/js/plugins/nestable/jquery.nestable.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url() ?>assets/inspinia/js/inspinia.js"></script>
    <script src="<?php echo base_url() ?>assets/js/plugins/pace/pace.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/js/jquery.form.js"></script>

    <!-- Data Tables -->
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <!-- Boostrap Validator -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/inspinia/boostrapvalidator/js/bootstrapValidator.js"></script>

    <!-- Sweet alert -->
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/sweetalert/sweetalert.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/chosen/chosen.jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/select2/select2.full.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/fullcalendar/moment.min.js"></script>

    <!-- Jquery Validate -->
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/validate/jquery.validate.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/iCheck/icheck.min.js"></script>
    <!-- DROPZONE -->
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dropzone/dropzone.js"></script>
    <!-- Switchery --> 
   <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/switchery/switchery.js"></script>

    <script>
        $(document).ready(function(){

            tabel_ttd_bkd();
       });
    </script>

    <script type="text/javascript">
        $(document).ready(function(e) {

            

            $("#defaultForm2").on('submit', (function(e) {
                e.preventDefault();
                $.ajax({
                        url : "<?php echo site_url('index.php/spesimen/ajax_tambah_data')?>",
                        type: "POST",
                        dataType: "JSON",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $('.msg').html('<div><div class="sk-spinner sk-spinner-rotating-plane"></div></div>');
                            $('.err').html("");
                        },
                        success: function(data)
                        {
                           
                           if(data.response == 'SUKSES'){
                                $('.msg').html('');
                                $('.err').html('');

                                $('#modal_tambah').modal('hide');
                                tabel_ttd_bkd();

                                swal({type:"success",title:data.judul, text:data.pesan});                    

                            }else{
                                $('.msg').html('');
                                $('.err').html('');
                                swal({type:"warning",title:data.judul, text:data.pesan});
                            }                       
                           
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            $('.msg').html('');
                            $('.err').html('');
                        },
                        complete: function() {                            

                        }
                    });

            }));

            $("#defaultForm2_update").on('submit', (function(e) {
                e.preventDefault();
                $.ajax({
                        url : "<?php echo site_url('index.php/spesimen/ajax_update_data')?>",
                        type: "POST",
                        dataType: "JSON",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $('.msg_update').html('<div><div class="sk-spinner sk-spinner-rotating-plane"></div></div>');
                            $('.err_update').html("");
                        },
                        success: function(data)
                        {
                           
                           if(data.response == 'SUKSES'){
                                $('.msg_update').html('');
                                $('.err_update').html('');
                                tabel_ttd_bkd();
                                $('#modal_update').modal('hide');
                                // tabel_ttd_bkd();

                                swal({type:"success",title:data.judul, text:data.pesan});                    

                            }else{
                                $('.msg_update').html('');
                                $('.err_update').html('');
                                swal({type:"warning",title:data.judul, text:data.pesan});
                            }                       
                           
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            $('.msg_update').html('');
                            $('.err_update').html('');
                        },
                        complete: function() {                            

                        }
                    });

            }));
            
        });
    </script>
   

    <script type="text/javascript">

    
    	function tabel_ttd_bkd(){
            var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

            var dataTable = $('#tbl_ttd_ka_bkd').DataTable( {
                    // "columns": [
                    //           null,
                    //           null,
                    //           null,
                    //           null,
                    //           null,
                    //           null
                    //           ],
                    responsive: false,
                    bAutoWidth: true, 
                    destroy: true,
                    // "bProcessing": true,
                    "scrollX": true,
                    "serverSide": true,
                    "language": {
                            "processing": "<div></div><div></div><div></div><div></div><div></div>"
                        },
                    "ajax":{
                        url :"<?php echo site_url('index.php/spesimen/data_ttd_ka_bkd')?>", // json datasource
                        type: "post",  // method  , by default get
                        // drawCallback: function( settings ) {
                          
                        // },
                        data : function(d){
                            // d.tahun = 2017;
                        },
                        beforeSend: function(){
                            $('#spinner_tbl_ttd_ka_bkd').html(spinner);
                        },complete: function(){
                                 $("#spinner_tbl_ttd_ka_bkd").html('');
                        },
                        error: function(){  // error handling
                            $(".tbl_ttd_ka_bkd-error").html("");
                            $("#tbl_ttd_ka_bkd").append('<tbody class="tbl_ttd_ka_bkd-error"><tr><div colspan=4>Tidak Ada Data</div></tr></tbody>');
                            $("#tbl_ttd_ka_bkd_processing").css("display","none");
                            
                        }

                    }
                  

                } );
                

                // setInterval( function () {
                //     $('#tbl1').DataTable().ajax.reload();
                // }, 1000 );


                $('#tbl_cuti input').unbind();
                $('#tbl_cuti input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                oTable.fnFilter(this.value);
                }
                });
        }


        function form_tambah(){
        	$('.msg').html('');
            $('.err').html('');

       		$('#nrk_input').val('');
       		$('#nama_input').val('');
            $('#gambar').val('');
            $('#modal_tambah').modal('show'); 
        }

        function cari_pgw(){
            var nrk = $('#nrk_input').val();
            $.ajax({
                    url : "<?php echo site_url('index.php/spesimen/cari_pegawai')?>",
                    type: "POST",
                    data: {nrk:nrk},
                    dataType: "JSON",
                    beforeSend: function() {
                    },
                    success: function(data)
                    {
                       
                       if(data.response == 'SUKSES'){
                            $('#nama_input').val(data.nama_pgw);
                            // swal("BERHASIL", "Data berhasil dihapus", "success");                  

                        }else{
                            swal("GAGAL", "Data tidak ditemukan", "error");
                            $('#nama_input').val('');
                        }                       
                       
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal("GAGAL", "Data tidak ditemukan", "error");
                        $('#nama_input').val('');
                    },
                    complete: function() {                            

                    }
                });
        }

       

        function hapus_data(id){
            // alert('hapus '+id)

            swal({
	          title: "Peringatan",
	          text: "Apakah anda ingin menghapus data ini?",
	          type: "warning",
	          showCancelButton: true,
	          confirmButtonColor: "#DD6B55",
	          confirmButtonText: "Ya, Hapus!",
	          cancelButtonText: "Tidak!",
	          closeOnConfirm: false,
	          closeOnCancel: false
	        },
	        function(isConfirm){
	          if (isConfirm) {
	            hapus_data_exc(id);
	          } else {
	                swal("BATAL", "Proses dibatalkan", "error");
	          }
	        });
        }

        function hapus_data_exc(id){
        	

        	$.ajax({
                    url : "<?php echo site_url('index.php/spesimen/delete_ttd')?>",
                    type: "POST",
                    data: {id:id},
                    dataType: "JSON",
                    beforeSend: function() {
                    },
                    success: function(data)
                    {
                       
                       if(data.response == 'SUKSES'){
                       		tabel_ttd_bkd();
                       		swal("BERHASIL", data.pesan, "success");                  

                        }else{
                            swal("GAGAL", data.pesan, "error");
                        }                       
                       
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal("GAGAL", data.pesan, "error");
                    },
                    complete: function() {                            

                    }
                });
        }

        function ubah_data(id){
            // $('#modal_libur_update').modal('show');
            // $('#status_update').val('');

            $.ajax({
                    url : "<?php echo site_url('index.php/spesimen/get_data_update')?>",
                    type: "POST",
                    data: {id:id},
                    dataType: "JSON",
                    beforeSend: function() {
                    },
                    success: function(data)
                    {
                       
                       if(data.respone == 'SUKSES'){
                       		$('.msg_update').html('');
                            $('.err_update').html('');

                       		$('#nrk_update').val(data.nrk);
                       		$('#nama_update').val(data.nama);

                            if(data.status=='Aktif'){
                                document.getElementById('status_update').checked = "checked";
                            }else{
                                document.getElementById('status_update').checked = "";
                            }
                            // $('#status_update').val('');
                            $('#modal_update').modal('show');                   

                        }else{
                            $('#modal_update').modal('hide'); 
                            swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
                        }                       
                       
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
                    },
                    complete: function() {                            

                    }
                });
        }


        function save_update(){
            // alert('simpan')
            $.ajax({
                    url : "<?php echo site_url('index.php/master_libur/ajax_update_data_libur')?>",
                    type: "POST",
                    data: $('#defaultForm2_update').serialize(),
                    dataType: "JSON",
                    beforeSend: function() {
                        $('.msg_update').html('<div><div class="sk-spinner sk-spinner-rotating-plane"></div></div>');
                        $('.err_update').html("");
                    },
                    success: function(data)
                    {
                       
                       if(data.response == 'SUKSES'){
                            $('.msg_update').html('<small>Data berhasil diubah.</small>');
                            $('.err_update').html('');

                            $('#modal_libur_update').modal('hide');
                            tabel_libur();
                            // setTimeout(function () {
                            //     reload();
                            // }, 1000);                        

                        }else{
                            $('.msg_update').html('');
                            $('.err_update').html('');
                            swal({type:"warning",title:"GAGAL", text:"TANGGAL SUDAH DIGUNAKAN, MOHON PERIKSA KEMBALI DATA YANG DIINPUT"});
                        }                       
                       
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error adding / update data');
                    },
                    complete: function() {                            

                    }
                });
        }


    </script>


    



