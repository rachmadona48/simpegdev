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
	                <h5>Form SPMU</h5>
	                <div class="ibox-tools">
	                    <a class="collapse-link">
	                        <i class="fa fa-chevron-up"></i>
	                    </a>                    
	                </div>
	            </div>
	            <div class="ibox-content">
	            	<form id="defaultForm2" name="defaultForm2" method="post" class="form-horizontal">
                        
                            <div class="form-group">
                                <label class="col-sm-2 control-label">SPMU</label>
                                <div class="col-sm-10">
                                    <input type="text" id="kode_spm" name="kode_spm" placeholder="kode_spm" value="<?php echo isset($kode_spm) ? $kode_spm : ""; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                             
                             
                             <div class="form-group">
                                <label class="col-sm-2 control-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" id="nama" name="nama" placeholder="nama" value="<?php echo isset($nama) ? $nama : ""; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Klogad Induk</label>
                                <div class="col-sm-10">
                                    <input type="text" id="klogad_induk" name="klogad_induk" placeholder="klogad_induk" value="<?php echo isset($klogad_induk) ? $klogad_induk : ""; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tahun</label>
                                <div class="col-sm-10">
                                    <input type="text" id="tahun" name="tahun" placeholder="tahun" value="<?php echo isset($tahun) ? $tahun : ""; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Kdsort</label>
                                <div class="col-sm-10">
                                    <input type="text" id="kdsort" name="kdsort" placeholder="kdsort" value="<?php echo isset($kdsort) ? $kdsort : ""; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                             
                             
                            <div class="form-group">                               
                                <div class="col-sm-4 col-sm-offset-2">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <a href="<?php echo base_url(); ?>index.php/master/spmu" class="btn btn-danger">Kembali</a>
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

        <script type="text/javascript">
                        
            $(function() {
                $("#defaultForm2").on("submit", function(event) {
                    event.preventDefault();
 
                    $.ajax({
                        url: "<?php echo $linkaction ?>",
                        type: "post",
                        data: $(this).serialize(),
                        dataType: 'json',
                        beforeSend: function() {
                            blocklayar();
                        },
                        success: function(data) {
                            // alert(data.response);
                            window.location.href = data.linkback;
                        },
                        error: function(xhr) {  
                            unblocklayar();  
                            alert("Terjadi kesalahan. Silahkan coba kembali");

                        },
                        complete: function() {
                            unblocklayar();  
                        }
                    });
                });
            });                

        </script>