
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

<form id="defaultForm2" name="defaultForm2" method="post" class="form-horizontal"  action="javascript:save();" data-bv-submitbuttons="button[type='submit']" data-remote="true" data-toggle="validator" role="form">
    <div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    	<h4 class="modal-title" id="myModalLabel">Form Rekap Cuti</h4>
    </div>
    <div class="modal-body">
    	
            <div class="row">
                <!-- START SIDE 1 -->
                <div class="col-md-12">
                    <div class="form-group">
        				<label class="col-sm-4 control-label"><font color="blue">NRK</font></label>
                    	<div class="col-sm-7">
                    		<input type="text" id="nrk" name="nrk" placeholder="NRK" class="form-control" value="<?php echo isset($nrk) ? $nrk : '' ?>" readOnly="true">
                            <input type="hidden" id="save_method_rekap" name="save_method_rekap" placeholder="NRK" class="form-control" value="<?php echo isset($data_rekap_cuti->JML_CUTI) ? $data_rekap_cuti->JML_CUTI : "0"; ?>" readOnly="true">
                    	</div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <?php if(isset($data_rekap_cuti->JML_CUTI)){ ?>
                        <input type="hidden" id="tahun" name="tahun" placeholder="NRK" class="form-control" value="<?php echo isset($data_rekap_cuti->TAHUN) ? $data_rekap_cuti->TAHUN : ""; ?>" readOnly="true">
                    <?php }else{ ?>
                        <div class="form-group pickerpicker">
                          <label class="col-sm-4 control-label">Tahun</label>
                          <div class="col-sm-8">                                      
                              <select class="chosen-jencuti" name="tahun" id="tahun" tabindex="2" data-placeholder="Pilih tahun...">
                                <option value="0"></option>
                                <!-- <option value="2016">2016</option> -->
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                              </select>
                          </div>
                        </div>
                    <?php } ?>

                    

                    <div class="form-group">
                      <label class="col-sm-4 control-label">Jumlah Cuti</label>
                      <div class="col-sm-4">
                            <input type="text" id="jml_cuti" name="jml_cuti" placeholder="Jumlah Cuti" class="form-control" onkeypress="return hanyaAngka(event)" value="<?php echo isset($data_rekap_cuti->JML_CUTI) ? $data_rekap_cuti->JML_CUTI : ""; ?>">
                      </div>
                    </div>

    	            <!-- <div class="form-group pickerpicker">
    	              <label class="col-sm-4 control-label">Jenis Cuti</label>
    	              <div class="col-sm-8">	                 	              
    	                  <select class="chosen-jencuti" name="jencuti" id="jencuti" tabindex="2" data-placeholder="Pilih Jenis Cuti...">
    	                    <option value=""></option>
                            <?php echo $listJenCuti ?>
    	                  </select>
    	              </div>
    	            </div> -->
    	            <!-- <div class="form-group pickerpicker"  id="data_2">
    	              <label class="col-sm-4 control-label">Tgl. Berakhir</label>
    	              <div class="input-group col-sm-7 date">
    	                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="tgakhir" name="tgakhir" placeholder="Tgl. Akhir" value="<?php echo isset($infoCuti->TGAKHIR) ? date('d-m-Y', strtotime($infoCuti->TGAKHIR)) : ""; ?>" class="form-control">
    	              </div>
    	            </div> -->
    	            
    	            
                    <div class="hr-line-dashed"></div>
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
 <script type="text/javascript">

            $(document).ready(function(){
                $('#defaultForm22').bootstrapValidator({
                    live: 'enabled',
                    excluded : 'disabled',
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        tahun: {
                            validators: {
                                notEmpty: {
                                    message: 'Tahun harus dipilih'
                                }
                            }
                        },pejtt: {
                            validators: {
                                notEmpty: {
                                    message: 'PEJTT harus dipilih'
                                }
                            }
                        },tgsk: {
                            validators: {
                                 date: {
                                    format: 'DD-MM-YYYY',
                                    message: 'Date is not valid'
                                },
                                notEmpty: {
                                    message: 'Tgl. SK tidak boleh kosong'
                                }
                            }
                        },tgakhir: {
                            validators: {
                                 date: {
                                    format: 'DD-MM-YYYY',
                                    message: 'The date is not a valid'
                                },
                                notEmpty: {
                                    message: 'Tgl. Akhir tidak boleh kosong'
                                }
                            }
                        }
                    }
                });

                $('#data_1 .input-group.date').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true,
                    format: "dd-mm-yyyy"
                }).on('changeDate', function(e) {
                // Revalidate the date field
                $('#defaultForm2').bootstrapValidator('revalidateField', 'tmt');
                }); 

                $('#data_2 .input-group.date').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true,
                    format: "dd-mm-yyyy"
                }).on('changeDate', function(e) {
                // Revalidate the date field
                $('#defaultForm2').bootstrapValidator('revalidateField', 'tgakhir');
                }); 

                $('#data_3 .input-group.date').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true,
                    format: "dd-mm-yyyy"
                }).on('changeDate', function(e) {
                // Revalidate the date field
                $('#defaultForm2').bootstrapValidator('revalidateField', 'tgsk');
                }); 
                
                /*START CHOSEN*/
                var config = {
                  '.chosen-jencuti'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "300px"},
                  '.chosen-pejtt'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "300px"},
                  '.chosen-jensk'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "300px"}
                }
                for (var selector in config) {
                  $(selector).chosen(config[selector]);
                }
                /*END CHOSEN*/                    

            });

            function numbersonly(myfield, e, dec) 
            {   
                var key; 
                var keychar; 
                if (window.event)
                    key = window.event.keyCode; 
                else if (e) 
                    key = e.which; 
                else 
                    return true; 
                keychar = String.fromCharCode(key); 

                // control keys 
                if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) ) 
                return true; 

                // numbers 
                else if ((("0123456789").indexOf(keychar) > -1))
                 return true; 

                // decimal point jump 
                else if (dec && (keychar == ".")) 
                { 
                    myfield.form.elements[dec].focus(); return false; 
                } 
                else 
                    return false; 
              }

            function hanyaAngka(evt) {
              var charCode = (evt.which) ? evt.which : event.keyCode
               if (charCode > 31 && (charCode < 48 || charCode > 57))
     
                return false;
              return true;
            }

            function save()
            {
                // alert(save_method);
                var nrk = $('#nrk').val()
                var tahun = $('#tahun').val()
                var jml_cuti = $('#jml_cuti').val()
                var save_method_rekap = $('#save_method_rekap').val()

                

                // alert(tahun);
                // alert(save_method);

                if(save_method_rekap != '0'){
                    if(jml_cuti == ''){
                        swal({type:"warning",title:"GAGAL", text:"Jumlah cuti tidak boleh kosong"});
                        
                    }else{
                        save2(save_method_rekap);
                    }
                }else{
                    if(tahun == '0' || tahun == 0 || jml_cuti == ''){
                        swal({type:"warning",title:"GAGAL", text:"Tahun dan jumlah cuti tidak boleh kosong"});
                        
                    }else{
                        save2(save_method_rekap);
                    }
                }
                

                

                // alert('simpan')
            }

            function save2(save_method_rekap)
            {
                
                var url;
                if(save_method_rekap != '0')
                {
                    url = "<?php echo site_url('home/ajax_update_rekap_cuti')?>";
                }
                else
                {    
                    url = "<?php echo site_url('home/ajax_add_rekap_cuti')?>";
                }

                
                
               
                  $.ajax({
                    url : url,
                    type: "POST",
                    data: $('#defaultForm2').serialize(),
                    dataType: "JSON",
                    beforeSend: function() {
                        $('.msg').html('<div><div class="sk-spinner sk-spinner-rotating-plane"></div></div>');
                        $('.err').html("");
                    },
                    success: function(data)
                    {
                       
                       if(data.response == 'SUKSES'){
                            $('.msg').html('<small>Data berhasil disimpan.</small>');
                            $('.err').html('');

                            $('#myModal').modal('hide');
                            setTimeout(function () {
                                reload();
                            }, 1000);                        

                        }else{
                            $('.msg').html('');
                            $('.err').html('');
                            swal({type:"warning",title:"GAGAL", text:data.pesan});
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