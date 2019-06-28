<table id="tbl_skp" class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2" width="40%">III. KEGIATAN TUGAS JABATAN</th>
            <th width="5%" rowspan="2">AK</th>                                             
            <th colspan="7">TARGET</th>
        </tr>
        <tr class="gradeX">
            <th colspan="2" width="10%">KUANT/OUTPUT</th>
            <th width="5%">KUAL/MUTU</th>
            <th colspan="2">Waktu</th>
            <th width="7%">Biaya</th>            
        </tr>
    </thead>
    <tbody class="contains-body">
        <?php if (count($skp)> 0) { ?>
            <?php foreach ($skp as $key => $value) { ?>
                <tr class="gradeX" id="row-<?php echo $value->id ?>">
                    <td class="center no"><?php echo $key+1 ?></td>
                    <td><?php echo $value->kegiatan ?></td>
                    <td><?php echo $value->ak ?></td>
                    <td width="5%" class="center"><?php echo $value->quantityshow ?></td>
                    <td width="10%"><?php echo $value->outputshow ?></td> 
                    <td><?php echo $value->qualityshow ?></td>
                    <td style="width:7%"><?php echo $value->total_monthshow ?></td>
                    <td width="5%">bulan</td>
                    <td><?php echo $value->biayashow ?></td>                    
                </tr>
            <?php } ?>
        <?php } ?>
        
    </tbody>
</table>