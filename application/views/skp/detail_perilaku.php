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
            <li>
                <strong>List Pengukuran</strong>
            </li>
        </ol>
         <!-- <small><i>(Menu untuk pengajuan dan proses cuti)</i></small> -->
    </div>
</div>


<!-- hanya untuk pns selain gubernur -->
<?php if ($user_id != '000000') { ?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">List Pengukuran</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>

            <div class="ibox-content">
            	<div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                            </div>
                        </div>
                </div>
                <div class="row" >            
                    <div class="col-sm-12">                                
                        <div class="table-responsive">
                            <table id="table" class="table table-striped table-bordered table-hover" >
                                <thead>
                                    <tr>
                                        <th>NRK</th>
                                        <th>NAMA</th>
                                        <th>PERIODE AWAL</th>
                                        <th>PERIODE AKHIR</th>
                                        <th>KETERANGAN</th>
                                        <th style="width:125px;">ACTION</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                </tbody>
                                <!--<tfoot>
                                </tfoot> -->
                            </table>
                                <?php
                             	//var_dump($infoUser);
            					//var_dump($_SESSION);
            				    ?>
                        </div><!-- div table responsive-->                      
                    </div>
                </div>    
            </div> <!-- akhir div ibox content-->
        </div> <!-- akhir div ibox float e-margins -->

      </div> <!-- akhir div col lg 6 -->
    </div><!-- akhir div row -->

</div>

<!-- List Bawahan -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">List Pengukuran Bawahan</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>

            <div class="ibox-content">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                            </div>
                        </div>
                </div>
                
                <div class="row" >            
                    <div class="col-sm-12">                                
                        <div class="table-responsive">
                            <table id="table2" class="table table-striped table-bordered table-hover" >
                                <thead>
                                    <tr>
                                        <th>NRK</th>
                                        <th>NAMA</th>
                                        <th>PERIODE AWAL</th>
                                        <th>PERIODE AKHIR</th>
                                        <th>KETERANGAN</th>
                                        <th style="width:125px;">ACTION</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                </tbody>
                                <!--<tfoot>
                                </tfoot> -->
                            </table>
                                <?php
                                //var_dump($infoUser);
                                //var_dump($_SESSION);
                                ?>
                        </div><!-- div table responsive-->                      
                    </div>
                </div>        
            </div> <!-- akhir div ibox content-->
        </div> <!-- akhir div ibox float e-margins -->

      </div> <!-- akhir div col lg 6 -->
    </div><!-- akhir div row -->

</div>
<?php } ?>



<!-- <?php echo $user_id; ?> -->

<!-- Start Modal -->


<div class="modal fade" id="modal_cuti" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document" style="width: 80%;">
    <!-- <div class="modal-content animated fadeInUp" id="modal_content"> -->
    <div class="modal-content animated fadeInUp" id="modal_content">

        <form id="defaultForm2" name="defaultForm2" method="post" class="form-horizontal"  action="javascript:save();" data-bv-submitbuttons="button[type='submit']" data-remote="true" data-toggle="validator" role="form">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="myModalLabel">Form SKP (KEGIATAN TUGAS JABATAN)</h3>
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

	                        <legend><h4>List SKP</h4></legend>
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

    <script type="text/javascript">

        var save_method; //for save method string
        var table;

        $(document).ready(function() {

            //datatables
            table = $('#table').DataTable({ 

                "processing": true, //Feature control the processing indicator.
                "language": {
                "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.

                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo site_url('Skp/ajax_list')?>",
                    "type": "POST"
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                { 
                    "targets": [ -1 ], //last column
                    "orderable": false, //set not orderable
                },
                ],

            });


            //datepicker
            $('.datepicker').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
                todayHighlight: true,
                orientation: "top auto",
                todayBtn: true,
                todayHighlight: true,  
            });

        });

</script>
<script type="text/javascript">

        var save_method; //for save method string
        var table2;

        $(document).ready(function() {

            //datatables
            table2 = $('#table2').DataTable({ 

                "processing": true, //Feature control the processing indicator.
                "language": {
                "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.
                // Load data for the table's content from an Ajax source
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo site_url('Skp/ajax_list2')?>",
                    "type": "POST"
                },
                //Set column definition initialisation properties.
                "columnDefs": [
                { 
                    "targets": [ -1 ], //last column
                    "orderable": false, //set not orderable
                },
                ],

            });


            //datepicker
            $('.datepicker').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
                todayHighlight: true,
                orientation: "top auto",
                todayBtn: true,
                todayHighlight: true,  
            });

        });

</script>


  
   


   


    



