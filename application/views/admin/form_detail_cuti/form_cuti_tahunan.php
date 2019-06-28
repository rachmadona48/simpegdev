
<style type="text/css">
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

    <div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    	<h4 class="modal-title" id="myModalLabel">Detail Informasi Cuti</h4>
    </div>
    <div class="modal-body">
    	
            <div class="row">
                <!-- START SIDE 1 -->
                <div class="col-md-6">
                    <div class="form-group">
        				<label class="col-sm-4 control-label"><font color="blue">NRK</font></label>
                    	<div class="col-sm-7"><p>: <?php echo $detail->NRK ?></p>
                    		<input type="hidden" id="id_hist" name="id_hist" placeholder="NRK" class="form-control" value="<?php echo $detail->ID_HIST ?>" readOnly="true">
                    	</div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><font color="blue">NAMA</font></label>
                        <div class="col-sm-7"><p>: <?php echo $detail->NAMA ?></p></div>
                    </div>
                    <!-- <div class="hr-line-dashed"></div> -->

                    <div class="form-group">
                        <label class="col-sm-4 control-label"><font color="blue">Jenis Cuti</font></label>
                        <div class="col-sm-7"><p>: <?php echo $detail->KETERANGAN ?></p></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label"><font color="blue">Lokasi Cuti</font></label>
                        <div class="col-sm-7"><p>: <?php echo $detail->KET_LOKASI ?></p></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label"><font color="blue">Tgl. Mulai</font></label>
                        <div class="col-sm-7"><p>: <?php echo $detail->TMT ?></p></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label"><font color="blue">Tgl. Akhir</font></label>
                        <div class="col-sm-7"><p>: <?php echo $detail->TGAKHIR ?></p></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label"><font color="blue">Tahun N</font></label>
                        <div class="col-sm-7"><p>: <?php echo $detail->CUTI_N ?> Hari</p></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label"><font color="blue">Tahun N-1</font></label>
                        <div class="col-sm-7"><p>: <?php echo $detail->CUTI_N_1 ?> Hari</p></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label"><font color="blue">Tahun N-2</font></label>
                        <div class="col-sm-7"><p>: <?php echo $detail->CUTI_N_2 ?> Hari</p></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label"><font color="blue">Total Cuti</font></label>
                        <div class="col-sm-7"><p>: <?php echo $detail->TOTAL_CUTI ?> Hari</p></div>
                    </div>

                    
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><font color="blue">Tahap proses</font></label>
                        <?php if($detail->STATUS_CUTI == 2){ ?>
                            <div class="col-sm-7"><p>: <span class="label label-warning"><?php echo $detail->TAHAP ?></span></p></div>
                        <?php }else if($detail->STATUS_CUTI == 3 || $detail->STATUS_CUTI == 7 || $detail->STATUS_CUTI == 9 || $detail->STATUS_CUTI == 10 || $detail->STATUS_CUTI == 11){ ?>
                            <div class="col-sm-7"><p>: <span class="label label-danger"><?php echo $detail->TAHAP ?></span></p></div>
                        <?php }else if($detail->STATUS_CUTI == 5 || $detail->STATUS_CUTI == 4 || $detail->STATUS_CUTI == 8){ ?>
                            <div class="col-sm-7"><p>: <span class="label label-success"><?php echo $detail->TAHAP ?></span></p></div>
                        <?php }else{ ?>
                            <div class="col-sm-7"><p>: <span class="label label-primary"><?php echo $detail->TAHAP ?></span></p></div>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label"><font color="blue">Alasan Cuti</font></label>
                        <div class="col-sm-7"><p>: <?php echo $detail->ALSN_CUTI ?></p></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label"><font color="blue">Telp Cuti</font></label>
                        <div class="col-sm-7"><p>: <?php echo $detail->TELP_CUTI ?></p></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label"><font color="blue">Alamat Cuti</font></label>
                        <div class="col-sm-7"><p>: <?php echo $detail->ALMT_CUTI ?></p></div>
                    </div>

                </div>   

                <div class="col-md-6">
                    <div class="alert alert-danger" >
                        <i style="font-size: 10px;"><b>Informasi *</b></i><br/>
                        <i style="font-size: 10px;">
                        Tahun N   : Jumlah hari cuti pada tahun berjalan <br/>
                        Tahun N-1 : Jumlah hari cuti pada satu tahun sebelumnya<br/>
                        Tahun N-2 : Jumlah hari cuti pada dua tahun sebelumnya
                        </i>
                    
                    </div>
                </div>       
            </div>

            <div class="row">
                <div class="col-md-12">
                <table id="tbl_detail_cuti" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <td align="left" width="3%"><b>No</b></td>
                                <td align="left" width="17%"><b>Tahap</b></td>
                                <td align="left" width="40%"><b>Keterangan</b></td>
                                <td align="left" width="40%"><b>Informasi</b></td>
                            </tr>
                        </thead>
                        <tbody>
                            <div id="spinner_tbl_detail_cuti"></div>
                        </tbody>
                    </table> 
                </div>
            </div>	            			            			        	
           
    	
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
        <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
           tabel_cuti();
        });

        function tabel_cuti(){
            var id_hist = $('#id_hist').val()
            var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 

            var dataTable = $('#tbl_detail_cuti').DataTable( {
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
                            "processing": "<div></div><div></div><div></div><div></div>"
                        },
                    "ajax":{
                        url :"<?php echo site_url('index.php/cuti/hist_detail_cuti')?>", // json datasource
                        type: "post",  // method  , by default get
                        // drawCallback: function( settings ) {
                          
                        // },
                        data : function(d){
                            d.id_hist = id_hist;
                        },
                        beforeSend: function(){
                            $('#spinner_tbl_detail_cuti').html(spinner);
                        },complete: function(){
                                 $("#spinner_tbl_detail_cuti").html('');
                        },
                        error: function(){  // error handling
                            $(".tbl_detail_cuti-error").html("");
                            $("#tbl_detail_cuti").append('<tbody class="tbl_detail_cuti-error"><tr><div colspan=4>Tidak Ada Data</div></tr></tbody>');
                            $("#tbl_detail_cuti_processing").css("display","none");
                            
                        }

                    }
                  

                } );
                

                // setInterval( function () {
                //     $('#tbl1').DataTable().ajax.reload();
                // }, 1000 );


                $('#tbl_detail_cuti input').unbind();
                $('#tbl_detail_cuti input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                oTable.fnFilter(this.value);
                }
                });
        }

        function d_rs(link){
            // alert(link);
            window.open('<?=site_url('index.php/cuti')?>/prinf_rs?dn='+link);  

        }
    </script>