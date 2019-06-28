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
    <script src="<?php echo base_url(); ?>assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugins/dataTables/jquery.dataTables.js"></script>

    <?php 
        $buat_penilaian = true;
        $is_has_nilai = false;        
        $is_input_keberatan = false;
        $is_input_keberatan_atasan_penilai = false;

        $is_waiting_keberatan_result = false;
        $is_has_not_nilai = true;
        $integritas = 0;
        $pelayanan = 0;
        $komitmen = 0;
        $disiplin = 0;
        $kerjasama = 0;
        $kepemimpinan = 0;        
        if (isset($nilai->penilaian_approvement)) { 
            $buat_penilaian = ($nilai->penilaian_approvement == PENILAIAN_DIBUAT);
            $is_input_keberatan = ($nilai->penilaian_approvement == PENILAIAN_DIKIRIM) && ($nrk==$nilai->nrk);
            $is_input_keberatan_atasan_penilai =  ($nilai->penilaian_approvement == PENILAIAN_KEBERATAN) && ($nrk==$nilai->nrk_atasan_pejabat);

            $is_waiting_keberatan_result = ($nilai->penilaian_approvement == PENILAIAN_KEBERATAN);
            $is_has_nilai = ($nilai->penilaian_approvement ==  PENILAIAN_DIKIRIM);
            $is_has_not_nilai = ($nilai->penilaian_approvement <= PENILAIAN_DIKIRIM);
            //$is_input_keputusan = ($nilai->penilaian_approvement == PENILAIAN_KEBERATAN) && ($nrk==$nilai->nrk_atasan_pejabat);
            $integritas = $nilai->integritas;
            $pelayanan = $nilai->pelayanan;
            $komitmen = $nilai->komitmen;
            $disiplin = $nilai->disiplin;
            $kerjasama = $nilai->kerjasama;
            $kepemimpinan = $nilai->kepemimpinan;     
        }    
    ?>


    <script type="text/javascript">      
        var pelayanan = <?php echo $pelayanan; ?>;        
        var integritas = <?php echo $integritas; ?>;
        var komitmen = <?php echo $komitmen; ?>;
        var disiplin = <?php echo $disiplin; ?>;
        var kerjasama = <?php echo $kerjasama; ?>;
        var kepemimpinan = <?php echo $kepemimpinan; ?>;
        var val_calc_perilaku = 40;
        var skp_jumlah = 0;
        $(document).ready(function() {              
            $(".btn-save").click(function(){         
            });            
            var table = $('#listnilaibawahan').DataTable({
                 "processing": true,
                "serverSide": true,
                "ajax": "<?php echo base_url()?>index.php/skp/ajax_list_listnilaibawahan"
            });

            var tablelistnilai = $('#listnilai').DataTable({
                 "processing": true,
                "serverSide": true,
                "ajax": "<?php echo base_url()?>index.php/skp/ajax_list_hasilnilai"
            });

            var tablelistkeputusanatasanpejabat = $('#list-atasan-pejabat-penilai').DataTable({
                 "processing": true,
                "serverSide": true,
                "ajax": "<?php echo base_url()?>index.php/skp/ajax_list_nilai_atasan_penilai"
            });

            onReloadCalculate();
        });

        $('#pelayanan').keyup(function () {
            onPraCalculate($(this).val(), "pelayanan");
        });

        $('#integritas').keyup(function () {
            onPraCalculate($(this).val(), "integritas");
        });

        $('#komitmen').keyup(function () {
            onPraCalculate($(this).val(), "komitmen");
        });

        $('#disiplin').keyup(function () {
            onPraCalculate($(this).val(), "disiplin");
        });

        $('#kerjasama').keyup(function () {
            onPraCalculate($(this).val(), "kerjasama");
        });

        $('#kepemimpinan').keyup(function () {
            onPraCalculate($(this).val(), "kepemimpinan");
        });

        function onReloadCalculate(){
            <?php if ($buat_penilaian) { ?>
                pelayanan =  $("#komitmen").val();
                integritas =  $("#integritas").val();
                komitmen =  $("#komitmen").val();
                disiplin =  $("#disiplin").val();
                kerjasama =  $("#kerjasama").val();
                kepemimpinan =  $("#kepemimpinan").val();
                skp_jumlah =   $("#kepemimpinan").val();
            <?php } ?>
            onCalculate();
        }

        function onPraCalculate(val, type){                        
            if (type == "pelayanan"){
                pelayanan = val;
            }else if (type == "integritas"){
                integritas = val;
            }else if (type == "komitmen"){
                komitmen = val;
            }else if (type == "disiplin"){
                disiplin = val;
            }else if (type == "kerjasama"){
                kerjasama = val;
            }else if (type == "kepemimpinan"){
                kepemimpinan = val;
            }
            onCalculate();
        }

        function onCalculate(){
            showingKetNilai(pelayanan, "pelayanan");
            showingKetNilai(integritas, "integritas");
            showingKetNilai(disiplin, "disiplin");
            showingKetNilai(komitmen, "komitmen");
            showingKetNilai(kerjasama, "kerjasama");            
            showingKetNilai(kepemimpinan, "kepemimpinan");            
            var jumlah = parseInt(pelayanan) + parseInt(integritas) + parseInt(disiplin) + parseInt(komitmen) + parseInt(kerjasama) + parseInt(kepemimpinan);
            
            var rata = 0;
            if (kepemimpinan == 0){
                rata = jumlah/5;
            }else if (kepemimpinan > 0){
                rata = jumlah/6;
            }
            var calc_perilaku = (rata*val_calc_perilaku)/100;
            var skp_jumlah = $("#skp-jumlah").text();
            var total = parseFloat(calc_perilaku) + parseFloat(skp_jumlah );
            $("#span-jumlah").text(jumlah);
            $("#span-rata").text(rata.toFixed(2));
            $("#span-perilaku").text(rata.toFixed(2));   
            $("#span-nilai-perilaku").text((calc_perilaku).toFixed(2));            
            $("#span-nilai-total-perilaku").text((total).toFixed(2));
            showingKetNilai(total, 'keterangan-total-perilaku');            
            
            
            console.log(pelayanan + ", " + integritas + ", " + disiplin + ", " + kerjasama + ", " + kepemimpinan);
        }

        function showingKetNilai(val, type){
            if (val==""){
                $("#" + type).val("0"); 
                val = 0;
                if (type=="pelayanan"){                    
                    pelayanan = 0;
                }else if (type=="komitmen"){                    
                    komitmen = 0;
                }else if (type=="disiplin"){                    
                    disiplin = 0;
                }else if (type=="kerjasama"){                    
                    kerjasama = 0;
                }
            }
            if (val <= 50){
                $("#span-" + type).text("(Buruk)");              
            }else if (val <= 60){
                $("#span-" + type).text("(Sedang)");                
            }else if (val <= 75){
                $("#span-" + type).text("(Cukup)");                
            }else if (val <= 90){
                $("#span-" + type).text("(Baik)");                
            }else {
                $("#span-" + type).text("(Sangat Baik)");                
            }
        }

        function onKirim(type){              
            onKirimPenilaian(type);                        
        }

        function onKirimPenilaian(type){
            if (!confirm('Are you sure?')){
                return;
            }
            var keberatan = $("#keberatan").val();
            $.ajax({
                url:  '<?php echo base_url() ?>index.php/skp/kirim_penilaian',
                type: "POST",
                data: {skp_id: '<?php echo isset($skp_id) ? $skp_id : "" ?>', type: type, keterangan:keberatan},
                dataType: 'html',
                success: function(msg) {                                     
                    var json = JSON.parse(msg);
                    if (json.response=="SUKSES"){
                        alert("Berhasil dikirim");
                        onBack();
                    }
                }
            }); 
        }

      
        function onSave(type){
            if (!confirm('Are you sure?')){                
                return;
            }       
            var pelayanan = $("#pelayanan").val();
            var integritas = $("#integritas").val();
            var komitmen = $("#komitmen").val();
            var disiplin = $("#disiplin").val();
            var kerjasama = $("#kerjasama").val();
            var kepemimpinan = $("#kepemimpinan").val();
            var data = {pelayanan: pelayanan, integritas:integritas, komitmen:komitmen, disiplin:disiplin, kerjasama:kerjasama, kepemimpinan: kepemimpinan};
            $.ajax({
                url:  '<?php echo base_url() ?>index.php/skp/simpan_penilaian',
                type: "POST",
                data: {skp_id: '<?php echo isset($skp_id) ? $skp_id : "" ?>', data: data},
                dataType: 'html',
                success: function(msg) {                                            
                    var json = JSON.parse(msg);                        
                    if (json.response=="SUKSES"){                        
                        alert("Berhasil diupdate");                                                    
                    }
                }
            });             
        }

        function onDone(type){
            if (!confirm('Are you sure?')){                
                return;
            }       
            var pelayanan = $("#pelayanan").val();
            var integritas = $("#integritas").val();
            var komitmen = $("#komitmen").val();
            var disiplin = $("#disiplin").val();
            var kerjasama = $("#kerjasama").val();
            var kepemimpinan = $("#kepemimpinan").val();
            var data = {pelayanan: pelayanan, integritas:integritas, komitmen:komitmen, disiplin:disiplin, kerjasama:kerjasama, kepemimpinan: kepemimpinan};
            var keberatan = $("#keberatan").val();
            $.ajax({
                url:  '<?php echo base_url() ?>index.php/skp/kirim_penilaian',
                type: "POST",
                data: {skp_id: '<?php echo isset($skp_id) ? $skp_id : "" ?>', type: type, data: data, keterangan:keberatan},
                dataType: 'html',
                success: function(msg) {                                            
                    var json = JSON.parse(msg);                        
                    if (json.response=="SUKSES"){                        
                        alert("Berhasil");   
                        onBack();                                                 
                    }
                }
            });             
        }

        function onKirimKeputusan(){
            if (!confirm('Are you sure?')){                
                return;
            }       
            var pelayanan = $("#pelayanan").val();
            var integritas = $("#integritas").val();
            var komitmen = $("#komitmen").val();
            var disiplin = $("#disiplin").val();
            var kerjasama = $("#kerjasama").val();
            var kepemimpinan = $("#kepemimpinan").val();
            var data = {pelayanan: pelayanan, integritas:integritas, komitmen:komitmen, disiplin:disiplin, kerjasama:kerjasama, kepemimpinan: kepemimpinan};
            $.ajax({
                url:  '<?php echo base_url() ?>index.php/skp/simpan_keputusan',
                type: "POST",
                data: {skp_id: '<?php echo isset($skp_id) ? $skp_id : "" ?>', data: data},
                dataType: 'html',
                success: function(msg) {                                            
                    var json = JSON.parse(msg);                        
                    if (json.response=="SUKSES"){                        
                        alert("Berhasil diupdate");                                                    
                    }
                }
            }); 
        }

          function onKirimKeberatan(){
            if (!confirm('Are you sure?')){
                return;
            }
            var keberatan = $("#keberatan").val();
            var data = {keberatan_bawahan: keberatan};
            $.ajax({
                url:  '<?php echo base_url() ?>index.php/skp/kirim_penilaian_keberatan',
                type: "POST",
                data: {skp_id: '<?php echo isset($skp_id) ? $skp_id : "" ?>', data: data},
                dataType: 'html',
                success: function(msg) {                                            
                    var json = JSON.parse(msg);                        
                    if (json.response=="SUKSES"){                        
                        alert("Berhasil dikirim");                            
                        onBack();
                    }
                }
            }); 
        }

        
        function onPenilaian(skp_id){            
            $.ajax({
                url: '<?php echo base_url() ?>index.php/skp/penilaian?skp_id=' + skp_id,
                dataType: 'html',
                success: function(data) {                    
                    $('.loadpage').html(data);
                }
            });    

        }

        function onFeedback(skp_id){            
            $.ajax({
                url: '<?php echo base_url() ?>index.php/skp/penilaian_feedback?skp_id=' + skp_id,
                dataType: 'html',
                success: function(data) {                    
                    $('.loadpage').html(data);
                }
            });    

        }

        function onBack(){
            $.ajax({
                url: '<?php echo base_url() ?>index.php/skp/list_penilaian?back=true',
                dataType: 'html',
                success: function(data) {                    
                    $('.loadpage').html(data);
                }
            });    
        }

        
        function errorElementClear(){            
           var el = $(".error").remove();
        }   

        function errorElement(element, desc){ 
            var el = $(".l"+element);            
            $("<div class='error'>"+ element + " " + desc +"</div>").insertBefore($(el));
        }
        
      
    </script>