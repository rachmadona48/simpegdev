<?php ?>

<div class="animated fadeInRight">


    <div class="ibox float-e-margins">
        <div class="">
            <div class="row">
                <div class="col-sm-12 b-r">
                    <?php if ($isStaff == 1) { ?>
                        <button class='btn btn-sm btn-primary pull-right' style="margin-left:10px" onclick="return showCapaianBawahan('<?php echo $token; ?>', '<?php echo $nrk; ?>');">Lihat Capaian Bawahan</button>&nbsp;&nbsp;
                    <?php } ?>
                    <!--CEK ATASAN-->
                    <?php
                    if (isset($ra)) {
                        $nrkAtasan = $ra->nrk_atasan;
                    } else {
                        $nrkAtasan = $user_id;
                    }
                    ?>
                    <?php if ($user_id != $user_id) { ?>
                        <?php if ($nrkAtasan == $user_id) { ?>
                            <button class='btn btn-sm btn-danger pull-right' onclick="return showCapaianBawahan('<?php echo $nrkAtasan; ?>');">Kembali</button> &nbsp;&nbsp;
                        <?php } else { ?>
                            <button class='btn btn-sm btn-danger pull-right' onclick="return showCapaianBawahan('<?php echo $nrkAtasan; ?>');">Kembali</button> &nbsp;&nbsp;
                        <?php } ?>
                    <?php } ?>
                    <!--CEK ATASAN-->

                </div>
            </div>
        </div>
    </div>
    <?php //}   ?>

    <div class="ibox float-e-margins">
        <!-- <div class="ibox-title navy-bg">
            <h5>Profile Anda bulan <?php //echo $days[$bln]." ".$tahun         ?></h5>
            <div class="ibox-tools">
            </div>
        </div> -->
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-12 b-r">
                    <?php echo $profile; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="ibox float-e-margins">
        <div class="ibox-title navy-bg">
            <?php if (empty($_GET['nrk'])) { ?>
                <h5>Pencapaian Akifitas Anda bulan <?php echo $days[$bln] . " " . $tahun ?></h5>
            <?php } else { ?>
                <h5>Pencapaian Akifitas Bawahan Anda <?php echo $nama; ?> bulan <?php echo $days[$bln] . " " . $tahun ?></h5>
            <?php } ?>
            <div class="ibox-tools">
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-12 b-r">
                    <div class="table-responsivex">
                        <table id="table_kpi" class="table table-striped table-bordered table-hover dataTables-exampless table_kpi" width="100%">
                            <?php if ($jumlahAktifitas > 0) { ?>
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal</th>
                                        <th>Laporan</th>
                                        <th>Status</th>
                                        <th>Waktu Efektif</th>
                                        <th>Volume</th>
                                        <th>Capaian</th>
                                    </tr>
                                </thead>
                            <?php } ?>
                            <tbody>
                                <?php
                                $no = 1;

                                if ($jumlahAktifitas < 1) {
                                    echo '<tr>
                                            <td colspan="7" align="center"><i class="fa fa-warning"> Anda belum menginputkan aktifitas dibulan ' . $days[$bln] . ' ' . $tahun . '</i></td>
                                          </tr>';
                                }

                                $capaian = 0;
                                $totalcapaian = 0;
                                $input = 0;
                                $totalInput = 0;
                                foreach ($Aktifitas as $rows) {

                                    $tanggal_aktf = date('d M Y', strtotime($rows->tanggal));
                                    $waktu = floatval($rows->waktu);
                                    $volume = floatval($rows->volume);

                                    if ($rows->status == 'valid') {
                                        $status = '<span class="label label-success">Valid</span>';
                                        $capaian = $waktu * $volume;
                                    } elseif ($rows->status == 'invalid') {
                                        if (strpos($rows->note, 'Invalid') !== false) {
                                            $status = '<span class="label label-danger">Tidak Valid (By System)</span>';
                                        } else {
                                            $status = '<span class="label label-danger">Tidak Valid (By Atasan)</span>';
                                        }

                                        $capaian = 0;
                                    } elseif ($rows->status == null) {
                                        $status = '<span class="label label-warning">Belum Validasi</span>';
                                        $capaian = 0;
                                    } else {
                                        $status = '<span class="label label-danger">Tidak Valid</span>';
                                        $capaian = 0;
                                    }
                                    $input = $waktu * $volume;
                                    $totalInput = $totalInput + $input;
                                    $totalcapaian = $totalcapaian + $capaian;

                                    echo '<tr>
                                            <td width="4">' . $no . '.</td>
                                            <td width="14%" align="center">' . $tanggal_aktf . '</td>
                                            <td width="60%">' . $rows->keterangan . ' <br/>' . $rows->jam_mulai . ':' . $rows->menit_mulai . "  - " . $rows->jam_selesai . ':' . $rows->menit_selesai . '</td>
                                            <td width="8%" align="center">' . $status . '</td>
                                            <td width="8%" align="center">' . $waktu . '</td>
                                            <td width="8%" align="center"><span>' . $volume . '</span></td>
                                            <td width="8%" align="center">' . $capaian . '</td>
                                          </tr>';

                                    $no++;
                                }

                                if (($no - 1) == $jumlahAktifitas && ($no - 1) > 0) {
                                    $totaltext = '<tr>
                                                    <td colspan="6" align="center"><b>TOTAL CAPAIAN WAKTU EFEKTIF</b></td>
                                                    <td colspan="1" align="center"><b>' . number_format($totalcapaian, 0, ",", ".") . '</b></td>
                                                </tr>';
                                } else {
                                    $totaltext = '<tr>
                                                    <td colspan="6" align="center"><b>TOTAL CAPAIAN WAKTU EFEKTIF</b></td>
                                                    <td colspan="1" align="center"><b>0</b></td>
                                                </tr>';
                                }
                                ?>

                            </tbody>
                            <tfoot>
                                <?php echo $totaltext; ?>
                                <tr>
                                    <td colspan="6" align="center"><b>TOTAL INPUT WAKTU EFEKTIF</b></td>
                                    <td colspan="1" align="center"><b><?php echo number_format($totalInput, 0, ",", ".") ?></b></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="ibox float-e-margins" id="dataAbsensi">
        <div class="ibox-title navy-bg">
            <h5>Penambahan Capaian Waktu Efektif</h5>
            <div class="ibox-tools">
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-8 b-r">
                    <?php echo $absensi['capaianefektiftabel']; ?>
                </div>
                <div class="col-sm-4 b-r">
                    <div class="alert alert-success" role="alert">
                        <a class="alert-link">
                            <table class="" border="0" width="100%">
                                <tr>
                                    <td align="left" >TOTAL CAPAIAN WAKTU EFEKTIF : </td>

                                </tr>
                                <tr>
                                    <td align="center" >
                                        <h2>
                                            <b>
                                                <?php
                                                $totalcapaianall = $totalcapaian + $absensi['capaianefektif'];
                                                echo "= " . number_format($totalcapaian, 0, ",", ".");
                                                ?> + <?php echo number_format($absensi['capaianefektif'], 0, ",", ".");
                                                ?>
                                            </b>
                                        </h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" ><h2><b><?php echo "= " . number_format($totalcapaianall, 0, ",", "."); ?></b></h2></td>
                                </tr>
                            </table>
                        </a>
                    </div>
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
                                $('#table_kpi').dataTable({
                                    retrieve: true,
                                    responsive: true
                                            // "scrollX": true
                                });
                            });
</script>


