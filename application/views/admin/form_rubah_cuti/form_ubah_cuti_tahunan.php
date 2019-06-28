
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
<form id="defaultForm2" name="defaultForm2" method="post" class="form-horizontal"  action="javascript:save_ubah();" data-bv-submitbuttons="button[type='submit']" data-remote="true" data-toggle="validator" role="form">
    <div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    	<h4 class="modal-title" id="myModalLabel">Ubah Cuti Tahunan</h4>
    </div>
    <div class="modal-body">
    	
            <div class="row">
                <!-- START SIDE 1 -->
                <div class="col-md-6">

                    <legend><h4>Cuti</h4></legend>
                    <div class="form-group">
        				<label class="col-sm-3 control-label"><font color="blue">NRK</font></label>
                    	<div class="col-sm-8"><p>: <?php echo $detail->NRK ?></p>
                    		<input type="hidden" id="id_hist_ubah" name="id_hist_ubah" placeholder="NRK" class="form-control" value="<?php echo $detail->ID_HIST ?>" readOnly="true">
                            <input type="hidden" id="jencuti_ubah" name="jencuti_ubah" placeholder="NRK" class="form-control" value="<?php echo $detail->JENCUTI ?>" readOnly="true">
                    	</div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><font color="blue">NAMA</font></label>
                        <div class="col-sm-8"><p>: <?php echo $detail->NAMA ?></p></div>
                    </div>
                    <!-- <div class="hr-line-dashed"></div> -->

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><font color="blue">Jenis Cuti</font></label>
                        <div class="col-sm-8"><p>: <?php echo $detail->KETERANGAN ?></p></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><font color="blue">Lokasi Cuti</font></label>
                        <div class="col-sm-8">
                            <select class="chosen-jencuti" name="id_lokasi_ubah" id="id_lokasi_ubah" data-placeholder="Pilih Lokasi Cuti..." >
                                <option value=""></option>
                                <!-- <option value="11">11</option> -->
                                <?php echo $lokasi_cuti ?>
                              </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><font color="blue">Tahap proses</font></label>
                        <div class="col-sm-8"><p>: <span class="label label-warning"><?php echo $detail->TAHAP ?></span></p></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Alasan Cuti</label>
                        <div class="col-sm-8">
                            <input type="text" id="alasan_cuti_ubah" name="alasan_cuti_ubah" placeholder="Alasan Cuti" value="<?php echo $detail->ALSN_CUTI ?>" class="form-control">
                        </div>
                    </div>

                    <legend id="lgn_lama"><h4>Lamanya cuti</h4></legend>
                    <div>
                        <div class="col-sm-6">
                            <div class="form-group" id="data_1">
                                <label class="col-sm-4 control-label"><font color="blue">Tgl. Mulai</font></label>
                                <div class="input-group col-sm-7 date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="tmt_ubah"  name="tmt_ubah" placeholder="Tgl. Mulai" class="form-control" value="<?php echo $detail->TMT ?>" onchange="cek_tanggal_ubah(this)" readonly="">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group"  id="data_2">
                              <label class="col-sm-4 control-label">Tgl. Akhir</label>
                              <div class="input-group col-sm-7 date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="tgakhir_ubah" name="tgakhir_ubah" placeholder="Tgl. Akhir" value="<?php echo $detail->TGAKHIR ?>" class="form-control" onchange="cek_tanggal_ubah(this)" readonly="">
                              </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="col-sm-6">
                            <div class="form-group">
                              <label class="col-sm-4 control-label">Tahun N-2</label>
                              <div class="input-group col-sm-7">
                                    <input type="text" id="tahun_n_2_ubah" name="tahun_n_2_ubah" placeholder="Tahun N-2" class="form-control" value="<?php echo $detail->CUTI_N_2 ?>" readonly="">
                                    <!-- <span class="text-danger">(Hari)</span> -->
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-sm-4 control-label">Tahun N-1</label>
                              <div class="input-group col-sm-7">
                                    <input type="text" id="tahun_n_1_ubah" name="tahun_n_1_ubah" placeholder="Tahun N-1" class="form-control" value="<?php echo $detail->CUTI_N_1 ?>" readonly="">
                              </div>
                            </div>
                            
                        </div>
                    </div>

                    <div>
                        <div class="col-sm-6">
                            <div class="form-group">
                              <label class="col-sm-4 control-label">Tahun N</label>
                              <div class="input-group col-sm-7">
                                    <input type="text" id="tahun_n_ubah" name="tahun_n_ubah" placeholder="Tahun N" class="form-control" value="<?php echo $detail->CUTI_N ?>" readonly="">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-sm-4 control-label">Total Cuti</label>
                              <div class="input-group col-sm-7">
                                    <input type="text" id="total_cuti_ubah" name="total_cuti_ubah" placeholder="Total Cuti" class="form-control" value="<?php echo $detail->TOTAL_CUTI ?>" readonly="">
                              </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="col-md-6">

                    <legend id="lgn_kontak"><h4>Kontak & alamat selama manjalankan cuti</h4></legend>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Telepon</label>
                      <div class="input-group col-sm-7">
                            <input type="text" id="telp_cuti_ubah" name="telp_cuti_ubah" placeholder="Telepon" value="<?php echo $detail->TELP_CUTI ?>" class="form-control">
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="col-sm-4 control-label">Alamat</label>
                      <div class="input-group col-sm-7">
                            <textarea class="form-control" rows="5" id="almt_cuti_ubah" name="almt_cuti_ubah" placeholder="Alamat" ><?php echo $detail->ALMT_CUTI ?></textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-4 control-label">Keterangan</label>
                      <div class="input-group col-sm-7">
                            <textarea class="form-control" rows="2" id="ket_ubah" name="ket_ubah" placeholder="Keterangan" ></textarea>
                      </div>
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
           
    	
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary" id="btn_save_ubah">Ubah</button>
    </div>
</form>
<!-- <script src="<?php echo base_url() ?>assets/inspinia/js/jquery-2.1.1.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/chosen/chosen.jquery.js"></script> -->
<script type="text/javascript">
    $(document).ready(function(){
       // tabel_cuti();

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

        var config = {
          // '.chosen-jencuti'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "100%"},
          // '.chosen-pejtt'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "300px"},
          // '.chosen-jensk'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "300px"}

          '.chosen-jencuti'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan',width: "100%"}
        }
        for (var selector in config) {
          $(selector).chosen(config[selector]);
        }
    });

    function cek_tanggal_ubah(){
        // alert('ddd')
        var id_hist = $('#id_hist_ubah').val();
        var tmt = $('#tmt_ubah').val();
        var tgakhir = $('#tgakhir_ubah').val();
        var jencuti = $('#jencuti_ubah').val();
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
                    document.getElementById("btn_save_ubah").disabled = true;
                    swal({type:"warning",title:"Gagal", text:"Tanggal mulai tidak boleh lebih kecil atau sama dengan dari tanggal akhir"});
                }else{
                    cek_jml_cuti_ubah(id_hist,tmt,tgakhir,jencuti);
                }
            }
        }

        
    }

    function cek_jml_cuti_ubah(id_hist,tmt,tgakhir,jencuti){
        $.ajax({
                url : "<?php echo site_url('index.php/cuti/cek_jml_cuti_ubah')?>",
                type: "POST",
                data: {id_hist:id_hist,tmt:tmt,tgakhir:tgakhir,jencuti:jencuti},
                dataType: "JSON",
                beforeSend: function() {
                },
                success: function(data)
                {
                   
                   if(data.respone == 'SUKSES'){
                        $('#tahun_n_ubah').val(data.tahun_n); 
                        $('#tahun_n_1_ubah').val(data.tahun_n_1); 
                        $('#tahun_n_2_ubah').val(data.tahun_n_2); 
                        $('#total_cuti_ubah').val(data.total_cuti);  
                        document.getElementById("btn_save_ubah").disabled = false;               

                    }else{
                        // $('#modal_libur_update').modal('hide'); 
                        $('#tahun_n_ubah').val(''); 
                        $('#tahun_n_1_ubah').val(''); 
                        $('#tahun_n_2_ubah').val(''); 
                        $('#total_cuti_ubah').val('');
                        document.getElementById("btn_save_ubah").disabled = true;
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

    function save_ubah(){
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
                save_next_ubah();
              } else {
                    swal("BATAL", "Proses dibatalkan", "error");
              }
            });
        }

        function save_next_ubah(){
            var jencuti = $('#jencuti_ubah').val();
            if(jencuti == 1){
                save_ct_tahunan_ubah(jencuti);
            }
        }

        function save_ct_tahunan_ubah(jencuti){
            var id_hist = $('#id_hist_ubah').val();
            var id_lokasi = $('#id_lokasi_ubah').val();
            var alasan_cuti = $('#alasan_cuti_ubah').val();
            var tmt = $('#tmt_ubah').val();
            var tgakhir = $('#tgakhir_ubah').val();
            var tahun_n_2 = $('#tahun_n_2_ubah').val();
            var tahun_n = $('#tahun_n_ubah').val();
            var tahun_n_1 = $('#tahun_n_1_ubah').val();
            var total_cuti = $('#total_cuti_ubah').val();
            var telp_cuti = $('#telp_cuti_ubah').val();
            var almt_cuti = $('#almt_cuti_ubah').val();
            var ket = $('#ket_ubah').val();

            // alert(id_lokasi);
            

            $.ajax({
                    url : "<?php echo site_url('index.php/cuti/save_ct_tahunan_ubah')?>",
                    type: "POST",
                    data: {id_hist:id_hist,tmt:tmt,tgakhir:tgakhir,jencuti:jencuti,id_lokasi:id_lokasi,alasan_cuti:alasan_cuti,tahun_n_2:tahun_n_2,tahun_n:tahun_n,tahun_n_1:tahun_n_1,total_cuti:total_cuti,telp_cuti:telp_cuti,almt_cuti:almt_cuti,ket:ket},
                    dataType: "JSON",
                    beforeSend: function() {
                        if(jencuti == ""){
                            swal({type:"warning",title:"GAGAL", text:"Jenis cuti belum dipilih"})
                            return false;
                        }else{
                            // $("#errUsergruble").html();                    
                        }  

                        if(alasan_cuti_ubah == ""){
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
                            $('#myModal').modal('hide');
                            // tabel_cuti(); 
                            swal({type:"success",title:"BERHASIL", text:data.pesan});
                            location.reload(); 
                                     

                        }else{
                            
                            swal({type:"warning",title:"GAGAL", text:data.pesan});
                        }                       
                       
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
                    },
                    complete: function() {   
                        tabel_cuti();                          

                    }
                });
        }
</script>