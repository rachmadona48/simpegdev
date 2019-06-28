<style type="text/css">
    .ibox-tools {
        margin-top: -8px !important;
    }

    .table_kpi{
        width: 100%;
        display: block;
        overflow-x: auto;
    }

    .table_kpi thead tr th, .table_kpi tbody tr td{
        border-right: 1px solid rgba(0,0,0,0.15);
        border-top: 1px solid rgba(0,0,0,0.15);
    }

    .table > tbody > tr > td {
        vertical-align: middle !important;
    }

    .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
        border: 1px solid rgba(0,0,0,0.15) !important;
    }

    .table>tbody>tr:hover {
        background-color: rgba(0,0,0,0.10) !important;
    }

</style>

<?php
//$query = "SELECT * FROM etkd WHERE userid = '" . $_SESSION['user_id'] . "' AND thbl ='" . $thbl . "'";
//$result_absen = @pg_query($con, $query);
//$jumlahAbsen = pg_num_rows($result_absen);
// echo $isStaff." & ".$groupUser; exit();



if ($isStaff == 1 && $groupUser == 4) {
    ?>
    <button class="btn btn-sm btn-success pull-right" style="margin-left:10px" onclick="">Lihat absensi bawahan</button>
<?php } ?>

<br>
<br>
<div class="ibox float-e-margins">
    <div class="ibox-title navy-bg">
        <h5>Rekapitulasi Absensi Anda dibulan <?php echo $days[$bln] . " " . $tahun ?></h5>
        <div class="ibox-tools">
        </div>
    </div>
    
    
    <div class="ibox-content">
        <?php if (isset($rows)){ ?>
        <div class="row">
            <div class="col-sm-6 b-r">
                <table class="table" width="100%" >

                    <thead>
                        <tr>
                            <td colspan="2" align="center"><b>Jenis Absensi</b></td>
                            <td><b>Jumlah</b></td>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td rowspan="5" valign="middle" width="35%">Kehadiran</td>
                            <td width="40%">Sakit</td>
                            <td width="25%"><?php
                                if ($rows->sakit == null) {
                                    echo '0';
                                } else {
                                    echo $rows->sakit;
                                }
                                ;
                                ?> hari</td>
                        </tr>
                        <tr>
                            <td>Alpa</td>
                            <td><?php
                                if ($rows->alpa == null) {
                                    echo '0';
                                } else {
                                    echo $rows->alpa;
                                }
                                ;
                                ?> hari</td>
                        </tr>
                        <tr>
                            <td>Ijin</td>
                            <td><?php
                                if ($rows->ijin == null) {
                                    echo '0';
                                } else {
                                    echo $rows->ijin;
                                }
                                ;
                                ?> hari</td>
                        </tr>
                        <tr>
                            <td>Terlambat</td>
                            <td><?php
                                if ($rows->late == null) {
                                    echo '0';
                                } else {
                                    echo $rows->late;
                                }
                                ;
                                ?> menit</td>
                        </tr>
                        <tr>
                            <td>Pulang Cepat</td>
                            <td><?php
                                if ($rows->early == null) {
                                    echo '0';
                                } else {
                                    echo $rows->early;
                                }
                                ;
                                ?> menit</td>
                        </tr>
                        <tr>
                            <td rowspan="3" valign="middle" width="35%">Dinas Luar</td>
                            <td width="40%">Dinas Luar Penuh</td>
                            <td width="25%"><?php
                                if ($rows->dlp == null) {
                                    echo '0';
                                } else {
                                    echo $rows->dlp;
                                }
                                ;
                                ?> hari</td>
                        </tr>
                        <tr>
                            <td>Dinas Luar Awal</td>
                            <td><?php
                                if ($rows->dlaw == null) {
                                    echo '0';
                                } else {
                                    echo $rows->dlaw;
                                }
                                ;
                                ?> hari</td>
                        </tr>
                        <tr>
                            <td>Dinas Luar Akhir</td>
                            <td><?php
                                if ($rows->dlak == null) {
                                    echo '0';
                                } else {
                                    echo $rows->dlak;
                                }
                                ;
                                ?> hari</td>
                        </tr>
                        <tr>
                            <td colspan="2">Perjalanan Dinas</td>
                            <td><?php
                                if ($rows->pd == null) {
                                    echo '0';
                                } else {
                                    echo $rows->pd;
                                }
                                ;
                                ?> hari</td>
                        </tr>
                        <tr>
                            <td colspan="2">Petugas Haji</td>
                            <td><?php
                                if ($rows->ph == null) {
                                    echo '0';
                                } else {
                                    echo $rows->ph;
                                }
                                ;
                                ?> hari</td>
                        </tr>
                        <tr>
                            <td colspan="2">DPP</td>
                            <td><?php
                                if ($rows->dpp == null) {
                                    echo '0';
                                } else {
                                    echo $rows->dpp;
                                }
                                ;
                                ?> hari</td>
                        </tr>
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
            <div class="col-sm-6 b-r">
                <table class="table" width="100%" >

                    <thead>
                        <tr>
                            <td colspan="2" align="center"><b>Jenis Absensi</b></td>
                            <td><b>Jumlah</b></td>
                        </tr>
                    </thead>

                    <tbody>


                        <tr>
                            <td rowspan="8" valign="middle" width="35%">Cuti</td>
                            <td width="40%">Cuti Tahunan</td>
                            <td width="25%"><?php
                                if ($rows->ct == null) {
                                    echo '0';
                                } else {
                                    echo $rows->ct;
                                }
                                ;
                                ?> hari</td>
                        </tr>
                        <tr>
                            <td>Cuti Persalinan Anak ke-1 & 2</td>
                            <td><?php
                                if ($rows->cbs == null) {
                                    echo '0';
                                } else {
                                    echo $rows->cbs;
                                }
                                ;
                                ?> hari</td>
                        </tr>
                        <tr>
                            <td>Cuti Persalinan Anak Ke-3</td>
                            <td><?php
                                if ($rows->cbs3 == null) {
                                    echo '0';
                                } else {
                                    echo $rows->cbs3;
                                }
                                ;
                                ?> hari</td>
                        </tr>
                        <tr>
                            <td>Cuti Sakit</td>
                            <td><?php
                                if ($rows->cs == null) {
                                    echo '0';
                                } else {
                                    echo $rows->cs;
                                }
                                ;
                                ?> hari</td>
                        </tr>
                        <tr>
                            <td>Cuti Alasan Penting < 6 hari</td>
                            <td><?php
                                if ($rows->cap == null) {
                                    echo '0';
                                } else {
                                    echo $rows->cap;
                                }
                                ;
                                ?> hari</td>
                        </tr>
                        <tr>
                            <td>Cuti Alasan Penting >= 6 hari</td>
                            <td><?php
                                if ($rows->cap5 == null) {
                                    echo '0';
                                } else {
                                    echo $rows->cap5;
                                }
                                ;
                                ?> hari</td>
                        </tr>
                        <tr>
                            <td>Cuti Pengganti Cuti Bersama</td>
                            <td><?php
                                if ($rows->cpcb == null) {
                                    echo '0';
                                } else {
                                    echo $rows->cpcb;
                                }
                                ;
                                ?> hari</td>
                        </tr>
                        <tr>
                            <td>Cuti Tunda</td>
                            <td><?php
                                if ($rows->ctu == null) {
                                    echo '0';
                                } else {
                                    echo $rows->ctu;
                                }
                                ;
                                ?> hari</td>
                        </tr>

                        <tr>
                            <td colspan="2">Diklat</td>
                            <td><?php
                                if ($rows->dk == null) {
                                    echo '0';
                                } else {
                                    echo $rows->dk;
                                }
                                ;
                                ?> hari</td>
                        </tr>
                        <tr>
                            <td colspan="2">Perjalanan Dinas</td>
                            <td><?php
                                if ($rows->pd == null) {
                                    echo '0';
                                } else {
                                    echo $rows->pd;
                                }
                                ;
                                ?> hari</td>
                        </tr>
                        <tr>
                            <td colspan="2">MPP</td>
                            <td><?php
                                if ($rows->mpp == null) {
                                    echo '0';
                                } else {
                                    echo $rows->mpp;
                                }
                                ;
                                ?> hari</td>
                        </tr>
                        <tr>
                            <td colspan="2">Izin Setengah Hari</td>
                            <td><?php
                                if ($rows->ijset == null) {
                                    echo '0';
                                } else {
                                    echo $rows->ijset;
                                };
                                ?> hari</td>
                        </tr>
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
        </div>
        <?php } else {
            echo '<div align = "center"><b>Data Absen Tidak Ditemukan, Silahkan Coba Bulan Lainnya!!<b></div>';
        } ?>
    </div>
    
    

</div>

<div class="clearfix"></div>
<div class="hr-line-dashed"></div>

<div class="ibox float-e-margins">
    <div class="ibox-title navy-bg">
        <h5>Transaksi Absensi Anda dibulan <?php echo $days[$bln] . " " . $tahun ?></h5>
        <div class="ibox-tools">
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-sm-12 b-r">
                <table class="table" width="100%" >
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>TANGGAL</th>
                            <th>SHIFT DATANG</th>
                            <th>SHIFT PULANG</th>
                            <th>JAM DATANG</th>
                            <th>LOKASI DATANG</th>
                            <th>JAM PULANG</th>
                            <th>LOKASI PULANG</th>
                            <th>TERLAMBAT</th>
                            <th>PULANG CEPAT</th>
                            <th>KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach($resultx as $rowx) {
                            $holiday = date('w', strtotime($rowx->date_shift));

                            if (intval($holiday) == 0 || intval($holiday) == 6) {
                                if ($rowx->keterangan == 'NWK') {
                                    echo "<tr style='background-color:rgba(255,0,0,0.15);'>";
                                    $keterangan = "LIBUR";
                                } else {
                                    echo "<tr>";
                                    $keterangan = $rowx->keterangan;
                                }
                            } else {
                                if ($rowx->keterangan == 'ALP') {
                                    echo "<tr>";
                                    $keterangan = "ALPA";
                                } elseif ($rowx->keterangan == 'NWK') {
                                    echo "<tr style='background-color:rgba(255,0,0,0.15);'>";
                                    $keterangan = "LIBUR";
                                } elseif ($rowx->keterangan == 'NWDS') {
                                    echo "<tr style='background-color:rgba(255,0,0,0.15);'>";
                                    $keterangan = "SHFT LIBUR";
                                } else {
                                    echo "<tr>";
                                    $keterangan = $rowx->keterangan;
                                }
                            }

                            if ($keterangan == "LIBUR") {
                                $telat = "";
                                $cepat = "";
                            } else {
                                $telat = gmdate('H:i:s', intval($rowx->late));
                                $cepat = gmdate('H:i:s', intval($rowx->early_departure));
                            }

                            echo "<td>" . $i . "</td>";
                            echo "<td align='center'>" . ($rowx->date_shift == "" ? "" : date('d-m-Y', strtotime($rowx->date_shift))) . "</td>";
                            // echo "<td align='center'>".($rowx->date_in == "" ? "" : date('d-m-Y',strtotime($rowx->date_in)))."</td>";
                            // echo "<td align='center'>".($rowx->date_out == "" ? "" : date('d-m-Y',strtotime($rowx->date_out)))."</td>";
                            echo "<td align='center'>" . $rowx->shift_in . "</td>";
                            echo "<td align='center'>" . $rowx->shift_out . "</td>";
                            echo "<td align='center'>" . $rowx->check_in . "</td>";
                            echo "<td>" . $rowx->lok_in . "</td>";
                            echo "<td align='center'>" . $rowx->check_out . "</td>";
                            echo "<td>" . $rowx->lok_out . "</td>";
                            echo "<td align='center'>" . $telat . "</td>";
                            echo "<td align='center'>" . $cepat . "</td>";
                            echo "<td>" . $keterangan . "</td>";
                            echo "</tr>";
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
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