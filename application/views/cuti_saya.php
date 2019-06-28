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
        <h2>Cuti</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php">Home</a>
            </li>
            <li class="active">
                <strong>Cuti Saya</strong>
            </li>
        </ol>
         <small><i>(Menu untuk pengajuan dan proses cuti)</i></small>
    </div>
</div>


<!-- hanya untuk pns selain gubernur -->
<?php if ($user_id != '000000') { ?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Cuti</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">
                <div class='pull-right'><button type='button' class='btn btn-primary btn-sm btn-block m-t' onclick="form_cuti()"><i class='fa fa-plus'></i> Tambah Data</button></div>

                <div class="row" >
                    <div class="ibox-title">
                    </div>

                        <div class="row">
                            <div class="col-sm-12">
                                
                                <table id="tbl_cuti" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <td align="left" width="3%"><b>No</b></td>
                                            <td align="left" width="5%"><b>NRK</b></td>
                                            <td align="left" width="10%"><b>NAMA</b></td>
                                            <td align="left" width="7%"><b>Jenis Cuti</b></td>
                                            <td align="left" width="7%"><b>Tanggal Mulai</b></td>
                                            <td align="left" width="8%"><b>Tanggal Berakhir</b></td>
                                            <td align="left" width="10%"><b>Status</b></td>
                                            <td align="left" width="20%"><b>Aksi</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div id="spinner_tbl_cuti"></div>
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
<?php } ?>


<?php if ($cek_bawahan->JML >=1){ ?>
<!-- validasi atasan -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Validasi Bawahan</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">

                <div class="row">
		            <div class="col-lg-12">
		                <div class="tabs-container">
		                    <ul class="nav nav-tabs">
		                        <li class="active"><a data-toggle="tab" href="#tab-1">Belum Validasi</a></li>
		                        <li class=""><a data-toggle="tab" href="#tab-2">Sudah Validasi</a></li>
		                    </ul>
		                    <div class="tab-content">
		                        <div id="tab-1" class="tab-pane active">
		                            <div class="panel-body">
		                            	<center><h3>Cuti Yang Belum Divalidasi</h3></center>
		                                <table id="tbl_atasan" class="table table-bordered table-striped table-hover">
		                                    <thead>
		                                        <tr>
		                                            <td align="left" width="3%"><b>No</b></td>
		                                            <td align="left" width="5%"><b>NRK</b></td>
		                                            <td align="left" width="10%"><b>NAMA</b></td>
		                                            <td align="left" width="7%"><b>Jenis Cuti</b></td>
		                                            <td align="left" width="7%"><b>Tanggal Mulai</b></td>
		                                            <td align="left" width="8%"><b>Tanggal Berakhir</b></td>
		                                            <td align="left" width="10%"><b>Status</b></td>
		                                            <td align="left" width="20%"><b>Aksi</b></td>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                        <div id="spinner_tbl_atasan"></div>
		                                    </tbody>
		                                </table>
		                            </div>
		                        </div>
		                        <div id="tab-2" class="tab-pane">
		                            <div class="panel-body">
		                                <center><h3>Cuti Yang Sudah Divalidasi</h3></center>
		                                <table id="tbl_atasan_2" class="table table-bordered table-striped table-hover">
		                                    <thead>
		                                        <tr>
		                                            <td align="left" width="3%"><b>No</b></td>
		                                            <td align="left" width="5%"><b>NRK</b></td>
		                                            <td align="left" width="10%"><b>NAMA</b></td>
		                                            <td align="left" width="7%"><b>Jenis Cuti</b></td>
		                                            <td align="left" width="7%"><b>Tanggal Mulai</b></td>
		                                            <td align="left" width="8%"><b>Tanggal Berakhir</b></td>
		                                            <td align="left" width="10%"><b>Status</b></td>
		                                            <td align="left" width="20%"><b>Aksi</b></td>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                        <div id="spinner_tbl_atasan_2"></div>
		                                    </tbody>
		                                </table>
		                            </div>
		                        </div>
		                    </div>

		                </div>
		            </div>
		        </div>
            </div> 
        </div> 

      </div> 
    </div>

</div>

<!-- validasi atasan old -->
<!-- <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Validasi Bawahan</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">

                <div class="row" >
                    <div class="ibox-title">
                    </div>

                        <div class="row">
                            <div class="col-sm-12">
                                
                                <table id="tbl_atasan" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <td align="left" width="3%"><b>No</b></td>
                                            <td align="left" width="5%"><b>NRK</b></td>
                                            <td align="left" width="10%"><b>NAMA</b></td>
                                            <td align="left" width="7%"><b>Jenis Cuti</b></td>
                                            <td align="left" width="7%"><b>Tanggal Mulai</b></td>
                                            <td align="left" width="8%"><b>Tanggal Berakhir</b></td>
                                            <td align="left" width="10%"><b>Status</b></td>
                                            <td align="left" width="20%"><b>Aksi</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div id="spinner_tbl_atasan"></div>
                                    </tbody>
                                </table>                                    
                                
                            </div>
                        </div>

                </div>

                
            </div> 
        </div> 

      </div> 
    </div>

</div> -->

<?php } ?>


<?php if ($cek_pyb->JML >= 1) { ?>
<!-- validasi pyb -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Validasi Pejabat</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab-1">Belum Validasi</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-2">Sudah Validasi</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <center><h3>Cuti Yang Belum Divalidasi</h3></center>
                                        <table id="tbl_pyb" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <td align="left" width="3%"><b>No</b></td>
                                                    <td align="left" width="5%"><b>NRK</b></td>
                                                    <td align="left" width="10%"><b>NAMA</b></td>
                                                    <td align="left" width="7%"><b>Jenis Cuti</b></td>
                                                    <td align="left" width="7%"><b>Tanggal Mulai</b></td>
                                                    <td align="left" width="8%"><b>Tanggal Berakhir</b></td>
                                                    <td align="left" width="10%"><b>Status</b></td>
                                                    <td align="left" width="20%"><b>Aksi</b></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <div id="spinner_tbl_pyb"></div>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <center><h3>Cuti Yang Sudah Divalidasi</h3></center>
                                        <table id="tbl_pyb_2" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <td align="left" width="3%"><b>No</b></td>
                                                    <td align="left" width="5%"><b>NRK</b></td>
                                                    <td align="left" width="10%"><b>NAMA</b></td>
                                                    <td align="left" width="7%"><b>Jenis Cuti</b></td>
                                                    <td align="left" width="7%"><b>Tanggal Mulai</b></td>
                                                    <td align="left" width="8%"><b>Tanggal Berakhir</b></td>
                                                    <td align="left" width="15%"><b>Status</b></td>
                                                    <td align="left" width="15%"><b>Aksi</b></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <div id="spinner_tbl_pyb_2"></div>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div> 
        </div> 

      </div> 
    </div>

</div>




<!-- validasi pyb old -->
<!-- <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Validasi Pejabat</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">

                <div class="row" >
                    <div class="ibox-title">
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            
                            <table id="tbl_pyb" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <td align="left" width="3%"><b>No</b></td>
                                        <td align="left" width="5%"><b>NRK</b></td>
                                        <td align="left" width="10%"><b>NAMA</b></td>
                                        <td align="left" width="7%"><b>Jenis Cuti</b></td>
                                        <td align="left" width="7%"><b>Tanggal Mulai</b></td>
                                        <td align="left" width="8%"><b>Tanggal Berakhir</b></td>
                                        <td align="left" width="10%"><b>Status</b></td>
                                        <td align="left" width="20%"><b>Aksi</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <div id="spinner_tbl_pyb"></div>
                                </tbody>
                            </table>                                    
                            
                        </div>
                    </div>
                </div>

                
            </div>
        </div>

      </div> 
    </div>

</div> -->

<?php } ?>

<!-- <?php echo $user_id; ?> -->

<?php if ($user_id == '000000') { ?>
<!-- validasi pyb lokasi luar negeri -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Validasi cuti tahunan lokasi luar negeri</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab-1">Belum Validasi</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-2">Sudah Validasi</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <center><h3>Cuti Yang Belum Divalidasi</h3></center>
                                        <table id="tbl_pyb_lokasi_luar_negeri" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <td align="left" width="3%"><b>No</b></td>
                                                    <td align="left" width="5%"><b>NRK</b></td>
                                                    <td align="left" width="10%"><b>NAMA</b></td>
                                                    <td align="left" width="7%"><b>Jenis Cuti</b></td>
                                                    <td align="left" width="7%"><b>Tanggal Mulai</b></td>
                                                    <td align="left" width="8%"><b>Tanggal Berakhir</b></td>
                                                    <td align="left" width="15%"><b>Status</b></td>
                                                    <td align="left" width="15%"><b>Aksi</b></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <div id="spinner_tbl_pyb_lokasi_luar_negeri"></div>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <center><h3>Cuti Yang Sudah Divalidasi</h3></center>
                                        <table id="tbl_pyb_lokasi_luar_negeri_2" class="table table-bordered table-striped table-hover" >
                                            <thead>
                                                <tr>
                                                    <td align="left" width="3%"><b>No</b></td>
                                                    <td align="left" width="5%"><b>NRK</b></td>
                                                    <td align="left" width="10%"><b>NAMA</b></td>
                                                    <td align="left" width="7%"><b>Jenis Cuti</b></td>
                                                    <td align="left" width="7%"><b>Tanggal Mulai</b></td>
                                                    <td align="left" width="8%"><b>Tanggal Berakhir</b></td>
                                                    <td align="left" width="15%"><b>Status</b></td>
                                                    <td align="left" width="15%"><b>Aksi</b></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <div id="spinner_tbl_pyb_lokasi_luar_negeri_2"></div>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div> 
        </div> 

      </div> 
    </div>

</div>


<!-- validasi luar negeri old -->
<!-- <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Validasi cuti tahunan lokasi luar negeri</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">

                <div class="row" >
                    <div class="ibox-title">
                    </div>

                        <div class="row">
                            <div class="col-sm-12">
                                
                                <table id="tbl_pyb_lokasi_luar_negeri" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <td align="left" width="3%"><b>No</b></td>
                                            <td align="left" width="5%"><b>NRK</b></td>
                                            <td align="left" width="10%"><b>NAMA</b></td>
                                            <td align="left" width="7%"><b>Jenis Cuti</b></td>
                                            <td align="left" width="7%"><b>Tanggal Mulai</b></td>
                                            <td align="left" width="8%"><b>Tanggal Berakhir</b></td>
                                            <td align="left" width="10%"><b>Status</b></td>
                                            <td align="left" width="20%"><b>Aksi</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div id="spinner_tbl_pyb_lokasi_luar_negeri"></div>
                                    </tbody>
                                </table>                                    
                                
                            </div>
                        </div>

                </div>

                
            </div> 
        </div>

      </div>
    </div>

</div> -->

<?php } ?>


<!-- Start Modal -->


<div class="modal fade" id="modal_cuti" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document" style="width: 80%;">
    <!-- <div class="modal-content animated fadeInUp" id="modal_content"> -->
    <div class="modal-content animated fadeInUp" id="modal_content">

        <form id="defaultForm2" name="defaultForm2" method="post" class="form-horizontal"  action="javascript:save();" data-bv-submitbuttons="button[type='submit']" data-remote="true" data-toggle="validator" role="form">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="myModalLabel">Form Pengajuan Cuti</h3>
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

                        <legend><h4>Atasan</h4></legend>
                        <div class="form-group">
                          <label class="col-sm-3 control-label">Status Atasan</label>
                          <div class="input-group col-sm-8">                                      
                              <select class="chosen-jencuti" name="status_atasan" id="status_atasan" data-placeholder="Status Atasan" onchange="cek_status_atasan()">
                                <option value=""></option>
                                <option value="ATASAN" selected>ATASAN LANGSUNG</option>
                                <option value="PLT">PLT</option>
                                <option value="PLH">PLH</option>
                                <!-- <?php echo $atasan ?> -->
                              </select>
                          </div>
                        </div>

                        <div class="form-group" id="atsn_langsung">
                          <label class="col-sm-3 control-label">Atasan</label>
                          <div class="input-group col-sm-8">                                      
                              <select class="chosen-jencuti" name="atasan" id="atasan" data-placeholder="Atasan Validasi Cuti">
                                <option value=""></option>
                                <!-- <option value="0">Nama Atasan</option> -->
                                <?php echo $atasan ?>
                              </select>
                          </div>
                        </div>

                        <div class="form-group" id="cari_plt" style="display: none;">
                          <label class="col-sm-3 control-label">Cari Atasan</label>
                          <div class="input-group col-sm-8">
                                <!-- <input type="text" id="alasan_cuti" name="alasan_cuti" placeholder="Alasan Cuti" class="form-control"> -->
                                <input type="text" placeholder="Cari NRK" name="cari_nrk" id="cari_nrk" class="form-control">
                                <div class="input-group-btn">
                                    <a class="btn btn-primary" onclick="act_cari_plt()">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </div>
                          </div>
                        </div>

                        <div class="form-group" id="spinner_cari_nrk" style="display: none;">
                        	<div class="col-sm-3"></div>
                        	<div class="col-sm-8">  
                                <div class="sk-spinner sk-spinner-wave pull-left">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id="atsn_plt_plh" style="display: none;">
                          <label class="col-sm-3 control-label">Atasan (PLT/PLH)</label>
                          <div class="input-group col-sm-8"> 

                              <b><p id="atasan_plt_plh"></p></b>
                              <input type="hidden" name="nrk_atasan_plt_plh" id="nrk_atasan_plt_plh" class="form-control" readonly="">
                          </div>
                        </div>

                        <!-- <div id="atasan_plt_plh2"></div> -->

                        <div class="form-group" id="klk_plt_plh" style="display: none;">
                          <label class="col-sm-3 control-label">Lokasi (PLT/PLH)</label>
                          <div class="input-group col-sm-8">                                      
                              <select class="chosen-klk_plt_plh" name="kolok_plt_plh" id="kolok_plt_plh" data-placeholder="Lokasi" onchange="cek_kojab()">
                                <option value=""></option>
                                <!-- <option value="0">Nama Atasan</option> -->
                                <?php echo $kolok_plt_plh ?>
                              </select>
                          </div>
                        </div>

                        <div class="form-group" id="spinner_cari_kojab" style="display: none;">
                        	<div class="col-sm-3"></div>
                        	<div class="col-sm-8">  
                                <div class="sk-spinner sk-spinner-wave pull-left">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id="jbt_plt_plh" style="display: none;">
                          <label class="col-sm-3 control-label">Jabatan (PLT/PLH)</label>
                          <div class="input-group col-sm-8">                                      
                              <select class="chosen-jbt_plt_plh" name="kojab_plt_plh" id="kojab_plt_plh" data-placeholder="Lokasi">
                                <option value=""></option>
                                <!-- <option value="0">Nama Atasan</option> -->
                                <!-- <?php echo $atasan ?> -->
                              </select>
                          </div>
                        </div>

                    </div>

                    <!-- <div>
                    	<hr>
                    </div> -->

                    <!-- <hr /> -->
					<center style="color: white;">_</center>
					<hr />
                    

                    <div class="col-md-12">

	                    <div class="col-md-6">

	                        <legend><h4>Cuti</h4></legend>
	                        <div class="form-group">
	                          <label class="col-sm-3 control-label">Jenis Cuti</label>
	                          <div class="input-group col-sm-8">                                      
	                              <select class="chosen-jencuti" name="jencuti" id="jencuti" data-placeholder="Pilih Jenis Cuti..." onchange="cek_tmt()">
	                                <option value=""></option>
	                                <?php echo $listJenCuti ?>
	                              </select>
	                          </div>
	                        </div>

	                        <div class="form-group" id="div_lokasi_cuti" style="display: none;">
	                          <label class="col-sm-3 control-label">Lokasi Cuti</label>
	                          <div class="input-group col-sm-8">                                      
	                              <select class="chosen-jencuti" name="id_lokasi" id="id_lokasi" data-placeholder="Pilih Lokasi Cuti..." >
	                                <option value=""></option>
	                                <?php echo $lokasi_cuti ?>
	                              </select>
	                          </div>
	                        </div>

	                        <div class="form-group" id="div_alasan_cuti" style="display: none;">
	                          <label class="col-sm-3 control-label">Alasan Cuti</label>
	                          <div class="input-group col-sm-8">
	                                <input type="text" id="alasan_cuti" name="alasan_cuti" placeholder="Alasan Cuti" class="form-control">
	                          </div>
	                        </div>

	                        <legend id="lgn_lama" style="display: none;"><h4>Lamanya cuti</h4></legend>
	                        <div>
	                            <div class="col-sm-6" id="div_tmt" style="display: none;">
	                                <div class="form-group" id="data_1">
	                                    <label class="col-sm-4 control-label"><font color="blue">Tgl. Mulai</font></label>
	                                    <div class="input-group col-sm-7 date">
	                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="tmt"  name="tmt" placeholder="Tgl. Mulai" class="form-control" onchange="cek_tanggal(this)" readonly="">
	                                    </div>
	                                </div>
	                            </div>
	                            
	                            <div class="col-sm-6" id="div_tgakhir" style="display: none;">
	                                <div class="form-group"  id="data_2">
	                                  <label class="col-sm-4 control-label">Tgl. Akhir</label>
	                                  <div class="input-group col-sm-7 date">
	                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="tgakhir" name="tgakhir" placeholder="Tgl. Akhir" class="form-control" onchange="cek_tanggal(this)" readonly="">
	                                  </div>
	                                </div>
	                            </div>
	                        </div>

	                        <div>
	                            <div class="col-sm-6" id="div_tahun_n" style="display: none;">
	                            	<div class="form-group">
	                                  <label class="col-sm-4 control-label">Tahun N-2</label>
	                                  <div class="input-group col-sm-7">
	                                        <input type="text" id="tahun_n_2" name="tahun_n_2" placeholder="Tahun N-2" class="form-control" readonly="">
	                                        <!-- <span class="text-danger">(Hari)</span> -->
	                                  </div>
	                                </div>

	                                <div class="form-group" id="div_tahun_n_1" style="display: none;">
	                                  <label class="col-sm-4 control-label">Tahun N-1</label>
	                                  <div class="input-group col-sm-7">
	                                        <input type="text" id="tahun_n_1" name="tahun_n_1" placeholder="Tahun N-1" class="form-control" readonly="">
	                                  </div>
	                                </div>

	                                
	                            </div>
	                        </div>

	                        <div>
	                            <div class="col-sm-6" id="div_tahun_n_2" style="display: none;">

	                                <div class="form-group">
	                                  <label class="col-sm-4 control-label">Tahun N</label>
	                                  <div class="input-group col-sm-7">
	                                        <input type="text" id="tahun_n" name="tahun_n" placeholder="Tahun N" class="form-control" readonly="">
	                                  </div>
	                                </div>

	                                <div class="form-group" id="div_total_cuti" style="display: none;">
	                                  <label class="col-sm-4 control-label">Total Cuti</label>
	                                  <div class="input-group col-sm-7">
	                                        <input type="text" id="total_cuti" name="total_cuti" placeholder="Total Cuti" class="form-control" readonly="">
	                                  </div>
	                                </div>
	                            </div>
	                        </div>

	                    </div>


	                    <div class="col-md-6">
	                        
	                        <legend id="lgn_kontak" style="display: none;"><h4>Kontak & alamat selama manjalankan cuti</h4></legend>
	                        <div class="form-group" id="div_telp_cuti" style="display: none;">
	                          <label class="col-sm-4 control-label">Telepon</label>
	                          <div class="input-group col-sm-7">
	                                <input type="text" id="telp_cuti" name="telp_cuti" placeholder="Telepon" class="form-control">
	                          </div>
	                        </div>


	                        <div class="form-group" id="div_almt_cuti" style="display: none;">
	                          <label class="col-sm-4 control-label">Alamat</label>
	                          <div class="input-group col-sm-7">
	                                <textarea class="form-control" rows="5" id="almt_cuti" name="almt_cuti" placeholder="Alamat" ></textarea>
	                          </div>
	                        </div>

	                    </div>

                    </div>

                    <div class="col-md-6">
                        <div class="alert alert-danger" id="div_info_ct_tahunan" style="display: none;">
                            <i style="font-size: 10px;"><b>Informasi *</b></i><br/>
                            <i style="font-size: 10px;">
                            Tahun N   : Jumlah hari cuti pada tahun berjalan <br/>
                            Tahun N-1 : Jumlah hari cuti pada satu tahun sebelumnya<br/>
                            Tahun N-2 : Jumlah hari cuti pada dua tahun sebelumnya
                            </i>
                        
                        </div>
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
            <button type="submit" class="btn btn-primary" id="btn_save" disabled="">Simpan</button>
        </div>
    </form>
        
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- start modal verif batal -->
<div class="modal fade" id="modal_verif_batal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <!-- <div class="modal-content animated fadeInUp" id="modal_content"> -->
    <div class="modal-content animated fadeInUp">

        <form id="defaultForm_verif_batal" name="defaultForm_verif_batal" method="post" class="form-horizontal"  action="javascript:save_verif_batal();" data-bv-submitbuttons="button[type='submit']" data-remote="true" data-toggle="validator" role="form">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="myModalLabel">Pembatalan Cuti</h3>
        </div>
        <div class="modal-body">
            
                <div class="row">
                    <!-- START SIDE 1 -->
                    



                    <div class="col-md-12">

                        <div class="form-group">
                          <label class="col-sm-4 control-label">Keterangan</label>
                          <div class="input-group col-sm-7">
                                <input type="hidden" id="id_hist_verif_batal" name="id_hist_verif_batal" class="form-control">
                                <input type="hidden" id="jencuti_verif_batal" name="jencuti_verif_batal" class="form-control">
                                <textarea class="form-control" rows="5" id="ket_verif_batal" name="ket_verif_batal" placeholder="Keterangan"></textarea>
                          </div>
                        </div>

                    </div>

                    <!-- END SIDE 1 -->            
                </div>                                                              
               
            
        </div>
        <div class="modal-footer">
            <span class="pull-left">
                <label class="msg_verif_batal text-success"></label>
                <label class="err_verif_batal text-danger"></label>
            </span>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" id="btn_save_verif_perubahan" >Simpan</button>
        </div>
    </form>
        
    </div>
  </div>
</div>
<!-- end modal verif batal -->

<!-- start modal verif perubahan -->
<div class="modal fade" id="modal_verif_perubahan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <!-- <div class="modal-content animated fadeInUp" id="modal_content"> -->
    <div class="modal-content animated fadeInUp">

        <form id="defaultForm_verif_perubahan" name="defaultForm_verif_perubahan" method="post" class="form-horizontal"  action="javascript:save_verif_perubahan();" data-bv-submitbuttons="button[type='submit']" data-remote="true" data-toggle="validator" role="form">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="myModalLabel">Validasi untuk perubahan</h3>
        </div>
        <div class="modal-body">
            
                <div class="row">
                    <!-- START SIDE 1 -->
                    



                    <div class="col-md-12">

                        <div class="form-group">
                          <label class="col-sm-4 control-label">Keterangan</label>
                          <div class="input-group col-sm-7">
                                <input type="hidden" id="id_hist_verif_perubahan" name="id_hist_verif_perubahan" class="form-control">
                                <input type="hidden" id="jencuti_verif_perubahan" name="jencuti_verif_perubahan" class="form-control">
                                <textarea class="form-control" rows="5" id="ket_verif_perubahan" name="ket_verif_perubahan" placeholder="Keterangan"></textarea>
                          </div>
                        </div>

                    </div>

                    <!-- END SIDE 1 -->            
                </div>                                                              
               
            
        </div>
        <div class="modal-footer">
            <span class="pull-left">
                <label class="msg_verif_perubahan text-success"></label>
                <label class="err_verif_perubahan text-danger"></label>
            </span>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" id="btn_save_verif_perubahan" >Simpan</button>
        </div>
    </form>
        
    </div>
  </div>
</div>
<!-- end modal verif perubahan -->

<!-- start modal ditangguhkan -->
<div class="modal fade" id="modal_verif_ditangguhkan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <!-- <div class="modal-content animated fadeInUp" id="modal_content"> -->
    <div class="modal-content animated fadeInUp">

        <form id="defaultForm_verif_ditangguhkan" name="defaultForm_verif_ditangguhkan" method="post" class="form-horizontal"  action="javascript:save_verif_ditangguhkan();" data-bv-submitbuttons="button[type='submit']" data-remote="true" data-toggle="validator" role="form">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="myModalLabel">Validasi untuk ditangguhkan</h3>
        </div>
        <div class="modal-body">
            
                <div class="row">
                    <!-- START SIDE 1 -->
                    



                    <div class="col-md-12">

                        <div class="form-group">
                          <label class="col-sm-4 control-label">Keterangan</label>
                          <div class="input-group col-sm-7">
                                <input type="hidden" id="id_hist_verif_ditangguhkan" name="id_hist_verif_ditangguhkan" class="form-control">
                                <input type="hidden" id="jencuti_verif_ditangguhkan" name="jencuti_verif_ditangguhkan" class="form-control">
                                <textarea class="form-control" rows="5" id="ket_verif_ditangguhkan" name="ket_verif_ditangguhkan" placeholder="Keterangan"></textarea>
                          </div>
                        </div>

                    </div>

                    <!-- END SIDE 1 -->            
                </div>                                                              
               
            
        </div>
        <div class="modal-footer">
            <span class="pull-left">
                <label class="msg_verif_ditangguhkan text-success"></label>
                <label class="err_verif_ditangguhkan text-danger"></label>
            </span>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" id="btn_save_verif_ditangguhkan" >Simpan</button>
        </div>
    </form>
        
    </div>
  </div>
</div>
<!-- end modal ditangguhkan -->


<!-- start modal disetujui atasan -->
<div class="modal fade" id="modal_verif_setujui_atasan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <!-- <div class="modal-content animated fadeInUp" id="modal_content"> -->
    <div class="modal-content animated fadeInUp">

        <form id="defaultForm_verif_setujui_atasan" name="defaultForm_verif_setujui_atasan" method="post" class="form-horizontal"  action="javascript:save_verif_setujui_atasan();" data-bv-submitbuttons="button[type='submit']" data-remote="true" data-toggle="validator" role="form">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="myModalLabel">Validasi disetujui</h3>
        </div>
        <div class="modal-body">
            
                <div class="row">
                    <!-- START SIDE 1 -->
                    



                    <div class="col-md-12">

                        <div class="form-group">
                          <label class="col-sm-4 control-label">Keterangan</label>
                          <div class="input-group col-sm-7">
                                <input type="hidden" id="id_hist_verif_setujui_atasan" name="id_hist_verif_setujui_atasan" class="form-control">
                                <input type="hidden" id="jencuti_verif_setujui_atasan" name="jencuti_verif_setujui_atasan" class="form-control">
                                <textarea class="form-control" rows="5" id="ket_verif_setujui_atasan" name="ket_verif_setujui_atasan" placeholder="Keterangan"></textarea>
                          </div>
                        </div>

                    </div>

                    <!-- END SIDE 1 -->            
                </div>                                                              
               
            
        </div>
        <div class="modal-footer">
            <span class="pull-left">
                <label class="msg_verif_setujui_atasan text-success"></label>
                <label class="err_verif_setujui_atasan text-danger"></label>
            </span>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" id="btn_save_verif_setujui_atasan" >Simpan</button>
        </div>
    </form>
        
    </div>
  </div>
</div>
<!-- end modal disetujui atasan -->


<!-- start modal ditangguhkan pyb -->
<div class="modal fade" id="modal_verif_ditangguhkan_pyb" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <!-- <div class="modal-content animated fadeInUp" id="modal_content"> -->
    <div class="modal-content animated fadeInUp">

        <form id="defaultForm_verif_ditangguhkan_pyb" name="defaultForm_verif_ditangguhkan_pyb" method="post" class="form-horizontal"  action="javascript:save_verif_ditangguhkan_pyb();" data-bv-submitbuttons="button[type='submit']" data-remote="true" data-toggle="validator" role="form">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="myModalLabel">Validasi ditangguhkan oleh pejabat</h3>
        </div>
        <div class="modal-body">
            
                <div class="row">
                    <!-- START SIDE 1 -->
                    



                    <div class="col-md-12">

                        <div class="form-group">
                          <label class="col-sm-4 control-label">Keterangan</label>
                          <div class="input-group col-sm-7">
                                <input type="hidden" id="id_hist_verif_ditangguhkan_pyb" name="id_hist_verif_ditangguhkan_pyb" class="form-control">
                                <input type="hidden" id="jencuti_verif_ditangguhkan_pyb" name="jencuti_verif_ditangguhkan_pyb" class="form-control">
                                <input type="hidden" id="status_pyb_verif_ditangguhkan_pyb" name="status_pyb_verif_ditangguhkan_pyb" class="form-control">
                                <textarea class="form-control" rows="5" id="ket_verif_ditangguhkan_pyb" name="ket_verif_ditangguhkan_pyb" placeholder="Keterangan"></textarea>
                          </div>
                        </div>

                    </div>

                    <!-- END SIDE 1 -->            
                </div>                                                              
               
            
        </div>
        <div class="modal-footer">
            <span class="pull-left">
                <label class="msg_verif_ditangguhkan_pyb text-success"></label>
                <label class="err_verif_ditangguhkan_pyb text-danger"></label>
            </span>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" id="btn_save_verif_ditangguhkan_pyb" >Simpan</button>
        </div>
    </form>
        
    </div>
  </div>
</div>
<!-- end modal ditangguhkan pyb -->

<!-- start modal disetujui pyb -->
<div class="modal fade" id="modal_verif_setujui_pyb" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <!-- <div class="modal-content animated fadeInUp" id="modal_content"> -->
    <div class="modal-content animated fadeInUp">

        <form id="defaultForm_verif_setujui_pyb" name="defaultForm_verif_setujui_pyb" method="post" class="form-horizontal"  action="javascript:save_verif_setujui_pyb();" data-bv-submitbuttons="button[type='submit']" data-remote="true" data-toggle="validator" role="form">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="myModalLabel">Validasi disetujui oleh pejabat</h3>
        </div>
        <div class="modal-body">
            
                <div class="row">
                    <!-- START SIDE 1 -->
                    



                    <div class="col-md-12">

                        <div class="form-group">
                          <label class="col-sm-4 control-label">Keterangan</label>
                          <div class="input-group col-sm-7">
                                <input type="hidden" id="id_hist_verif_setujui_pyb" name="id_hist_verif_setujui_pyb" class="form-control">
                                <input type="hidden" id="jencuti_verif_setujui_pyb" name="jencuti_verif_setujui_pyb" class="form-control">
                                <input type="hidden" id="status_pyb_verif_setujui_pyb" name="status_pyb_verif_setujui_pyb" class="form-control">
                                <textarea class="form-control" rows="5" id="ket_verif_setujui_pyb" name="ket_verif_setujui_pyb" placeholder="Keterangan"></textarea>
                          </div>
                        </div>

                    </div>

                    <!-- END SIDE 1 -->            
                </div>                                                              
               
            
        </div>
        <div class="modal-footer">
            <span class="pull-left">
                <label class="msg_verif_setujui_pyb text-success"></label>
                <label class="err_verif_setujui_pyb text-danger"></label>
            </span>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" id="btn_save_verif_setujui_pyb" >Simpan</button>
        </div>
    </form>
        
    </div>
  </div>
</div>
<!-- end modal disetujui pyb -->

<!-- start modal setujui penangguhan oleh pyb -->
<div class="modal fade" id="modal_verif_setujui_penangguhan_pyb" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <!-- <div class="modal-content animated fadeInUp" id="modal_content"> -->
    <div class="modal-content animated fadeInUp">

        <form id="defaultForm_verif_setujui_penangguhan_pyb" name="defaultForm_verif_setujui_penangguhan_pyb" method="post" class="form-horizontal"  action="javascript:save_verif_setujui_penangguhan_pyb();" data-bv-submitbuttons="button[type='submit']" data-remote="true" data-toggle="validator" role="form">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="myModalLabel">Setujui penangguhan oleh pejabat</h3>
        </div>
        <div class="modal-body">
            
                <div class="row">
                    <!-- START SIDE 1 -->
                    



                    <div class="col-md-12">

                        <div class="form-group">
                          <label class="col-sm-4 control-label">Keterangan</label>
                          <div class="input-group col-sm-7">
                                <input type="hidden" id="id_hist_verif_setujui_penangguhan_pyb" name="id_hist_verif_setujui_penangguhan_pyb" class="form-control">
                                <input type="hidden" id="jencuti_verif_setujui_penangguhan_pyb" name="jencuti_verif_setujui_penangguhan_pyb" class="form-control">
                                <input type="hidden" id="status_pyb_verif_setujui_penangguhan_pyb" name="status_pyb_verif_setujui_penangguhan_pyb" class="form-control">
                                <textarea class="form-control" rows="5" id="ket_verif_setujui_penangguhan_pyb" name="ket_verif_setujui_penangguhan_pyb" placeholder="Keterangan"></textarea>
                          </div>
                        </div>

                    </div>

                    <!-- END SIDE 1 -->            
                </div>                                                              
               
            
        </div>
        <div class="modal-footer">
            <span class="pull-left">
                <label class="msg_verif_setujui_penangguhan_pyb text-success"></label>
                <label class="err_verif_setujui_penangguhan_pyb text-danger"></label>
            </span>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" id="btn_save_verif_setujui_penangguhan_pyb" >Simpan</button>
        </div>
    </form>
        
    </div>
  </div>
</div>
<!-- end modal setujui penangguhan oleh pyb -->


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div id="widthForm" class="modal-dialog modal-lg" role="document" style="width: 80%;">
    <div class="modal-content animated fadeInUp" id="modal_content_detail">
        
    </div>
  </div>
</div>


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

    <script>
        $(document).ready(function(){

            $('#data_8 .input-group.date').datepicker({
                viewMode: "years", 
                minViewMode: "years",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "yyyy",
                endDate : 'y'
            });

            $('#data_1 .input-group.date').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true,
                    format: "dd-mm-yyyy"
            });

            $('#data_2 .input-group.date').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true,
                    format: "dd-mm-yyyy"
            });

           tabel_cuti();
           tabel_atasan();
           tabel_atasan_2();
           tabel_pyb();
           tabel_pyb_validasi();
           tabel_pyb_lokasi_luar_negeri();
           tabel_pyb_lokasi_luar_negeri_validasi();


           /*START CHOSEN*/
            var config = {
              // '.chosen-jencuti'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "100%"},
              // '.chosen-pejtt'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "300px"},
              // '.chosen-jensk'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "300px"}

              '.chosen-jencuti'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "100%"},
              '.chosen-jbt_plt_plh'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "100%"},
              '.chosen-klk_plt_plh'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "100%"}
            }
            for (var selector in config) {
              $(selector).chosen(config[selector]);
            }
            /*END CHOSEN*/

       });
    </script>

    <script type="text/javascript">
    	function cek_status_atasan(){
    		var status_atasan = $('#status_atasan').val();

    		// alert(status_atasan);
    		if(status_atasan == 'ATASAN'){
    			$('#atsn_langsung').show()
    			$('#cari_plt').hide()
    			$('#atsn_plt_plh').hide()
    			$('#klk_plt_plh').hide()
    			$('#jbt_plt_plh').hide()
    		}else{
    			$('#atsn_langsung').hide()
    			$('#cari_nrk').val('');
    			$('#nrk_atasan_plt_plh').val('');
    			$('#cari_plt').show()
    			// $('#atsn_plt_plh').show()
    			// $('#klk_plt_plh').show()
    			// $('#jbt_plt_plh').show()
    		}
    	}

    	function act_cari_plt(){
    		var nrk = $('#cari_nrk').val();

    		// var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

    		// alert(atasan_plt_plh);

    		$.ajax({
                    url : "<?php echo site_url('index.php/cuti/act_cari_plt')?>",
                    type: "POST",
                    data: {nrk:nrk},
                    dataType: "JSON",
                    beforeSend: function() {
                    	$('#spinner_cari_nrk').show();
                    },
                    success: function(data)
                    {
                       $('#spinner_cari_nrk').hide();
                       if(data.respone == 'SUKSES'){
                       		$('#atsn_plt_plh').show();
                       		$('#atasan_plt_plh').html(data.option);
                       		$('#nrk_atasan_plt_plh').val(data.nrk);
                       		// $('#klk_plt_plh').show();
                       		cek_kolok();
    						$('#jbt_plt_plh').hide();
                        }else{
                            // $('#modal_libur_update').modal('hide'); 
                            $('#atsn_plt_plh').hide();
                            $('#atasan_plt_plh').html('');
                       		$('#nrk_atasan_plt_plh').val('');
                       		$('#klk_plt_plh').hide();
    						$('#jbt_plt_plh').hide();
                            
                            swal({type:"warning",title:"GAGAL", text:data.pesan});
                        }                       
                       
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                    	$('#atasan_plt_plh').html();
                       	$('#nrk_atasan_plt_plh').val();
                       	$('#klk_plt_plh').hide();
    					$('#jbt_plt_plh').hide();
                    	$('#spinner_cari_nrk').hide();
                        swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
                    },
                    complete: function() {                            
                    	$('#spinner_cari_nrk').hide();
                    }
                });
    	}

    	function cek_kolok(){
    		// var kolok_plt_plh = $('#kolok_plt_plh').val();

    		// $('#jbt_plt_plh').show();


    		$.ajax({
                    url : "<?php echo site_url('index.php/cuti/cek_kolok')?>",
                    type: "POST",
                    // data: {kolok_plt_plh:kolok_plt_plh},
                    dataType: "JSON",
                    beforeSend: function() {
                    	// $('#spinner_cari_kolok').show();
                    },
                    success: function(data)
                    {
                       // $('#spinner_cari_kolok').hide();
                       $('#klk_plt_plh').show();
                   		$.each(data, function(index, row) {
		                    $('#kolok_plt_plh').append('<option value='+row.KOLOK+'>'+row.NALOK+'</option>');
		                });                     
                       
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                    	
                    	// $('#spinner_cari_kolok').hide();
                        swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
                    },
                    complete: function() {                            
                    	// $('#spinner_cari_kolok').hide();

                    	var config = {
		                    '.chosen-klk_plt_plh'     : {width:"90%"}
		                    }
		                for (var selector in config) {
		                    $(selector).chosen(config[selector]);
		                }

		                $(".chosen-klk_plt_plh").trigger("chosen:updated"); 
                    }
                });
    	}

    	function cek_kojab(){
    		var kolok_plt_plh = $('#kolok_plt_plh').val();

    		// $('#jbt_plt_plh').show();


    		$.ajax({
                    url : "<?php echo site_url('index.php/cuti/cek_kojab')?>",
                    type: "POST",
                    data: {kolok_plt_plh:kolok_plt_plh},
                    dataType: "JSON",
                    beforeSend: function() {
                    	$('#spinner_cari_kojab').show();
                    },
                    success: function(data)
                    {
                       $('#spinner_cari_kojab').hide();
                       $('#jbt_plt_plh').show();
                   		$.each(data, function(index, row) {
		                    $('#kojab_plt_plh').append('<option value='+row.KOJAB+'>'+row.NAJABL+'</option>');
		                });                     
                       
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                    	
                    	$('#spinner_cari_kojab').hide();
                        swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
                    },
                    complete: function() {                            
                    	$('#spinner_cari_kojab').hide();

                    	var config = {
		                    '.chosen-jbt_plt_plh'     : {width:"90%"}
		                    }
		                for (var selector in config) {
		                    $(selector).chosen(config[selector]);
		                }

		                $(".chosen-jbt_plt_plh").trigger("chosen:updated"); 
                    }
                });
    	}
    </script>
   

    <script type="text/javascript">



    	function tabel_cuti(){
            var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

            var dataTable = $('#tbl_cuti').DataTable( {
                    // "columns": [
                    //           null,
                    //           null,
                    //           null,
                    //           null,
                    //           null,
                    //           null
                    //           ],
                    // "order": [[ 5, "desc" ]],
                    responsive: false,
                    bAutoWidth: false, 
                    destroy: true,
                    // "bProcessing": true,
                    "scrollX": true,
                    "serverSide": true,
                    "language": {
                            "processing": "<div></div><div></div><div></div><div></div><div></div>"
                        },
                    "ajax":{
                        url :"<?php echo site_url('index.php/cuti/data_cuti_saya')?>", // json datasource
                        type: "post",  // method  , by default get
                        // drawCallback: function( settings ) {
                          
                        // },
                        data : function(d){
                            // d.tahun = 2017;
                        },
                        beforeSend: function(){
                            $('#spinner_tbl_cuti').html(spinner);
                        },complete: function(){
                                 $("#spinner_tbl_cuti").html('');
                        },
                        error: function(){  // error handling
                            $(".tbl_cuti-error").html("");
                            $("#tbl_cuti").append('<tbody class="tbl_cuti-error"><tr><div colspan=7>Tidak Ada Data</div></tr></tbody>');
                            $("#tbl_cuti_processing").css("display","none");
                            
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

        function tabel_atasan(){
            var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

            var dataTable = $('#tbl_atasan').DataTable( {
                    // "columns": [
                    //           null,
                    //           null,
                    //           null,
                    //           null,
                    //           null,
                    //           null
                    //           ],
                    responsive: false,
                    bAutoWidth: false, 
                    destroy: true,
                    // "bProcessing": true,
                    "scrollX": true,
                    "serverSide": true,
                    "language": {
                            "processing": "<div></div><div></div><div></div><div></div><div></div>"
                        },
                    "ajax":{
                        url :"<?php echo site_url('index.php/cuti/data_cuti_atasan')?>", // json datasource
                        type: "post",  // method  , by default get
                        // drawCallback: function( settings ) {
                          
                        // },
                        data : function(d){
                            // d.tahun = 2017;
                        },
                        beforeSend: function(){
                            $('#spinner_tbl_atasan').html(spinner);
                        },complete: function(){
                                 $("#spinner_tbl_atasan").html('');
                        },
                        error: function(){  // error handling
                            $(".tbl_atasan-error").html("");
                            $("#tbl_atasan").append('<tbody class="tbl_atasan-error"><tr><div colspan=7>Tidak Ada Data</div></tr></tbody>');
                            $("#tbl_atasan_processing").css("display","none");
                            
                        }

                    }
                  

                } );
                

                // setInterval( function () {
                //     $('#tbl1').DataTable().ajax.reload();
                // }, 1000 );


                $('#tbl_atasan input').unbind();
                $('#tbl_atasan input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                oTable.fnFilter(this.value);
                }
                });
        }

        function tabel_atasan_2(){
            var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

            var dataTable = $('#tbl_atasan_2').DataTable( {
                    // "columns": [
                    //           null,
                    //           null,
                    //           null,
                    //           null,
                    //           null,
                    //           null
                    //           ],

                    responsive: false,
                    bAutoWidth: false, 
                    destroy: true,
                    // "bProcessing": true,
                    "scrollX": true,
                    "serverSide": true,
                    "language": {
                            "processing": "<div></div><div></div><div></div><div></div><div></div>"
                        },
                    "ajax":{
                        url :"<?php echo site_url('index.php/cuti/data_cuti_atasan_sudah_validasi')?>", // json datasource
                        type: "post",  // method  , by default get
                        // drawCallback: function( settings ) {
                          
                        // },
                        data : function(d){
                            // d.tahun = 2017;
                        },
                        beforeSend: function(){
                            $('#spinner_tbl_atasan_2').html(spinner);
                        },complete: function(){
                                 $("#spinner_tbl_atasan_2").html('');
                        },
                        error: function(){  // error handling
                            $(".tbl_atasan_2-error").html("");
                            $("#tbl_atasan_2").append('<tbody class="tbl_atasan_2-error"><tr><div colspan=7>Tidak Ada Data</div></tr></tbody>');
                            $("#tbl_atasan_2_processing").css("display","none");
                            
                        }

                    }
                  

                } );
                

                // setInterval( function () {
                //     $('#tbl1').DataTable().ajax.reload();
                // }, 1000 );


                $('#tbl_atasan_2 input').unbind();
                $('#tbl_atasan_2 input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                oTable.fnFilter(this.value);
                }
                });
        }

        function tabel_pyb(){
            var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

            var dataTable = $('#tbl_pyb').DataTable( {
                    // "columns": [
                    //           null,
                    //           null,
                    //           null,
                    //           null,
                    //           null,
                    //           null
                    //           ],
                    responsive: false,
                    bAutoWidth: false, 
                    destroy: true,
                    // "bProcessing": true,
                    "scrollX": true,
                    "serverSide": true,
                    "language": {
                            "processing": "<div></div><div></div><div></div><div></div><div></div>"
                        },
                    "ajax":{
                        url :"<?php echo site_url('index.php/cuti/data_cuti_pyb')?>", // json datasource
                        type: "post",  // method  , by default get
                        // drawCallback: function( settings ) {
                          
                        // },
                        data : function(d){
                            // d.tahun = 2017;
                        },
                        beforeSend: function(){
                            $('#spinner_tbl_pyb').html(spinner);
                        },complete: function(){
                                 $("#spinner_tbl_pyb").html('');
                        },
                        error: function(){  // error handling
                            $(".tbl_pyb-error").html("");
                            $("#tbl_pyb").append('<tbody class="tbl_pyb-error"><tr><div colspan=7>Tidak Ada Data</div></tr></tbody>');
                            $("#tbl_pyb_processing").css("display","none");
                            
                        }

                    }
                  

                } );
                

                // setInterval( function () {
                //     $('#tbl1').DataTable().ajax.reload();
                // }, 1000 );


                $('#tbl_pyb input').unbind();
                $('#tbl_pyb input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                oTable.fnFilter(this.value);
                }
                });
        }

        function tabel_pyb_validasi(){
            var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

            var dataTable = $('#tbl_pyb_2').DataTable( {
                    // "columns": [
                    //           null,
                    //           null,
                    //           null,
                    //           null,
                    //           null,
                    //           null
                    //           ],

                    responsive: false,
                    bAutoWidth: false, 
                    destroy: true,
                    // "bProcessing": true,
                    "scrollX": true,
                    "serverSide": true,
                    "language": {
                            "processing": "<div></div><div></div><div></div><div></div><div></div>"
                        },
                    "ajax":{
                        url :"<?php echo site_url('index.php/cuti/data_cuti_pyb_2')?>", // json datasource
                        type: "post",  // method  , by default get
                        // drawCallback: function( settings ) {
                          
                        // },
                        data : function(d){
                            // d.tahun = 2017;
                        },
                        beforeSend: function(){
                            $('#spinner_tbl_pyb_2').html(spinner);
                        },complete: function(){
                                 $("#spinner_tbl_pyb_2").html('');
                        },
                        error: function(){  // error handling
                            $(".tbl_pyb-error").html("");
                            $("#tbl_pyb_2").append('<tbody class="tbl_pyb_2-error"><tr><div colspan=7>Tidak Ada Data</div></tr></tbody>');
                            $("#tbl_pyb_2_processing").css("display","none");
                            
                        }

                    }
                  

                } );
                

                // setInterval( function () {
                //     $('#tbl1').DataTable().ajax.reload();
                // }, 1000 );


                $('#tbl_pyb_2 input').unbind();
                $('#tbl_pyb_2 input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                oTable.fnFilter(this.value);
                }
                });
        }

        function tabel_pyb_lokasi_luar_negeri(){
            var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

            var dataTable = $('#tbl_pyb_lokasi_luar_negeri').DataTable( {
                    // "columns": [
                    //           null,
                    //           null,
                    //           null,
                    //           null,
                    //           null,
                    //           null
                    //           ],
                    responsive: false,
                    bAutoWidth: false, 
                    destroy: true,
                    // "bProcessing": true,
                    "scrollX": true,
                    "serverSide": true,
                    "language": {
                            "processing": "<div></div><div></div><div></div><div></div><div></div>"
                        },
                    "ajax":{
                        url :"<?php echo site_url('index.php/cuti/data_cuti_pyb_lokasi_luar_negeri')?>", // json datasource
                        type: "post",  // method  , by default get
                        // drawCallback: function( settings ) {
                          
                        // },
                        data : function(d){
                            // d.tahun = 2017;
                        },
                        beforeSend: function(){
                            $('#spinner_tbl_pyb_lokasi_luar_negeri').html(spinner);
                        },complete: function(){
                                 $("#spinner_tbl_pyb_lokasi_luar_negeri").html('');
                        },
                        error: function(){  // error handling
                            $(".tbl_pyb_lokasi_luar_negeri-error").html("");
                            $("#tbl_pyb_lokasi_luar_negeri").append('<tbody class="tbl_pyb_lokasi_luar_negeri-error"><tr><div colspan=7>Tidak Ada Data</div></tr></tbody>');
                            $("#tbl_pyb_lokasi_luar_negeri_processing").css("display","none");
                            
                        }

                    }
                  

                } );
                

                // setInterval( function () {
                //     $('#tbl1').DataTable().ajax.reload();
                // }, 1000 );


                $('#tbl_pyb_lokasi_luar_negeri input').unbind();
                $('#tbl_pyb_lokasi_luar_negeri input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                oTable.fnFilter(this.value);
                }
                });
        }

        function tabel_pyb_lokasi_luar_negeri_validasi(){
            var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

            var dataTable = $('#tbl_pyb_lokasi_luar_negeri_2').DataTable( {
                    // "columns": [
                    //           null,
                    //           null,
                    //           null,
                    //           null,
                    //           null,
                    //           null
                    //           ],
                    responsive: false,
                    bAutoWidth: false, 
                    destroy: true,
                    // fixedHeader:true,
                    // "bProcessing": true,
                    // "scrollY": true,
                    "scrollX": true,
                    "serverSide": true,
                    "language": {
                            "processing": "<div></div><div></div><div></div><div></div><div></div>"
                        },
                    "ajax":{
                        url :"<?php echo site_url('index.php/cuti/data_cuti_pyb_lokasi_luar_negeri_2')?>", // json datasource
                        type: "post",  // method  , by default get
                        // drawCallback: function( settings ) {
                          
                        // },
                        data : function(d){
                            // d.tahun = 2017;
                        },
                        beforeSend: function(){
                            $('#spinner_tbl_pyb_lokasi_luar_negeri_2').html(spinner);
                        },complete: function(){
                                 $("#spinner_tbl_pyb_lokasi_luar_negeri_2").html('');
                        },
                        error: function(){  // error handling
                            $(".tbl_pyb_lokasi_luar_negeri_2-error").html("");
                            $("#tbl_pyb_lokasi_luar_negeri_2").append('<tbody class="tbl_pyb_lokasi_luar_negeri_2-error"><tr><div colspan=7>Tidak Ada Data</div></tr></tbody>');
                            $("#tbl_pyb_lokasi_luar_negeri_2_processing").css("display","none");
                            
                        }

                    }
                  

                } );
                


                // setInterval( function () {
                //     $('#tbl1').DataTable().ajax.reload();
                // }, 1000 );


                $('#tbl_pyb_lokasi_luar_negeri_2 input').unbind();
                $('#tbl_pyb_lokasi_luar_negeri_2 input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                oTable.fnFilter(this.value);
                }
                });
        }


        function form_cuti(){
            // $('#jencuti').val();
            // document.getElementById("defaultForm2").reset(); 
            $('#modal_cuti').modal('show'); 
        }

        

        function cek_tmt(){
            var jencuti = $('#jencuti').val();
            // alert(jencuti);

            if(jencuti == 1){
                cek_tmt_cuti_tahunan();
            }else if(jencuti == 2){
                $("#div_lokasi_cuti").hide();
                $("#div_alasan_cuti").hide();
                $("#lgn_lama").hide();
                $("#div_tmt").hide();
                $("#div_tgakhir").hide();
                $("#div_tahun_n").hide();
                $("#div_tahun_n_1").hide();
                $("#div_tahun_n_2").hide();
                $("#div_total_cuti").hide();
                $("#lgn_kontak").hide();
                $("#div_telp_cuti").hide();
                $("#div_almt_cuti").hide();
                $("#div_info_ct_tahunan").hide();
                document.getElementById("btn_save").disabled = true;
                
            }else{
                $("#div_lokasi_cuti").hide();
                $("#div_alasan_cuti").hide();
                $("#lgn_lama").hide();
                $("#div_tmt").hide();
                $("#div_tgakhir").hide();
                $("#div_tahun_n").hide();
                $("#div_tahun_n_1").hide();
                $("#div_tahun_n_2").hide();
                $("#div_total_cuti").hide();
                $("#lgn_kontak").hide();
                $("#div_telp_cuti").hide();
                $("#div_almt_cuti").hide();
                $("#div_info_ct_tahunan").hide();
                document.getElementById("btn_save").disabled = true;
            }
        }

        function cek_tmt_cuti_tahunan(){
            $.ajax({
                    url : "<?php echo site_url('index.php/cuti/cek_tmt_cuti_tahunan')?>",
                    type: "POST",
                    // data: {tmt:tmt,tgakhir:tgakhir,jencuti:jencuti},
                    dataType: "JSON",
                    beforeSend: function() {
                    },
                    success: function(data)
                    {
                       
                       if(data.respone == 'SUKSES'){
                            $("#div_lokasi_cuti").show();
                            $("#div_alasan_cuti").show();
                            $("#lgn_lama").show();
                            $("#div_tmt").show();
                            $("#div_tgakhir").show();
                            $("#div_tahun_n").show();
                            $("#div_tahun_n_1").show();
                            $("#div_tahun_n_2").show();
                            $("#div_total_cuti").show();
                            $("#lgn_kontak").show();
                            $("#div_telp_cuti").show();
                            $("#div_almt_cuti").show();
                            $("#div_info_ct_tahunan").show();
                            
                            $('#tahun_n').val(data.tahun_n); 
                            $('#tahun_n_1').val(data.tahun_n_1); 
                            $('#tahun_n_2').val(data.tahun_n_2); 
                            // $('.err_update').html('');                  

                        }else{
                            // $('#modal_libur_update').modal('hide'); 
                            $("#div_lokasi_cuti").hide();
                            $("#div_alasan_cuti").hide();
                            $("#lgn_lama").hide();
                            $("#div_tmt").hide();
                            $("#div_tgakhir").hide();
                            $("#div_tahun_n").hide();
                            $("#div_tahun_n_1").hide();
                            $("#div_tahun_n_2").hide();
                            $("#div_total_cuti").hide();
                            $("#lgn_kontak").hide();
                            $("#div_telp_cuti").hide();
                            $("#div_almt_cuti").hide();
                            $("#div_info_ct_tahunan").hide();
                            swal({type:"warning",title:"GAGAL", text:data.pesan});
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

        function cek_tanggal(){
            // alert('ddd')
            var tmt = $('#tmt').val();
            var tgakhir = $('#tgakhir').val();
            var jencuti = $('#jencuti').val();
            // alert(jencuti+'ddd2')
            
            if (jencuti == ''){
                swal({type:"warning",title:"Gagal", text:"Jenis cuti tidak boleh kosong"});
                // return false;
            }else{
                
                if (tmt != '' && tgakhir != ''){
                    // if(tmt >= tgakhir){
                    // alert((cek_selisih_hari(tmt,tgakhir)));

                    // cek selisih tanggal 
                    var tgl_awal_pisah = tmt.split('-');
                    var tgl_akhir_pisah = tgakhir.split('-');
                    var objek_tgl = new Date();
                    var tgl_awal_leave = objek_tgl.setFullYear(tgl_awal_pisah[2],tgl_awal_pisah[1],tgl_awal_pisah[0]);
                    var tgl_akhir_leave = objek_tgl.setFullYear(tgl_akhir_pisah[2],tgl_akhir_pisah[1],tgl_akhir_pisah[0]);
                    var hasil = (tgl_akhir_leave-tgl_awal_leave)/86400000;
                    // cek selisih tanggal 


                    if(hasil < 0){
                        document.getElementById("btn_save").disabled = true;
                        swal({type:"warning",title:"Gagal", text:"Tanggal mulai tidak boleh lebih kecil atau sama dengan dari tanggal akhir"});
                    }else{
                        cek_jml_cuti(tmt,tgakhir,jencuti);
                    }
                }
            }

            
        }

        function cek_selisih_hari(tmt,tgakhir){
            // alert('cek selisih hari');

            var tgl_awal_pisah = tmt.split('-');
            var tgl_akhir_pisah = tgakhir.split('-');
            var objek_tgl = new Date();
            var tgl_awal_leave = objek_tgl.setFullYear(tgl_awal_pisah[2],tgl_awal_pisah[1],tgl_awal_pisah[0]);
            var tgl_akhir_leave = objek_tgl.setFullYear(tgl_akhir_pisah[2],tgl_akhir_pisah[1],tgl_akhir_pisah[0]);
            var hasil = (tgl_akhir_leave-tgl_awal_leave)/86400000;


            // alert(hasil);

            return number(hasil);
        }

        function cek_jml_cuti(tmt,tgakhir,jencuti){
            $.ajax({
                    url : "<?php echo site_url('index.php/cuti/cek_jml_cuti')?>",
                    type: "POST",
                    data: {tmt:tmt,tgakhir:tgakhir,jencuti:jencuti},
                    dataType: "JSON",
                    beforeSend: function() {
                    },
                    success: function(data)
                    {
                       
                       if(data.respone == 'SUKSES'){
                            $('#tahun_n').val(data.tahun_n); 
                            $('#tahun_n_1').val(data.tahun_n_1); 
                            $('#tahun_n_2').val(data.tahun_n_2); 
                            $('#total_cuti').val(data.total_cuti);  
                            document.getElementById("btn_save").disabled = false;               

                        }else{
                            // $('#modal_libur_update').modal('hide'); 
                            $('#tahun_n').val(''); 
                            $('#tahun_n_1').val(''); 
                            $('#tahun_n_2').val(''); 
                            $('#total_cuti').val('');
                            document.getElementById("btn_save").disabled = true;
                            swal({type:"warning",title:"GAGAL", text:data.pesan});
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

        function save(){
            // alert('hapus '+id)

            swal({
	          title: "Peringatan",
	          text: "Apakah data sudah benar?",
	          type: "warning",
	          showCancelButton: true,
	          confirmButtonColor: "#DD6B55",
	          confirmButtonText: "Ya, Simpan!",
	          cancelButtonText: "Tidak!",
	          closeOnConfirm: false,
	          closeOnCancel: false
	        },
	        function(isConfirm){
	          if (isConfirm) {
	            save_next();
	          } else {
	                swal("BATAL", "Proses dibatalkan", "error");
	          }
	        });
        }

        function save_next(){
        	var jencuti = $('#jencuti').val();
        	if(jencuti == 1){
        		save_ct_tahunan(jencuti);
        	}
        }

        function save_ct_tahunan(jencuti){
        	var status_atasan = $('#status_atasan').val();
        	var nrk_atasan_plt_plh = $('#nrk_atasan_plt_plh').val();
        	var kolok_plt_plh = $('#kolok_plt_plh').val();
        	var kojab_plt_plh = $('#kojab_plt_plh').val();

            var atasan = $('#atasan').val();
            var id_lokasi = $('#id_lokasi').val();
        	var alasan_cuti = $('#alasan_cuti').val();
        	var tmt = $('#tmt').val();
        	var tgakhir = $('#tgakhir').val();
        	var tahun_n_2 = $('#tahun_n_2').val();
        	var tahun_n = $('#tahun_n').val();
        	var tahun_n_1 = $('#tahun_n_1').val();
        	var total_cuti = $('#total_cuti').val();
        	var telp_cuti = $('#telp_cuti').val();
        	var almt_cuti = $('#almt_cuti').val();

        	$.ajax({
                    url : "<?php echo site_url('index.php/cuti/save_ct_tahunan')?>",
                    type: "POST",
                    data: {tmt:tmt,tgakhir:tgakhir,atasan:atasan,jencuti:jencuti,id_lokasi:id_lokasi,alasan_cuti:alasan_cuti,tahun_n_2:tahun_n_2,tahun_n:tahun_n,tahun_n_1:tahun_n_1,total_cuti:total_cuti,telp_cuti:telp_cuti,almt_cuti:almt_cuti,status_atasan:status_atasan,nrk_atasan_plt_plh:nrk_atasan_plt_plh,kolok_plt_plh:kolok_plt_plh,kojab_plt_plh:kojab_plt_plh},
                    dataType: "JSON",
                    beforeSend: function() {

                    	if(status_atasan != "ATASAN"){
                    		if(nrk_atasan_plt_plh == ""){
	                            swal({type:"warning",title:"GAGAL", text:"Atasan PLT/PLH tidak boleh kosong"})
	                            return false;
	                        }else{
	                            // $("#errUsergruble").html();                    
	                        }

	                        if(kolok_plt_plh == ""){
	                            swal({type:"warning",title:"GAGAL", text:"Lokasi PLT/PLH tidak boleh kosong"})
	                            return false;
	                        }else{
	                            // $("#errUsergruble").html();                    
	                        }

	                        if(kojab_plt_plh == ""){
	                            swal({type:"warning",title:"GAGAL", text:"Jabatan PLT/PLH tidak boleh kosong"})
	                            return false;
	                        }else{
	                            // $("#errUsergruble").html();                    
	                        }

                    	}else{
                    		if(atasan == ""){
	                            swal({type:"warning",title:"GAGAL", text:"Atasan tidak boleh kosong"})
	                            return false;
	                        }else{
	                            // $("#errUsergruble").html();                    
	                        } 
                    	}

                        

                    	if(jencuti == ""){
		                    swal({type:"warning",title:"GAGAL", text:"Jenis cuti belum dipilih"})
		                    return false;
		                }else{
		                    // $("#errUsergruble").html();                    
		                }  

                        if(id_lokasi == ""){
                            swal({type:"warning",title:"GAGAL", text:"Lokasi cuti tidak boleh kosong"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        }

		                if(alasan_cuti == ""){
		                    swal({type:"warning",title:"GAGAL", text:"Alasan cuti tidak boleh kosong"})
		                    return false;
		                }else{
		                    // $("#errUsergruble").html();                    
		                }

		                if(telp_cuti == ""){
		                    swal({type:"warning",title:"GAGAL", text:"Telepon tidak boleh kosong"})
		                    return false;
		                }else{
		                    // $("#errUsergruble").html();                    
		                } 

		                if(almt_cuti == ""){
		                    swal({type:"warning",title:"GAGAL", text:"Telepon tidak boleh kosong"})
		                    return false;
		                }else{
		                    // $("#errUsergruble").html();                    
		                } 

                    },
                    success: function(data)
                    {
                       
                       if(data.respone == 'SUKSES'){
                       		$('#modal_cuti').modal('hide'); 
                            swal({type:"success",title:"BERHASIL", text:data.pesan});
                            tabel_cuti();          

                        }else{
                            
                            swal({type:"warning",title:"GAGAL", text:data.pesan});
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


        function detail_cuti(id_hist,jencuti){
            // $('#modal_cuti').modal('show'); 
            $.ajax({
                    url : "<?php echo site_url('index.php/cuti/detail_cuti')?>",
                    type: "POST",
                    data: {id_hist:id_hist,jencuti:jencuti},
                    dataType: "JSON",
                    beforeSend: function() {
                        $('#myModal').modal('toggle');
                         $('body').css('overflow', 'scroll');
                        $("#modal_content_detail").html('<div class="sk-spinner sk-spinner-three-bounce" style="width:110px;"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div></div>');
                    },
                    success: function(data)
                    {
                       
                       if(data.response == 'SUKSES'){   
                            // alert(data.result);         
                            $("#modal_content_detail").html(data.result);
                            // $('input').attr('readonly', 'readonly');
                            if(data.widthForm == 'one'){
                                $('#widthForm').removeAttr('class').attr('class', '');                                
                                $('#widthForm').addClass('modal-dialog');
                            }else{
                                $('#widthForm').removeAttr('class').attr('class', '');
                                $('#widthForm').addClass('modal-dialog');
                                $('#widthForm').addClass('modal-lg');                                
                            }
                        }else{
                            // swal({type:"warning",title:"GAGAL", text:data.pesan});
                            $("#modal_content_detail").html('');
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

        function batal_cuti(id_hist,jencuti){
            // alert(id_hist);
            // alert(jencuti);
            $('#id_hist_verif_batal').val(id_hist); 
            $('#jencuti_verif_batal').val(jencuti); 
            $('#modal_verif_batal').modal('show'); 
        }

        function save_verif_batal(){
            // alert('hapus '+id)

            swal({
              title: "Peringatan",
              text: "Apakah anda sudah yakin?",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Ya, Simpan!",
              cancelButtonText: "Tidak!",
              closeOnConfirm: false,
              closeOnCancel: false
            },
            function(isConfirm){
              if (isConfirm) {
                save_verif_batal2();
              } else {
                    swal("BATAL", "Proses dibatalkan", "error");
              }
            });
        }

        function save_verif_batal2(){
            var id_hist = $('#id_hist_verif_batal').val(); 
            var jencuti = $('#jencuti_verif_batal').val(); 
            var ket = $('#ket_verif_batal').val(); 

            $.ajax({
                    url : "<?php echo site_url('index.php/cuti/save_verif_batal')?>",
                    type: "POST",
                    data: {id_hist:id_hist,jencuti:jencuti,ket:ket},
                    dataType: "JSON",
                    beforeSend: function() {
                        if(id_hist == ""){
                            swal({type:"warning",title:"GAGAL", text:"Proses gagal"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        }  

                        if(jencuti == ""){
                            swal({type:"warning",title:"GAGAL", text:"Proses gagal"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        }

                        if(ket == ""){
                            swal({type:"warning",title:"GAGAL", text:"Keterangan tidak boleh kosong"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        } 

                        

                    },
                    success: function(data)
                    {
                       
                       if(data.respone == 'SUKSES'){
                            $('#modal_verif_batal').modal('hide'); 
                            swal({type:"success",title:"BERHASIL", text:data.pesan});
                            tabel_cuti();          

                        }else{
                            
                            swal({type:"warning",title:"GAGAL", text:data.pesan});
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

        function verif_perubahan(id_hist,jencuti){
            // alert(id_hist);
            // alert(jencuti);
            $('#id_hist_verif_perubahan').val(id_hist); 
            $('#jencuti_verif_perubahan').val(jencuti); 
            $('#modal_verif_perubahan').modal('show'); 
        }

        function save_verif_perubahan(){
            // alert('hapus '+id)

            swal({
              title: "Peringatan",
              text: "Apakah anda sudah yakin?",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Ya, Simpan!",
              cancelButtonText: "Tidak!",
              closeOnConfirm: false,
              closeOnCancel: false
            },
            function(isConfirm){
              if (isConfirm) {
                save_verif_perubahan2();
              } else {
                    swal("BATAL", "Proses dibatalkan", "error");
              }
            });
        }

        function save_verif_perubahan2(){
            var id_hist = $('#id_hist_verif_perubahan').val(); 
            var jencuti = $('#jencuti_verif_perubahan').val(); 
            var ket = $('#ket_verif_perubahan').val(); 

            $.ajax({
                    url : "<?php echo site_url('index.php/cuti/save_verif_perubahan')?>",
                    type: "POST",
                    data: {id_hist:id_hist,jencuti:jencuti,ket:ket},
                    dataType: "JSON",
                    beforeSend: function() {
                        if(id_hist == ""){
                            swal({type:"warning",title:"GAGAL", text:"Proses gagal"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        }  

                        if(jencuti == ""){
                            swal({type:"warning",title:"GAGAL", text:"Proses gagal"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        }

                        if(ket == ""){
                            swal({type:"warning",title:"GAGAL", text:"Keterangan tidak boleh kosong"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        } 

                        

                    },
                    success: function(data)
                    {
                       
                       if(data.respone == 'SUKSES'){
                            $('#modal_verif_perubahan').modal('hide'); 
                            swal({type:"success",title:"BERHASIL", text:data.pesan});
                            tabel_atasan(); 
                            tabel_pyb(); 
                            tabel_pyb_validasi(); 
                            tabel_atasan_2(); 
                            tabel_pyb_lokasi_luar_negeri();  
                            tabel_pyb_lokasi_luar_negeri_validasi();     

                        }else{
                            
                            swal({type:"warning",title:"GAGAL", text:data.pesan});
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

        function verif_ditangguhkan(id_hist,jencuti){
            // alert(id_hist);
            // alert(jencuti);
            $('#id_hist_verif_ditangguhkan').val(id_hist); 
            $('#jencuti_verif_ditangguhkan').val(jencuti); 
            $('#modal_verif_ditangguhkan').modal('show'); 
        }

        function save_verif_ditangguhkan(){
            // alert('hapus '+id)

            swal({
              title: "Peringatan",
              text: "Apakah anda sudah yakin?",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Ya, Simpan!",
              cancelButtonText: "Tidak!",
              closeOnConfirm: false,
              closeOnCancel: false
            },
            function(isConfirm){
              if (isConfirm) {
                save_verif_ditangguhkan2();
              } else {
                    swal("BATAL", "Proses dibatalkan", "error");
              }
            });
        }

        function save_verif_ditangguhkan2(){
            var id_hist = $('#id_hist_verif_ditangguhkan').val(); 
            var jencuti = $('#jencuti_verif_ditangguhkan').val(); 
            var ket = $('#ket_verif_ditangguhkan').val(); 

            $.ajax({
                    url : "<?php echo site_url('index.php/cuti/save_verif_ditangguhkan')?>",
                    type: "POST",
                    data: {id_hist:id_hist,jencuti:jencuti,ket:ket},
                    dataType: "JSON",
                    beforeSend: function() {
                        if(id_hist == ""){
                            swal({type:"warning",title:"GAGAL", text:"Proses gagal"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        }  

                        if(jencuti == ""){
                            swal({type:"warning",title:"GAGAL", text:"Proses gagal"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        }

                        if(ket == ""){
                            swal({type:"warning",title:"GAGAL", text:"Keterangan tidak boleh kosong"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        } 

                        

                    },
                    success: function(data)
                    {
                       
                       if(data.respone == 'SUKSES'){
                            $('#modal_verif_ditangguhkan').modal('hide'); 
                            swal({type:"success",title:"BERHASIL", text:data.pesan});
                            tabel_atasan(); 
                            tabel_atasan_2();
                            tabel_pyb(); 
                            tabel_pyb_validasi(); 
                            tabel_pyb_lokasi_luar_negeri();   
                            tabel_pyb_lokasi_luar_negeri_validasi();     

                        }else{
                            
                            swal({type:"warning",title:"GAGAL", text:data.pesan});
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


        function verif_setujui_atasan(id_hist,jencuti){
            // alert(id_hist);
            // alert(jencuti);
            $('#id_hist_verif_setujui_atasan').val(id_hist); 
            $('#jencuti_verif_setujui_atasan').val(jencuti); 
            $('#modal_verif_setujui_atasan').modal('show'); 
        }

        function save_verif_setujui_atasan(){
            // alert('hapus '+id)

            swal({
              title: "Peringatan",
              text: "Apakah anda sudah yakin?",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Ya, Simpan!",
              cancelButtonText: "Tidak!",
              closeOnConfirm: false,
              closeOnCancel: false
            },
            function(isConfirm){
              if (isConfirm) {
                save_verif_setujui_atasan2();
              } else {
                    swal("BATAL", "Proses dibatalkan", "error");
              }
            });
        }

        function save_verif_setujui_atasan2(){
            var id_hist = $('#id_hist_verif_setujui_atasan').val(); 
            var jencuti = $('#jencuti_verif_setujui_atasan').val(); 
            var ket = $('#ket_verif_setujui_atasan').val(); 

            $.ajax({
                    url : "<?php echo site_url('index.php/cuti/save_verif_setujui_atasan')?>",
                    type: "POST",
                    data: {id_hist:id_hist,jencuti:jencuti,ket:ket},
                    dataType: "JSON",
                    beforeSend: function() {
                        if(id_hist == ""){
                            swal({type:"warning",title:"GAGAL", text:"Proses gagal"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        }  

                        if(jencuti == ""){
                            swal({type:"warning",title:"GAGAL", text:"Proses gagal"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        }

                        if(ket == ""){
                            swal({type:"warning",title:"GAGAL", text:"Keterangan tidak boleh kosong"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        } 

                        

                    },
                    success: function(data)
                    {
                       
                       if(data.respone == 'SUKSES'){
                            $('#modal_verif_setujui_atasan').modal('hide'); 
                            swal({type:"success",title:"BERHASIL", text:data.pesan});
                            // tabel_cuti();   
                            tabel_atasan(); 
                            tabel_atasan_2();
                            tabel_pyb(); 
                            tabel_pyb_validasi();    
                            tabel_pyb_lokasi_luar_negeri();  
                            tabel_pyb_lokasi_luar_negeri_validasi();

                        }else{
                            
                            swal({type:"warning",title:"GAGAL", text:data.pesan});
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

        function rubah_ajukan(id_hist,jencuti,id_lokasi){
            // alert(id_hist);
            // alert(jencuti);
            // $('#id_hist_rubah_ajukan').val(id_hist); 
            // $('#jencuti_rubah_ajukan').val(jencuti); 
            // $('#modal_rubah_ajukan').modal('show'); 

            $.ajax({
                    url : "<?php echo site_url('index.php/cuti/get_rubah_cuti')?>",
                    type: "POST",
                    data: {id_hist:id_hist,jencuti:jencuti,id_lokasi:id_lokasi},
                    dataType: "JSON",
                    beforeSend: function() {
                        $('#myModal').modal('toggle');
                         $('body').css('overflow', 'scroll');
                        $("#modal_content_detail").html('<div class="sk-spinner sk-spinner-three-bounce" style="width:110px;"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div></div>');
                    },
                    success: function(data)
                    {
                       
                       if(data.response == 'SUKSES'){   
                            // alert(data.result);         
                            $("#modal_content_detail").html(data.result);
                            // $('input').attr('readonly', 'readonly');
                            if(data.widthForm == 'one'){
                                $('#widthForm').removeAttr('class').attr('class', '');                                
                                $('#widthForm').addClass('modal-dialog');
                            }else{
                                $('#widthForm').removeAttr('class').attr('class', '');
                                $('#widthForm').addClass('modal-dialog');
                                $('#widthForm').addClass('modal-lg');                                
                            }
                        }else{
                            // swal({type:"warning",title:"GAGAL", text:data.pesan});
                            $("#modal_content_detail").html('');
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

        function verif_ditangguhkan_pyb(id_hist,jencuti,status_pyb=''){
            // alert(id_hist);
            // alert(jencuti);
            $('#id_hist_verif_ditangguhkan_pyb').val(id_hist); 
            $('#jencuti_verif_ditangguhkan_pyb').val(jencuti); 
            $('#status_pyb_verif_ditangguhkan_pyb').val(status_pyb); 
            $('#modal_verif_ditangguhkan_pyb').modal('show'); 
        }

        function save_verif_ditangguhkan_pyb(){
            // alert('hapus '+id)

            swal({
              title: "Peringatan",
              text: "Apakah anda sudah yakin?",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Ya, Simpan!",
              cancelButtonText: "Tidak!",
              closeOnConfirm: false,
              closeOnCancel: false
            },
            function(isConfirm){
              if (isConfirm) {
                save_verif_ditangguhkan2_pyb();
              } else {
                    swal("BATAL", "Proses dibatalkan", "error");
              }
            });
        }

        function save_verif_ditangguhkan2_pyb(){
            var id_hist = $('#id_hist_verif_ditangguhkan_pyb').val(); 
            var jencuti = $('#jencuti_verif_ditangguhkan_pyb').val(); 
            var status_pyb = $('#status_pyb_verif_ditangguhkan_pyb').val(); 
            var ket = $('#ket_verif_ditangguhkan_pyb').val(); 

            $.ajax({
                    url : "<?php echo site_url('index.php/cuti/save_verif_ditangguhkan_pyb')?>",
                    type: "POST",
                    data: {id_hist:id_hist,jencuti:jencuti,ket:ket,status_pyb:status_pyb},
                    dataType: "JSON",
                    beforeSend: function() {
                        if(id_hist == ""){
                            swal({type:"warning",title:"GAGAL", text:"Proses gagal"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        }  

                        if(jencuti == ""){
                            swal({type:"warning",title:"GAGAL", text:"Proses gagal"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        }

                        if(ket == ""){
                            swal({type:"warning",title:"GAGAL", text:"Keterangan tidak boleh kosong"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        } 

                        

                    },
                    success: function(data)
                    {
                       
                       if(data.respone == 'SUKSES'){
                            $('#modal_verif_ditangguhkan_pyb').modal('hide'); 
                            swal({type:"success",title:"BERHASIL", text:data.pesan});
                            tabel_atasan();
                            tabel_atasan_2();
                            tabel_pyb(); 
                            tabel_pyb_validasi(); 
                            tabel_pyb_lokasi_luar_negeri();     
                            tabel_pyb_lokasi_luar_negeri_validasi();   

                        }else{
                            
                            swal({type:"warning",title:"GAGAL", text:data.pesan});
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

        function verif_setujui_pyb(id_hist,jencuti,status_pyb=''){
            // alert(id_hist);
            // alert(jencuti);
            $('#id_hist_verif_setujui_pyb').val(id_hist); 
            $('#jencuti_verif_setujui_pyb').val(jencuti); 
            $('#status_pyb_verif_setujui_pyb').val(status_pyb); 
            $('#modal_verif_setujui_pyb').modal('show'); 
        }

        function save_verif_setujui_pyb(){
            // alert('hapus '+id)

            swal({
              title: "Peringatan",
              text: "Apakah anda sudah yakin?",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Ya, Simpan!",
              cancelButtonText: "Tidak!",
              closeOnConfirm: false,
              closeOnCancel: false
            },
            function(isConfirm){
              if (isConfirm) {
                save_verif_setujui_pyb2();
              } else {
                    swal("BATAL", "Proses dibatalkan", "error");
              }
            });
        }

        function save_verif_setujui_pyb2(){
            var id_hist = $('#id_hist_verif_setujui_pyb').val(); 
            var jencuti = $('#jencuti_verif_setujui_pyb').val(); 
            var status_pyb = $('#status_pyb_verif_setujui_pyb').val(); 
            var ket = $('#ket_verif_setujui_pyb').val(); 

            $.ajax({
                    url : "<?php echo site_url('index.php/cuti/save_verif_setujui_pyb')?>",
                    type: "POST",
                    data: {id_hist:id_hist,jencuti:jencuti,ket:ket,status_pyb:status_pyb},
                    dataType: "JSON",
                    beforeSend: function() {
                        if(id_hist == ""){
                            swal({type:"warning",title:"GAGAL", text:"Proses gagal"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        }  

                        if(jencuti == ""){
                            swal({type:"warning",title:"GAGAL", text:"Proses gagal"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        }

                        if(ket == ""){
                            swal({type:"warning",title:"GAGAL", text:"Keterangan tidak boleh kosong"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        } 

                        

                    },
                    success: function(data)
                    {
                       
                       if(data.respone == 'SUKSES'){
                            $('#modal_verif_setujui_pyb').modal('hide'); 
                            swal({type:"success",title:"BERHASIL", text:data.pesan});
                            tabel_atasan();   
                            tabel_atasan_2();
                            tabel_pyb(); 
                            tabel_pyb_validasi();    
                            tabel_pyb_lokasi_luar_negeri();  
                            tabel_pyb_lokasi_luar_negeri_validasi();

                        }else{
                            
                            swal({type:"warning",title:"GAGAL", text:data.pesan});
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

        function verif_setujui_penangguhan_pyb(id_hist,jencuti,status_pyb=''){
            // alert(id_hist);
            // alert(jencuti);
            $('#id_hist_verif_setujui_penangguhan_pyb').val(id_hist); 
            $('#jencuti_verif_setujui_penangguhan_pyb').val(jencuti);
            $('#status_pyb_verif_setujui_penangguhan_pyb').val(status_pyb); 
            $('#modal_verif_setujui_penangguhan_pyb').modal('show'); 
        }

        function save_verif_setujui_penangguhan_pyb(){
            // alert('hapus '+id)

            swal({
              title: "Peringatan",
              text: "Apakah anda sudah yakin?",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Ya, Simpan!",
              cancelButtonText: "Tidak!",
              closeOnConfirm: false,
              closeOnCancel: false
            },
            function(isConfirm){
              if (isConfirm) {
                save_verif_setujui_penangguhan_pyb2();
              } else {
                    swal("BATAL", "Proses dibatalkan", "error");
              }
            });
        }

        function save_verif_setujui_penangguhan_pyb2(){
            var id_hist = $('#id_hist_verif_setujui_penangguhan_pyb').val(); 
            var jencuti = $('#jencuti_verif_setujui_penangguhan_pyb').val(); 
            var status_pyb = $('#status_pyb_verif_setujui_penangguhan_pyb').val(); 
            var ket = $('#ket_verif_setujui_penangguhan_pyb').val(); 

            $.ajax({
                    url : "<?php echo site_url('index.php/cuti/save_verif_setujui_penangguhan_pyb')?>",
                    type: "POST",
                    data: {id_hist:id_hist,jencuti:jencuti,ket:ket,status_pyb:status_pyb},
                    dataType: "JSON",
                    beforeSend: function() {
                        if(id_hist == ""){
                            swal({type:"warning",title:"GAGAL", text:"Proses gagal"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        }  

                        if(jencuti == ""){
                            swal({type:"warning",title:"GAGAL", text:"Proses gagal"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        }

                        if(ket == ""){
                            swal({type:"warning",title:"GAGAL", text:"Keterangan tidak boleh kosong"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        } 

                        

                    },
                    success: function(data)
                    {
                       
                       if(data.respone == 'SUKSES'){
                            $('#modal_verif_setujui_penangguhan_pyb').modal('hide'); 
                            swal({type:"success",title:"BERHASIL", text:data.pesan});
                            tabel_atasan();   
                            tabel_atasan_2();
                            tabel_pyb(); 
                            tabel_pyb_validasi();  
                            tabel_pyb_lokasi_luar_negeri();    
                            tabel_pyb_lokasi_luar_negeri_validasi();

                        }else{
                            
                            swal({type:"warning",title:"GAGAL", text:data.pesan});
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

        function cetak_sk_cuti(id_hist,jencuti){
            // alert(id_hist);
            // alert(jencuti);

            window.open('<?=site_url('cuti')?>/cetak_sk/'+id_hist+'/'+jencuti);

        }



    </script>


    



