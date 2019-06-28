<table class="table table-striped table-bordered table-advance table-hover" id="table_pegawai_kasi_<?php echo $data_kasi2->NIP18 ?>"">
    <thead>
        <tr>
            <th class="hidden-xs">NRK</th>
            <th>NIP</th>
            <th>NAMA</th>
            <th>JABATAN</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pegawai as $pegawai) { ?>
        <tr>
            <td class="hidden-xs">
                <?php echo $pegawai->NRK ?>
            </td>
                                                <td >
                <?php echo $pegawai->NIP18 ?>
            </td>
            <td >
                 <?php echo $pegawai->NAMA ?>
            </td>
            <td>
                 <?php echo $pegawai->JABATAN ?>
            </td>
            <td>
            <a  class="btn btn-info btn-xs black" onclick="pilih_pegawai_from_kasi('<?php echo $data_kasi2->NIP18 ?>','<?php echo $data_kasi2->KOLOK ?>','<?php echo $data_kasi2->KOJAB ?>','<?php echo $data_kasi2->NRK ?>','<?php echo $pegawai->NIP18 ?>','<?php echo $pegawai->KOLOK_EXIST ?>','<?php echo $pegawai->KOJAB_EXIST ?>','<?php echo $pegawai->NRK ?>','<?php echo $pegawai->SPMU ?>','<?php echo $data_kasi2->SPMU ?>','table_pegawai_kasi_<?php echo $data_kasi2->NIP18 ?>')"><i class="fa fa-check"></i> Pilih </a>
                
                
                
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>


<script type="text/javascript">
    function pilih_pegawai_from_kasi(nip_kepala,kolok_kepala,kojab_kepala,nrk_kepala,nip18_staff,kolok_staff,kojab_staff,nrk_staff,spmu_staff,spmu_kepala,table_pegawai_kasi){
        // alert('td_kasi_'+nip_kepala);
        var spinner = '<div class="sk-spinner sk-spinner-three-bounce animated fadeInDown"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div><div class="sk-bounce4"></div><div class="sk-bounce5"></div><div class="sk-bounce6"></div><div class="sk-bounce7"></div></div>'; 
        $.ajax({
            url : "<?php echo site_url('index.php/Setting_struktur/pilih_pegawai_from_kasi')?>",
            type: "POST",
            data: {nip_kepala:nip_kepala,kolok_kepala:kolok_kepala,kojab_kepala:kojab_kepala ,nrk_kepala:nrk_kepala,nip18_staff:nip18_staff,kolok_staff:kolok_staff,kojab_staff:kojab_staff,nrk_staff:nrk_staff,spmu_kepala:spmu_kepala,spmu_staff:spmu_staff},
            dataType: "JSON",
            beforeSend: function() {
                $('#'+table_pegawai_kasi).html(spinner);
            },
            success: function(data)
            {
                // location.reload(); 
                $('#'+table_pegawai_kasi).html('');   
                // cari_pegawai(str_cari_pegawai,nip_kepala,div_tabel_kasi,spmu_kasi)  
                tampil_staff(nip_kepala,'td_kasi_'+nip_kepala,spmu_kepala)                
               
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                // $('#'+table_pegawai_kasi).html('');
                swal({type:"warning",title:"GAGAL", text:"KONEKSI TIDAK STABIL"});

                // tampil_staff(nip_kepala,'td_kasi_'+nip_kepala,spmu_kepala) 
            },
            complete: function() {                            

            }
        });
    }

    
</script>
                            

