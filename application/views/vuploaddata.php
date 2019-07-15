    <style type="text/css">           

        .panel, .ibox{
          text-decoration: none;
          outline: none;                
          border: none;
          border-radius: 5px;
          box-shadow: 2px 2px 3px 3px #999;  
        }

        .form-group #referensi_list {          
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

    </style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Upload Data Kolektif</h2>
        <ol class="breadcrumb">
            <li>
                <?php if($user_group == 4): ?>
                <a href="<?php echo site_url('report/laporan')?>">Home</a>
                <?php elseif($user_group == 2 || $user_group == 3 || $user_group >= 11): ?>
                <a href="<?php echo site_url('pegawai')?>">Home</a>
                <?php endif; ?>
            </li>            
            <li class="active">
                <strong>Upload</strong>
            </li>
        </ol>
         <small><i>(Menu untuk melakukan penginputan data secara langsung dari luar)</i></small>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content">

    <div class="row">            
        <div class="col-md-12">
            <!-- START REFERENSI -->
            <div class="ibox float-e-margins animated fadeInRight">
                <div class="ibox-title">
                    <div class="row">
                        <div style="margin-top:5px;margin-left:2px">
                            <div class="col-md-5 form-group">
                                <select name="referensi_list" id="referensi_list" data-placeholder="--- Pilih Tempat untuk melakukan upload ---" class="form-control chosen-select" tabindex="2">
                                    <option value="0">Pilih Form Inputan</option>
                                    <option value="1">Pangkat / Gaji</option>
                                    <option value="2">PNS </option>
                                    <option value="3">Pensiun </option>
                                    <option value="4">Jabatan Eselon </option>                                                                            
                                </select>       
                                <span class="help-block m-b-none"><u><i>Pilih jenis file yang akan diupload.</i></u></span>
                            </div>
                        </div>

                        
                    </div>  

                                      
                </div>
                <div class="ibox-content">
                    <hr/>

                    <!-- input pangkat kolektif -->
                    <div id="upangkatgaji" style="display: none">
                    <h3 class="font bold text-navy"> Aturan Penggunaan Input Data Pangkat dan Gaji Pokok</h3>
                        <ol>
                             <li>File yang mendukung adalah <b>Microsoft Excel 2007 ke atas</b></li>
                            <li>File Excel menggunakan <b>2 sheet</b>
                                    <ul>
                                        <li>
                                        <b>SHEET 1 : Riwayat Pangkat</b><br/>
                                        Status : <b>INSERT</b><br/>
                                        Total kolom = <b>13</b> (kolom M)<br/> 
                                        Kolom : <span style="color:#1ab394"><b>NRK, TMT, KOPANG, TTMASKER, BBMASKER, KOLOK, GAPOK,PEJTT, NOSK, TGSK, USER_ID, TERM, TG_UPD, KLOGAD, SPMU, TAHUN_REFGAJI, JENIS_SK, JENRUB</b></span>
                                        </li>

                                        <li>
                                        <b>SHEET 2 : Riwayat Gaji Pokok</b><br/>
                                        Status : <b>INSERT</b><br/>
                                        Total kolom = <b>15</b> (kolom O)<br/> 
                                        Kolom : <span style="color:#1ab394"><b>NRK, TMT, GAPOK, JENRUB, KOPANG, TTMASKER, BBMASKER, KOLOK, NOSK, TGSK, TTMASYAD, BBMASYAD, USER_ID, TERM, TG_UPD, KLOGAD, SPMU, TAHUN_REFGAJI, JENIS_SK</b></span>
                                        </li>
                                    </ul>

                            </li>
                            <li>Penginputan untuk jenis tanggal menggunakan format cell tipe  <b>Text</b> dengan format <b>DD/MM/YYYY</b></li>
                            <li>Penginputan data yang mempunyai nilai 0(nol) menggunakan appostrophy(') menjadi <b>'0</b></li>
                        </ol>
                        <h2 class="font-bold text-danger">FILE YANG DIUPLOAD HARUS SESUAI DENGAN ATURAN DI ATAS, <BR/>
                        KESALAHAN KARENA PERBEDAAN ISI FILE EXCEL BUKAN KESALAHAN SISTEM</h2>

                        <label>Upload File Pangkat/Gaji di bawah ini</label>
                        
                        <input type="hidden" id="checkproses" value="1">  
                        
                        <div class="row">
                            <form action='#' method='post' enctype='multipart/form-data' id='myForm2' onsubmit='return insertpanggaji();' > 
                                <input type='file' id='upload2' name='upload2'/>
                                <div class='sk-spinner sk-spinner-fading-circle' id='spinr' style='display:none; margin:0'>
                                            <div class='sk-circle1 sk-circle'></div>
                                            <div class='sk-circle2 sk-circle'></div>
                                            <div class='sk-circle3 sk-circle'></div>
                                            <div class='sk-circle4 sk-circle'></div>
                                            <div class='sk-circle5 sk-circle'></div>
                                            <div class='sk-circle6 sk-circle'></div>
                                            <div class='sk-circle7 sk-circle'></div>
                                            <div class='sk-circle8 sk-circle'></div>
                                            <div class='sk-circle9 sk-circle'></div>
                                            <div class='sk-circle10 sk-circle'></div>
                                            <div class='sk-circle11 sk-circle'></div>
                                            <div class='sk-circle12 sk-circle'></div>
                                        </div>
                                <input type='submit' value='Submit'/> 
                            </form>
                        </div>
                    </div>
                    <!-- end div upangkatgaji -->

                    <!-- input jabatan -->
                    <div id="ujabatan" style="display: none">
                        <h3 class="font bold text-navy"> Aturan Penggunaan Input PNS (SUMPAH PNS)</h3>
                        <ol>
                             <li>File yang mendukung adalah <b>Microsoft Excel 2007 ke atas</b></li>
                            <li>File Excel menggunakan <b>4 sheet</b>
                                    <ul>
                                        <li>
                                        <b>SHEET 1 : Pegawai 1</b><br/>
                                        Status : <b>UPDATE</b><br/>
                                        Total kolom = <b>14</b> (kolom N)<br/> 
                                        Kolom : <span style="color:#1ab394"><b>NRK, KLOGAD, NAMA, TITEL, STAPEG, TMTSTAPEG, USER_ID, TERM, TG_UPD, KOLOK, KOJAB, TITELDEPAN, KD, SPMU</b></span>
                                        </li>

                                        <li>
                                        <b>SHEET 2 : Riwayat Jabatan Struktural</b><br/>
                                        Status : <b>INSERT</b><br/>
                                        Total kolom = <b>22</b> (kolom V)<br/> 
                                        Kolom : <span style="color:#1ab394"><b>NRK, TMT, KOLOK, KOJAB, KDSORT, TGAKHIR, KOPANG, ESELON,PEJTT, NOSK, TGSK, KREDIT, STATUS, USER_ID, TERM, TG_UPD, CKOJABF, TMTPENSIUN, KLOGAD, SPMU, NESELON2, JENIS_SK</b></span>
                                        </li>

                                        <li>
                                        <b>SHEET 3 : Riwayat Pangkat</b><br/>
                                        Status : <b>INSERT</b><br/>
                                        Total kolom = <b>18</b> (kolom R)<br/> 
                                        Kolom : <span style="color:#1ab394"><b>NRK, TMT, KOPANG, TTMASKER, BBMASKER, KOLOK, GAPOK, PEJTT, NOSK, TGSK, USER_ID, TERM, TG_UPD, KLOGAD, SPMU, TAHUN_REFGAJI, JENIS_SK, JENRUB</b></span>
                                        </li>

                                     
                                        <li>
                                        <b>SHEET 4 : Riwayat Gaji Pokok</b><br/>
                                        Status : <b>INSERT</b><br/>
                                        Total kolom = <b>19</b> (kolom S)<br/> 
                                        Kolom : <span style="color:#1ab394"><b>NRK, TMT, GAPOK, JENRUB, KOPANG, TTMASKER, BBMASKER, KOLOK, NOSK, TGSK, TTMASYAD, BBMASYAD, USER_ID, TERM, TG_UPD, KLOGAD, SPMU, TAHUN_REFGAJI, JENIS_SK</b></span>
                                        </li>
                                    </ul>

                            </li>
                            <li>Penginputan untuk jenis tanggal menggunakan format cell tipe  <b>Text</b> dengan format <b>DD/MM/YYYY</b></li>
                            <li>Penginputan data yang mempunyai nilai 0(nol) menggunakan appostrophy(') menjadi <b>'0</b></li>
                        </ol>
                       <h2 class="font-bold text-danger">FILE YANG DIUPLOAD HARUS SESUAI DENGAN ATURAN DI ATAS, <BR/>
                        KESALAHAN KARENA PERBEDAAN ISI FILE EXCEL BUKAN KESALAHAN SISTEM</h2>

                        <label>Upload File PNS di bawah ini</label>
                        <div class="row">
                            <form action='#' method='post' enctype='multipart/form-data' id='myForm3' onsubmit='return insertsumpahpns();' > 
                                <input type='file' id='upload3' name='upload3'/>
                                <div class='sk-spinner sk-spinner-fading-circle' id='spinr2' style='display:none; margin:0'>
                                            <div class='sk-circle1 sk-circle'></div>
                                            <div class='sk-circle2 sk-circle'></div>
                                            <div class='sk-circle3 sk-circle'></div>
                                            <div class='sk-circle4 sk-circle'></div>
                                            <div class='sk-circle5 sk-circle'></div>
                                            <div class='sk-circle6 sk-circle'></div>
                                            <div class='sk-circle7 sk-circle'></div>
                                            <div class='sk-circle8 sk-circle'></div>
                                            <div class='sk-circle9 sk-circle'></div>
                                            <div class='sk-circle10 sk-circle'></div>
                                            <div class='sk-circle11 sk-circle'></div>
                                            <div class='sk-circle12 sk-circle'></div>
                                        </div>
                                <input type='submit' value='Submit'/> 
                            </form>
                        </div>
                    </div>
                    <!-- end div jabatan -->

                    <!-- input pensiun -->
                    <div id="upensiun" style="display: none">
                        <h3 class="font bold text-navy"> Aturan Penggunaan Input Data Pensiun</h3>
                        <ol>
                            <li>File yang mendukung adalah <b>Microsoft Excel 2007 ke atas</b></li>
                            <li>File Excel menggunakan <b>2 sheet</b>
                                    <ul>
                                        <li>
                                        <b>SHEET 1 : Pegawai 1</b><br/>
                                        Status : <b>UPDATE</b><br/>
                                        Total kolom = <b>3</b> (kolom C)<br/> 
                                        Kolom : <span style="color:#1ab394"><b>NRK, KLOGAD, TMTPENSIUN</b></span>
                                        </li>

                                        <li>
                                        <b>SHEET 2 : Riwayat Jabatan Struktural</b><br/>
                                        Status : <b>INSERT</b><br/>
                                        Total kolom = <b>16</b> (kolom P)<br/> 
                                        Kolom : <span style="color:#1ab394"><b>NRK, TMT, KOLOK, KOJAB, KDSORT, TGAKHIR, KOPANG, ESELON,PEJTT, NOSK, TGSK, KREDIT, STATUS, USER_ID, TERM, TG_UPD</b></span>
                                        </li>
                                    </ul>
                            </li>
                            <li>Penginputan untuk jenis tanggal menggunakan format cell tipe  <b>Text</b> dengan format <b>DD/MM/YYYY</b></li>
                            <li>Penginputan data yang mempunyai nilai 0(nol) menggunakan appostrophy(') menjadi <b>'0</b></li>
                        </ol>
                        <h2 class="font-bold text-danger">FILE YANG DIUPLOAD HARUS SESUAI DENGAN ATURAN DI ATAS, <BR/>
                        KESALAHAN KARENA PERBEDAAN ISI FILE EXCEL BUKAN KESALAHAN SISTEM</h2>

                        <label>Upload File Pensiun di bawah ini</label>
                       
                        <div class="row">
                            <form action='#' method='post' enctype='multipart/form-data' id='myForm4' onsubmit='return insertpensiun();' > 
                                <input type='file' id='upload4' name='upload4'/>
                                <div class='sk-spinner sk-spinner-fading-circle' id='spinr3' style='display:none; margin:0'>
                                            <div class='sk-circle1 sk-circle'></div>
                                            <div class='sk-circle2 sk-circle'></div>
                                            <div class='sk-circle3 sk-circle'></div>
                                            <div class='sk-circle4 sk-circle'></div>
                                            <div class='sk-circle5 sk-circle'></div>
                                            <div class='sk-circle6 sk-circle'></div>
                                            <div class='sk-circle7 sk-circle'></div>
                                            <div class='sk-circle8 sk-circle'></div>
                                            <div class='sk-circle9 sk-circle'></div>
                                            <div class='sk-circle10 sk-circle'></div>
                                            <div class='sk-circle11 sk-circle'></div>
                                            <div class='sk-circle12 sk-circle'></div>
                                        </div>
                                <input type='submit' value='Submit'/> 
                            </form>
                        </div>
                    </div>
                    <!-- end div pensiun -->

                    <!-- input jabeselon -->
                    <div id="ujabeselon" style="display: none">
                        <h3 class="font bold text-navy"> Aturan Penggunaan Input Data Jabatan Eselon</h3>
                        <ol>
                            <li>File yang mendukung adalah <b>Microsoft Excel 2007 ke atas</b></li>
                            <li>File Excel menggunakan <b>2 sheet</b>
                                    <ul>
                                        <li>
                                        <b>SHEET 1 : Pegawai 1</b><br/>
                                        Status : <b>UPDATE</b><br/>
                                        Total kolom = <b>4</b> (kolom D)<br/> 
                                        Kolom : <span style="color:#1ab394"><b>NRK, KLOGAD, USER_ID, TG_UPD</b></span>
                                        </li>

                                        <li>
                                        <b>SHEET 2 : Riwayat Jabatan Struktural</b><br/>
                                        Status : <b>INSERT</b><br/>
                                        Total kolom = <b>16</b> (kolom P)<br/> 
                                        Kolom : <span style="color:#1ab394"><b>NRK, TMT, KOLOK, KOJAB, KDSORT, TGAKHIR, KOPANG, ESELON,PEJTT, NOSK, TGSK, KREDIT, STATUS, USER_ID, TERM, TG_UPD</b></span>
                                        </li>
                                    </ul>
                            </li>
                            <li>Penginputan untuk jenis tanggal menggunakan format cell tipe  <b>Text</b> dengan format <b>DD/MM/YYYY</b></li>
                            <li>Penginputan data yang mempunyai nilai 0(nol) menggunakan appostrophy(') menjadi <b>'0</b></li>
                        </ol>
                        <h2 class="font-bold text-danger">FILE YANG DIUPLOAD HARUS SESUAI DENGAN ATURAN DI ATAS, <BR/>
                        KESALAHAN KARENA PERBEDAAN ISI FILE EXCEL BUKAN KESALAHAN SISTEM</h2>

                        <label>Upload File Jabatan Eselon di bawah ini</label>
                       
                        <div class="row">
                            <form action='#' method='post' enctype='multipart/form-data' id='myForm5' onsubmit='return insertjabeselon();' > 
                                <input type='file' id='upload5' name='upload5'/>
                                <div class='sk-spinner sk-spinner-fading-circle' id='spinr4' style='display:none; margin:0'>
                                            <div class='sk-circle1 sk-circle'></div>
                                            <div class='sk-circle2 sk-circle'></div>
                                            <div class='sk-circle3 sk-circle'></div>
                                            <div class='sk-circle4 sk-circle'></div>
                                            <div class='sk-circle5 sk-circle'></div>
                                            <div class='sk-circle6 sk-circle'></div>
                                            <div class='sk-circle7 sk-circle'></div>
                                            <div class='sk-circle8 sk-circle'></div>
                                            <div class='sk-circle9 sk-circle'></div>
                                            <div class='sk-circle10 sk-circle'></div>
                                            <div class='sk-circle11 sk-circle'></div>
                                            <div class='sk-circle12 sk-circle'></div>
                                        </div>
                                <input type='submit' value='Submit'/> 
                            </form>
                        </div>
                    </div>
                    <!-- end div jabeselon -->
                    

                </div>
            </div>
            <!-- END REFERENSI -->
        </div>        
    </div>

</div>

<style type="text/css">
    .modal-lg{
        width: 1024px !important;
    }
</style>

<!-- Start Modal -->
<div class="modal" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
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
        var dataTable = null;

        $('#myForm3').on('submit',function(event){
            event.preventDefault();
        })

        $('#myForm4').on('submit',function(event){
            event.preventDefault();
        })

        $('#myForm5').on('submit',function(event){
            event.preventDefault();
        })
    
            ubahformupload();

            $(document).ready(function(){
                $( "#referensi_list" ).change(function(event) {

                    event.preventDefault();
                    ubahformupload();
  
                })               

            });                    

            function ubahformupload()
            {
                var input = $('#referensi_list').val();
                
                if(input == 0)
                {
                    $('#upangkatgaji').hide();
                    $('#ujabatan').hide();
                    $('#upensiun').hide();   
                    $('#ujabeselon').hide();
                }
                else if(input == 1)
                {
                    $('#upangkatgaji').show();
                    $('#ujabatan').hide();
                    $('#upensiun').hide();
                    $('#ujabeselon').hide();
                }
                else if(input == 2)
                {
                    $('#upangkatgaji').hide();
                    $('#ujabatan').show();
                    $('#upensiun').hide();
                    $('#ujabeselon').hide();
                }
                else if(input == 3)
                {
                    $('#upangkatgaji').hide();
                    $('#ujabatan').hide();
                    $('#upensiun').show();
                    $('#ujabeselon').hide();
                }
                else if(input == 4)
                {
                    $('#upangkatgaji').hide();
                    $('#ujabatan').hide();
                    $('#upensiun').hide();
                    $('#ujabeselon').show();
                }
            }
           


            function insertklogad()
            {
                var formdata = new FormData();      
                var file = $('#upload')[0].files[0];
                formdata.append('fFile', file);
                $.each($('#myForm').serializeArray(), function(a, b){
                    formdata.append(b.name, b.value);
                });
      
                $.ajax({
                    url: '<?php echo base_url("index.php/referensi/ExcelFunct"); ?>',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    beforeSend: function(){
                      // add event or loading animation
                     $('#spinr').show();
                    },
                    success: function(data) {
                        $('#spinr').hide();
                        if(data>0)
                        {
                            swal("Error!", "Data sudah ada.", "error"); 
                        }
                        else
                        {
                            swal("Sukses!", "Data berhasil diinput.", "success"); 
                            reloadTable();       
                        }
                      
                    },
                    error: function(xhr) 
                    {                              
                       swal("Error!", "Data gagal diinput.", "error"); 
                    },
                    
                });
                return false;
            }

            function insertpangkat()
            {
                var formdata = new FormData();      
                var file = $('#upload2')[0].files[0];
                formdata.append('fFile', file);
                $.each($('#myForm2').serializeArray(), function(a, b){
                    formdata.append(b.name, b.value);
                });
      
                $.ajax({
                    url: '<?php echo base_url("index.php/riwayat/insertpangkat"); ?>',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    beforeSend: function(){
                      // add event or loading animation
                     $('#spinr').show();
                    },
                    success: function(data) {
                        $('#spinr').hide();
                        
                            swal("Sukses!", "Data berhasil diinput. Data sama = "+data , "success"); 
                            //reloadTable();       
                        
                      
                    },
                    error: function(xhr) 
                    {                              
                       swal("Error!", "Data gagal diinput.", "error"); 
                    },
                    
                });
                return false;
            }

            function insertpanggaji()
            {
                var formdata = new FormData();      
                var file = $('#upload2')[0].files[0];
                formdata.append('fFile', file);

                $.each($('#myForm2').serializeArray(), function(a, b){ 
                    formdata.append(b.name, b.value);
                });
      
                $.ajax({
                    url: '<?php echo base_url("index.php/uploaddata/insertpanggaji"); ?>',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    beforeSend: function(){
                      // add event or loading animation
                     $('#spinr').show();
                    },
                    success: function(data) {
                        
                        $('#spinr').hide();
                            
                            if(data == 1)
                            {
                              
                                swal({type:"success",title:"Berhasil !!", text:"Seluruh Data Berhasil Dibuat."});  
                            }
                            
                            else
                            {
                               swal({type:"warning",title:"PERINGATAN !!", text:"Sebagian Data Berhasil Diinput."});  
                            }
                            //swal("Sukses!", "Data berhasil diinput. Data sama = "+data , "success"); 
                            //reloadTable();       
                            
                            $url = '<?php echo site_url('uploaddata/downloadlog') ?>';
                            window.open($url,'_blank');
                      
                    },
                    error: function(xhr) 
                    {                              
                       swal("Error!", "Data gagal diinput.", "error"); 
                    },
                    
                });
                return false;
            }

            function insertsumpahpns()
            {
                var formdata = new FormData();      
                var file = $('#upload3')[0].files[0];
                
                formdata.append('fFile', file);

                $.each($('#myForm3').serializeArray(), function(a, b){
                    formdata.append(b.name, b.value);
                });
      
                
                $.ajax({
                    url: '<?php echo base_url("index.php/uploaddata/insertsumpahpns"); ?>',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    dataType:'JSON',
                    beforeSend: function(){
                      // add event or loading animation
                     $('#spinr2').show();
                    },
                    success: function(data) {
                        //console.log(data.response);
                        $('#spinr2').hide();
                            
                            if(data.response == '1')
                            {
                              
                                swal({type:"success",title:"Berhasil !!", text:"Seluruh Data Berhasil Dibuat."});  
                            }
                            else if(data.response == '0')
                            {
                              
                                swal({type:"warning",title:"PERINGATAN !!", text:"Terdapat data duplikasi dan sebagian data berhasil diinput."});    
                            }
                            else
                            {
                               swal({type:"error",title:"ERROR !!", text:"Terdapat data gagal diinput."});  
                            }
                                
                             
                             $url = '<?php echo site_url('uploaddata/downloadlogpns') ?>';
                            window.open($url,'_blank');
                      
                    },
                    error: function(xhr) 
                    {     
                                       
                         
                       //swal("Error!", "Data gagal diinput.", "error"); 
                    }/*,
                    complete:function()
                    {
                        return false;
                    }
                    */
                });
               
            }

            function insertpensiun()
            {
                var formdata = new FormData();      
                var file = $('#upload4')[0].files[0];
                
                formdata.append('fFile', file);

                $.each($('#myForm4').serializeArray(), function(a, b){
                    formdata.append(b.name, b.value);
                });
      
                
                $.ajax({
                    url: '<?php echo base_url("index.php/uploaddata/insertpensiun"); ?>',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    dataType:'JSON',
                    beforeSend: function(){
                      // add event or loading animation
                     $('#spinr3').show();
                    },
                    success: function(data) {
                        //console.log(data.response);
                        $('#spinr3').hide();
                            
                            if(data.response == '1')
                            {
                              
                                swal({type:"success",title:"Berhasil !!", text:"Seluruh Data Berhasil Dibuat."});  
                            }
                            else if(data.response == '0')
                            {
                              
                                swal({type:"warning",title:"PERINGATAN !!", text:"Terdapat data duplikasi dan sebagian data berhasil diinput."});    
                            }
                            else
                            {
                               swal({type:"error",title:"ERROR !!", text:"Terdapat data gagal diinput."});  
                            }
                                
                             
                             $url = '<?php echo site_url('uploaddata/downloadlogpensiun') ?>';
                            window.open($url,'_blank');
                      
                    },
                    error: function(xhr) 
                    {     
                                       
                         
                       //swal("Error!", "Data gagal diinput.", "error"); 
                    }/*,
                    complete:function()
                    {
                        return false;
                    }
                    */
                });
               
            }

            function insertjabeselon()
            {
                var formdata = new FormData();      
                var file = $('#upload5')[0].files[0];
                
                formdata.append('fFile', file);

                $.each($('#myForm5').serializeArray(), function(a, b){
                    formdata.append(b.name, b.value);
                });
      
                
                $.ajax({
                    url: '<?php echo base_url("index.php/uploaddata/insertjabataneselon"); ?>',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    dataType:'JSON',
                    beforeSend: function(){
                      // add event or loading animation
                     $('#spinr4').show();
                    },
                    success: function(data) {
                        //console.log(data.response);
                        $('#spinr4').hide();
                            
                            if(data.response == '1')
                            {
                              
                                swal({type:"success",title:"Berhasil !!", text:"Seluruh Data Berhasil Dibuat."});  
                            }
                            else if(data.response == '0')
                            {
                              
                                swal({type:"warning",title:"PERINGATAN !!", text:"Terdapat data duplikasi dan sebagian data berhasil diinput."});    
                            }
                            else
                            {
                               swal({type:"error",title:"ERROR !!", text:"Terdapat data gagal diinput."});  
                            }
                                
                             
                             $url = '<?php echo site_url('uploaddata/downloadlogjabeselon') ?>';
                            window.open($url,'_blank');
                      
                    },
                    error: function(xhr) 
                    {     
                                       
                         
                       //swal("Error!", "Data gagal diinput.", "error"); 
                    }/*,
                    complete:function()
                    {
                        return false;
                    }
                    */
                });
               
            }


            /*START CHOSEN*/
            var config = {
              '.chosen-select'           : {search_contains:true,no_results_text:'Oops, Data Tidak Ditemukan'}              
            }
            for (var selector in config) {
              $(selector).chosen(config[selector]);
            }
            /*END CHOSEN*/
        </script>

        <script>
       
    function fnClickAddRow() 
        {
            $('#editable').dataTable().fnAddData( [
                "Custom row",
                "New row",
                "New row",
                "New row",
                "New row" ] );

        }
    </script>

