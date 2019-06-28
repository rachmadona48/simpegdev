<?php
$bulan = $this->input->get('bulan')? $this->input->get('bulan') : date('M');

$tahun = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
$tgl = $this->input->get('bulan') ? $this->input->get('bulan') . " " . $this->input->get('tahun') : date('M Y');

$thbl = date('Ym');

?>

<style type="text/css">
    .show-grid [class^="col-"] {
        background-color: none !important;
        /*border: 1px solid #ddd;*/
        padding-bottom: 0px;
        padding: 0px !important;
    }
    
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
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Rekap Absensi</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php">Home</a>
            </li>
            <li class="active">
                <strong>Rekap Absensi</strong>
            </li>
        </ol>
         <small><i>(Menu untuk menampilkan Rekap Absensi)</i></small>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="row animated fadeInRight">
        <div class="col-md-12">
            <div class="col-md-12">
                <form class="form-inline">
                    <div class="row show-grid">
                        <div class="clearfix visible-xs"></div>
                        <div class="col-xs-10 col-sm-3" style="background-color: rgba(255,255,255,0.0) !important;">
                            <div class="form-group">
                                <!-- <label class="font-noraml col-md-2">Pilih Periode</label> -->
                                <div id="data_4" class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" readonly="true" style="cursor: pointer" class="form-control" id="monthyear" value="<?php echo $tgl; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-2 col-sm-1" style="background-color: rgba(255,255,255,0.0) !important;">
                            <div class="form-group" style="margin-left: -15px;margin-top:2px;z-index:999999;display: block; position: relative">
                                <button class="btn btn-sm btn-primary" id="go">Go !</button>
                            </div>
                        </div>
                        <div class="col-xs-2 col-sm-1" style="background-color: rgba(255,255,255,0.0) !important;">
                            <div class="form-group" style="margin-left: -15px;margin-top:2px;z-index:999999;display: block; position: relative">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="m-r-md inline"></div>
            <div class="clearfix"></div>
            

            <div class="col-md-12">
                <!-- <br>
                <br>
                    <button class="btn btn-sm btn-success pull-right" style="margin-left:10px" onclick="return setMonthYear1('<?php echo $token ?>','<?php echo $nrk ?>')">Lihat absensi bawahan</button> -->

                <div class="row"></div>
                <div id="content_utama">

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Mainly scripts -->
<!-- <script src="../../js/jquery-2.1.1.js"></script>     -->
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
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/dataTables/dataTables.tableTools.min.js"></script>

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
    
        $(document).ready(function() {
            var today = new Date();
            var dd = today.getDate();
            var mm = ("0" + (today.getMonth() + 1)).slice(-2);
            var yyyy = today.getFullYear();

            $('#data_4.input-group.date').datepicker({
                changeyear: false,
                minViewMode: 1,
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                todayHighlight: true,
                format: 'M yyyy'
            }).on("input change", function(e) {

            });
            
            rekap_absensi_detail();

        });


        function isNumberKey(evt, obj) {

            var charCode = (evt.which) ? evt.which : event.keyCode
            var value = obj.value;
            var dotcontains = value.indexOf(".") != -1;
            if (dotcontains)
                if (charCode == 46)
                    return false;
            if (charCode == 46)
                return true;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        function converBulan(bulan) {
            if (bulan == 'Jan') {
                return '01';
            } else if (bulan == 'Feb') {
                return '02';
            } else if (bulan == 'Mar') {
                return '03';
            } else if (bulan == 'Apr') {
                return '04';
            } else if (bulan == 'May') {
                return '05';
            } else if (bulan == 'Jun') {
                return '06';
            } else if (bulan == 'Jul') {
                return '07';
            } else if (bulan == 'Aug') {
                return '08';
            } else if (bulan == 'Sep') {
                return '09';
            } else if (bulan == 'Oct') {
                return '10';
            } else if (bulan == 'Nov') {
                return '11';
            } else if (bulan == 'Dec') {
                return '12';
            }
        }
        
         //FIRST LOAD
//        setTimeout(function()
//        {
//            
//            rekap_absensi_detail(a);
//        }, 50);
        
        //FIRST LOAD
        
//        function setMonthYear() {
//            var b = $("#monthyear").val();
//            var dt = b.split(" ");
//            var m = dt[0];
//            var y = dt[1];
//            var a = "?bulan=" + m + "&tahun=" + y;
//            
//            rekap_absensi_detail(a);
//
//        }

        $('#go').click(function(e){
            e.preventDefault();
            e.stopPropagation();
            
            var b = $("#monthyear").val();
            var dt = b.split(" ");
            var m = dt[0];
            var y = dt[1];
            var a = "?bulan=" + m + "&tahun=" + y;
            
            //alert("Errwwwiinnn")
            
            $.ajax({
                type:'GET',
                url: "<?php echo base_url(); ?>rekap_absensi/rekap_absensi_detail"+a,
                success:function(msg){
                 $("#content_utama").html(msg);
                },
                error: function(result)
                {
                   $("#content_utama").html("Error"); 
                },
                fail:(function(status) {
                   $("#content_utama").html("Fail");
                }),
                beforeSend:function(d){
                 $('#content_utama').html('<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>');
                }

               });
        });

        function rekap_absensi_detail() {
            var b = $("#monthyear").val();
            var dt = b.split(" ");
            var m = dt[0];
            var y = dt[1];
            var a = "?bulan=" + m + "&tahun=" + y;
            
            //alert("Helllo - rekap_absensi/rekap_absensi_detail"+a);
            
            
            $.ajax({
                type:'GET',
                url: "<?php echo base_url(); ?>rekap_absensi/rekap_absensi_detail",
                success:function(msg){
                 $("#content_utama").html(msg);
                },
                error: function(result)
                {
                   $("#content_utama").html("Error"); 
                },
                fail:(function(status) {
                   $("#content_utama").html("Fail");
                }),
                beforeSend:function(d){
                 $('#content_utama').html('<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>');
                }

               }); 
        }



</script>