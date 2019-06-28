                            
<table class="table table-striped table-bordered table-advance table-hover">
    <thead>
        <tr>
            <th>
                 NAMA STAFF
            </th>
            <th>
                 JABATAN
            </th>
            <th>
                <a class="btn btn-xs btn-primary" onclick="$('#tr_cari_<?php echo $data_kasi->NIP18 ?>').show()">
                    <i class="fa fa-plus"></i>
                     Tambah Staff 
                </a> 
            </th>
        </tr>
        <tr id="tr_cari_<?php echo $data_kasi->NIP18 ?>" style="display: none">
            <td colspan="3">
                <div class="form-group">
                    <label class="control-label col-md-2" >Cari Pegawai :</label>
                    <div class="col-md-4">
                        <input class="form-control" placeholder="Ketik NRK atau NIP PEGAWAI" type="text" id='str_cari_<?php echo $data_kasi->NIP18 ?>' value=""></input>
                        
                    </div>
                    
                    <div class="col-md-2">
                        <a class="btn btn-sm btn-primary" onclick="cari_pegawai($('#str_cari_<?php echo $data_kasi->NIP18 ?>').val(),'<?php echo $data_kasi->NIP18 ?>','div_tabel_<?php echo $data_kasi->NIP18 ?>','<?php echo $data_kasi->SPMU ?>')">
                            <i class="fa fa-search"></i>
                            Cari
                        </a>  
                    </div>
                </div>  
                        
                <div class="col-md-12" id="div_tabel_<?php echo $data_kasi->NIP18 ?>"></div>      
                          
            </td>
        </tr>
    </thead>
    <tbody>
       
        <?php foreach ($staff as $staff) { ?>
        <tr id="staff_staff_<?php echo $staff->NIP18 ?>">
            <td >
                 <b><?php echo $staff->NAMA ?></b><br>
                 <?php echo $staff->NIP18 ?>
            </td>
            <td>
                 <?php echo $staff->JABATAN ?>
            </td>
            <td>
                <a class="btn btn-danger btn-xs black"  onclick="confirm('Anda yakin menghapus data pegawai tersebut?') ? hapus_staff_from_kasi('<?php echo $staff->NIP18 ?>','<?php echo $data_kasi->NIP18 ?>','<?php echo $data_kasi->SPMU ?>','<?php echo $data_kasi->KOLOK ?>') : ''"><i class="fa fa-trash-o"></i> 
                    Delete
                </a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    function cari_pegawai(str_cari_pegawai,nip_kasi,div_tabel_kasi,spmu_kasi){
        // alert(str_cari_pegawai+' : '+nip_kasi+' : '+div_tabel_kasi+' : '+spmu_kasi);

        var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 
        // alert(spinner);
        $.ajax({
            url : "<?php echo site_url('index.php/Setting_struktur/cari_pegawai')?>",
            type: "POST",
            data: {nip_kasi:nip_kasi,spmu_kasi:spmu_kasi,str_cari_pegawai:str_cari_pegawai},
            dataType: "JSON",
            beforeSend: function() {
                $('#'+div_tabel_kasi).html(spinner);
            },
            success: function(data)
            {
                $('#'+div_tabel_kasi).html('');
                // location.reload(); 
                // alert(data.response);
                if(data.response=='SUKSES'){
                    // alert(data.result);
                    $('#'+div_tabel_kasi).html(data.result);
                }                    
               
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $('#'+div_tabel_kasi).html('');
                // swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});
            },
            complete: function() {                            

            }
        });
    }


    function hapus_staff_from_kasi(nip,nip_kasi,spmu_kasi,kolok_kasi){
        $.ajax({
            url : "<?php echo site_url('index.php/Setting_struktur/hapus_staff_from_kasi')?>",
            type: "POST",
            data: {nip:nip},
            dataType: "JSON",
            beforeSend: function() {
                
            },
            success: function(data)
            {
                // location.reload();   
                // tampil_kasi(nip_kabid,'td_kabid_'+nip_kabid,spmu_kabid,kolok_kabid);
                tampil_staff(nip_kasi,'td_kasi_'+nip_kasi,spmu_kasi);                    
               
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
