<?php 
    header('Cache-Control: max-age=900');
?>
<style>
    .chosen-container-single .chosen-single abbr{
        cursor: pointer;
    }

     @media screen and (min-width: 770px){
            div#forPhone{
                display: none;
            }

            .modal-lg{
                width: 1024px !important;
            }

            #btnRiwayat{
                float: left !important;
            }
            
        }

</style>
<div class="row wrapper border-bottom white-bg page-heading">
	<!-- <input id="tesgmb" type="text" value="<?php //echo base_url()?>assets/img/banner/6.jpg"> -->
	<div class="col-lg-10">
        <h2>Pegawai Pensiun</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo site_url('statistik')?>">Home</a>
            </li>
            <li class="active">
                <strong>Pegawai Tahun <?php echo $th_next; ?></strong>
            </li>
        </ol>
         <small><i>(Menu untuk menampilkan detail pegawai pensiun)</i></small>
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
			<div class="ibox float-e-margins">
				<div class="ibox-title navy-bg" id="headerBox">
					<h5>Pegawai pensiun Tahun <?php echo $th_next; ?></h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>

					</div>
				</div>
				<div class="ibox-content">
					<input type="hidden" name="spmu" id="spmu" value ="<?php if(isset($spmu)){ echo $spmu; }?>">
					<input type="hidden" name="th_next" id="th_next" value ="<?php if(isset($th_next)){ echo $th_next; }?>">
					<input type="hidden" name="thbl" id="thbl" value ="<?php if(isset($thbl)){ echo $thbl; }?>">
					<div class="spiner-example" id="spinloading" style="display: none">
                                <div class="sk-spinner sk-spinner-three-bounce">
                                    <div class="sk-bounce1"></div>
                                    <div class="sk-bounce2"></div>
                                    <div class="sk-bounce3"></div>
                                </div>
                            </div>
					<table id="tbl-grid" class="table table-striped table-bordered table-hover dataTables-example" >
						<thead>
						<tr>
<!--							<th>No</th>-->
							<th width="3%">No</th>
							<th width="40%">SKPD</th>
							<th>THBL</th>
							<th>JUMLAH</th>
						</tr>
						</thead>
						<tbody></tbody>
						
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- START MODAL FORM AKTIFITAS UMUM -->
<div class="modal fade" id="modalPassword" tabindex="-1" role="dialog" aria-labelledby="modalUmumTitle">
    <div class="modal-dialog modal-lg" role="document" id="pesan">
      
    </div>
</div>

		<!-- jqueryForm -->
        <script src="<?php echo base_url(); ?>assets/js/jquery.form.js"></script>

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

		<!-- Sweet alert -->
		<script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/sweetalert/sweetalert.min.js"></script>

        <!-- Validation -->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/inspinia/boostrapvalidator/js/bootstrapValidator.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/lib-1.0.0.js"></script>

		<!-- Chosen -->
		<script src="<?php echo base_url(); ?>assets/js/plugins/chosen/chosen.jquery.js"></script>

		<!-- Data picker -->
		<script src="<?php echo base_url(); ?>assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
        
		<script type="text/javascript" language="javascript" >
            $('.chosen-select-deselect').chosen({allow_single_deselect:true});
            //$('.chosen-select-deselect').chosen("destroy");
			$(document).ready(function() {
				
				
				var dataTable = $('#tbl-grid').DataTable( {
					
					"bSort":false,
					responsive: false,
					scrollX:true,
					"processing": true,
					"serverSide": true,
					destroy:true,
					"language": {
						"processing": "<div></div><div></div><div></div><div></div><div></div>"
					},
					"ajax":{
						url :"<?=site_url('detpegawai/data_pensiun_skpd_next')?>", // json datasource
						type: "post",  // method  , by default get
						"data": function ( d ) {
				
							d.spmu = $('#spmu').val();
							d.th_next = $('#th_next').val();
							d.thbl = $('#thbl').val();
						},
						error: function(){  // error handling
							$(".tbl-grid-error").html("");
							$("#tbl-grid").append('<tbody class="employee-grid-error"><tr><th colspan="4">No data found in the server</th></tr></tbody>');
							$("#tbl-grid_processing").css("display","none");
						}
					}
					
				} );
				//$('#tbl-grid_filter').css("display","none");//hide filtering
				//resetsrc();
			} );

				
				
		</script>


