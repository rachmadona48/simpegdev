<style type="text/css">
    .col-lg-4 .ibox .ibox-title{
        background-color: rgba(0,0,0,0.1);
    }
    .col-lg-4 .ibox .ibox-content{
        background-color: rgba(10,0,0,0.07);
    }
    #addMenu .modal-content .modal-header {
        padding: 10px 15px; 
        text-align: center;
    }
    #addMenu .ibox-content {
        background-color: #ffffff;
        color: inherit;
        padding: 0px 0px 0px 0px !important; 
        border-color: #e7eaec;
        border-image: none;
        border-style: solid solid none;
        border-width: 1px 0px;
    }

    .dd-item .pull-right button{
        margin-top: 5px;
        margin-right: 2px;
    }

    .sk-spinner-circle.sk-spinner {
        height: 22px;
        margin: 0 !important;
        position: relative;
        width: 22px;
    }

    .sk-spinner-three-bounce.sk-spinner {
        margin: 0 auto;
        text-align: center;
        width: 140px !important;
    }

    .dataTables_scroll .dataTables_scrollHeadInner{
        width: 100% !important;
    }

    .dataTables_scroll .dataTables_scrollHeadInner table{
        width: 100% !important;   
    }

    .dataTables_scroll .dataTables_scrollBody{
        width: 100% !important;
    }

    .dataTables_scroll .dataTables_scrollBody table{
        width: 100% !important;
    }

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

    .btn-block{
        width: 10%;
        float:left;
        margin-left: 20px;
    }

    .btn-tambah{
        margin-top:3px;
    }

    input, select{
        border-color: red;
    }

</style>




<?php
	date_default_timezone_set('Asia/Jakarta');
    $date_now = date('Ym');
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List Sasaran Kinerja Pegawai</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">
                <strong>Skp</strong>
            </li>
        </ol>
         <!-- <small><i>(Menu untuk pengajuan dan proses cuti)</i></small> -->
    </div>
</div>|


<!-- hanya untuk pns selain gubernur -->
<?php if ($user_id != '000000') { ?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">List SKP</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">
                

                <div class="row" >
                    <div class="ibox-title">
                    </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">                                
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                                            <tr>
                                                                <th>NO</th>
                                                                <th colspan="2" width="45%">I. PEJABAT PENILAI</th>
                                                                <th>NO</th>
                                                                <th colspan="6">II. PEGAWAI NEGERI SIPIL YANG DINILAI</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="gradeA">
                                                                <td class="center">1</td>
                                                                <td>Nama</td>
                                                                <td><?=$infoUserAtasan->NAMA_ABS;?></td>
                                                                <td class="center">1</td>
                                                                <td colspan="2">Nama</td> 
                                                                <td colspan="4"><?=$infoUser->NAMA_ABS;?></td>
                                                            </tr>
                                                             <tr class="gradeA">
                                                                <td class="center">2</td>
                                                                <td>NIP</td>
                                                                <td><?=$infoUserAtasan->NIP18;?></td>
                                                                <td class="center">2</td>
                                                                <td colspan="2">NIP</td> 
                                                                <td colspan="4"><?=$infoUser->NIP18;?></td>
                                                            </tr>
                                                             <tr class="gradeA">
                                                                <td class="center">3</td>
                                                                <td>Pangkat/Gol.Ruang</td>
                                                                <td><?=$infoUserAtasan->NAPANG.'('.$infoUserAtasan->GOL.')';?></td>
                                                                <td class="center">3</td>
                                                                <td colspan="2">Pangkat/Gol.Ruang</td> 
                                                                <td colspan="4"><?=$infoUser->NAPANG.'('.$infoUser->GOL.')';?></td>
                                                            </tr>
                                                            <tr class="gradeA">
                                                                <td class="center">4</td>
                                                                <td>Jabatan</td>
                                                                <td><?=$infoUserAtasan->NAJABL;?></td>
                                                                <td class="center">4</td>
                                                                <td colspan="2">Jabatan</td> 
                                                                <td colspan="4"><?=$infoUser->NAJABL;?></td>
                                                            </tr>
                                                            <tr class="gradeA">
                                                                <td class="center">5</td>
                                                                <td>Unit Kerja</td>
                                                                <td><?=$infoUserAtasan->NALOKL;?></td>
                                                                <td class="center">5</td>
                                                                <td colspan="2">Unit Kerja</td> 
                                                                <td colspan="5"><?=$infoUser->NALOKL;?></td>
                                                            </tr>
                                                        </tbody> 
                                                    </table>
                                                      
                                </div>
                            </div>
                        </div>
                        

                    <!-- </div> -->
                </div>

                
            </div> <!-- akhir div ibox content-->
        </div> <!-- akhir div ibox float e-margins -->

      </div> <!-- akhir div col lg 6 -->
       <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">List SKP</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">
                

                <div class="row" >
                    <div class="ibox-title">
                    </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">                                                                
                                                    <br/>
                                                    <table id="listskp" class="table table-bordered table-striped table-hover">
                                                         <thead>
                                                            <tr>
                                                                <th rowspan="2">NO</th>
                                                                <th rowspan="2" width="50%">III. KEGIATAN TUGAS JABATAN</th>
                                                                <th rowspan="2">AK</th>                                             
                                                                <th colspan="7">TARGET</th>
                                                            </tr>
                                                            <tr class="gradeX">
                                                                <th colspan="2" width="10%">KUANT/OUTPUT</th>
                                                                <th>KUAL/MUTU</th>
                                                                <th colspan="2">Waktu</th>
                                                                <th>Biaya</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                
                                                
                                                        <tbody class="contains-body">
                                                        </tbody>
                                </table>                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">                            
                            <button type='button' class='btn btn-primary btn-block btn-tambah' onclick="fnClickAddRow()">Tambah</button>
                            <button type='button' class='btn btn-primary btn-block btn-submit'><i class='fa'></i>Submit</button>
                            <a href="<?php echo base_url(); ?>index.php/skp/cetak_skp" target="_blank" class='btn btn-warning btn-block btn-submit' ><i class='fa'></i>Cetak</button></a>
                            
                        </div>

                    <!-- </div> -->
                </div>

                
            </div> <!-- akhir div ibox content-->
        </div> <!-- akhir div ibox float e-margins -->

      </div> <!-- akhir div col lg 6 -->
    </div><!-- akhir div row -->

</div>
<?php } ?>


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
    <script type="text/javascript">      
        var status_crud = "";  
        $(document).ready(function() {                        
             var table = $('#listskp').DataTable({
                 "processing": true,
                "serverSide": true,
                "ajax": "<?php echo base_url()?>index.php/skp/ajax_list_perilaku_kerja"
            });

        });

        function save(btn){
            var arr_data = [];
            $(".new").each(function(i,obj){
                var elchild = $(obj).children();
                elchild
                var arr_child = [];
                $(elchild).each(function(j,objchl){                        
                    var newValue = "";
                    if ($(objchl).children()){
                        var inputel = $(objchl).find("input");
                        if ($(inputel).hasClass("form-control")){
                            newValue  = $(inputel).val();                                
                            arr_child.push(newValue);
                        }

                        var inpute2 = $(objchl).find("select");
                        if ($(inpute2).hasClass("form-control")){
                            newValue  = $(inpute2).val();                                
                            arr_child.push(newValue);
                        }
                    }                         
                 });

                arr_data.push(arr_child);
            });                      
            $.ajax({
                type: "POST",
                data: {data:arr_data},
                url: "<?php echo base_url(); ?>index.php/skp/submit_skp",
                success: function(msg){                                                                                
                    var json = JSON.parse(msg);
                    if (json.response=="SUKSES"){                        
                        displayTable(json.data);
                        status_crud = "";
                        $(".btn").attr("disabled",false);                         
                    }
                }
            });      
        }

        function displayTable(data){
            var strhtml = "";
            $(data).each(function(i,obj){  
                console.log(obj);
                var ak = (obj.ak == null) ? '' : obj.ak;
                var qty = (obj.quantityshow == null) ? '' : obj.quantityshow;
                var output = (obj.outputshow == null) ? '' : obj.outputshow;
                var quality = (obj.qualityshow == null) ? '' : obj.qualityshow;
                var total_month = (obj.total_monthshow == null) ? '' : obj.total_monthshow;
                var biaya = (obj.biayashow == null) ? '' : obj.biayashow;                
                strhtml = strhtml + '<tr class="gradeX" id="row-' + obj.id + '">';
                strhtml = strhtml + '<td class="no">' + (i+1)  + '</td>';
                strhtml = strhtml + '<td>' + obj.kegiatan  + '</td>';
                strhtml = strhtml + '<td>' + ak + '</td>';
                strhtml = strhtml + '<td>' + qty  + '</td>';
                strhtml = strhtml + '<td width="10%">' + output  + '</td>';
                strhtml = strhtml + '<td>' + quality  + '</td>';
                strhtml = strhtml + '<td>' + total_month  + '</td>';
                strhtml = strhtml + '<td width="10%">Bulan</td>';
                strhtml = strhtml + '<td>' + biaya  + '</td>';
                strhtml = strhtml + '<td><a href="javascript:void(0)" onclick="onEdit(this)">edit</a> | <a href="javascript:void(0)" onclick="onDelete(this)">delete</a><td>';
                strhtml = strhtml + '</tr>';                
            });            
            $(".contains-body").html("");
            $(".contains-body").html(strhtml);
        }


        function fnClickAddRow(){
            var eltblbody =$(".contains-body").text();  
            var contain_body = eltblbody.replace(/\s+/g, '');            
            var el = $(".gradeX").last();            
            var no = $("table .no").last().text();
            var number= parseInt(no)+1;
            if (isNaN(number)){
                number = 1;
            }

            var html = '<tr class="gradeX new">';
                html = html + '<td class="no">' + number +'</td>';
                html = html + '<td><input type="text" name="kegiatan[]" class="form-control"/></td>';
                html = html + '<td><input type="number" name="ak[]" class="form-control" value="0"/></td>';
                html = html + '<td><input type="number" name="quantity[]" class="form-control" value="0"/></td>';
                var arr_select = ["Laporan","Dokumen","Surat","Berkas"];
                var str_html = onSelectOutput(arr_select, "");  
                html = html + '<td width="10%">' + str_html + '</td>';                
                html = html + '<td><input type="number" name="kual[]" class="form-control" value="0"/></td>';
                html = html + '<td><input type="text" name="time[]" class="form-control" value="0"/></td>';                
                html = html + '<td>bulan</td>';                
                html = html + '<td><input type="text" class="form-control" name="date[]" value="0"></td>';
                html = html + '<td class="action"><a href="javascript:void(0)" onclick="onDelete(this)">delete</a></td>';
                html = html + '</tr>';
                        
            if (contain_body==""){
                $('.contains-body').html(html);
            }else{
                $(html).insertAfter(el);
            }
            $( ".dtpicker" ).datepicker();
            $("input,select").css("border-color","red");
            //$('.clockpicker').clockpicker();
            //$(".btn-submit").show();
        }

        function onDelete(elm){              
            if (!confirm('Are you sure?')){                
                return;
            }
            $(".btn").attr("disabled",true);
            var el_add_row = $(".new");
            if (!el_add_row){
                $(".btn-submit").hide();
            }
            var el = $(elm).parent().parent();                        
            var arr_id = $(el).attr("id");
            var is_exist = false;
            if (arr_id){
                is_exist = true;
                var arr_id = $(el).attr("id").split("-");
            }
            if (is_exist){
                $.ajax({
                    type: "POST",
                    data: {id:arr_id[1]},
                    url: "<?php echo base_url(); ?>index.php/skp/delete_skp",
                    success: function(msg){                    
                        var json = JSON.parse(msg);
                        if (json.response=="SUKSES"){
                            $(el).remove();  
                            $(".btn").attr("disabled",false);
                        }
                    }
                }); 
            }else{
                $(el).remove();  
                $(".btn").attr("disabled",false);
            }
            reSortNumber();                            
        }

        var elEdit = [];
        function onEdit(elm){
            status = "edit";
            elEdit = [];
            $(".new").remove();
            var el = $(elm).parent().parent();            
             $(el).each(function(i,obj){
                 var elchild = $(obj).children();                 
                 $(elchild).each(function(j,objchl){
                    var val = $(objchl).text();                                        
                    if (j>0 && j<9){
                        elEdit.push(val);
                        if (j==2 || j==3  || j==5 || j==6  || j==8){
                            $(objchl).html('<input type="number" class="form-control" value="' + val + '"/>');
                        }else if (j==4){
                            var arr_select = ["Laporan","Dokumen","Surat","Berkas"];
                            var str_html = onSelectOutput(arr_select, val);                            
                            $(objchl).html(str_html);                            
                        }else if (j==7){
                            $(objchl).html("bulan");
                        }else{
                            $(objchl).html('<input type="text" class="form-control" value="' + val + '"/>');    
                        }
                        
                    }else if (j==9){
                        $(objchl).html('<a href="javascript:void(0)" onclick="onUpdate(this)">update</a> | <a href="javascript:void(0)" onclick="onCancel(this)">cancel</a>');
                    }     
                 });
            });
            $("input,select").css("border-color","red");
            $(".btn").attr("disabled",true);
            status_crud = "edit";
        }

        function onSelectOutputMonth(val){
            var arr_select = ["January","February","Maret","April", "Mei", "juni","july","Agustus", "September","October", "November","Desember"];
            return onSelectOutput(arr_select, val);
        }

        function onSelectOutput(arr_data, val){            
            var str_html = '<select class="form-control">';
            $(arr_data).each(function(key,value){
                if (val==value){
                    str_html = str_html + '<option value="'+ value +'" selected>'+ value +'</option>';
                }else{
                    str_html = str_html + '<option value="'+ value +'">'+ value +'</option>';
                }
            });
            str_html = str_html + '</select>';
            return str_html;            
        }

        function onCancel(elm){            
            var el = $(elm).parent().parent();
             $(el).each(function(i,obj){
                 var elchild = $(obj).children();                 
                 $(elchild).each(function(j,objchl){
                    var val = $(objchl).text();                    
                    if (j>0 && j<9){                        
                        $(objchl).text(elEdit[j-1]);
                    }else if (j==9){
                        $(objchl).html('<a href="javascript:void(0)" onclick="onEdit(this)">edit</a> | <a href="javascript:void(0)" onclick="onDelete(this)">delete</a>');
                    }     
                 });
            });
            var isFormExist = isFormExit();
            if (isFormExist){
                $(".btn").attr("disabled",false);
            }
            status_crud = "";
        }

        function onUpdate(elm){
            $(".btn").attr("disabled",true);
            var el = $(elm).parent().parent();            
            var arr_id = $(el).attr("id").split("-");                        
            var arr_data = [];            
            var elchild = $(el).children();                 
            $(elchild).each(function(j,objchl){
                //var val = $(objchl).text();                    
                if (j>0 && j<9){
                    if (j==4 || j==7){
                        var inputel = $(objchl).find("select");
                        var value = $(inputel).val();
                        arr_data.push(value);
                    }else{
                        var inputel = $(objchl).find("input");
                        var value = $(inputel).val();
                        arr_data.push(value);
                    }
                }     
            });
            
            $.ajax({
                type: "POST",
                data: {id:arr_id[1],data:arr_data},
                url: "<?php echo base_url(); ?>index.php/skp/update_skp",
                success: function(msg){                    
                    var json = JSON.parse(msg);
                    if (json.response=="SUKSES"){
                        displayUpdate(el);
                        status_crud = "";                        
                        
                    }
                }
            }); 
        }

        function displayUpdate(el){              
             $(el).each(function(i,obj){
                 var elchild = $(obj).children();                 
                 $(elchild).each(function(j,objchl){
                    //var val = $(objchl).text();
                    if (j>0 && j<9){
                        if (j==4){
                            var inputel = $(objchl).find("select");
                            var value = $(inputel).val();
                            $(objchl).text(value);
                        }else{
                            var inputel = $(objchl).find("input");
                            var value = $(inputel).val();
                            $(objchl).text(value);
                        }
                    }else if (j==9){
                        $(objchl).html('<a href="javascript:void(0)" onclick="onEdit(this)">edit</a> | <a href="javascript:void(0)" onclick="onDelete(this)">delete</a>');
                    }     
                 });
            });

            var boolean = isFormExit();
            if (boolean){
                $(".btn").attr("disabled",false);    
            }
        }

        function reSortNumber(){
            var number = 1;
            $(".gradeX").each(function(i,obj){
                var elchild = $(obj).children();
                $(elchild).each(function(j,objchl){
                    if ($(objchl).hasClass("no")){
                        $(objchl).text(number++);
                    }
                });
            });
        }

        function isFormExit(){
            var isFormExit = true;
            var arr_data = [];       
            $(".contains-body tr").each(function(j,obj){
                var elchild = $(obj).children();                       
                $(elchild).each(function(j,objchl){                                        
                    if (j>0 && j<9){
                        if (j==4){
                            var inputel = $(objchl).find("select");
                            var value = $(inputel).val();
                            if (value)
                                arr_data.push(value);
                        }else{
                            var inputel = $(objchl).find("input");
                            var value = $(inputel).val();
                            if (value)
                                arr_data.push(value);
                        }
                    }  
                });
            });            
            isFormExit  = arr_data.length == 0;
            return isFormExit;
        }
    </script>
