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
    }\

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

    .paginate_button{
            border: 1px solid #ccc;
            padding: 6px;
    }

    .kegiatan{
        float:left;
        width: 70%;
    }

    .sel-kegiatan{     
        float:left;
        width: 29%;    
    }

    .tr-kegiatan{
        cursor: pointer;
    }

    .tr-exist{
        background-color: yellow !important;
    }

</style>




<?php
	date_default_timezone_set('Asia/Jakarta');
    $date_now = date('Ym');
?>

<!-- hanya untuk pns selain gubernur -->
<?php if ($user_id != '000000') { ?>

    <?php if ($skp_header->status_approvement==DIKEMBALIKAN && $skp_header->nrk == $nrk) { ?>

        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">List SKP Setelah Koreksi</h5>
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
                                    <table id="table-skp-koreksi" class="table table-bordered table-striped table-hover table-skp-koreksi">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">NO</th>
                                                <th rowspan="2" width="40%">III. KEGIATAN TUGAS JABATAN</th>
                                                <th  width="5%" rowspan="2">AK</th>                                             
                                                <th colspan="7">TARGET</th>
                                            </tr>
                                            <tr class="gradeX">
                                                <th colspan="2" width="10%">KUANT/OUTPUT</th>
                                                <th width="5%">KUAL/MUTU</th>
                                                <th colspan="2">Waktu</th>
                                                <th width="7%">Biaya</th>
                                                <th width="15%">Action</th>
                                            </tr>
                                        </thead>
                                            <tbody class="contains-body-koreksi">
                                                <?php 
                                                     if (count($skp_koreksi) > 0 ){
                                                         foreach ($skp_koreksi as $key => $value) {
                                                ?>
                                                            <tr class="gradeX" id="row-<?php echo $value->id?>" id-kegiatan="<?php echo $value->id_kegiatan ?>" type-kegiatan="<?php echo $value->jenis_kegiatan ?>">
                                                                <td class="center no"><?php echo ($key+1) ?></td>
                                                                <td><?php echo $value->kegiatan ?></td>
                                                                <td><?php echo $value->ak ?></td>
                                                                <td width="5%" class="center"><?php echo $value->quantityshow ?></td>
                                                                <td width="10%"><?php echo $value->outputshow ?></td> 
                                                                <td><?php echo $value->qualityshow ?></td>
                                                                <td style="width:7%" ="7%"><?php echo $value->total_monthshow ?></td>
                                                                <td width="5%">bulan</td>
                                                                <?php if ($value->biayashow >0 ) { ?>
                                                                    <td><?php echo $value->biayashow ?></td>
                                                                <?php }else{ ?>
                                                                    <td>-</td>
                                                                <?php } ?>                                                     
                                                                <td>
                                                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="onEdit(this)">edit</a> | <a href="javascript:void(0)"   class="btn btn-sm btn-primary"  onclick="onDelete(this)">delete</a>
                          
                                                                </td>
                                                                
                                                            </tr>
                                                            <?php }
                                                            } ?>
                                                        </tbody>
                                </table>                                    
                                </div>
                            </div>
                        </div>                        
                        <div class="row">                            
                            <?php if ($type=="mine"){ ?>                                
                                <button type='button' class='btn btn-primary btn-block btn-tambah' onclick="AddRowKoreksi()">Tambah</button>
                                <button type='button' class='btn btn-primary btn-block btn-submit'><i class='fa'></i>Simpan</button>
                                <button type='button' class='btn btn-primary btn-block btn-kirim'><i class='fa'></i>Kirim</button>
                                <a href="<?php echo base_url(); ?>index.php/skp/cetak_skp?id=<?php echo $id ?>" target="_blank" class='btn btn-warning btn-block' ><i class='fa'></i>Cetak</button></a>                                
                            <?php } ?>
                            <button type='button' class='btn btn-primary btn-block btn-tambah' onclick="back()">Back</button>
                        </div>
                        

                    <!-- </div> -->
                </div>



                
            </div> <!-- akhir div ibox content-->
        </div> <!-- akhir div ibox float e-margins -->
        <?php } ?>

    <div class="ibox float-e-margins">
        <div class="ibox-title" style="background-color:#1AB394">                
            <?php if ($skp_header->status_approvement==DIKEMBALIKAN && $skp_header->nrk == $nrk) { ?>
                <h5 style="color:#ffffff">List SKP Sebelum Koreksi</h5>
            <?php }else {?>
                <h5 style="color:#ffffff">List SKP</h5>
            <?php }?>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">                
            <?php if ($skp_header->status_approvement==DIKEMBALIKAN && $skp_header->nrk == $nrk) { ?>
                                <div class="row">
                                    <div class="col-md-1">
                                        History Koreksi
                                    </div>     
                                    <div class="col-md-3">
                                        <select class="form-control history">
                                            <?php foreach ($version  as $key => $value) { ?>
                                                <?php if ( ($max_version-1) == $value->version ) { ?>
                                                    <option value="<?php echo $value->version; ?>" selected><?php echo ($value->version+1); ?></option>
                                                <?php } else { ?>                                                
                                                    <option value="<?php echo $value->version; ?>"><?php echo ($value->version+1); ?></option>
                                                <?php }?>
                                            <?php }?>
                                        </select>
                                    </div>                
                                </div><br/>
                            <?php } ?>
            <?php if ($type=="approval"){ ?>      
                <div class="row">

                    <div class="ibox-title">
                    </div>                    
                    <div class="row"> 

                        <div class="col-sm-12">

                            <div class="table-responsive">                                
                                <table class="table table-bordered table-striped table-hover table-skp">                                    
                                    <tbody>
                                        <tr class="gradeA">
                                            <td class="center">1</td>
                                            <td>Nama</td>
                                            <td><?=$owner_skp->NAMA_ABS;?></td>                       
                                        </tr>
                                        <tr class="gradeA">
                                            <td class="center">2</td>
                                            <td>NIP</td>
                                            <td><?=$owner_skp->NIP18;?></td>                       
                                        </tr>
                                        <tr class="gradeA">
                                            <td class="center">3</td>
                                            <td>Pangkat/Gol.Ruang</td>
                                            <td><?=$owner_skp->NAPANG.'('.$owner_skp->GOL.')';?></td>
                                        </tr>
                                        <tr class="gradeA">
                                            <td class="center">4</td>
                                            <td>Jabatan</td>
                                            <td><?=$owner_skp->NAJABL;?></td>                       
                                        </tr>
                                        <tr class="gradeA">
                                            <td class="center">5</td>
                                            <td>NaUnit Kerja</td>
                                                <td><?=$owner_skp->NALOKL;?></td>                       
                                            </tr>
                                        </tbody> 
                                     </table>
                                                      
                                </div>
                            </div>
                        </div>
                        

                    <!-- </div> -->
                </div>

                
                <?php } ?>      

                <div class="row" >
                    <div class="ibox-title">
                    </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive tbl-history">                                                                
                                                    <br/>
                                                    <table id="tbl_skp" class="table table-bordered table-striped table-hover">
                                                         <thead>
                                                            <tr>
                                                                <th rowspan="2">NO</th>
                                                                <th rowspan="2" width="40%">III. KEGIATAN TUGAS JABATAN</th>
                                                                <th  width="5%" rowspan="2">AK</th>                                             
                                                                <th colspan="7">TARGET</th>
                                                            </tr>
                                                            <tr class="gradeX">
                                                                <th colspan="2" width="10%">KUANT/OUTPUT</th>
                                                                <th width="5%">KUAL/MUTU</th>
                                                                <th colspan="2">Waktu</th>
                                                                <th width="7%">Biaya</th>
                                                                <?php if ($skp_header->status_approvement<=DIKIRIM ) { ?>
                                                                    <th width="15%">Action</th>
                                                                <?php } ?>                                                              
                                                            </tr>
                                                        </thead>
                                                        <tbody class="contains-body">
                                                            <?php 
                                                            if (count($skp)){
                                                                foreach ($skp as $key => $value) {
                                                                ?>
                                                            <tr class="gradeX" id="row-<?php echo $value->id?>" id-kegiatan="<?php echo $value->id_kegiatan ?>" type-kegiatan="<?php echo $value->jenis_kegiatan ?>">
                                                                <td class="center no"><?php echo ($key+1) ?></td>
                                                                <td><?php echo $value->kegiatan ?></td>
                                                                <td><?php echo $value->ak ?></td>
                                                                <td width="5%" class="center"><?php echo $value->quantityshow ?></td>
                                                                <td width="10%"><?php echo $value->outputshow ?></td> 
                                                                <td><?php echo $value->qualityshow ?></td>
                                                                <td style="width:7%" ="7%"><?php echo $value->total_monthshow ?></td>
                                                                <td width="5%">bulan</td>
                                                                <?php if ($value->biayashow >0 ) { ?>
                                                                    <td><?php echo $value->biayashow ?></td>
                                                                <?php }else{ ?>
                                                                    <td>-</td>
                                                                <?php } ?>
                                                                <?php if ($skp_header->status_approvement<=DIKIRIM) { ?>                                  
                                                                 <td>
                                                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="onEdit(this)">edit</a> | <a href="javascript:void(0)"   class="btn btn-sm btn-primary"  onclick="onDelete(this)">delete</a>
                          
                                                                </td>
                                                                <?php } ?>  
                                                                
                                                            </tr>
                                                            <?php }
                                                            } ?>
                                                        </tbody>
                                </table>                                    
                                </div>
                            </div>
                        </div>                        
                        <div class="row">                            
                            <?php if ($type=="mine"){ ?>                                
                                <?php if ($skp_header->status_approvement == BUAT_SKP) { ?>
                                    <button type='button' class='btn btn-primary btn-block btn-tambah' onclick="AddRowSKP()">Tambah</button>
                                    <button type='button' class='btn btn-primary btn-block btn-submit'><i class='fa'></i>Simpan</button>
                                    <button type='button' class='btn btn-primary btn-block btn-kirim'><i class='fa'></i>Kirim</button>
                                <?php } ?>
                                <?php if ($skp_header->status_approvement != DIKEMBALIKAN) { ?>
                                        <a href="<?php echo base_url(); ?>index.php/skp/cetak_skp?id=<?php echo $id ?>" target="_blank" class='btn btn-warning btn-block' ><i class='fa'></i>Cetak</button></a>      
                                <?php } ?>
                            <?php } else {  ?>
                                <?php if ($skp_header->status_approvement == DIKIRIM) { ?>
                                    <button type='button' class='btn btn-primary btn-block btn-tambah' onclick="AddRowSKP()">Tambah</button>
                                    <button type='button' class='btn btn-primary btn-block btn-submit'><i class='fa'></i>Simpan</button>
                                    <button type='button' class='btn btn-primary btn-block btn-approve'><i class='fa'></i>Diterima</button>
                                    <button type='button' class='btn btn-primary btn-block btn-kembali'><i class='fa'></i>Dikembalikan</button>
                                <?php } ?>
                            <?php } ?>    
                            <button type='button' class='btn btn-primary btn-block btn-tambah' onclick="back()">Back</button>                        
                        </div>
                        

                    
                </div>



                
            </div> 
        </div>

        

</div>
<?php } ?>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <!-- <div class="modal-content animated fadeInUp" id="modal_content"> -->
    <div class="modal-content animated fadeInUp" id="modal_content">

        <!-- <form id="defaultForm2" name="defaultForm2" method="post" class="form-horizontal"  action="javascript:save();" data-bv-submitbuttons="button[type='submit']" data-remote="true" data-toggle="validator" role="form"> -->
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="myModalLabel">Form SKP (KEGIATAN TUGAS JABATAN)</h3>
        </div>
        <div class="modal-body">
            <div style="overflow-y: scroll;height: 457px;">
            <table id="tbl-popup-kegiatan" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th rowspan="2">NO</th>
                        <th rowspan="2">Kegiatan</th>
                    </tr>
                </thead>
                <tbody class="kegiatan-body">
                </tbody>
            </table>
            </div>
        </div>
        <div class="modal-footer">            
            <button type="button" class="btn btn-danger btn-popup tutup" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary btn-popup ok">OK</button>
        </div>
    <!-- </form> -->
        
    </div>
  </div>
</div>

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
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/jasny/jasny-bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/jsKnob/jquery.knob.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugins/dataTables/jquery.dataTables.js"></script>
    
    <script type="text/javascript">          
        var status_crud = "";  
        var m_element = "";
        var m_jenis_kegiatan = [];
        var elEdit = [];
        var col_no = 0;
        var col_keg = 1;
        var col_ak = 2;
        var col_quant = 3;
        var col_out = 4;
        var col_kual = 5;
        var col_time = 6;
        var col_mounth = 7;
        var col_biaya = 8;
        var col_act = 9;

         <?php if (count($skp)){ ?>
                <?php foreach ($skp as $key => $value) { ?>
                    m_jenis_kegiatan['<?php echo $value->id ?>'] = ['<?php echo $value->id_kegiatan ?>','<?php echo $value->jenis_kegiatan; ?>'];
                <?php } ?>
        <?php  } ?>

        
        $(document).ready(function() {            
           

            $(".btn-submit").click(function(){                    
                if (status_crud=="edit"){                    
                    alert('pastikan tidak sedang mengedit data');
                }else{
                    //$(".btn").attr("disabled",true);
                    save(this);
                }
            })

            $(".tutup").click(function(){
                $(m_element.element).val("");
                $(m_element.element).attr("attr-id-keg", "");                                
                $(m_element.el).prop("selectedIndex", 0);               
                m_element  = "";

            });

             $(".ok").click(function(){                
                if (m_element.id!=''){                      
                    var el_tr = $(m_element.element).parent().parent();
                    $(el_tr).attr("id-kegiatan", m_element.id);
                    $(el_tr).attr("type-kegiatan", m_element.type);
                    $(m_element.element).attr("attr-id-keg", m_element.id);
                    $(m_element.element).val(m_element.val);       
                    $('#modal').modal('toggle');
                }
            });

             $(".close").click(function(){
                $(m_element.element).val("");                                
                $(m_element.element).attr("attr-id-keg", "");
                $(m_element.el).prop("selectedIndex", 0);
                m_element  = ""; 
             })

            $(".history").change(function(){
                var val = $(this).val();
                $.ajax({
                    type: "POST",
                    data: {id:"<?php echo $id ?>",version: val},
                    url: "<?php echo base_url(); ?>index.php/skp/view_version_skp",
                    success: function(msg){
                        $('.tbl-history').html(msg);
                    }
                });                
            });

            $(".btn-approve").click(function(){
                onApproval("<?php echo SKP_DITERIMA; ?>");
            });

            $(".btn-kirim").click(function(){
                onApproval("<?php echo DIKIRIM; ?>");
            });

            $(".btn-kembali").click(function(){
                onApproval("<?php echo DIKEMBALIKAN?>");
            });            
        });


        function onApproval(type_approvement){
            if (!confirm('Are you sure?')){                
                return;
            }
            $(".btn").attr("disabled",true);            
            
            $.ajax({
                type: "POST",
                data: {id:'<?php echo $id ?>', value : type_approvement},
                url: "<?php echo base_url(); ?>index.php/skp/update_approval",
                success: function(msg){
                    var json = JSON.parse(msg);
                    if (json.response=="SUKSES"){                                                                                
                        if (type_approvement == "<?php echo DIKIRIM ?>"){
                            alert("berhasil dikirim");
                        }else if (type_approvement == "<?php echo DIKEMBALIKAN ?>"){
                            alert("berhasil dikembalikan");
                        }                            
                        back();
                    }
                }
             });    
        }

        function save(btn){            
            var arr_data = getArrData(".new");
            console.log(arr_data);          
            $.ajax({
                type: "POST",
                data: {data:arr_data, id:'<?php echo $id ?>'},
                url: "<?php echo base_url(); ?>index.php/skp/tambah_skp",
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
            m_jenis_kegiatan = [];                        
            $(data).each(function(i,obj){                
                m_jenis_kegiatan[obj.id] = [obj.id_kegiatan,obj.jenis_kegiatan];
                var ak = (obj.ak == null) ? '' : obj.ak;
                var qty = (obj.qualityshow == null) ? '' : obj.qualityshow;
                var outputshow = (obj.outputshow == null) ? '' : obj.outputshow;
                var quantityshow = (obj.quantityshow == null) ? '' : obj.quantityshow;
                var total_monthshow = (obj.total_monthshow == null) ? '' : obj.total_monthshow;
                var biayashow = (obj.biayashow == null) ? '' : obj.biayashow;                
                strhtml = strhtml + '<tr class="gradeX" id="row-' + obj.id + '" id-kegiatan="' + obj.id_kegiatan + '" type-kegiatan="' + obj.jenis_kegiatan +'">';
                strhtml = strhtml + '<td class="no">' + (i+1)  + '</td>';
                strhtml = strhtml + '<td>' + obj.kegiatan  + '</td>';
                strhtml = strhtml + '<td>' + ak + '</td>';
                strhtml = strhtml + '<td>' + qty  + '</td>';
                strhtml = strhtml + '<td width="10%">' + outputshow  + '</td>';
                strhtml = strhtml + '<td>' + quantityshow  + '</td>';
                strhtml = strhtml + '<td>' + total_monthshow  + '</td>';
                strhtml = strhtml + '<td width="10%">Bulan</td>';
                strhtml = strhtml + '<td>' + biayashow  + '</td>';
                strhtml = strhtml + '<td><a class="btn btn-ms btn-primary" href="javascript:void(0)" onclick="onEdit(this)" class="btn btn-ms btn-primary" >edit</a> | <a href="javascript:void(0)" class="btn btn-ms btn-primary" onclick="onDelete(this)">delete</a><td>';
                strhtml = strhtml + '</tr>';                
            });            
            <?php if ($skp_header->status_approvement == DIKEMBALIKAN ){ ?>
                $(".contains-body-koreksi").html("");
                $(".contains-body-koreksi").html(strhtml);                                
            <?php } else { ?>
                $(".contains-body").html("");
                $(".contains-body").html(strhtml);
             <?php } ?>
            
        }

        function AddRowKoreksi(){            
            addRow(".contains-body-koreksi");
        }

        function AddRowSKP(){            
            addRow(".contains-body");
        }

        function addRow(cls){
            var elem = $(cls);
            var eltblbody =$(elem).text();  
            var contain_body = eltblbody.replace(/\s+/g, '');            
            var el = $(cls + " .gradeX").last();            
         
            var html = '<tr class="gradeX new" id-kegiatan="" type-kegiatan="">';
                html = html + '<td class="no"></td>';
                html = html + '<td><input type="text" attr-id-keg="" name="kegiatan[]" class="form-control kegiatan"/>' + getTypeSelect("") + '</td>';
                html = html + '<td><input type="text" name="ak[]" class="form-control numeric" value="0"/></td>';
                html = html + '<td><input type="text" name="quantity[]" class="form-control numeric" value="0"/></td>';                
                var arr_select = [];
                    <?php foreach ($doc_type as $key => $value) { ?>
                        arr_select.push({key: "<?php echo $value->id; ?>", value: "<?php echo $value->name; ?>"});
                    <?php } ?>
                var str_html = onSelectOutput(arr_select, "");  
                html = html + '<td width="10%">' + str_html + '</td>';                
                html = html + '<td><input type="text" name="kual[]" class="form-control numeric" value="100" readonly /></td>';
                str_html = onSelectOutputMonth("1");
                html = html + '<td width="10%">' + str_html + '</td>'; 
                // html = html + '<td><input type="text" name="time[]" class="form-control numeric" value="0"/></td>';                
                html = html + '<td>bulan</td>';                
                <?php if ($infoUser->ESELON[0]==="2" || $infoUser->ESELON[0] ==="3") {?>
                    html = html + '<td><input type="text" class="form-control numeric" value="0" /></td>';
                <?php }else{?>    
                    html = html + '<td><input type="text" class="form-control numeric" value="0" readonly /></td>';
                <?php }?>    
                html = html + '<td class="action"><a href="javascript:void(0)" class="btn btn-ms btn-primary" onclick="onDelete(this)">delete</a></td>';
                html = html + '</tr>';
                        
            if (contain_body==""){
                $(cls).html(html);
            }else{
                $(html).insertAfter(el);
            }
            $( ".dtpicker" ).datepicker();
            $("input,select").css("border-color","red");
            reSortNumber('#tbl_skp tr');
            reSortNumber('.table-skp-koreksi tr');
            numericfunction();                        
        }

        function getTypeSelect(val){
            var arr_data = [                
                {key:"", value:"Tanpa referensi"},
                {key:"program", value:"Program atau Aggaran"},
                {key:"tupoksi", value:"Tupoksi"}
            ]
            var str_html = '<select class="form-control sel-kegiatan" onchange="onChangeTypeKegiatan(this)">';
            $(arr_data).each(function(key,value){
                if (val==value.key){
                    str_html = str_html + '<option value="'+value.key +'" selected>' + value.value + '</option>';
                }else{
                    str_html = str_html + '<option value="'+value.key +'">' + value.value + '</option>';
                }
            });
            
            str_html = str_html + '</select>';
            return str_html;
        }

        function onChangeTypeKegiatan(el){
            var val = $(el).val();            
            if (val==""){
                var el_tr = $(el).parent().parent();                
                var element = $(el).prev();
                $(element).val("");
                $(element).attr("attr-id-keg","");
                $(el_tr).attr("id-kegiatan","");
                $(el_tr).attr("type-kegiatan","");
            } else if (val=="empty"){
                var element = $(el).prev();
                $(element).val("");                
                $(element).attr("attr-id-keg","");
            } else {
                $('#modal').modal('toggle');
                $(".kegiatan-body").html('<tr><td colspan="2">loading....</td></tr>');                
                $.ajax({
                    type: "POST",
                    data: {type:val,skp_nrk: '<?php echo $skp_header->nrk; ?>'},
                    url: "<?php echo base_url(); ?>index.php/skp/list_popup_kegiatan",
                    success: function(msg){                                                                                
                        var json = JSON.parse(msg);
                        if (json.response=="SUKSES"){                        
                            displayTableKegiatan(el,json);                                                    
                        }                                    
                    }
                });                   
            }            
        }

        function get_ids_attr_kegiatan(){
            var arr_data = [];
        }


        function displayTableKegiatan(el, json_root){
            var json = json_root.data;
            var type = json_root.type;
            var str_html = "";
            var ids =  getIds(el, type);
            $.each(json, function( index, value ) {                            
                if (isExistIds(ids, value.id)){
                    str_html = str_html + "<tr class='tr-exist tr-kegiatan-" + value.id + "' attr-id='' attr-value=''><td>"+ (index+1) +"</td><td>" + value.name + "</td></tr>";                
                }else{
                    str_html = str_html + "<tr class='tr-kegiatan tr-kegiatan-" + value.id + "' attr-id='" + value.id + "' attr-value='" + value.name +"'><td>"+ (index+1) +"</td><td>" + value.name + "</td></tr>";                
                }                
            });
            $(".kegiatan-body").html(str_html);
            $(".btn-popup").attr("disabled",false);
            $(".kegiatan-body tr").css("background-color","#F5F5F6");            
            var element = $(el).prev();
            m_element = {el:el, element:element, id: "", val: "", type: type};
            $(".kegiatan-body .tr-kegiatan").click(function() {                  
                $(".kegiatan-body .tr-kegiatan").css("background-color","#F5F5F6");
                $(this).css("background-color","red");
                var id = $(this).attr("attr-id");
                var val = $(this).attr("attr-value");    
                m_element = {el:el, element:element, id: id, val: val, type: type};
            });

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
                            reSortNumber("#tbl_skp tr");                            
                            reSortNumber(".table-skp-koreksi tr");
                        }
                    }

                }); 
            }else{                
                $(el).remove();  
                $(".btn").attr("disabled",false);
                reSortNumber("#tbl_skp tr");                            
                reSortNumber(".table-skp-koreksi tr");
            }
            
        }
       
        function onEdit(elm){
            status = "edit";
            elEdit = [];            
            $(".new").remove();
            var el = $(elm).parent().parent();            
             $(el).each(function(i,obj){
                var id = $(obj).attr("id").split("-")[1];
                // console.log("id ====== " + id);
                var elchild = $(obj).children();                 
                 $(elchild).each(function(j,objchl){
                    var val = $(objchl).text();                                        
                    if (j>col_no && j<col_act){
                        elEdit.push(val);
                        if (j==col_ak || j==col_quant  || j==col_kual){
                            $(objchl).html('<input type="text" class="form-control" value="' + val + '"/>');
                        }else if (j==col_out){
                            var arr_select = [];
                            <?php foreach ($doc_type as $key => $value) { ?>
                                arr_select.push({key: "<?php echo $value->id; ?>", value: "<?php echo $value->name; ?>"});
                            <?php } ?>                            
                            var str_html = onSelectOutput(arr_select, val);                            
                            $(objchl).html(str_html);                            
                        }else if (j==col_time){                            
                            var str_html = onSelectOutputMonth(val);
                            $(objchl).html(str_html);
                        }else if (j==col_mounth){
                            $(objchl).html("bulan");
                        }else if (j==col_biaya){
                            if (val == "-"){
                                val = "0";
                            }
                            $(objchl).html('<input type="text" class="form-control" value="' + val + '"/>');
                        }else if (j ==col_keg) {                            

                            var selvalue = "";
                            var id_kegiatan = "";
                            if (m_jenis_kegiatan[id]){
                                var selvalue = m_jenis_kegiatan[id][1];
                                var id_kegiatan = m_jenis_kegiatan[id][0];
                            }
                            $(objchl).html('<input type="text" attr-id-keg="' + id_kegiatan + '" class="form-control kegiatan" value="' + val + '"/>' + getTypeSelect(selvalue) );
                        }
                        else{
                            <?php if ($infoUser->ESELON[0]==="2" || $infoUser->ESELON[0] ==="3") {?>
                                $(objchl).html('<input type="text" class="form-control" value="' + val + '"/>');
                            <?php }else{?>    
                                $(objchl).html('<input type="text" class="form-control" value="' + val + '" readonly/>');
                            <?php }?>    
                            
                        }
                        
                    }else if (j==col_act){
                        $(objchl).html('<a href="javascript:void(0)" class="btn btn-ms btn-primary btn-update" onclick="onUpdate(this)">update.</a> | <a href="javascript:void(0)" class="btn btn-ms btn-primary btn-cancel" onclick="onCancel(this)">cancel</a>');
                    }     
                 });
            });
            $("input,select").css("border-color","red");
            $(".btn").attr("disabled",true);
            $(".btn-update").attr("disabled",false);
            $(".btn-cancel").attr("disabled",false);            
            status_crud = "edit";
        }

        function onSelectOutputMonth(val){
            var arr_select = [{"key":"1", "value":"1"},
            {"key":"2", "value": "2"},
            {"key":"3", "value": "3"},
            {"key":"4", "value":"4"}, 
            {"key":"5", "value":"5"}, 
            {"key":"6", "value":"6"},
            {"key":"7", "value":"7"},
            {"key":"8", "value":"8"}, 
            {"key":"9", "value":"9"}, 
            {"key":"10", "value":"10"}, 
            {"key":"11", "value":"11"},
            {"key":"12", "value": "12"}];
            return onSelectOutput(arr_select, val);
        }

        function onSelectOutput(arr_data, val){            
            var str_html = '<select class="form-control">';
            $(arr_data).each(function(key,value){                
                if (val==value.key){
                    str_html = str_html + '<option value="'+ value.key +'" selected>'+ value.value +'</option>';
                }else{
                    str_html = str_html + '<option value="'+ value.key +'">'+ value.value +'</option>';
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
                        $(objchl).html('<a href="javascript:void(0)" class="btn btn-ms btn-primary btn-update" onclick="onEdit(this)">edit</a> | <a href="javascript:void(0)" class="btn btn-ms btn-primary btn-update" onclick="onDelete(this)">delete</a>');
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
            //$(".btn").attr("disabled",true);
            var el = $(elm).parent().parent();            
            var arr_id = $(el).attr("id").split("-");                        
            var arr_data = [];            
            var elchild = $(el).children();                 
            $(elchild).each(function(j,objchl){
                        var inputel = $(objchl).find("input");
                        if ($(inputel).hasClass("form-control")){
                            newValue  = $(inputel).val();
                            arr_data.push(newValue);
                        }
                        if($(inputel).hasAttr('attr-id-keg')) {
                            newValue  = $(inputel).attr('attr-id-keg');
                            arr_data.push(newValue);
                        }

                        var inpute2 = $(objchl).find("select");
                        if ($(inpute2).hasClass("form-control")){
                            newValue  = $(inpute2).val();                                
                            arr_data.push(newValue);
                        }
                //var val = $(objchl).text();                    
                // if (j>0 && j<9){
                //     if (j==1 || j==4 || j==6){
                //         var inputel = $(objchl).find("select");
                //         var value = $(inputel).val();
                //         arr_data.push(value);
                //     }else{
                //         var inputel = $(objchl).find("input");
                //         var value = $(inputel).val();
                //         arr_data.push(value);

                //         if($(inputel).hasAttr('attr-id-keg')) {
                //             value  = $(inputel).attr('attr-id-keg');
                //             arr_data.push(value);
                //         }
                //     }
                // }     
            });

            // console.log(arr_data);
            
            $.ajax({
                type: "POST",
                data: {id:arr_id[1],data:arr_data,type:"<?php echo $type ?>"},
                url: "<?php echo base_url(); ?>index.php/skp/update_skp",
                success: function(msg){                    
                    var json = JSON.parse(msg);
                    if (json.response=="SUKSES"){
                        displayUpdate(el);
                        status_crud = "";                        
                        
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 500) {
                        alert('Internal error: ' + jqXHR.responseText);
                    } else {
                        alert('Unexpected error.');
                    }
                }
            }); 
        }

        function displayUpdate(el){              
             $(el).each(function(i,obj){
                 var elchild = $(obj).children();                 
                 $(elchild).each(function(j,objchl){
                    //var val = $(objchl).text();
                    if (j>col_no && j<col_biaya){
                        if (j==col_out || j==col_time){
                            var inputel = $(objchl).find("select");
                            var value = $(inputel).children("option:selected").text();                            
                            console.log(inputel);
                            console.log(value);
                            $(objchl).text(value);
                        }else{
                            var inputel = $(objchl).find("input");
                            var value = $(inputel).val();
                            $(objchl).text(value);
                        }
                    }else if (j==col_biaya){
                        var inputel = $(objchl).find("input");
                        var value = $(inputel).val();
                        if (value=="0"){
                            value = "-";
                        }
                        $(objchl).text(value);
                    }else if (j==col_act){
                        $(objchl).html('<a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="onEdit(this)">edit</a> | <a  class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="onDelete(this)">delete</a>');
                    }     
                 });
            });

            var boolean = isFormExit();
            if (boolean){
                $(".btn").attr("disabled",false);    
            }
        }

        function reSortNumber(cls){
            var el = $(cls);
            var number = 1;
            $(el).each(function(i,obj){                
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
                    if (j>col_no && j<col_act){
                        if (j==col_out){
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

        function back(){
             $.ajax({
                url: '<?php echo base_url() ?>index.php/skp/list_skp?back=true',
                dataType: 'html',
                success: function(data) {                    
                    $('.loadpage').html(data);
                }
            });    
        }

        function numericfunction(){            
            $(".numeric").keydown(function(event) {
        // Allow only backspace and delete
                if ( event.keyCode == 46 || event.keyCode == 8 ) {
                    // let it happen, don't do anything
                }
                else {
                    // Ensure that it is a number and stop the keypress
                    if (event.keyCode < 48 || event.keyCode > 57 ) {
                        event.preventDefault(); 
                    }   
                }
            });
        }

        function getArrData(el){
            var arr_data = [];
            $(el).each(function(i,obj){
                var elchild = $(obj).children();                
                var arr_child = [];
                $(elchild).each(function(j,objchl){                        
                    var newValue = "";
                    if ($(objchl).children()){
                        var inputel = $(objchl).find("input");
                        if ($(inputel).hasClass("form-control")){
                            newValue  = $(inputel).val();
                            arr_child.push(newValue);
                        }
                        if($(inputel).hasAttr('attr-id-keg')) {
                            newValue  = $(inputel).attr('attr-id-keg');
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
            return arr_data;
        }

        // function insertIds(type, val){
        //     if (type = "tupoksi"){
        //         if (m_ids_tupoksi.indexOf(val) === -1) {
        //             m_ids_tupoksi.push(val)
        //         }                
        //     }
        // }

        // function removeIds(type, val){
        //     if (type = "tupoksi"){
        //         m_ids_tupoksi.remove(val);                
        //     }
        // }

        function getIds(el, type){
            var ids = [];
            // var el_tr_tbl = $(el).parent().parent().parent();
            // console.log(el_tr_tbl);
            var el_tbody = $(el).parent().parent().parent();
            var el_tr = $(el_tbody).children();
            console.log(el_tr);
            if (type = "tupoksi"){                                
                $(el_tr).each(function(i,obj){                
                    var attr_type_kegiatan = $(obj).attr("type-kegiatan");
                    if (attr_type_kegiatan == "tupoksi"){
                        var id_kegiatan = $(obj).attr("id-kegiatan");
                        ids.push(id_kegiatan);
                    }                       
                });
            }
            console.log(ids);
            return ids;
        }

        function isExistIds(ids, val){
            var is_exist = false;                
            if (ids.includes(val)) {                    
                is_exist = true;
            }            
            return is_exist;
        }

        $.fn.hasAttr = function(name) {  
           return this.attr(name) !== undefined;
        };

        // Array.prototype.remove = function() {
        //     var what, a = arguments, L = a.length, ax;
        //     while (L && this.length) {
        //         what = a[--L];
        //         while ((ax = this.indexOf(what)) !== -1) {
        //             this.splice(ax, 1);
        //         }
        //     }
        //     return this;
        // };
    </script>
