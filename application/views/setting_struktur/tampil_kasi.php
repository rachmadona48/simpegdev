


<table class="table table-bordered table-advance table-hover">
	<thead>
	<tr>
		
		<th>
			  <?php echo $unit->LEVEL3; ?>
		</th>
		<th>
			 Jabatan
		</th>
		<th>										
			<!-- <a type="button" data-toggle="modal" data-target="#myModalLevel3" class="btn btn-xs btn-primary" onclick="$('#panel_staff').show();$('#panel_kasi').show();tambah_kasi('<?php echo $_GET['token'] ?>','<?php echo $_GET['nip_kabid'] ?>','td_pilih_kasi','<?php echo $_GET['target_kabid'] ?>','<?php echo $_GET['tahunbulan'] ?>','<?php echo $_GET['spmu'] ?>','<?php echo $_GET['fieldn'] ?>','insert');tambah_staff('<?php echo $_GET['token'] ?>','<?php echo $_GET['nip_kabid'] ?>','td_pilih_staff','<?php echo $_GET['target_kabid'] ?>','<?php echo $_GET['tahunbulan'] ?>','<?php echo $_GET['spmu'] ?>','<?php echo $_GET['fieldn'] ?>','insert');"><i class="fa fa-plus"></i>Tambah <?php echo $_SESSION['level3'] ?></a> -->
			<a type="button" data-toggle="modal" onclick="myModalLevel3('<?php echo $data_kabid->NIP18; ?>','<?php echo $data_kabid->KOLOK; ?>','<?php echo $data_kabid->KOJAB; ?>','<?php echo $data_kabid->NRK; ?>','<?php echo $data_kabid->SPMU; ?>','<?php echo $spmu_kadis; ?>')" class="btn btn-xs btn-primary" ><i class="fa fa-plus"></i>Tambah <?php echo $unit->LEVEL3; ?></a>
		</th>
	</tr>								

	</thead>
	<tbody>
		<?php foreach ($kasi as $ka_si) { ?>
			<tr  style="background-color:#f9f79b" id="kasi_<?php echo $ka_si->TABEL.'_'.$ka_si->NIP18 ?>">
				<td >
					 <b><?php echo $ka_si->NAMA ?></b><br>
					 <?php echo $ka_si->NIP18 ?>						 
				</td>
				<td>
					<?php echo $ka_si->JABATAN ?>
				</td>
				<td>

					<?php if($ka_si->TABEL == 'kepala_kadis'){ ?>

						<!-- <a type="button" data-toggle="modal" data-target="#myModalLevel3" class="btn btn-xs btn-warning" onclick="$('#panel_staff').hide();$('#panel_kasi').show();tambah_kasi('<?php echo $_GET['token'] ?>','<?php echo $_GET['nip_kabid'] ?>','td_pilih_kasi','<?php echo $_GET['target_kabid'] ?>','<?php echo $_GET['tahunbulan'] ?>','<?php echo $_GET['spmu'] ?>','<?php echo $_GET['fieldn'] ?>','update', '<?php echo $rows['nama'] ?>', '<?php echo $rows['nip18'] ?>','<?php echo $rows['kolok'] ?>','<?php echo $rows['kojab'] ?>');"><i class="fa fa-pencil"></i>Ubah</a>							 
						&nbsp;
						<a class="btn btn-danger btn-xs black"  onclick="confirm('Anda yakin menghapus data pegawai tersebut?') ? hapus_kasi('<?php echo $_GET['token'] ?>','<?php echo $_GET['nip_kabid'] ?>','<?php echo $rows['nip18'] ?>','','<?php echo $_GET['tahunbulan'] ?>','<?php echo "kasi_".$rows['tabel']."_".$rows['nip18'] ?>') : ''"><i class="fa fa-trash-o"></i> Delete</a>		 -->

						<a type="button" data-toggle="modal" class="btn btn-xs btn-warning" onclick="myModalLevel3Ubah('<?php echo $ka_si->NIP18 ?>','<?php echo $ka_si->NAMA ?>','<?php echo $ka_si->SPMU ?>','<?php echo $ka_si->KOLOK ?>','<?php echo $data_kabid->NIP18; ?>')"><i class="fa fa-pencil"></i>Ubah</a>							 
						&nbsp;
						<a class="btn btn-danger btn-xs black" onclick="confirm('Anda yakin menghapus data pegawai tersebut?') ? hapus_kasi('<?php echo $ka_si->NIP18 ?>','<?php echo $data_kabid->NIP18; ?>','<?php echo $data_kabid->SPMU; ?>','<?php echo $data_kabid->KOLOK; ?>') : '' "><i class="fa fa-trash-o"></i> Delete</a>											

					<?php } elseif ($ka_si->TABEL== 'kepala_staff') { ?>

						<!-- <a class="btn btn-danger btn-xs black"  onclick="confirm('Anda yakin menghapus data pegawai tersebut?') ? hapus_staff('<?php echo $_GET['token'] ?>','<?php echo $_GET['nip_kabid'] ?>','<?php echo $rows['nip18'] ?>','','<?php echo $_GET['tahunbulan'] ?>','<?php echo $_GET['spmu'] ?>','<?php echo $_GET['fieldn'] ?>', '<?php echo "kasi_".$rows['tabel']."_".$rows['nip18'] ?>') : ''"><i class="fa fa-trash-o"></i> Delete</a> -->
						<a class="btn btn-danger btn-xs black" onclick="confirm('Anda yakin menghapus data pegawai tersebut?') ? hapus_staff_from_kabid('<?php echo $ka_si->NIP18 ?>','<?php echo $data_kabid->NIP18; ?>','<?php echo $data_kabid->SPMU; ?>','<?php echo $data_kabid->KOLOK; ?>') : '' "><i class="fa fa-trash-o"></i> Delete</a>

					<?php }?>
					
					
				</td>
			</tr>

			<?php if($ka_si->TABEL == 'kepala_kadis'){ ?>

				<tr id="2kasi_<?php echo $ka_si->TABEL.'_'.$ka_si->NIP18 ?>">
					<TD colspan="3">
						<!-- <a  class="btn btn-info btn-xs black" onclick="tampil_staff('<?php echo $_GET['token'] ?>','<?php echo $rows['nip18'] ?>','td_kasi_<?php echo $rows['nip18'] ?>','<?php echo $_GET['tahunbulan'] ?>','<?php echo $_GET['spmu'] ?>','<?php echo $_GET['fieldn'] ?>')"><i class="fa fa-sitemap"></i> Tampilkan Staff </a> -->
						<a  class="btn btn-info btn-xs black" onclick="tampil_staff('<?php echo $ka_si->NIP18 ?>','td_kasi_<?php echo $ka_si->NIP18 ?>','<?php echo $ka_si->SPMU ?>')"><i class="fa fa-sitemap"></i> Tampilkan Staff </a>
                        <a  class="btn btn-danger btn-xs black" onclick="tutup_staff('td_kasi_<?php echo $ka_si->NIP18 ?>')"><i class="fa fa-times"></i> Tutup </a>
					
					<div id="td_kasi_<?php echo $ka_si->NIP18 ?>"></div></td>
				</tr>

			<?php }else{ ?>

				<tr id="2kasi_<?php echo $ka_si->TABEL.'_'.$ka_si->NIP18 ?>"><td colspan="3">&nbsp;</td></tr>

			<?php } ?>

		<?php   } ?>

		
	</tbody>
</table>



<!-- LEVEL 3 -->
<div class="modal inmodal" id="myModalLevel3" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 60%;">
        <div class="modal-content animated fadeIn">                                        
            <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                            
            <br>
            	<div class="panel blank-panel">
                    <div class="panel-heading">						                            
                        <div class="panel-options">
                            <ul class="nav nav-tabs">						                                    
                                <li id="panel_kasi" class="active"><a data-toggle="tab" href="#tab-4">Kasubag</a></li>
                                <li id="panel_staff" class=""><a data-toggle="tab" href="#tab-5">Staff</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="tab-content">
                        	<div id="tab-4" class="tab-pane active">
                                <center>
                                    <h4>Pilih <?php echo $unit->LEVEL3; ?></h4>
                                    <strong id="kasi_old"></strong>
                					<!-- <input type="hidden" name="nip_old3" id="nip_old3" value=""> -->
								</center>
								<br>
								<div>

									<input type="hidden" class="form-control" id="nip_kabid" name="nip_kabid" readonly="" value="">
                                    <input type="hidden" class="form-control" id="kolok_kabid" name="kolok_kabid" readonly="" value="">
                                    <input type="hidden" class="form-control" id="kojab_kabid" name="kojab_kabid" readonly="" value="">
                                    <input type="hidden" class="form-control" id="nrk_kabid" name="nrk_kabid" readonly="" value="">
                                    <input type="hidden" class="form-control" id="spmu_kabid" name="spmu_kabid" readonly="" value="">
                                    <input type="hidden" class="form-control" id="spmu_kadis" name="spmu_kadis" readonly="" value="">

                                    <!-- <input type="hidden" class="form-control" id="kolok2" name="kolok2" readonly="" value="<?php echo $unit->KOLOK; ?>"> -->

									<table id="tabel_kasubag_form_kabid" class="table table-striped table-bordered table-advance table-hover">
		                                <thead>
		                                    <tr>
		                                        <th class="hidden-xs">NIK</th><th>NAMA</th><th>JABATAN</th><th></th>
		                                    </tr>
		                                </thead>
		                                <tbody>
		                                    <div id="spinner_kasubag_form_kabid"></div>
		                                
		                                </tbody>
		                            </table>

								</div>
							</div>
							<div id="tab-5" class="tab-pane">
                                <center>
                                    <h4>Pilih Staff</h4>
								</center>
								<br>
								<div>

									<input type="hidden" class="form-control" id="nip_kabid2" name="nip_kabid2" readonly="" value="">
                                    <input type="hidden" class="form-control" id="kolok_kabid2" name="kolok_kabid2" readonly="" value="">
                                    <input type="hidden" class="form-control" id="kojab_kabid2" name="kojab_kabid2" readonly="" value="">
                                    <input type="hidden" class="form-control" id="nrk_kabid2" name="nrk_kabid2" readonly="" value="">
                                    <input type="hidden" class="form-control" id="spmu_kabid2" name="spmu_kabid2" readonly="" value="">
                                    <input type="hidden" class="form-control" id="spmu_kadis2" name="spmu_kadis2" readonly="" value="">

									<table id="tabel_pegawai_from_kabid" class="table table-striped table-bordered table-advance table-hover">
		                                <thead>
		                                    <tr>
		                                        <th class="hidden-xs">NIK</th><th>NAMA</th><th>JABATAN</th><th></th>
		                                    </tr>
		                                </thead>
		                                <tbody>

		                                    <div id="spinner_pegawai_from_kabid"></div>
		                                
		                                </tbody>												
	                                </table>

								</div>
							</div>
                        </div>
                   	</div>
              	</div>
            	
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- LEVEL 3-->

<!-- LEVEL 3 UBAH -->
<div class="modal inmodal" id="myModalLevel3Ubah" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 75%;">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                            
                <h4 class="modal-title">Pilih <?php echo $unit->LEVEL3 ?></h4>
                <strong id="kasubag_old"></strong>
                <input type="hidden" name="nip_kasubag_old" id="nip_kasubag_old" value="">
                <input type="hidden" name="spmu_kabid_ubah" id="spmu_kabid_ubah" value="">
                <input type="hidden" name="kolok_kabid_ubah" id="kolok_kabid_ubah" value="">  
                <input type="hidden" name="nip_kabid_ubah_kasi" id="nip_kabid_ubah_kasi" value=""> 
            </div>
            <div class="modal-body" id="td_pilih_kabag">
                <div class="panel-body">

                    <input type="hidden" class="form-control" id="spmu_pimpinan2_ubah_kasubag" name="spmu_pimpinan2_ubah_kasubag" readonly="" value="<?php echo $spmu_kadis; ?>">

                    <table id="tabel_kasubag_form_kabid_ubah" class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                            <tr>
                                <th>NIK</th><th>NAMA</th><th>JABATAN</th><th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <div id="spinner_tabel_kasubag_ubah"></div>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- LEVEL 3 UBAH-->

<!-- <script src="<?php echo base_url() ?>assets/inspinia/js/jquery-2.1.1.js"></script> -->
<!-- Data Tables -->
<script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/dataTables.responsive.js"></script>
<script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/dataTables.tableTools.min.js"></script>

<script type="text/javascript">
	function myModalLevel3(nip_kabid,kolok_kabid,kojab_kabid,nrk_kabid,spmu_kabid,spmu_kadis){
	// alert(nip18);
        // tabel_kabag();
        // tabel_kasubag();
        // tabel_pegawai();
        $('#nip_kabid').val(nip_kabid);
        $('#kolok_kabid').val(kolok_kabid);
        $('#kojab_kabid').val(kojab_kabid);
        $('#nrk_kabid').val(nrk_kabid);
        $('#spmu_kabid').val(spmu_kabid);
        $('#spmu_kadis').val(spmu_kadis);

        $('#nip_kabid2').val(nip_kabid);
        $('#kolok_kabid2').val(kolok_kabid);
        $('#kojab_kabid2').val(kojab_kabid);
        $('#nrk_kabid2').val(nrk_kabid);
        $('#spmu_kabid2').val(spmu_kabid);
        $('#spmu_kadis2').val(spmu_kadis);


        tabel_kasubag_form_kabid();
        tabel_pegawai_from_kabid();
        $('#myModalLevel3').modal('show');

    }

    function myModalLevel3Ubah(nip_old,nama_old,spmu_kabid,kolok_kabid,nip_kabid){
        // alert(spmu_kabid);
        $('#spmu_kabid_ubah').val(spmu_kabid);
        $('#kolok_kabid_ubah').val(kolok_kabid);
        $('#nip_kabid_ubah_kasi').val(nip_kabid);
        $('#nip_kasubag_old').val(nip_old);
        $('#kasubag_old').html('Pengganti '+nama_old+' ('+nip_old+')');
        tabel_kasubag_form_kabid_ubah();
        $('#myModalLevel3Ubah').modal('show');
    }

    function tabel_kasubag_form_kabid(){
        var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

        var dataTable = $('#tabel_kasubag_form_kabid').DataTable( {
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
                    url :"<?php echo site_url('index.php/Setting_struktur/tabel_kasubag_form_kabid')?>", // json datasource
                    type: "post",  // method  , by default get
                    // drawCallback: function( settings ) {
                      
                    // },
                    data : function(d){
                        d.nip_kabid = $('#nip_kabid').val();
                        d.kolok_kabid = $('#kolok_kabid').val();
                        d.kojab_kabid = $('#kojab_kabid').val();
                        d.nrk_kabid = $('#nrk_kabid').val();
                        d.spmu_kabid = $('#spmu_kabid').val();
                        d.spmu_kadis = $('#spmu_kadis').val();

                    },
                    beforeSend: function(){
                        $('#spinner_kasubag_form_kabid').html(spinner);
                    },complete: function(){
                             $("#spinner_kasubag_form_kabid").html('');
                    },
                    error: function(){  // error handling
                        $(".tabel_kasubag_form_kabid-error").html("");
                        $("#tabel_kasubag_form_kabid").append('<tbody class="tabel_kasubag_form_kabid-error"><tr><div colspan=3>Tidak Ada Data</div></tr></tbody>');
                        $("#tabel_kasubag_form_kabid_processing").css("display","none");
                        
                    }

                }
              

            } );
            

            // setInterval( function () {
            //     $('#tbl1').DataTable().ajax.reload();
            // }, 1000 );


            $('#tabel_kasubag_form_kabid input').unbind();
            $('#tabel_kasubag_form_kabid input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            oTable.fnFilter(this.value);
            }
            });
    }

    function tabel_kasubag_form_kabid_ubah(){
        var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

        var dataTable = $('#tabel_kasubag_form_kabid_ubah').DataTable( {
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
                    url :"<?php echo site_url('index.php/Setting_struktur/tabel_kasubag_form_kabid_ubah')?>", // json datasource
                    type: "post",  // method  , by default get
                    // drawCallback: function( settings ) {
                      
                    // },
                    data : function(d){
                        d.spmu_kadis = $('#spmu_pimpinan2_ubah_kasubag').val();
                        d.nip_kasubag_old = $('#nip_kasubag_old').val();
                        d.spmu_kabid_ubah = $('#spmu_kabid_ubah').val();
                        d.kolok_kabid_ubah = $('#kolok_kabid_ubah').val();
                        d.nip_kabid_ubah_kasi = $('#nip_kabid_ubah_kasi').val();
                        
                    },
                    beforeSend: function(){
                        $('#spinner_tabel_kasubag_ubah').html(spinner);
                    },complete: function(){
                             $("#spinner_tabel_kasubag_ubah").html('');
                    },
                    error: function(){  // error handling
                        $(".tabel_kasubag_form_kabid_ubah-error").html("");
                        $("#tabel_kasubag_form_kabid_ubah").append('<tbody class="tabel_kasubag_form_kabid_ubah-error"><tr><div colspan=3>Tidak Ada Data</div></tr></tbody>');
                        $("#tabel_kasubag_form_kabid_ubah_processing").css("display","none");
                        
                    }

                }
              

            } );
            

            // setInterval( function () {
            //     $('#tbl1').DataTable().ajax.reload();
            // }, 1000 );


            $('#tabel_kasubag_form_kabid input').unbind();
            $('#tabel_kasubag_form_kabid input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            oTable.fnFilter(this.value);
            }
            });
    }

    function pilih_kasi_from_kabid(nip_kadis,kolok_kadis,kojab_kadis,nrk_kadis,nip18_kepala,kolok_kepala,kojab_kepala,nrk_kepala,spmu_kadis,spmu_kepala){
        // alert('pilih kasi: '+nip_kadis+' : '+kolok_kadis+' : '+kojab_kadis+' : '+nrk_kadis+' : '+NIP18+' : '+KOLOK_EXIST+' : '+KOJAB_EXIST+' : '+NRK+' : '+spmu_pimpinan)

        $.ajax({
            url : "<?php echo site_url('index.php/Setting_struktur/pilih_kasi')?>",
            type: "POST",
            data: {nip_kadis:nip_kadis,kolok_kadis:kolok_kadis,kojab_kadis:kojab_kadis ,nrk_kadis:nrk_kadis,nip18_kepala:nip18_kepala,kolok_kepala:kolok_kepala,kojab_kepala:kojab_kepala,nrk_kepala:nrk_kepala,spmu_kadis:spmu_kadis,spmu_kepala:spmu_kepala},
            dataType: "JSON",
            beforeSend: function() {
                
            },
            success: function(data)
            {
                // location.reload();    
                $('#myModalLevel3').modal('hide');  
                tampil_kasi(nip_kadis,'td_kabid_'+nip_kadis,spmu_kadis,kolok_kadis)                
               
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
            },
            complete: function() {                            

            }
        });

    }

    function pilih_kasi_from_kabid_ubah(nip18_kepala,kolok_kepala,kojab_kepala,nrk_kepala,spmu_kepala,nip_kabag_old,spmu_kabid,kolok_kabid,nip_kabid){
        // alert(nip18_kepala+' : '+kolok_kepala+' : '+kojab_kepala+' : '+nrk_kepala+' : '+spmu_kepala+' : '+nip_kabag_old);
        $.ajax({
            url : "<?php echo site_url('index.php/Setting_struktur/pilih_kasi_from_kabid_ubah')?>",
            type: "POST",
            data: {nip18_kepala:nip18_kepala,kolok_kepala:kolok_kepala,kojab_kepala:kojab_kepala,nrk_kepala:nrk_kepala,spmu_kepala:spmu_kepala,nip_kabag_old:nip_kabag_old},
            dataType: "JSON",
            beforeSend: function() {
                
            },
            success: function(data)
            {
                // location.reload(); 
                $('#myModalLevel3Ubah').modal('hide');  
                tampil_kasi(nip_kabid,'td_kabid_'+nip_kabid,spmu_kabid,kolok_kabid);                       
               
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
            },
            complete: function() {                            

            }
        });
    }

    function tabel_pegawai_from_kabid(){
        var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

        var dataTable = $('#tabel_pegawai_from_kabid').DataTable( {
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
                    url :"<?php echo site_url('index.php/Setting_struktur/tabel_pegawai_from_kabid')?>", // json datasource
                    type: "post",  // method  , by default get
                    // drawCallback: function( settings ) {
                      
                    // },
                    data : function(d){
                        d.nip_kabid = $('#nip_kabid2').val();
                        d.kolok_kabid = $('#kolok_kabid2').val();
                        d.kojab_kabid = $('#kojab_kabid2').val();
                        d.nrk_kabid = $('#nrk_kabid2').val();
                        d.spmu_kabid = $('#spmu_kabid2').val();
                        d.spmu_kadis = $('#spmu_kadis2').val();

                    },
                    beforeSend: function(){
                        $('#spinner_pegawai_from_kabid').html(spinner);
                    },complete: function(){
                             $("#spinner_pegawai_from_kabid").html('');
                    },
                    error: function(){  // error handling
                        $(".tabel_pegawai_from_kabid-error").html("");
                        $("#tabel_pegawai_from_kabid").append('<tbody class="tabel_pegawai_from_kabid-error"><tr><div colspan=3>Tidak Ada Data</div></tr></tbody>');
                        $("#tabel_pegawai_from_kabid_processing").css("display","none");
                        
                    }

                }
              

            } );
            

            // setInterval( function () {
            //     $('#tbl1').DataTable().ajax.reload();
            // }, 1000 );


            $('#tabel_pegawai_from_kabid input').unbind();
            $('#tabel_pegawai_from_kabid input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            oTable.fnFilter(this.value);
            }
            });
    }

    function pilih_pegawai_from_kabid(nip_kepala,kolok_kepala,kojab_kepala,nrk_kepala,nip18_staff,kolok_staff,kojab_staff,nrk_staff,spmu_kepala,spmu_staff){
        // alert('pilih pegawai: '+nip_kadis+' : '+kolok_kadis+' : '+kojab_kadis+' : '+nrk_kadis+' : '+NIP18+' : '+KOLOK_EXIST+' : '+KOJAB_EXIST+' : '+NRK+' : '+spmu_pimpinan)

        $.ajax({
            url : "<?php echo site_url('index.php/Setting_struktur/pilih_pegawai')?>",
            type: "POST",
            data: {nip_kepala:nip_kepala,kolok_kepala:kolok_kepala,kojab_kepala:kojab_kepala ,nrk_kepala:nrk_kepala,nip18_staff:nip18_staff,kolok_staff:kolok_staff,kojab_staff:kojab_staff,nrk_staff:nrk_staff,spmu_kepala:spmu_kepala,spmu_staff:spmu_staff},
            dataType: "JSON",
            beforeSend: function() {
                
            },
            success: function(data)
            {
                // location.reload();  
                tampil_kasi(nip_kepala,'td_kabid_'+nip_kepala,spmu_kepala,kolok_kepala)                      
               
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
            },
            complete: function() {                            

            }
        });

    }


    function tampil_staff(nip18,target_kasi,spmu_kasi){
        // alert(target_kasi);
        $('#'+target_kasi).show();
        var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 
        // alert(spinner);
        $.ajax({
            url : "<?php echo site_url('index.php/Setting_struktur/tampil_staff')?>",
            type: "POST",
            data: {nip18:nip18,target_kasi:target_kasi,spmu_kasi:spmu_kasi},
            dataType: "JSON",
            beforeSend: function() {
                $('#'+target_kasi).html(spinner);
            },
            success: function(data)
            {
                $('#'+target_kasi).html('');
                // location.reload(); 
                // alert(data.response);
                if(data.response=='SUKSES'){
                    // alert(data.result);

                    $('#'+target_kasi).html(data.result);
                }                    
               
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $('#'+target_kasi).html('');
                // swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
            },
            complete: function() {                            

            }
        });
    }

    function tutup_staff(target_kasi){
        $('#'+target_kasi).hide();
    }

    function hapus_kasi(nip,nip_kabid,spmu_kabid,kolok_kabid){
        $.ajax({
            url : "<?php echo site_url('index.php/Setting_struktur/hapus_kasi')?>",
            type: "POST",
            data: {nip:nip},
            dataType: "JSON",
            beforeSend: function() {
                
            },
            success: function(data)
            {
                // location.reload();   
                tampil_kasi(nip_kabid,'td_kabid_'+nip_kabid,spmu_kabid,kolok_kabid)                     
               
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
            },
            complete: function() {                            

            }
        });
    }


    function hapus_staff_from_kabid(nip,nip_kabid,spmu_kabid,kolok_kabid){
        $.ajax({
            url : "<?php echo site_url('index.php/Setting_struktur/hapus_staff_from_kabid')?>",
            type: "POST",
            data: {nip:nip},
            dataType: "JSON",
            beforeSend: function() {
                
            },
            success: function(data)
            {
                // location.reload();   
                tampil_kasi(nip_kabid,'td_kabid_'+nip_kabid,spmu_kabid,kolok_kabid)                     
               
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
            },
            complete: function() {                            

            }
        });
    }


</script>

