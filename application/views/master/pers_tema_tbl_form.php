<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
        <h2>Profile</h2>
        <ol class="breadcrumb">
            <li>
                <a href="#">Home</a>
            </li>
            <li class="active">
                <strong>Profile</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
        <div class="col-lg-12">
        	<div class="ibox float-e-margins">

	            <div class="ibox-title">
	                <h5>Form Jabatan</h5>
	                <div class="ibox-tools">
	                    <a class="collapse-link">
	                        <i class="fa fa-chevron-up"></i>
	                    </a>                    
	                </div>
	            </div>
	            <div class="ibox-content">
	            	<form id="defaultForm2" name="defaultForm2" method="post" class="form-horizontal">
                        
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Kdtema</label>
                                <div class="col-sm-10">
                                    <input type="text" id="kdtema" name="kdtema" placeholder="Kdtema" value="<?php echo isset($kdtema) ? $kdtema : ""; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                             
                        
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Natema</label>
                                <div class="col-sm-10">
                                    <input type="text" id="natema" name="natema" placeholder="Natema" value="<?php echo isset($natema) ? $natema : ""; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                             
                        
                            <div class="form-group">
                                <label class="col-sm-2 control-label">User_id</label>
                                <div class="col-sm-10">
                                    <input type="text" id="user_id" name="user_id" placeholder="User Id" value="<?php echo isset($user_id) ? $user_id : ""; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                             
                        
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Term</label>
                                <div class="col-sm-10">
                                    <input type="text" id="term" name="term" placeholder="Term" value="<?php echo isset($term) ? $term : ""; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                             
                        
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tg_upd</label>
                                <div class="col-sm-10">
                                    <input type="text" id="tg_upd" name="tg_upd" placeholder="Tg Upd" value="<?php echo isset($tg_upd) ? $tg_upd : ""; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                             
                            <div class="form-group">                               
                                <div class="col-sm-4 col-sm-offset-2">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <a href="#" class="btn btn-danger">Kembali</a>
                                        </div>                                      
                                    </div>
                                </div>                              
                                <div class="col-sm-4 col-sm-offset-2">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button style="margin-left:5px;" class="btn btn-primary pull-right" type="submit">Simpan</button>
                                            <button class="btn btn-white pull-right" type="reset">Batal</button>                                                                                
                                        </div>
                                    </div>
                                </div>
                            </div>                     
                       
                    </form>
	        	</div>
	        	    
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

        <!-- Custom and plugin javascript -->
        <script src="<?php echo base_url(); ?>assets/inspinia/js/inspinia.js"></script>
        <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/pace/pace.min.js"></script>
        <!-- Custom and plugin javascript -->

        <!-- Date Picker -->
        <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js"></script>
        <!-- Date Picker -->


        <!-- Validation -->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/inspinia/boostrapvalidator/js/bootstrapValidator.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/lib-1.0.0.js"></script>    
        <!-- Validation -->

        