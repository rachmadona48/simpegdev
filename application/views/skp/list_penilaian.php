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

    .btn-block{
        width: 10%;
        float:left;
        margin-left: 20px;
    }

    .btn-tambah{
        margin-top:3px;
    }

    .table input,.table select{
        border-color: red;
    }

    .dataTables_wrapper .dataTables_processing {
        position: absolute;
        top: 30%;
        left: 0%;
        width: 30%;
        height: 40px;
        margin-left: -20%;
        margin-top: -25px;
        padding-top: 20px;
        text-align: center;
        font-size: 1.2em;
        background:none;
        }

        .error{
            color:red;
        }

        .full{
            width: 100% !important;
        }

        .paginate_button{
            border: 1px solid #ccc;
            padding: 6px;
    }

</style>




<?php
	date_default_timezone_set('Asia/Jakarta');
    $date_now = date('Ym');
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List Sasaran Kinerja Pegawai</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">
                <strong>Skp</strong>
            </li>
        </ol>
         <!-- <small><i>(Menu untuk pengajuan dan proses cuti)</i></small> -->
    </div>
</div>|


<!-- hanya untuk pns selain gubernur -->
<?php if ($user_id != '000000') { ?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row loadpage">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">List SKP</h5>
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
                                <div class="table-responsive">                                
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                                            <tr>
                                                                <th>NO</th>
                                                                <th colspan="2" width="45%">I. PEJABAT PENILAI</th>
                                                                <th>NO</th>
                                                                <th colspan="6">II. PEGAWAI NEGERI SIPIL YANG DINILAI</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="gradeA">
                                                                <td class="center">1</td>
                                                                <td>Nama</td>
                                                                <td><?=$infoUserAtasan->NAMA_ABS;?></td>
                                                                <td class="center">1</td>
                                                                <td colspan="2">Nama</td> 
                                                                <td colspan="4"><?=$infoUser->NAMA_ABS;?></td>
                                                            </tr>
                                                             <tr class="gradeA">
                                                                <td class="center">2</td>
                                                                <td>NIP</td>
                                                                <td><?=$infoUserAtasan->NIP18;?></td>
                                                                <td class="center">2</td>
                                                                <td colspan="2">NIP</td> 
                                                                <td colspan="4"><?=$infoUser->NIP18;?></td>
                                                            </tr>
                                                             <tr class="gradeA">
                                                                <td class="center">3</td>
                                                                <td>Pangkat/Gol.Ruang</td>
                                                                <td><?=$infoUserAtasan->NAPANG.'('.$infoUserAtasan->GOL.')';?></td>
                                                                <td class="center">3</td>
                                                                <td colspan="2">Pangkat/Gol.Ruang</td> 
                                                                <td colspan="4"><?=$infoUser->NAPANG.'('.$infoUser->GOL.')';?></td>
                                                            </tr>
                                                            <tr class="gradeA">
                                                                <td class="center">4</td>
                                                                <td>Jabatan</td>
                                                                <td><?=$infoUserAtasan->NAJABL;?></td>
                                                                <td class="center">4</td>
                                                                <td colspan="2">Jabatan</td> 
                                                                <td colspan="4"><?=$infoUser->NAJABL;?></td>
                                                            </tr>
                                                            <tr class="gradeA">
                                                                <td class="center">5</td>
                                                                <td>Unit Kerja</td>
                                                                <td><?=$infoUserAtasan->NALOKL;?></td>
                                                                <td class="center">5</td>
                                                                <td colspan="2">Unit Kerja</td> 
                                                                <td colspan="5"><?=$infoUser->NALOKL;?></td>
                                                            </tr>
                                                        </tbody> 
                                                    </table>
                                                      
                                </div>
                            </div>
                        </div>
                        

                    <!-- </div> -->
                </div>

                
            </div> <!-- akhir div ibox content-->
        </div> <!-- akhir div ibox float e-margins -->

      </div> <!-- akhir div col lg 6 -->
       <div class="col-lg-12">        
            <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">List SKP hasil nilai</h5>
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
                                <div class="table-responsive">                                                                
                                    <br/>
                                    <table id="listnilai" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>                                                
                                                <th>Periode Awal</th>
                                                <th>Periode Akhir</th>                                                
                                                <th>Keterangan</th>                               
                                                <th width="20%">Action</th>    
                                            </tr>
                                        </thead>
                                    <tbody class="contains-body">                                        
                                    </tbody>
                                </table>                                    
                                </div>
                            </div>
                        </div>
                </div>
            </div> <!-- akhir div ibox content-->
            </div> <!-- akhir div ibox float e-margins -->
           
        </div>
        <?php if ($infoUser->ESELON!='00') { ?>
           <div class="col-lg-12">        
                <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#1AB394">
                    <h5 style="color:#ffffff">List SKP Yang dinilai</h5>
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
                                    <div class="table-responsive">                                                                
                                        <br/>
                                        <table id="listnilaibawahan" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>                                                
                                                    <th>Periode Awal</th>
                                                    <th>Periode Akhir</th>                                                
                                                    <th>Keterangan</th>                               
                                                    <th width="20%">Action</th>    
                                                </tr>
                                            </thead>
                                        <tbody class="contains-body">                                        
                                        </tbody>
                                    </table>                                    
                                    </div>
                                </div>
                            </div>
                    </div>
                </div> <!-- akhir div ibox content-->
                </div> <!-- akhir div ibox float e-margins -->
               
            </div>

            <div class="col-lg-12">        
                <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#1AB394">
                    <h5 style="color:#ffffff">List SKP keputusan atasan pejabat penilai</h5>
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
                                    <div class="table-responsive">                                                                
                                        <br/>
                                        <table id="list-atasan-pejabat-penilai" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>                                                
                                                    <th>Periode Awal</th>
                                                    <th>Periode Akhir</th>                                                
                                                    <th>Keterangan</th>                               
                                                    <th width="20%">Action</th>    
                                                </tr>
                                            </thead>
                                        <tbody class="contains-body">                                        
                                        </tbody>
                                    </table>                                    
                                    </div>
                                </div>
                            </div>
                    </div>
                </div> <!-- akhir div ibox content-->
                </div> <!-- akhir div ibox float e-margins -->
               
            </div>
        <?php } ?>
         

       <!-- akhir div col lg 6 -->
    </div><!-- akhir div row -->
</div>

<?php } ?>
