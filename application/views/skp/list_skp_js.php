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
    <script type="text/javascript">      
        $(document).ready(function() {  
            $(".btn-tambah").click(function(){     
                errorElementClear()
                $('#modal').modal('toggle');
                $("#modal_content input").val("");
                $("modal_content textarea").val("");
            });
            
            var table = $('#listskp').DataTable({
                 "processing": true,
                "serverSide": true,
                "ajax": "<?php echo base_url()?>index.php/skp/ajax_list_skp"
            });

             var table = $('#listskpapproval').DataTable({
                 "processing": true,
                "serverSide": true,
                "ajax": "<?php echo base_url()?>index.php/skp/ajax_list_skp_approval"
            });



            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

            $(".btn_save").click(function(){                    
                var stardate = $(".start").val();                
                var enddate = $(".end").val();
                errorElementClear();
                if (stardate==""){
                    errorElement("start", "tidak boleh kosong");                
                }
                if (enddate==""){
                    errorElement("end", "tidak boleh kosong");                
                }                
                var desc = $(".kegiatan").val();                                
                $.ajax({
                    type: "POST",
                    data: {startdate: stardate, enddate: enddate, desc: desc, id: m_id},
                    url: "<?php echo base_url(); ?>index.php/skp/save_skp",
                    success: function(msg){                                                                                
                        var json = JSON.parse(msg);
                        if (json.response=="SUKSES"){                        
                            m_id = "";
                            $('#listskp').DataTable().ajax.reload();
                            $('#modal').modal('toggle');            
                        }else if (json.response=="ERROR"){
                            errorElement("periode", json.description);
                        }
                    }
                }); 
            });
        });

        function onDetail(id){
            $.ajax({
                url: '<?php echo base_url() ?>index.php/skp/form_skp?id=' + id + "&type=mine",
                dataType: 'html',
                success: function(data) {                    
                    $('.loadpage').html(data);
                }
            });                      
        }

        function onDetailApproval(id){
            $.ajax({
                url: '<?php echo base_url() ?>index.php/skp/form_skp?id=' + id + "&type=approval",
                dataType: 'html',
                success: function(data) {                    
                    $('.loadpage').html(data);
                }
            });          
        }

        var m_id = "";
        function onEditSkp(id){
            $.ajax({
                type: "GET",                    
                url: "<?php echo base_url(); ?>index.php/skp/edit_skp?id=" + id,
                success: function(msg){ 
                    var json = JSON.parse(msg);                    
                    if (json.response=="SUKSES"){
                        m_id = json.data.id;
                        var stardate = json.data.startdate.replace(/-/g, "/");                        
                        var enddate = json.data.enddate.replace(/-/g, "/");                        
                        var stardate = getMonthByString(stardate);
                        var enddate = getMonthByString(enddate);
                        $(".start").val(stardate);
                        $(".end").val(enddate);
                        $(".kegiatan").val(json.data.description);
                        $('#modal').modal('toggle');            
                    }
                }
            }); 
        }

        function onDeleteSkp(id){            
            if (!confirm('Are you sure?')){                
                return;
            }
            $.ajax({
                type: "GET",                    
                url: "<?php echo base_url(); ?>index.php/skp/delete_skp_header?id=" + id,
                success: function(msg){ 
                    var json = JSON.parse(msg);                    
                    if (json.response=="SUKSES"){                        
                        $('#listskp').DataTable().ajax.reload();                                
                    }
                }
            }); 
        }

        function getMonthByString(month){
            var arr_month = month.split("/");
            console.log(arr_month[1]);
            var month = "01";
            if (arr_month[1]=="JAN"){
                month = "01";
            }else if (arr_month[1]=="FEB"){
                month = "02";
            }else if (arr_month[1]=="MAR"){
                month = "03";
            }else if (arr_month[1]=="APR"){
                month = "04";
            }else if (arr_month[1]=="MAY"){
                month = "05";
            }else if (arr_month[1]=="JUN"){
                month = "06";
            }else if (arr_month[1]=="JUl"){
                month = "07";
            }else if (arr_month[1]=="AUG"){
                month = "08";
            }else if (arr_month[1]=="SEP"){
                month = "09";
            }else if (arr_month[1]=="OCT"){
                month = "10";
            }else if (arr_month[1]=="NOV"){
                month = "11";
            }else if (arr_month[1]=="DEC"){
                month = "12";
            }
            var dtreturn = arr_month[0]+"/"+ month + "/" + arr_month[2];
            
            return dtreturn;
        }

        function errorElementClear(){            
           var el = $(".error").remove();
        }   

        function errorElement(element, desc){ 
            var el = $(".l"+element);            
            $("<div class='error'>"+ element + " " + desc +"</div>").insertBefore($(el));
        }
        
      
    </script>