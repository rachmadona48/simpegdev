    <style type="text/css">
    
        #small-chat {position: fixed;bottom: 20px;right: 0px;z-index: 100;}
        #small-chat .badge {position: absolute;top: -3px;right: -4px;}
        .open-small-chat {height: 38px;width: 38px;display: block;background: #1ab394;padding: 9px 8px;text-align: center;color: #fff;border-radius: 50%;}
        .open-small-chat:hover {color: white;background: #1ab394;}
        .small-chat-box {display: none;position: fixed;bottom: 20px;right: 75px;background: #fff;border: 1px solid #e7eaec;width: 230px;height: 320px;border-radius: 4px;}
        .small-chat-box.ng-small-chat {display: block;}
        .body-small .small-chat-box {bottom: 70px;right: 20px;}
        .small-chat-box.active {display: block;}
        .small-chat-box .heading {background: #2f4050;padding: 8px 15px;font-weight: bold;color: #fff;}
        .small-chat-box .chat-date {opacity: 0.6;font-size: 10px;font-weight: normal;}
        .small-chat-box .content {padding: 15px 15px;}
        .small-chat-box .content .author-name {font-weight: bold;margin-bottom: 3px;font-size: 11px;}
        .small-chat-box .content > div {padding-bottom: 20px;}
        .small-chat-box .content .chat-message {padding: 5px 10px;border-radius: 6px;font-size: 11px;line-height: 14px;max-width: 80%;background: #f3f3f4;margin-bottom: 10px;}
        .small-chat-box .content .chat-message.active {background: #1ab394;color: #fff;}
        .small-chat-box .content .left {text-align: left;clear: both;}
        .small-chat-box .content .left .chat-message {float: left;}
        .small-chat-box .content .right {text-align: right;clear: both;}
        .small-chat-box .content .right .chat-message {float: right;}
        .small-chat-box .form-chat {padding: 10px 10px;}

        .panel, .ibox{
          text-decoration: none;
          outline: none;                
          border: none;
          border-radius: 5px;
          box-shadow: 2px 2px 3px 3px #999;  
        }

        .form-group #riwayat_list {          
          display: inline-block;          
          cursor: pointer;          
          text-decoration: none;
          outline: none;                
          border: none;
          border-radius: 5px;
          box-shadow: 2px 2px 3px 3px #999;
        }      

        .input-group-addon{
            background-color: #1ab394 !important;
            color: #fff !important;
        }

         #ibox_bkd .ibox-content{
            padding: 15px 20px 0px 20px !important;
        }
        .user-friends
        {
            height:130px !important; 
            display:block !important; 
            overflow-y:auto !important;
        }

        #profile-content
        {
            max-height:250px !important;
        }

        .form-group #riwayat_list:hover {background-color: rgba(0,0,0,0.08);}  

        /*.modal-lg{
            width: 1024px !important;
        }*/
                

        /*Tampilkan pencarian di tampilan phone*/
        @media screen and (min-width: 770px){
            div#forPhone{
                display: none;
            }

            .modal-lg{
                width: 1024px !important;
            }
        }        

    </style>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Identitas Pegawai</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Home</a>
            </li>            
            <li class="active">
                <strong>Riwayat</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content">
<?php if($user_group > 1){ ?>
    <div class="row" id="forPhone">
        <div class="col-md-12">
            <div id="ibox_bkd" class="ibox float-e-margins animated fadeInRightBig">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-4">
                            <form id="form_4bkd" method="POST" action="<?php echo site_url(); ?>/riwayat">
                              <div class="form-group">                        
                                <div class="input-group">                          
                                  <input type="text" class="form-control" id="nrkP" name="nrkP" value="<?php echo $nrk; ?>" data-mask="999999" placeholder="NRK" autocomplete="off">
                                  <div class="input-group-addon btn btn-primary" style="cursor:pointer;" onclick="getProfile('4bkd');">Go</div>                          
                                </div>
                                <small><span class="help-block m-b-none"><u><i>Masukkan NRK Pegawai yang akan ditampilkan (Cth : 123456).</i></u></span></small>
                              </div>                      
                            </form>
                        </div>                                        
                    </div>
                </div>
            </div>
        </div>
    </div>

   




<?php } ?>
<?php if(isset($infoUser->NRK)){ ?>
    <div class="row">   

        <?php 
            $cols = 12;
            if(isset($bawahan)){      
                if($bawahan != ""){    
                    $cols = 9;
                }else{
                    $cols = 12;
                }
            }else{
                $cols = 12;
            }
        ?>         
                
        <div class="col-md-<?php echo $cols; ?>">
            <div class="ibox float-e-margins animated fadeInDown">
                <div class="ibox-title">
                    <h5>Profile Detail</h5>
                </div>
                <div>
                 <div class="ibox-content profile-content" id="profile-content">
                        <div class="row">
                            <div class="col-sm-1">
                                <div class="text-center animated fadeInDown">
                                    <input type="hidden" id="self_nrk" name="self_nrk" value="<?php echo isset($infoUser->NRK) ? $infoUser->NRK : '';?>">
                                    <input type="hidden" id="self_nip" name="self_nip" value="<?php echo isset($infoUser->NIP18) ? $infoUser->NIP18 : ''; ?>">

                                    <?php 

                                        if(isset($infoUser->NRK)){
                                            $linkImg = "assets/img/photo/".$infoUser->NRK.".jpg";

                                            $nrk = $infoUser->NRK;    
                                            $nip18 = $infoUser->NIP18;
                                            $pathir = $infoUser->PATHIR;
                                            $talhir = $infoUser->TALHIR;
                                            $nama = $infoUser->NAMA_ABS;
                                            $titel = $infoUser->TITEL;
                                            $titeldepan = $infoUser->TITELDEPAN;
                                            $stapeg = $infoUser->STATUS_PEGAWAI;
                                            $najabl = $infoUser->NAJABL;
                                            $nalokl = $infoUser->NALOKL;
                                            $kd = $infoUser->KD;
                                            $muang = $infoUser->MUANG;
                                            $tmtstapeg= $infoUser->TMT_STAPEG;

                                            if(isset($infoUserJabatan))
                                            {
                                                $esln = $infoUserJabatan->NESELON2;
												
                                                if($esln == '00' || $esln==' ')
                                                {
                                                    $eselon="NON ESELON";
                                                }
                                                else
                                                {
                                                    $eselon = "ESELON ".$esln;
                                                }
                                            }
                                            else
                                            {
                                                $eselon="NON ESELON";
                                            }
                                            

                                            


                                            if(file_exists($linkImg)){
                                            $img = "assets/img/photo/".$infoUser->NRK.".jpg";                                    
                                            }else{
                                                $img = "assets/img/photo/profile_small.jpg";
                                            }

                                        }else{
                                            $linkImg = "assets/img/photo/profile_small.jpg";    
                                            $nrk = "";    
                                            $nip18 = "";
                                            $pathir = "";
                                            $talhir = "";                                    
                                            $nama = "";
                                            $titel = "";
                                            $titeldepan = "";
                                            $stapeg = "";
                                            $najabl = "";
                                            $nalokl = "";
                                            $kd="";
                                            $eselon="";
                                            $img = "assets/img/photo/profile_small.jpg";                                    
                                        }

                                        
                                            $nohp = isset($infoUser3->NOHP) ? $infoUser3->NOHP : "";
                                            $notelp = isset($infoUser3->NOTELP) ? $infoUser3->NOTELP : "";
                                            $alamat = isset($infoUser3->ALAMAT) ? $infoUser3->ALAMAT : "";
                                            $rt = isset($infoUser3->RT) ? $infoUser3->RT : "";
                                            $rw = isset($infoUser3->RW) ? $infoUser3->RW : "";
                                            $nawil = isset($infoUser3->NAWIL) ? $infoUser3->NAWIL : "";
                                            $nacam = isset($infoUser3->NACAM) ? $infoUser3->NACAM : "";
                                            $nakel = isset($infoUser3->NAKEL) ? $infoUser3->NAKEL : "";
                                            $prop = isset($infoUser3->PROPINSI) ? $infoUser3->PROPINSI : "";
                                            $email = isset($infoUser3->EMAIL) ? $infoUser3->EMAIL : "";
                                        
                                           //var_dump($img);                             
                                        
                                    ?>   
                                            <img alt="image" class="img-circle m-t-xs img-responsive" src="<?php echo base_url().$img;  ?>">
                                    
                                </div>
                            </div>


                            <div class="col-sm-6">                            
                                <p><b><?php echo "<strong><a class=\"text-navy\">$titeldepan $nama$titel </a></strong>"; ?></b></p>
                                <address style="font-size:11px;">
                                <p><i class="fa fa-credit-card"></i>&nbsp; <?php echo "<strong><a class=\"text-success\"> $nrk - $nip18 </a></strong>"; ?></p>
                                <p><i class="fa fa-birthday-cake"></i>&nbsp; <?php echo "<strong><a class=\"text-danger\">$pathir, $talhir </a></strong>"; ?></p>
                                <p><i class="fa fa-ioxhost"></i>&nbsp; <?php echo "<strong><a class=\"text-primary\">$stapeg / $kd / $eselon </a></strong>"; ?></p>
                                 <p><i class="fa fa-calendar"></i>&nbsp; <?php echo "<strong><a class=\"text-navy\">TMT(CPNS) ".$muang." / (PNS) ".$tmtstapeg."</a></strong>"; ?></p>
                                 <p><i class="fa fa-line-chart"></i>&nbsp; <?php echo "<strong><a class=\"text-warning\">$najabl</a></strong>"; ?></p>
                                 <p><i class="fa fa-map-marker"></i>&nbsp; <?php echo "<strong><a class=\"text-info\">$nalokl</a></strong>"; ?></p>

                                <p>&nbsp;</p>
                                </address>
                            </div>

                            <div class="col-sm-5">
                                 <address style="font-size:10px;">
                                
                                <p><i class="fa fa-phone"></i>&nbsp; <?php echo "<strong><a class=\"text-success\">$notelp</a></strong>"; ?></p>
                                <p><i class="fa fa-mobile"></i>&nbsp; <?php echo "<strong><a class=\"text-danger\">$nohp</a></strong>"; ?></p>
                                <p><i class="fa fa-at"></i>&nbsp; <?php echo "<strong><a class=\"text-primary\">$email </a></strong>"; ?></p>
                                <p><i class="fa fa-home"></i>&nbsp; <?php echo "<strong><a class=\"text-info\">".$alamat." RT-".$rt." RW-".$rw."<br/> &nbsp;&nbsp;&nbsp;&nbsp; KECAMATAN ".$nacam."<br/> &nbsp;&nbsp;&nbsp;&nbsp; KELURAHAN ".$nakel."<br/> &nbsp;&nbsp;&nbsp; ".$nawil." - ".$prop."</a></strong>"; ?></p>
                                <p>&nbsp;</p>
                                </address>   
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        
            <?php 
                if(isset($bawahan)){ 
                    if($bawahan != ""){ 
            ?>
            <div class="col-md-3">
                <div class="ibox float-e-margins animated fadeInUp">

                    <div class="ibox-title">
                        <h3>Struktur Pegawai</h3>
                        <p class="small">
                            Bersama KITA BISA!!!
                        </p>
                        <div class="form-group" id="data_4">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="monthyear" onchange="return setMonthYear();" placeholder="Bulan Tahun" class="form-control" value="<?php echo $thbl; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">                        
                        <div class="user-friends tooltip-demo">
                            <div class="" id="list_bawahan">
                                <?php echo isset($bawahan) ? $bawahan : ""; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                    } else {
                        echo '<input type="hidden" id="monthyear" placeholder="Bulan Tahun" class="form-control" value="'.$thbl.'">';
                    }
                }
            ?>
        
        <div class="col-md-12">
            <!-- START HISTORY -->
            <div class="ibox float-e-margins animated fadeInRight">
                <div class="ibox-title">
                    <div class="row">
                        <div style="margin-top:5px;margin-left:2px">
                            <div class="col-md-5 form-group">                            
                                <select name="riwayat_list" id="riwayat_list" data-placeholder="--- Pilih Riwayat ---" class="form-control chosen-select" tabindex="2">
                                    <option value=""></option>
                                    <option value=""></option>
                                    <?php echo $menu_select; ?>                                                              
                                </select>       
                                <span class="help-block m-b-none"><u><i>Pilih jenis riwayat yang akan ditampilkan.</i></u></span>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="ibox-content">
                    <input type="hidden" id="checkproses" value="1">
                    <div  id="content_riwayat" class="">
                        
                    </div>
                </div>
            </div>
            <!-- END HISTORY -->
        </div>        
    </div>    

<?php } ?>

	<!-- <div id="container">	
		<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php //echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
	</div> -->
</div>

<div id="small-chat" style="display:<?php echo $showBack; ?>">
    <form style="display:none" method="POST" id="form_<?php echo $nrkatasan; ?>">
        <input type="hidden" name="nrk" id="nrk_<?php echo $nrkatasan; ?>" value="<?php echo $nrkatasan; ?>">
        <input type="hidden" class="thblBack" name="thbl" id="thbl_<?php echo $nrkatasan; ?>" value="<?php echo $thbl; ?>">
    </form>
    <a class="open-small-chat" title="Kembali" onClick="getProfile('<?php echo $nrkatasan; ?>');">
        <i class="fa fa-step-backward"></i>
    </a>
    <?php if(isset($showBackPokok)){ ?>
        <?php if($showBackPokok != "none"){ ?>
            <form style="display:none" method="POST" action="<?php echo base_url(); ?>index.php/hist/datapokok" id="form_<?php echo $nrk; ?>">
                <input type="hidden" name="nrk" id="nrk_<?php echo $nrk; ?>" value="<?php echo $nrk; ?>">
                <input type="hidden" name="tglpilih" id="tglpilih_<?php echo $nrk; ?>" value="<?php echo $thbl; ?>">
                <input type="hidden" name="spmu" id="spmu_<?php echo $nrk; ?>" value="<?php echo $spmu; ?>">
            </form>
            <a class="open-small-chat" title="Kembali" onClick="getProfile('<?php echo $nrk; ?>');">
                <i class="fa fa-fast-backward"></i>
            </a>
        <?php } ?>
    <?php } ?>
</div>


<!-- Start Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div id="widthForm" class="modal-dialog modal-lg" role="document">
    <div class="modal-content animated fadeInUp" id="modal_content">
        
    </div>
  </div>
</div>
<!-- End Modal -->


        <!-- jqueryForm -->
        <script src="<?php echo base_url(); ?>assets/js/jquery.form.js"></script>

        <!-- Data picker -->
       <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js"></script>
         


        <!-- Data Tables -->
        <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/dataTables.responsive.js"></script>
        <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/dataTables.tableTools.min.js"></script>
        <!-- Data Tables -->

        <!-- Boostrap Validator -->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/inspinia/boostrapvalidator/js/bootstrapValidator.js"></script>
        
        <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/chosen/chosen.jquery.js"></script>

        <!-- Custom and plugin javascript -->
        <script src="<?php echo base_url(); ?>assets/inspinia/js/inspinia.js"></script>
        <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/pace/pace.min.js"></script>
        <!-- Custom and plugin javascript -->   

        <!-- Sweet alert -->
        <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/sweetalert/sweetalert.min.js"></script>

        <!-- Input Mask-->
        <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/jasny/jasny-bootstrap.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                $('#data_1 .input-group.date').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true,
                    format: "dd-mm-yyyy"
                }); 
                
            });
        </script>

        <script type="text/javascript">

            $('.dataTables-example').dataTable({
                responsive: true,                
                // "dom": 'T<"clear">lfrtip',
                // "tableTools": {
                //     "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
                // }
            });

            $(document).ready(function(){
                $( "#riwayat_list" ).change(function(event) {
                    event.preventDefault();

                    $.ajax({
                        url: "riwayat/generateRiwayat",
                        type: "post",
                        data: {nrk:$("#nrkP").val(), id_riwayat:$("#riwayat_list").val()},
                        dataType: 'json',
                        beforeSend: function() {
                            $('#_content_riwayat').removeAttr('class').attr('class', '');
                            var animation = 'fadeOutDown';
                            $('#_content_riwayat').addClass('animated');
                            $('#_content_riwayat').addClass(animation);
                            // return false;
                            $('#content_riwayat').html('<div><img src="<?php echo base_url() ?>assets/inspinia/img/loading_bar.gif"></div>');
                            $('#checkproses').val('0');
                        },
                        success: function(data) {                                                                     
                            if(data.response == 'SUKSES'){
                                 $("#content_riwayat").html(data.result);
                                 $('#checkproses').val('1');
                            }else{
                                 $("#content_riwayat").html('');
                                 $('#checkproses').val('0');
                            }
                        },
                        error: function(xhr) {                              
                            if($('#checkproses').val() == 0){
                                $("#content_riwayat").html("<small class='text-danger'>Silahkan Coba Kembali...</small>");
                            }
                        },
                        complete: function() {
                            $('.dataTables-example').dataTable({
                                // responsive: true,
                                "destroy" : true,
                                "scrollX": true
                            });

                            if($('#checkproses').val() == 0){
                                $("#content_riwayat").html("<small class='text-danger'>Silahkan Coba Kembali...</small>");
                            }
                        }
                    });
                });
            });         


            $(document).ready(function(){
                var today = new Date();
                var dd    = today.getDate();
                var mm    = ("0" + (today.getMonth() + 1)).slice(-2); 
                var yyyy  = today.getFullYear(); 

                    $('#data_4 .input-group.date').datepicker({
                                changeyear: false,
                                minViewMode: 1,
                                keyboardNavigation: false,
                                forceParse: false,
                                autoclose: true,
                                todayHighlight: true,
                                // format: 'yyyy-mm-dd'
                                format: 'M yyyy'
                            });

                    $("#tglpilih").unbind('change');        

            });


            function getProfile(nrk){
                $("#thbl_"+nrk).val($("#monthyear").val());
                $("#form_"+nrk).submit();
            }

            function getForm(form,action,key1,key2,key3,key4){
                save_method = action;

                $.ajax({
                    url: "riwayat/generateForm",
                    type: "post",
                    data: {form:form,nrk:$('#nrkP').val(),action:action,key1:key1,key2:key2,key3:key3,key4:key4},
                    dataType: 'json',
                    beforeSend: function() {
                        $('#myModal').modal('toggle');
                        $("#modal_content").html('<div class="sk-spinner sk-spinner-three-bounce" style="width:110px;"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div></div>');
                    },
                    success: function(data) {                                                                     
                        if(data.response == 'SUKSES'){
                            $("#modal_content").html(data.result);

                            if(data.widthForm == 'one'){
                                $('#widthForm').removeAttr('class').attr('class', '');                                
                                $('#widthForm').addClass('modal-dialog');
                            }else{
                                $('#widthForm').removeAttr('class').attr('class', '');
                                $('#widthForm').addClass('modal-dialog');
                                $('#widthForm').addClass('modal-lg');                                
                            }

                        }else{
                            $("#modal_content").html('');
                        }
                    },
                    error: function(xhr) {                              
                        $('#myModal').modal('hide');  
                    },
                    complete: function() {
                                                
                    }
                });
            }

            function setMonthYear(){                
                
                $.ajax({
                    url: "riwayat/generateStrukturPegawai",
                    type: "post",
                    data: {nrk:$("#nrkP").val(), thbl:$("#monthyear").val()},
                    dataType: 'json',
                    beforeSend: function() {
                        $('#list_bawahan').removeAttr('class').attr('class', '');
                        var animation = 'fadeOutDown';
                        $('#list_bawahan').addClass('animated');
                        $('#list_bawahan').addClass(animation);
                        // return false;
                    },
                    success: function(data) {                                                                     
                        if(data.response == 'SUKSES'){                             
                             if(data.result == ""){
                                $("#list_bawahan").html("<small class='text-navy'>Bawahan Tidak Ditemukan</small>");
                             }else{
                                $("#list_bawahan").html(data.result);
                             }
                        }else{
                            $("#list_bawahan").html("<small class='text-danger'>Silahkan Coba Kembali...</small>");
                        }
                    },
                    error: function(xhr) {                              
                        $("#list_bawahan").html("<small class='text-danger'>Silahkan Coba Kembali...</small>");
                    },
                    complete: function() {
                        $('#list_bawahan').removeAttr('class').attr('class', '');
                        var animation = 'fadeInUp';
                        $('#list_bawahan').addClass('animated');
                        $('#list_bawahan').addClass(animation);
                    }
                });


            }

            function reload()
            {
                $.ajax({
                        url: "riwayat/generateRiwayat",
                        type: "post",
                        data: {nrk:$("#nrkP").val(), id_riwayat:$("#riwayat_list").val()},
                        dataType: 'json',
                        beforeSend: function() {
                            $('#_content_riwayat').removeAttr('class').attr('class', '');
                            var animation = 'fadeOutDown';
                            $('#_content_riwayat').addClass('animated');
                            $('#_content_riwayat').addClass(animation);
                            // return false;
                            $('#content_riwayat').html('<div><img src="<?php echo base_url() ?>assets/inspinia/img/loading_bar.gif"></div>');
                            $('#checkproses').val('0');
                        },
                        success: function(data) {                                                                     
                            if(data.response == 'SUKSES'){
                                 $("#content_riwayat").html(data.result);
                                 $('#checkproses').val('1');
                            }else{
                                 $("#content_riwayat").html('');
                                 $('#checkproses').val('0');
                            }
                        },
                        error: function(xhr) {                              
                            if($('#checkproses').val() == 0){
                                $("#content_riwayat").html("<small class='text-danger'>Silahkan Coba Kembali...</small>");
                            }
                        },
                        complete: function() {
                            $('.dataTables-example').dataTable({
                                // responsive: true,
                                "destroy" : true,
                                "scrollX": true
                            });

                            if($('#checkproses').val() == 0){
                                $("#content_riwayat").html("<small class='text-danger'>Silahkan Coba Kembali...</small>");
                            }
                        }
                    });
            }

            function confirmHapusData(dest,key1,key2,key3,key4){
                /*START SWEETALERT*/                
                    swal({
                        title: "Anda yakin hapus data ini?",                        
                        text: "Data tidak akan dapat dikembalikan setelah dihapus!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonColor: "#F8AC59",
                        cancelButtonText: "Tidak, batalkan!",
                        closeOnConfirm: false
                    }, function (isConfirm) {
                        if (isConfirm) {
                            rslt = hapusData(dest,key1,key2,key3,key4);                            
                        }                         
                    });               
                /*END SWEETALERT*/
            }

            function hapusData(dest,key1,key2,key3,key4){
                var result = 0;

                $.ajax({
                    url: '<?php echo base_url("index.php/riwayat/hapusHist"); ?>',
                    type: "post",
                    data: {destination:dest, action:'hapus',key1:key1,key2:key2,key3:key3,key4:key4},
                    dataType: 'json',
                    beforeSend: function() {
                        
                    },
                    success: function(data) {                                                                     
                        if(data.response == 'SUKSES'){                    
                            swal("Hapus!", "Data berhasil dihapus.", "success");    
                            reload();
                        }else{
                            swal("Gagal!", "Data gagal dihapus.", "error");                            
                        }
                    },
                    error: function(xhr) {                              
                        swal("Gagal!", "Data gagal dihapus.", "error");
                    },
                    complete: function() {
                                                
                    }
                });

                return result;
            }
            
            /*START CHOSEN*/
            var config = {
              '.chosen-select'           : {no_results_text:'Oops, Data Tidak Ditemukan'}              
            }
            for (var selector in config) {
              $(selector).chosen(config[selector]);
            }
            /*END CHOSEN*/

            function detail_cuti(id_hist,jencuti){
            // $('#modal_cuti').modal('show'); 
                $.ajax({
                        url : "<?php echo site_url('index.php/cuti/detail_cuti')?>",
                        type: "POST",
                        data: {id_hist:id_hist,jencuti:jencuti},
                        dataType: "JSON",
                        beforeSend: function() {
                            $('#myModal').modal('toggle');
                             $('body').css('overflow', 'scroll');
                            $("#modal_content_detail").html('<div class="sk-spinner sk-spinner-three-bounce" style="width:110px;"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div></div>');
                        },
                        success: function(data)
                        {
                           
                           if(data.response == 'SUKSES'){   
                                // alert(data.result);         
                                $("#modal_content_detail").html(data.result);
                                // $('input').attr('readonly', 'readonly');
                                if(data.widthForm == 'one'){
                                    $('#widthForm').removeAttr('class').attr('class', '');                                
                                    $('#widthForm').addClass('modal-dialog');
                                }else{
                                    $('#widthForm').removeAttr('class').attr('class', '');
                                    $('#widthForm').addClass('modal-dialog');
                                    $('#widthForm').addClass('modal-lg');                                
                                }
                            }else{
                                // swal({type:"warning",title:"GAGAL", text:data.pesan});
                                $("#modal_content_detail").html('');
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
        </script>

