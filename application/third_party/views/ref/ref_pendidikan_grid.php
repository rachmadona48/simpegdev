<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
        <h2>Pendidikan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="#">Ref</a>
            </li>
            <li class="active">
                <strong>Pendidikan</strong>
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
				
        		<div class="ibox-content">
					<form role="form" action="#" method="POST" class="form-inline" return="false">
						<label>Jenis Pendidikan:</label>
							<div class="input-group">
								<select name="jendik" id="jendik" data-placeholder="Jenis Pendidikan" class="chosen-select" style="width:350px;" tabindex="2">
								<option value="">Select</option>
								<?php
									foreach ($sjendik as $sj){
										echo '<option value="'.$sj->JENDIK.'">'.$sj->KETERANGAN.'</option>';
									}
								?>
								</select>
							</div>
							<div class="input-group">
								<span><input type="button" name="enter" value="Go" class="btn btn-primary" onclick="cari()"></span>
							</div>
					</form>
				</div>
			</div>		
		</div>
	</div>



	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title navy-bg">
					<h5>Pendidikan</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-wrench"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li><a href="#">Config option 1</a>
							</li>
							<li><a href="#">Config option 2</a>
							</li>
						</ul>
						<a class="close-link">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
            	
            		<div class="ibox-content">
						<div class="table-responsive">
		            		<table id="employee-grid" class="table table-striped table-bordered table-hover  dataTables-example" cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
								<thead>
									<tr>
										<th>No</th>
										<th>Kode Pendidikan</th>
										<th>Pendidikan</th>
										<th>User Id</th>
										<th>Term</th>									
										<th>Tg Upd</th>
									</tr>
								</thead>
							</table>
	            		</div>
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

        <!-- Chosen -->
		<script src="<?php echo base_url(); ?>assets/js/plugins/chosen/chosen.jquery.js"></script>

      <!-- <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/inspinia/additional/datatables/css/jquery.dataTables.min.css"/>-->
       
  		
        
		<script type="text/javascript" language="javascript" >
			$(document).ready(function() {
	
				var config = {
					'.chosen-select'           : {},
					'.chosen-select-deselect'  : {allow_single_deselect:true},
					'.chosen-select-no-single' : {disable_search_threshold:10},
					'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
					'.chosen-select-width'     : {width:"95%"}
				}
				for (var selector in config) {
					$(selector).chosen(config[selector]);
				}
				
				var dataTable = $('#employee-grid').DataTable( {
					"aoColumns": [
									
								      null,
								      null,		
								      null,
								      null,
									  null,
								      
									 								  
								      { "bSortable": false }
								    ],
					"processing": true,
					
					
					"language": {
							"processing": "<div></div><div></div><div></div><div></div><div></div>"
						},
					"ajax":{
						url :"<?=base_url('index.php/ref/ref_pendidikan/data')?>", // json datasource
						type: "POST",  // method  , by default get
						data: function(d){
							d.JENDIK=$('#jendik').val()
						},
					}
				} );							
				
		});	
				function cari()
				{
					var dataTable = $('#employee-grid').DataTable();
					dataTable.ajax.reload();
				}

		</script>
