<?php if($user_group == 1) { ?>
<style>
  #tdata th:nth-child(0),th:nth-child(1), th:nth-child(2), th:nth-child(3),th:nth-child(4),th:nth-child(5),th:nth-child(6),th:nth-child(7)
  {
    text-align:center !important;
  }

  a.btn-danger.dim {
    box-shadow: inset 0px 0px 0px #ea394c, 0px 5px 0px 0px #ea394c, 0px 10px 5px #999999;
  }



  [data-tooltip] {
      display: inline-block;
      position: relative;
   }
  /* Tooltip styling */
  [data-tooltip]:before {
      content: attr(data-tooltip);
      display: none;
      position: absolute;
      background: #000;
      color: #fff;
      padding: 4px 8px;
      font-size: 14px;
      line-height: 1.4;
      min-width: 100px;
      text-align: center;
      border-radius: 4px;
  }
  [data-tooltip-position="bottom"]:before {
      left: 50%;
      -ms-transform: translateX(-50%);
      -moz-transform: translateX(-50%);
      -webkit-transform: translateX(-50%);
      transform: translateX(-50%);
  }

  [data-tooltip-position="bottom"]:before {
      top: 100%;
      margin-top: 6px;
  }

  /* Tooltip arrow styling/placement */
  [data-tooltip]:after {
      content: '';
      display: none;
      position: absolute;
      width: 0;
      height: 0;
      border-color: transparent;
      border-style: solid;
  }
  /* Dynamic horizontal centering for the tooltip */
  [data-tooltip-position="bottom"]:after {
      left: 50%;
      margin-left: -6px;
  }
  /* Dynamic vertical centering for the tooltip */

  [data-tooltip-position="bottom"]:after {
      top: 100%;
      border-width: 0 6px 6px;
      border-bottom-color: #000;
  }

  /* Show the tooltip when hovering */
  [data-tooltip]:hover:before,
  [data-tooltip]:hover:after {
      display: block;
      z-index: 30;
  }

  .select2-container {
      box-sizing: border-box;
      display: inline-block;
      margin: 0;
      position: absolute;
      vertical-align: middle;
      z-index: 9999999 !important;
  }



</style>
 <link href="<?php echo base_url(); ?>assets/inspinia/css/bootstrap.min.css" rel="stylesheet">
 <link href="<?php echo base_url(); ?>assets/inspinia/css/animate.css" rel="stylesheet">
 <link href="<?php echo base_url(); ?>assets/inspinia/css/style.css" rel="stylesheet">
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
        <h2>Profile</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php">Home</a>
            </li>
            <li class="active">
                <strong>Profile</strong>
            </li>
        </ol>
         <small><i>(Menu untuk menampilkan profil dan riwayat pegawai)</i></small>
    </div>
    <div class="col-lg-2">
   &nbsp;
    </div>
</div>
          <div class="wrapper wrapper-content animated fadeInDown">
            <div class="ibox float-e-margins" style="margin-top: 10px">
              <div class="ibox-content">
                <div class="row">
                  <div class="col-md-12">
                

                      <span class="pull-right">
                        <!-- <a href="<?php //echo base_url(); ?>index.php/profile/toPdf" target="_blank" class="btn btn-outline btn-danger dim">
                          <i class="fa fa-save"></i> PDF
                        </a> -->
                         <button class="btn btn-outline btn-warning " onclick="onclickbutton()"><i class="fa fa-edit"></i> Ubah Data Profil</button>
                        <a href="<?php echo base_url(); ?>index.php/profile/drh" target="_blank" class="btn btn-outline btn-danger dim">
                          <i class="fa fa-save"></i> PDF
                        </a>
                      </span>

                        <?php 
                        // var_dump($infoUser);exit;
                        if(isset($infoUser->NRK))
                        {
                            $linkImg = "assets/img/photo/".$infoUser->NRK.".jpg";

                            $nrk = $infoUser->NRK;    
                            $nip18 = $infoUser->NIP18;
                            $titel = $infoUser->TITEL;
                            $titeldepan = $infoUser->TITELDEPAN;
                            $pathir = $infoUser->PATHIR;
                            $talhir = $infoUser->TLHR;
                            $nama = $infoUser->NAMA_ABS;
                            $name=trim($nama,'');
                            $stapeg = $infoUser->STATUS_PEGAWAI;
                            $najabl = $infoUser->NAJABL;
                            $_SESSION['logged_in']['najabl'] = $najabl;
                            $_SESSION['logged_in']['kojab'] = $infoUser->KOJAB;
                            $nalokl = $infoUser->NALOKL;
                            $naklogad = $infoUser->NAKLOGAD;
                            $kd = $infoUser->KD;
                            $gol = $infoUser->GOL;
                            $napang =$infoUser->NAPANG;

                            if($kd == 'S')
                            {
                                if($infoUser->NESELON2 == "NON ESELON")
                                {
                                    $eselon = "NON ESELON";
                                }
                                else
                                {
                                    $eselon = "ESELON ".$infoUser->NESELON2;
                                }
                                
                            }
                            else
                            {
                                $eselon = "NON ESELON";
                            }

                            $img_small="";                  
                            if(file_exists($linkImg)){
                              $img = base_url()."assets/img/photo/".$infoUser->NRK.".jpg";      
                              $img_small = base_url()."assets/img/photo/".$infoUser->NRK."_thumb.jpg";                              
                            }else{
                              $img = base_url()."assets/img/photo/profile_small.jpg";
                              $img_small = base_url()."assets/img/photo/profile_getProfile.jpg";
                            }
                        }
                        $notelp="";$nohp="";$email="";$alamat="";$rt="";$rw="";$nawil="";$nacam="";$nakel="";$prop="";$email="";
                        if(isset($infoUser3->NRK))
                        {
                            $nohp=$infoUser3->NOHP;
                            $notelp=$infoUser3->NOTELP;
                            $alamat=$infoUser3->ALAMAT;
                            $rt=$infoUser3->RT;
                            $rw=$infoUser3->RW;
                            $nawil=$infoUser3->NAWIL;
                            $nacam=$infoUser3->NACAM;
                            $nakel=$infoUser3->NAKEL;
                            $prop=$infoUser3->PROPINSI;
                            $email=$infoUser3->EMAIL;
                        }
                         ?>

                        <div class="profile-image">
                            <a href="<?php echo $img; ?>" data-gallery="">
                              <img src="<?php echo $img_small;  ?>" class="img-circle circle-border m-b-md" alt="profile">
                            </a>    
                            <!-- The Gallery as lightbox dialog, should be a child element of the document body -->
                            <div id="blueimp-gallery" class="blueimp-gallery">
                                <div class="slides"></div>
                                <h3 class="title"></h3>
                                <a class="prev">‹</a>
                                <a class="next">›</a>
                                <a class="close">×</a>
                                <a class="play-pause"></a>
                                <ol class="indicator"></ol>
                            </div>  
                        </div>
                        <div class="profile-info">
                            <div class="">
                                <div>
                                    <h3 class="no-margins">
                                      <?php 
                                      if($titel == null && $titeldepan == null)
                                      {
                                        echo "<td style='width:700px'>".$name."</td>";
                                      }
                                      else if($titel == null && $titeldepan != null)
                                      {
                                        echo "<td style='width:700px'>".$titeldepan.' '.$name."</td>";
                                      }
                                      else if($titel !=null && $titeldepan == null)
                                      {
                                      	if(substr($titel,0,1)==',')
                                      	{
                                      		echo "<td style='width:700px'>".$name.$titel."</td>";
                                      	}
                                      	else
                                      	{
                                      		echo "<td style='width:700px'>".$name.', '.$titel."</td>";
                                      	}
                                        
                                      }
                                      else
                                      {
                                      	if(substr($titel,0,1)==',')
                                      	{
                                      		echo "<td style='width:700px'>".$titeldepan.' '.$name.$titel."</td>";
                                      	}
                                      	else
                                      	{
                                      		//echo "<td style='width:700px'>".$name.', '.$titel."</td>";
                                      		echo "<td style='width:700px'>".$titeldepan.' '.$name.', '.$titel."</td>";
                                      	}
                                        //echo "<td style='width:700px'>".$titeldepan.' '.$name.$titel."</td>";
                                      }
                                      ?>
                                    </h3>
                                    <br/>
                                    <div class="col-md-6">
                                      <address style="font-size:11px;">
                                      	<span data-tooltip="NRK - NIP" data-tooltip-position="bottom">
											                     <p><i class="fa fa-credit-card"></i>&nbsp; <?php echo "<strong><span class=\"text-success\"> $nrk - $nip18 </span></strong>"; ?></p>
                  									  	</span>
                  									  	<br/>

                                      	<span data-tooltip="Tempat Tanggal Lahir" data-tooltip-position="bottom">
                                      		<p> <i class="fa fa-birthday-cake"></i> &nbsp; <?php echo "<strong><span class=\"text-danger\">$pathir, $talhir </span></strong>"; ?></p>
                                      	</span>
                                      	<br/>
                                      
                                      	<!-- <span data-tooltip="Status Pegawai" data-tooltip-position="bottom">
                                      		<p><i class="fa fa-ioxhost"></i>&nbsp; <?php echo "<strong><span class=\"text-primary\">$stapeg </span></strong>"; ?></p>
                                      	</span>
                                      	<br/> -->

                                        <span data-tooltip="Status Pegawai / Kode Jabatan / Eselon / Pangkat (Gol)" data-tooltip-position="bottom">
                                        <p><i class="fa fa-ioxhost"></i>&nbsp; <?php echo "<strong><span class=\"text-primary\">$stapeg / $kd / $eselon / $napang ($gol) </span></strong>"; ?></p>
                                        </span>
                                        <br/>

                                      	<span data-tooltip="Lokasi Kerja" data-tooltip-position="bottom">
                                      		<p><i class="fa fa-map-marker"></i>&nbsp; <?php echo "<strong><span class=\"text-info\">$nalokl</span></strong>"; ?></p>
                                      	</span>
                                      	<br/>

                                      	<span data-tooltip="Jabatan" data-tooltip-position="bottom">
                                       		<p><i class="fa fa-line-chart"></i>&nbsp; <?php echo "<strong><span class=\"text-warning\">$najabl</span></strong>"; ?></p>
                                       	</span>
                                      	<br/>

                                      	<span data-tooltip="Lokasi Gaji" data-tooltip-position="bottom">
		                                   <p><i class="fa fa-money"></i>&nbsp; <?php echo "<strong><span class=\"text-navy\">$naklogad</span></strong>"; ?></p>
		                                </span>
		                                <br/>
                                      </address>
                                    </div>
                                    <div class="col-md-6">

                                      <address style="font-size:10px;">
                                      <br/>

                                      	<span data-tooltip="No. Telp" data-tooltip-position="bottom">
                                      		<p><i class="fa fa-phone"></i>&nbsp; <?php echo "<strong><span class=\"text-success\">$notelp</span></strong>"; ?></p>
                                      	</span><br/>

                                      	<span data-tooltip="No. Ponsel" data-tooltip-position="bottom">
                                      		<p><i class="fa fa-mobile"></i>&nbsp; <?php echo "<strong><span class=\"text-danger\">$nohp</span></strong>"; ?></p> 
										</span><br/>                                     

										<span data-tooltip="Email" data-tooltip-position="bottom"> 
                                      		<p><i class="fa fa-at"></i>&nbsp; <?php echo "<strong><span class=\"text-primary\">$email </span></strong>"; ?></p>
                                      	</span><br/>

                                      <?php if($alamat=="" && $rt=="" && $rw=="" && $nacam=="" && $nakel=="" && $nawil=="" && $prop=="")
                                      { ?>
                                      		<p><i class="fa fa-home"></i>&nbsp; </p>
                                      <?php }
                                      else
                                      { ?>
                                      		<span data-tooltip="Alamat Domisili" data-tooltip-position="bottom"> 
                                      		<p><i class="fa fa-home"></i>&nbsp; <?php echo "<strong><span class=\"text-info\">".$alamat." RT-".$rt." RW-".$rw."<br/> &nbsp;&nbsp;&nbsp;&nbsp; KECAMATAN ".$nacam." KELURAHAN ".$nakel."<br/> &nbsp;&nbsp;&nbsp;&nbsp; ".$nawil." - ".$prop."</span></strong>"; ?></p>
                                      		</span><br/>
                                      <?php } ?>
                                      
                                      <p>&nbsp;</p>
                                    </address>   
                                    </div>  
                                </div>
                            </div>
                        </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
                



<div class="wrapper wrapper-content animated fadeInRight">
<?php if($infoJabatanS != null){ ?>
    <?php echo $this->session->flashdata('pesan'); ?>

    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Jabatan Struktural</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">
               <table class="table table-hover table-striped table-bordered" width="100%">
                  <thead>
                     <tr>
                        <th width="2%">No</th>
                        <th width="8%">TMT</th>
                        <th width="15%">Lokasi</th>
                        <th width="16%">Jabatan</th>
                        <th width="14%">Pangkat (Gol)</th>
                        <th width="5%">ESELON</th>
                        <th width="10%">No. SK</th> 
                        <th width="8%">Tg. SK</th>
                        <th width="14%">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                  <?php 
                     $i=1; 
                     foreach($infoJabatanS as $row): 
                        $tmt = date('d-m-Y', strtotime($row->TMT));
                        $tgsk = date('d-m-Y', strtotime($row->TGSK));
                  ?>
                     <tr>
                        <td class="center"> <center><?php echo $i; ?>.</center></td>
                        <td><?php echo $tmt; ?></td>
                        <td><?php echo $row->NALOKL; ?></td>
                        <td><?php echo $row->NAJABL; ?></td>
                        <td><?php echo $row->NAPANG; ?> (<?php echo $row->GOL; ?> )</td>
                        <td><?php echo $row->ESELON; ?></td>
                        <td><?php echo $row->NOSK; ?></td>
                        <td><?php echo $tgsk; ?></td>
                        <td>
                          <center>
                          <?php 
                            if($row->STATUS_FILE_UPLOAD == 1)
                            {
                          ?>
                            <!-- JIKA MENUGGU APPROVE -->
                            <a href="<?php echo site_url(); ?>file/upload/jabatan/<?php echo $row->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-success" title="Lihat File"><i class="fa fa-search"></i> Wait</a>
                          <?php
                            }
                            elseif($row->STATUS_FILE_UPLOAD == 2) 
                            {
                          ?>
                            <a href="<?php echo site_url(); ?>file/upload/jabatan/<?php echo $row->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-warning" title="Lihat File" ><i class="fa fa-search"></i> </a>
                          <?php
                            }
                            elseif ($row->STATUS_FILE_UPLOAD == 3) 
                            {
                          ?>
                          <!-- JIKA REVISI -->
                            <a href="#revisi-edit" id="btn-revisi"
                                revisi_nrk="<?php echo $row->NRK; ?>"  
                                revisi_tmt="<?php echo $row->TMT; ?>"  
                                revisi_kolok="<?php echo $row->KOLOK; ?>"  
                                revisi_kojab="<?php echo $row->KOJAB; ?>"  
                                revisi_filelama="<?php echo $row->FILE_UPLOAD; ?>"  
                                data-toggle="modal" title="Revisi" class="btn btn-mini btn-primary">
                                <i class="fa fa-repeat"></i> 
                              </a>

                           <!--  <a href="<?php echo site_url(); ?>file/upload/jabatan/<?php echo $row->FILE_UPLOAD; ?>"  class="btn btn-mini btn-info" data-rel="tooltip" data-placement="top" title="Revisi" ><i class="fa fa-repeat"></i> </a> -->
                           <?php
                              }
                              elseif ($row->STATUS_FILE_UPLOAD == NULL) 
                              {
                            ?>
                              <a href="#user-edit" id="btn-dit"
                                data_nrk="<?php echo $row->NRK; ?>"  
                                data_tmt="<?php echo $row->TMT; ?>"  
                                data_kolok="<?php echo $row->KOLOK; ?>"  
                                data_kojab="<?php echo $row->KOJAB; ?>"  
                                data-toggle="modal" title="Upload" class="btn btn-mini btn-primary">
                                <i class="fa fa-upload"></i> 
                              </a>
                          <?php }  ?>
                          

                           </center>
                        </td>
                     </tr>
                  <?php $i++; endforeach ?>
                  </tbody>
                </table>
            </div> <!-- akhir div ibox content-->
        </div> <!-- akhir div ibox float e-margins -->
      </div> <!-- akhir div col lg 6 -->
    </div><!-- akhir div row -->
<?php }?>

<?php if($infoJabatanF != null){ ?>
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Jabatan Fungsional</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">
               <table class="table table-bordered" width="100%">
                  <thead>
                    <tr>
                        <th width="15px">No</th>
                        <th>TMT</th>
                        <th>Lokasi</th>
                        <th>Jabatan</th>
                        <th>Pangkat (Gol)</th>
                        <th>No. SK</th>
                        <th>Tg. SK</th>
                        <th>Aksi</th>
                    </tr>
                  </thead>
                     <tbody>
                     <?php 
                        $i=1; 
                        foreach($infoJabatanF as $rows):
                          $tmt = date('d-m-Y', strtotime($rows->TMT));
                          $tgsk = date('d-m-Y', strtotime($rows->TGSK));
                          $temte = date('Y-m-d H:i:s', strtotime($rows->TMT));

                     ?>
                   <tr>
                     <td class="center"> <center><?php echo $i; ?>.</center></td>
                        <td><?php echo $tmt; ?></td>
                        <td><?php echo $rows->NALOKL; ?></td>
                        <td><?php echo $rows->NAJABL; ?></td>
                        <td><?php echo $rows->NAPANG; ?> (<?php echo $rows->GOL; ?> )</td>
                        <td><?php echo $rows->NOSK; ?></td>
                        <td><?php echo $tgsk; ?></td>
                      <td>
                         <center>
                         <?php 
                            if($rows->STATUS_FILE_UPLOAD == 1)
                            {
                         ?>
                            <!-- JIKA MENUGGU APPROVE -->
                            <a href="<?php echo site_url(); ?>file/upload/jabatan_funsional/<?php echo $rows->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-success" title="Lihat File"><i class="fa fa-search"></i> Wait</a>
                         <?php
                            }
                            elseif($rows->STATUS_FILE_UPLOAD == 2) 
                            {
                         ?>
                            <a href="<?php echo site_url(); ?>file/upload/jabatan_funsional/<?php echo $rows->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-warning" title="Lihat File" ><i class="fa fa-search"></i> </a>
                        <?php
                          }
                          elseif ($rows->STATUS_FILE_UPLOAD == 3) 
                          {
                        ?>
                        <!-- JIKA REVISI -->
                          <a href="#revisi-jbf" id="btn-revisi-jbf"
                              rev_jbf_nrk="<?php echo $rows->NRK; ?>"  
                              rev_jbf_kolok="<?php echo $rows->KOLOK; ?>"  
                              rev_jbf_kojab="<?php echo $rows->KOJAB; ?>"  
                              rev_jbf_tmt="<?php echo $tmt; ?>"  
                              rev_jbf_filelama="<?php echo $rows->FILE_UPLOAD; ?>"  
                              data-toggle="modal" title="Revisi" class="btn btn-mini btn-primary">
                              <i class="fa fa-repeat"></i> 
                            </a>
                         <?php
                            }
                            elseif ($rows->STATUS_FILE_UPLOAD == 0) 
                            {
                          ?>
                            <a href="#upload-jbf" id="btn-jbf"
                              jbf_nrk="<?php echo $rows->NRK; ?>"  
                              jbf_kojab="<?php echo $rows->KOJAB; ?>"  
                              jbf_kolok="<?php echo $rows->KOLOK; ?>"  
                              jbf_tmt="<?php echo $tmt; ?>"  
                              data-toggle="modal" title="Upload" class="btn btn-mini btn-primary">
                              <i class="fa fa-upload"></i> 
                            </a>
                        <?php }  ?>
                        

                         </center>
                      </td>
                   </tr>

                   <?php $i++; endforeach ?>
                  </tbody>
                </table>
            </div> <!-- akhir div ibox content-->
        </div> <!-- akhir div ibox float e-margins -->

      </div> <!-- akhir div col lg 6 -->
    </div><!-- akhir div row -->
<?php }?>

<div class="row">
<?php if($infoPenForm !=null) { ?>
    <div class="col-lg-6">
      <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Pendidikan Formal</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content" style="display:block">
               <table class="table table-bordered" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Sekolah</th>
                      <th>No Ijazah</th>
                      <th>Tg Ijazah</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php 
                        $i=1; 
                        foreach($infoPenForm as $key): 
                         $tglijazah = date('d-m-Y', strtotime($key->TGIJAZAH));
                        if($key->UNIVER!='00000' AND $key->NASEK==" ")
                        {
                           $data = $key->NAUNIVER;
                        }
                        else
                        {
                           $data = $key->NASEK;
                        }
                     ?>
                     <tr>
                        <td class="center"> <center><?php echo $i; ?>.</center></td>
                        <td><?php echo $data; ?><br>Lokasi : <?php echo $key->KOTSEK; ?></td>
                        <td><?php echo $key->NOIJAZAH; ?></td>
                        <td><?php echo $tglijazah; ?></td>
                        <td>
                          <center>
                          <?php 
                            if($key->STATUS_FILE_UPLOAD == 1)
                            {
                          ?>
                            <!-- JIKA MENUGGU APPROVE -->
                            <a href="<?php echo site_url(); ?>file/upload/pendidikan_formal/<?php echo $key->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-success" title="Lihat File"><i class="fa fa-search"></i> Wait</a>
                          <?php
                            }
                            elseif($key->STATUS_FILE_UPLOAD == 2) 
                            {
                          ?>
                            <a href="<?php echo site_url(); ?>file/upload/pendidikan_formal/<?php echo $key->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-warning" title="Lihat File" ><i class="fa fa-search"></i> </a>
                          <?php
                            }
                            elseif ($key->STATUS_FILE_UPLOAD == 3) 
                            {
                          ?>
                          <!-- JIKA REVISI -->
                            <a href="#revisi-pendidikan" id="btn-revisi-pendidikan"
                                dt_revisi_nrk="<?php echo $key->NRK; ?>"  
                                dt_revisi_jendik="<?php echo $key->JENDIK; ?>"  
                                dt_revisi_kodik="<?php echo $key->KODIK; ?>"  
                                dt_revisi_tglija="<?php echo $tglijazah; ?>"  
                                dt_revisi_filelama="<?php echo $key->FILE_UPLOAD; ?>"  
                                data-toggle="modal" title="Revisi" class="btn btn-mini btn-primary">
                                <i class="fa fa-repeat"></i> 
                              </a>

                           
                           <?php
                              }
                              elseif ($key->STATUS_FILE_UPLOAD == NULL) 
                              {
                            ?>
                              <a href="#upload-pendidikan" id="btn-pendidikan"
                                dt_nrk="<?php echo $key->NRK; ?>"  
                                dt_jendik="<?php echo $key->JENDIK; ?>"  
                                dt_kodik="<?php echo $key->KODIK; ?>"  
                                dt_tglija="<?php echo $tglijazah; ?>"  
                                data-toggle="modal" title="Upload" class="btn btn-mini btn-primary">
                                <i class="fa fa-upload"></i> 
                              </a>
                          <?php }  ?>
                          

                           </center>
                        </td>
                     </tr>

                     <?php $i++; endforeach ?>

                       
                  </tbody>
                </table>
            </div> <!-- akhir div ibox content-->
        </div> <!-- akhir div ibox float e-margins -->

      </div> <!-- akhir div col lg 6 -->
<?php } ?>

<?php if($infoPenNForm !=null) { ?>
      <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Pendidikan Non Formal</h5>
                  <div class="ibox-tools" >
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">
               <table class="table table-bordered" width="100%">
                  <thead>
                    <tr>
                      <th width="15px">No</th>
                      <th>Sekolah</th>
                      <th>No Ijazah</th>
                      <th>Tg Ijazah</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php 
                        $i=1; 
                        foreach($infoPenNForm as $keys): 
                          $tglijazah = date('d-m-Y', strtotime($keys->TGIJAZAH));
                          $tgl_ijazaah = date('Y-m-d H:i:s', strtotime($keys->TGIJAZAH));
                      ?>
                      <tr>
                        <td class="center"> <center><?php echo $i; ?>.</center></td>
                        <td><?php echo $keys->NASEK; ?><br>Lokasi : <?php echo $keys->KOTSEK; ?></td>
                        <td><?php echo $keys->NOIJAZAH; ?></td>
                        <td><?php echo $tglijazah; ?></td>
                        <td>
                           <center>
                           <?php 
                              if($keys->STATUS_FILE_UPLOAD == 1)
                              {
                           ?>
                           <!-- jika menunggu approve -->
                              <a href="<?php echo site_url(); ?>file/upload/pendidikan_non_formal/<?php echo $keys->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-success" title="Lihat File"><i class="fa fa-search"></i> Wait</a>
                           <?php
                              }
                              elseif($keys->STATUS_FILE_UPLOAD == 2) 
                              {
                           ?> 
                              <a href="http://pusdatin.jakarta.go.id/upload_file_pegawai/<?php echo $keys->NRK; ?>/pendidikan_non_formal/<?php echo $keys->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-warning" title="Lihat File" ><i class="fa fa-search"></i> </a>
                          <?php
                            }
                            elseif ($keys->STATUS_FILE_UPLOAD == 3) 
                            {
                          ?>
                          <!-- JIKA REVISI -->
                            <a href="#revisi-pendidikan-nonformal" id="btn-revisi-pendidikan-nonformal"
                                rev_nfp_nrk="<?php echo $keys->NRK; ?>"  
                                rev_nfp_kodik="<?php echo $keys->KODIK; ?>"  
                                rev_nfp_jendik="<?php echo $keys->JENDIK; ?>"  
                                rev_nfp_tgljazah="<?php echo $tglijazah; ?>"  
                                rev_nfp_noijazah="<?php echo $keys->NOIJAZAH; ?>"  
                                rev_nfp_revisi_filelama="<?php echo $keys->FILE_UPLOAD; ?>"  
                                data-toggle="modal" title="Revisi" class="btn btn-mini btn-primary">
                                <i class="fa fa-repeat"></i> 
                              </a>

                           
                           <?php
                              }
                              elseif ($keys->STATUS_FILE_UPLOAD == 0) 
                              {
                            ?>
                              <a href="#upload-pendidikan-nonformal" id="btn-pendidikan-nonformal"
                                nfp_nrk="<?php echo $keys->NRK; ?>"  
                                nfp_kodik="<?php echo $keys->KODIK; ?>"  
                                nfp_jendik="<?php echo $keys->JENDIK; ?>"  
                                nfp_tgljazah="<?php echo $tglijazah; ?>"  
                                nfp_noijazah="<?php echo $keys->NOIJAZAH; ?>"  
                                data-toggle="modal" title="Upload" class="btn btn-mini btn-primary">
                                <i class="fa fa-upload"></i> 
                              </a>
                          <?php }  ?>
                          

                           </center>
                        </td>
                     </tr>

                     <?php $i++; endforeach ?>

                  </tbody>
                </table>
            </div> <!-- akhir div ibox content-->
        </div> <!-- akhir div ibox float e-margins -->

      </div> <!-- akhir div col lg 6 -->
<?php }?>
    </div><!-- akhir div row -->

<?php if($infoHubkel!=null){ ?>
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Keluarga</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">
               <table class="table table-bordered" width="100%">
                  <thead>
                    <tr>
                      <th width="15px">No</th><th>Hubungan</th><th>Nama</th><th>TTL</th> <th>Jenis Kelamin</th> <th>Tunjangan</th><th>Pekerjaan</th><th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      $i=1; 
                      foreach($infoHubkel as $row):  
                      $talhir = date('d-m-y', strtotime($row->TALHIR));
                    ?>
                    <tr>
                      <td class="center"> <center><?php echo $i; ?>.</center></td>
                      <td><?php echo $row->NAHUBKEL; ?></td>
                      <td><?php echo $row->NAMA; ?></td>
                      <td><?php echo $row->TEMHIR; ?> / <?php echo $talhir; ?></td>
                      <td>
                        <?php echo ($row->JENKEL == 'P' ? 'PEREMPUAN' : 'LAKI-LAKI'); ?>
                      </td>
                      <td><?php echo $row->TUNJANGAN; ?></td>
                      <td><?php echo $row->KERJAAN; ?></td>
                      <td>
                          <center>
                          <?php 
                            if($row->STATUS_FILE_UPLOAD == 1)
                            {
                          ?>
                            <a href="<?php echo site_url(); ?>file/upload/hubkel/<?php echo $row->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-success" title="Lihat File"><i class="fa fa-search"></i> Wait</a>
                          <?php
                            }
                            elseif($row->STATUS_FILE_UPLOAD == 2) 
                            {
                          ?>
                            <!-- JIKA MENUGGU APPROVE -->
                            <a href="<?php echo site_url(); ?>file/upload/hubkel/<?php echo $row->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-warning" title="Lihat File" ><i class="fa fa-search"></i> </a>
                          <?php
                            }
                            elseif ($row->STATUS_FILE_UPLOAD == 3) 
                            {
                          ?>
                            <!-- JIKA REVISI -->
                            <a href="#revisi-hubkel" id="btn-revisi-hubkel"
                              rev_hubkel_nrk="<?php echo $row->NRK; ?>"  
                              rev_hubkel_hubkel="<?php echo $row->HUBKEL; ?>"   
                              rev_hubkel_filelama="<?php echo $row->FILE_UPLOAD; ?>"  
                              data-toggle="modal" title="Revisi" class="btn btn-mini btn-primary">
                              <i class="fa fa-repeat"></i> 
                            </a>
                          <?php
                            }
                            elseif ($row->STATUS_FILE_UPLOAD == 0) 
                            {
                          ?>
                            <a href="#upload-hubkel" id="btn-hubkel"
                              hubkel_nrk="<?php echo $row->NRK; ?>"  
                              hubkel_hubkel="<?php echo $row->HUBKEL; ?>"  
                              data-toggle="modal" title="Upload" class="btn btn-mini btn-primary">
                              <i class="fa fa-upload"></i> 
                            </a>
                          <?php }  ?>
                                

                        </center>
                      </td>
                    </tr>

                    <?php $i++; endforeach ?>
                  </tbody>
                </table>
            </div> <!-- akhir div ibox content-->
        </div> <!-- akhir div ibox float e-margins -->

      </div> <!-- akhir div col lg 6 -->
    </div><!-- akhir div row -->
<?php }?>

<?php if($infoGapokUser != null){ 

  ?>
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Gaji Pokok</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">
                <table class="table table-bordered" width="100%">
                  <thead>
                    <tr>
                      <th width="15px">No</th>
                      <th>TMT</th> 
                      <th>Pangkat(Gol)</th>
                      <th>Gaji</th>
                      <th>No. SK</th>
                      <th>Tg. SK</th> 
                      <th>Aksi</th> 
                    </tr>
                  </thead>
                  <tbody>
                           <?php 
                              $i=1; 
                              foreach($infoGapokUser as $inf): 
                              $tgsk = date('d-m-Y', strtotime($inf->TGSK));
                              $tmt = date('d M Y', strtotime($inf->TMT));
                              $TEEMTE = date('Y-m-d', strtotime($inf->TMT));
                           ?>
                           <tr>
                              <td class="center"> <center><?php echo $i; ?>.</center></td>
                              <td><?php echo $tmt; ?></td>
                              <td><?php echo $inf->NAPANG; ?> (<?php echo $inf->GOL; ?>)</td>
                              <td><?php echo number_format($inf->GAPOK); ?></td>
                              <td><?php echo $inf->NOSK; ?></td>
                              <td><?php echo $tgsk; ?></td>
                              <td>
                                 <center>
                                 <?php 
                                    if($inf->STATUS_FILE_UPLOAD == 1)
                                    {
                                 ?>
                                    <a href="<?php echo site_url(); ?>file/upload/gapok/<?php echo $inf->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-success" title="Lihat File"><i class="fa fa-search"></i> Wait</a>
                                 <?php
                                    }
                                    elseif($inf->STATUS_FILE_UPLOAD == 2) 
                                    {
                                 ?>
                                    <!-- JIKA MENUGGU APPROVE -->
                                    <a href="<?php echo site_url(); ?>file/upload/gapok/<?php echo $inf->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-warning" title="Lihat File" ><i class="fa fa-search"></i> </a>
                                <?php
                                  }
                                  elseif ($inf->STATUS_FILE_UPLOAD == 3) 
                                  {
                                ?>
                                <!-- JIKA REVISI -->
                                  <a href="#revisi-gapok" id="btn-revisi-gapok"
                                      rev_gp_nrk="<?php echo $inf->NRK; ?>"  
                                      rev_gp_tmt="<?php echo $inf->TMT; ?>"  
                                      rev_gp_gapok="<?php echo $inf->GAPOK; ?>"  
                                      rev_gp_filelama="<?php echo $inf->FILE_UPLOAD; ?>"  
                                      data-toggle="modal" title="Revisi" class="btn btn-mini btn-primary">
                                      <i class="fa fa-repeat"></i> 
                                    </a>

                                 
                                 <?php
                                    }
                                    elseif ($inf->STATUS_FILE_UPLOAD == 0) 
                                    {
                                  ?>
                                    <a href="#upload-gapok" id="btn-gapok"
                                      gp_nrk="<?php echo $inf->NRK; ?>"  
                                      gp_tmt="<?php echo $TEEMTE; ?>"  
                                      gp_gapok="<?php echo $inf->GAPOK; ?>"  
                                      data-toggle="modal" title="Upload" class="btn btn-mini btn-primary">
                                      <i class="fa fa-upload"></i> 
                                    </a>
                                <?php }  ?>
                                

                                 </center>
                              </td>
                           </tr>

                           <?php $i++; endforeach ?>
                  </tbody>
                </table>
            </div> <!-- akhir div ibox content-->
        </div> <!-- akhir div ibox float e-margins -->

      </div> <!-- akhir div col lg 6 -->
    </div><!-- akhir div row -->
<?php }?>

<?php if($infoPangkat != null){ ?>
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Pangkat</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">
              <table class="table table-bordered" width="100%">
                  <thead>
                    <tr>
                        <th width="15px">No</th>
                        <th>TMT</th>
                        <th>Pangkat</th> 
                        <th>Golongan</th>
                        <th>No. SK</th>
                        <th>Tg. SK</th> 
                        <th>Aksi</th> 
                    </tr>
                  </thead>
                  <tbody>
                     <?php 
                        $i=1; 
                        foreach($infoPangkat as $pkt): 
                        $tmt = date('d M Y', strtotime($pkt->TMT));
                        $tgsk = date('d-m-Y', strtotime($pkt->TGSK));
                     ?>
                   <tr>
                      <td class="center"> <center><?php echo $i; ?>.</center></td>
                      <td><?php echo $tmt; ?></td>
                      <td><?php echo $pkt->NAPANG; ?></td>
                      <td><?php echo $pkt->GOL; ?></td>
                      <td><?php echo $pkt->NOSK; ?></td>
                      <td><?php echo $tgsk; ?></td>
                      <td>
                         <center>
                         <?php 
                            if($pkt->STATUS_FILE_UPLOAD == 1)
                            {
                         ?>
                            <a href="<?php echo site_url(); ?>file/upload/pangkat/<?php echo $pkt->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-success" title="Lihat File"><i class="fa fa-search"></i> Wait</a>
                         <?php
                            }
                            elseif($pkt->STATUS_FILE_UPLOAD == 2) 
                            {
                         ?>
                            <!-- JIKA MENUGGU APPROVE -->
                            <a href="<?php echo site_url(); ?>file/upload/pangkat/<?php echo $pkt->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-warning" title="Lihat File" ><i class="fa fa-search"></i> </a>
                        <?php
                          }
                          elseif ($pkt->STATUS_FILE_UPLOAD == 3) 
                          {
                        ?>
                        <!-- JIKA REVISI -->
                          <a href="#revisi-pangkat" id="btn-revisi-pangkat"
                              rev_pkt_nrk="<?php echo $pkt->NRK; ?>"  
                              rev_pkt_tmt="<?php echo $pkt->TMT; ?>"  
                              rev_pkt_gapok="<?php echo $pkt->GAPOK; ?>"  
                              rev_pkt_kopang="<?php echo $pkt->KOPANG; ?>"  
                              rev_pkt_filelama="<?php echo $pkt->FILE_UPLOAD; ?>"  
                              data-toggle="modal" title="Revisi" class="btn btn-mini btn-primary">
                              <i class="fa fa-repeat"></i> 
                            </a>
                         <?php
                            }
                            elseif ($pkt->STATUS_FILE_UPLOAD == 0) 
                            {
                          ?>
                            <a href="#upload-pangkat" id="btn-pangkat"
                              pkt_nrk="<?php echo $pkt->NRK; ?>"  
                              pkt_tmt="<?php echo $pkt->TMT; ?>"  
                              pkt_kopang="<?php echo $pkt->KOPANG; ?>"  
                              pkt_gapok="<?php echo $pkt->GAPOK; ?>"  
                              data-toggle="modal" title="Upload" class="btn btn-mini btn-primary">
                              <i class="fa fa-upload"></i> 
                            </a>
                        <?php }  ?>
                        

                         </center>
                      </td>
                   </tr>

                   <?php $i++; endforeach ?>
                  </tbody>
                </table>
               
            </div> <!-- akhir div ibox content-->
        </div> <!-- akhir div ibox float e-margins -->

      </div> <!-- akhir div col lg 6 -->
    </div><!-- akhir div row -->
<?php }?>

<?php if($infoHargaan != null) { ?>
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Penghargaan</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">
               <table class="table table-bordered" width="100%">
                  <thead>
                    <tr>
                      <th width="15px">No</th><th>Penghargaan</th><th>Asal</th><th>No.SK</th><th>Tg .SK</th><th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php 
                        $i=1; 
                        foreach($infoHargaan as $row):
                     ?>
                   <tr>
                      <td class="center"> <center><?php echo $i; ?>.</center></td>
                      <td><?php echo $row->NAHARGA; ?></td>
                      <td><?php echo $row->ASAL_HRG; ?></td>
                      <td><?php echo $row->NOSK; ?></td>
                      <td><?php echo $row->TGSK; ?></td>
                      <td>
                         <center>
                         <?php 
                            if($row->STATUS_FILE_UPLOAD == 1)
                            {
                         ?>
                            <a href="<?php echo site_url(); ?>file/upload/penghargaan/<?php echo $row->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-success" title="Lihat File"><i class="fa fa-search"></i> Wait</a>
                         <?php
                            }
                            elseif($row->STATUS_FILE_UPLOAD == 2) 
                            {
                         ?>
                            <!-- JIKA MENUGGU APPROVE -->
                            <a href="<?php echo site_url(); ?>file/upload/penghargaan/<?php echo $row->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-warning" title="Lihat File" ><i class="fa fa-search"></i> </a>
                        <?php
                          }
                          elseif ($row->STATUS_FILE_UPLOAD == 3) 
                          {
                        ?>
                        <!-- JIKA REVISI -->
                            <a href="#revisi-penghargaan" id="btn-revisi-penghargaan"
                              rev_penghargaan_nrk="<?php echo $row->NRK; ?>"  
                              rev_penghargaan_kd="<?php echo $row->KDHARGA; ?>"  
                              rev_penghargaan_filelama="<?php echo $row->FILE_UPLOAD; ?>"  
                              data-toggle="modal" title="Revisi" class="btn btn-mini btn-primary">
                              <i class="fa fa-repeat"></i> 
                            </a>
                         <?php
                            }
                            elseif ($row->STATUS_FILE_UPLOAD == 0) 
                            {
                          ?>
                            <a href="#upload-penghargaan" id="btn-penghargaan"
                              penghargaan_nrk="<?php echo $row->NRK; ?>"  
                              penghargaan_kd="<?php echo $row->KDHARGA; ?>"  
                              data-toggle="modal" title="Upload" class="btn btn-mini btn-primary">
                              <i class="fa fa-upload"></i> 
                            </a>
                        <?php }  ?>
                        

                         </center>
                      </td>
                   </tr>

                   <?php $i++; endforeach ?>
                  </tbody>
 
                </table>
            </div> <!-- akhir div ibox content-->
        </div> <!-- akhir div ibox float e-margins -->

      </div> <!-- akhir div col lg 6 -->
    </div><!-- akhir div row -->
<?php }?>

<?php if($infoCuti != null) { ?>
  <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Cuti</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">
               <table class="table table-bordered" width="100%">
                  <thead>
                    <tr>
                      <th width="15px">No</th>
                      <th>TMT</th>
                      <th>No.SK</th>
                      <th>Tg.SK</th>
                      <th>Jenis Cuti</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php 
                        $i=1; 
                        foreach($infoCuti as $row):
                        $tmt = date('d-m-Y', strtotime($row->TMT));
                        $tgakhir = date('d-m-Y', strtotime($row->TGAKHIR));
                        $tgupd = date('d-m-Y', strtotime($row->TG_UPD));
                     ?>
                   <tr>
                      <td class="center"> <center><?php echo $i; ?>.</center></td>
                      <td><?php echo $row->TMT; ?></td>
                      <td><?php echo $row->NOSK; ?></td>
                      <td><?php echo $row->TGSK; ?></td>
                      <td><?php echo $row->KETERANGAN; ?></td>
                      <td>
                         <center>
                         <?php 
                            if($row->STATUS_FILE_UPLOAD == 1)
                            {
                         ?>
                            <a href="<?php echo site_url(); ?>file/upload/cuti/<?php echo $row->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-success" title="Lihat File"><i class="fa fa-search"></i> Wait</a>
                         <?php
                            }
                            elseif($row->STATUS_FILE_UPLOAD == 2) 
                            {
                         ?>
                            <!-- JIKA MENUGGU APPROVE -->
                            <a href="<?php echo site_url(); ?>file/upload/cuti/<?php echo $row->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-warning" title="Lihat File" ><i class="fa fa-search"></i> </a>
                        <?php
                          }
                          elseif ($row->STATUS_FILE_UPLOAD == 3) 
                          {
                        ?>
                        <!-- JIKA REVISI -->
                            <a href="#revisi-cuti" id="btn-revisi-cuti"
                              rev_cuti_nrk="<?php echo $row->NRK; ?>"  
                              rev_cuti_jencuti="<?php echo $row->JENCUTI; ?>"  
                              rev_cuti_tgakhir="<?php echo $tgakhir; ?>"  
                              rev_cuti_tgupd="<?php echo $tgupd; ?>"  
                              rev_cuti_tmt="<?php echo $tmt; ?>"  
                              rev_cuti_nosk="<?php echo $row->NOSK; ?>"  
                              rev_cuti_filelama="<?php echo $row->FILE_UPLOAD; ?>"  
                              data-toggle="modal" title="Revisi" class="btn btn-mini btn-primary">
                              <i class="fa fa-repeat"></i> 
                            </a>
                         <?php
                            }
                            elseif ($row->STATUS_FILE_UPLOAD == 0) 
                            {
                          ?>
                            <a href="#upload-cuti" id="btn-cuti"
                              cuti_nrk="<?php echo $row->NRK; ?>"  
                              cuti_jencuti="<?php echo $row->JENCUTI; ?>"  
                              cuti_tgakhir="<?php echo $tgakhir; ?>"  
                              cuti_tgupd="<?php echo $tgupd; ?>"  
                              cuti_tmt="<?php echo $tmt; ?>"  
                              cuti_nosk="<?php echo $row->NOSK; ?>"  
                              data-toggle="modal" title="Upload" class="btn btn-mini btn-primary">
                              <i class="fa fa-upload"></i> 
                            </a>
                        <?php }  ?>
                        

                         </center>
                      </td>
                   </tr>

                   <?php $i++; endforeach ?>
                  </tbody>
                </table>
            </div> <!-- akhir div ibox content-->
        </div> <!-- akhir div ibox float e-margins -->

      </div> <!-- akhir div col lg 6 -->
    </div><!-- akhir div row -->
<?php }?>

<?php if($infoDisiplin != null) { ?>
  <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Riwayat Hukuman Disiplin</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">
               <table class="table table-bordered" width="100%">
                  <thead>
                    <tr>
                      <th width="15px">No</th><th>No.SK</th><th>Tg.SK</th><th>Hukuman Disiplin</th><th>Tanggal Mulai</th><th>Tanggal Akhir</th><th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php 
                        $i=1; 
                        foreach($infoDisiplin as $row):
                     ?>
                   <tr>
                      <td class="center"> <center><?php echo $i; ?>.</center></td>
                      <td><?php echo $row->NOSK; ?></td>
                      <td><?php echo $row->TGSK; ?></td>
                      <td><?php echo $row->KETERANGAN; ?></td>
                      <td><?php echo $row->TGMULAI; ?></td>
                      <td><?php echo $row->TGAKHIR; ?></td>
                      <td>
                         <center>
                         <?php 
                            if($row->STATUS_FILE_UPLOAD == 1)
                            {
                         ?>
                            <a href="<?php echo site_url(); ?>file/upload/hukdis/<?php echo $row->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-success" title="Lihat File"><i class="fa fa-search"></i> Wait</a>
                         <?php
                            }
                            elseif($row->STATUS_FILE_UPLOAD == 2) 
                            {
                         ?>
                            <!-- JIKA MENUGGU APPROVE -->
                            <a href="<?php echo site_url(); ?>file/upload/hukdis/<?php echo $row->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-warning" title="Lihat File" ><i class="fa fa-search"></i> </a>
                        <?php
                          }
                          elseif ($row->STATUS_FILE_UPLOAD == 3) 
                          {
                        ?>
                        <!-- JIKA REVISI -->
                            <a href="#revisi-hukdis" id="btn-revisi-hukdis"
                              rev_hukdis_nrk="<?php echo $row->NRK; ?>"  
                              rev_hukdis_tgsk="<?php echo $row->TGSK; ?>"  
                              rev_hukdis_jnshuk="<?php echo $row->JENHUKDIS; ?>"  
                              rev_hukdis_filelama="<?php echo $row->FILE_UPLOAD; ?>"  
                              data-toggle="modal" title="Revisi" class="btn btn-mini btn-primary">
                              <i class="fa fa-repeat"></i> 
                            </a>
                         <?php
                            }
                            elseif ($row->STATUS_FILE_UPLOAD == 0) 
                            {
                          ?>
                            <a href="#upload-hukdis" id="btn-hukdis"
                              hukdis_nrk="<?php echo $row->NRK; ?>"  
                              hukdis_tgsk="<?php echo $row->TGSK; ?>"  
                              hukdis_jnshuk="<?php echo $row->JENHUKDIS; ?>"  
                              data-toggle="modal" title="Upload" class="btn btn-mini btn-primary">
                              <i class="fa fa-upload"></i> 
                            </a>
                        <?php }  ?>
                        

                         </center>
                      </td>
                   </tr>

                   <?php $i++; endforeach ?>
                  </tbody>
                </table>
            </div> <!-- akhir div ibox content-->
        </div> <!-- akhir div ibox float e-margins -->

      </div> <!-- akhir div col lg 6 -->
    </div><!-- akhir div row -->
<?php }?>

<?php if($infoSKPUser != null) { ?>
  <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#1AB394">
                <h5 style="color:#ffffff">Riwayat SKP</h5>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
            </div>
            <div class="ibox-content">
               <table class="table table-bordered" width="100%">
                  <thead>
                    <tr>
                      <th width="15px">No</th>
                      <th>Tahun</th>
                      <th>SKP</th>
                      <th>Perilaku</th>
                      <th>Nilai Prestasi</th>
                      <th>Keterangan Prestasi</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php 
                        $i=1; 
                        foreach($infoSKPUser as $skp): 
                     ?>
                   <tr>
                      <td class="center"> <center><?php echo $i; ?>.</center></td>
                      <td><?php echo $skp->TAHUN; ?></td>
                      <td><?php echo $skp->INPUT_SKP; ?></td>
                      <td><?php echo $skp->RATA2; ?></td>
                      <td><?php echo $skp->NILAI_PRESTASI; ?></td>
                      <td><?php echo $skp->KET_PRESTASI; ?></td>
                      <td>
                         <center>
                         <?php 
                            if($skp->STATUS_FILE_UPLOAD == 1)
                            {
                         ?>
                            <a href="<?php echo site_url(); ?>file/upload/skp/<?php echo $skp->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-success" title="Lihat File"><i class="fa fa-search"></i> Wait</a>
                         <?php
                            }
                            elseif($skp->STATUS_FILE_UPLOAD == 2) 
                            {
                         ?>
                            <!-- JIKA MENUGGU APPROVE -->
                            <a href="<?php echo site_url(); ?>file/upload/skp/<?php echo $skp->FILE_UPLOAD; ?>" target="_blank" class="btn btn-mini btn-warning" title="Lihat File" ><i class="fa fa-search"></i> </a>
                        <?php
                          }
                          elseif ($skp->STATUS_FILE_UPLOAD == 3) 
                          {
                        ?>
                        <!-- JIKA REVISI -->
                          <a href="#revisi-skp" id="btn-revisi-skp"
                              rev_skp_nrk="<?php echo $skp->NRK; ?>"  
                              rev_skp_thn="<?php echo $skp->TAHUN; ?>"  
                              rev_skp_filelama="<?php echo $skp->FILE_UPLOAD; ?>"  
                              data-toggle="modal" title="Revisi" class="btn btn-mini btn-primary">
                              <i class="fa fa-repeat"></i> 
                            </a>
                         <?php
                            }
                            elseif ($skp->STATUS_FILE_UPLOAD == 0) 
                            {
                          ?>
                            <a href="#upload-skp" id="btn-skp"
                              skp_nrk="<?php echo $skp->NRK; ?>"  
                              skp_thn="<?php echo $skp->TAHUN; ?>"  
                              data-toggle="modal" title="Upload" class="btn btn-mini btn-primary">
                              <i class="fa fa-upload"></i> 
                            </a>
                        <?php }  ?>
                        

                         </center>
                      </td>
                   </tr>

                   <?php $i++; endforeach ?>
                  </tbody>

                </table>
            </div> <!-- akhir div ibox content-->
        </div> <!-- akhir div ibox float e-margins -->

      </div> <!-- akhir div col lg 6 -->
    </div><!-- akhir div row -->
<?php }?>

<br/> <br/>  

    <div class="modal fade" id="modalform" style="overflow:hidden" role="dialog" aria-labelledby="modalUmumTitle" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document" id="pesan" >
            <form class="form-horizontal" id="formPass" action="javascript:updateDataPeg();" method="POST" >                
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modalUmumTitle">Form Isi Data Pegawai<i>  
                        <?php echo $peg2->NRK." - ".$peg2->NAMA; ?> </i></h4>
                        <input type="hidden" id="NRK" name="NRK" value= "<?php echo $user_id; ?>"/>
                        
                    </div>
                    <div class="modal-body">
                        
                        <div class="row">
                            <!--side kiri-->
                            <div class="col-lg-6">

                                <div class="form-group">
                                  <label class="col-sm-4 control-label" for="jendikcps">Agama</label>
                                  <select class="form-control select2_agama" name="agama" id="agama">
                                      
                                      <?php echo $listAgama; ?>
                                  </select>
                                </div>

                                <div class="form-group">
                                  <p><label class="col-sm-4 control-label" for="jenkel">Jenis Kelamin </label></p>
                                    <div class="radio radio-success radio-inline">
                                        <input type="radio"  id="jenkel" value="L" name="jenkel" <?php echo isset($peg2->JENKEL)? (($peg2->JENKEL == 'L') ? 'checked' : ''): 'checked'; ?>>
                                        <label for="jenkel" style="padding: 0px 2px ;"> Laki-laki </label>
                                    </div>
                                    <div class="radio radio-success radio-inline">
                                        <input type="radio" id="jenkel" value="P" name="jenkel" <?php echo isset($peg2->JENKEL)? (($peg2->JENKEL == 'P') ? 'checked' : ''):''; ?>>
                                        <label for="jenkel" style="padding: 0px 2px ;"> Perempuan </label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="col-sm-4 control-label">No. TASPEN</label>
                                  <div class="input-group col-sm-7">
                                      <input class="form-control" maxlength="18" type="text" id="taspen" placeholder="TASPEN" name="taspen" value="<?php echo trim($peg2->TASPEN); ?>">
                                  </div>
                                </div>

                                

                                <div class="form-group">
                                  <label class="col-sm-4 control-label">NIK</label>
                                  <div class="input-group col-sm-7">
                                      <input class="form-control" maxlength="16" type="text" id="noppen" placeholder="NOPPEN" name="noppen" onkeypress="return numbersonly1(this, event)"   value="<?php echo $peg2->NOPPEN; ?>">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label">No. Kartu Keluarga</label>
                                  <div class="input-group col-sm-7">
                                      <input class="form-control" maxlength="16" type="text" id="nokk" placeholder="NOKK" onkeypress="return numbersonly1(this, event)"  name="nokk" value="<?php echo $peg2->NOKK; ?>">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label">No. Rek Bank DKI</label>
                                  <div class="input-group col-sm-7">
                                      <input class="form-control" maxlength="12" type="text" id="simpeda" onkeypress="return numbersonly1(this, event)" placeholder="no rek Bank DKI" name="simpeda" value="<?php echo $peg2->SIMPEDA; ?>">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label">NPWP</label>
                                  <div class="input-group col-sm-7">
                                      <input class="form-control" maxlength="15" onkeypress="return numbersonly1(this, event)"  type="text" id="npwp" placeholder="NPWP" name="npwp" value="<?php echo $peg2->NPWP; ?>">
                                  </div>
                                </div>

                                 <div class="form-group">
                                  <p><label class="col-sm-4 control-label" for="darah">Gol. Darah</label></p>
                                    <div class="radio radio-success radio-inline">
                                        <input type="radio" id="darah" value="O" name="darah" <?php echo isset($peg2->DARAH)? ((trim($peg2->DARAH) == 'O') ? 'checked' : ''): ''; ?>>
                                        <label for="darah" style="padding: 0px 2px ;"> O </label>
                                    </div>
                                    <div class="radio radio-success radio-inline">
                                        <input type="radio" id="darah" value="A" name="darah" <?php echo isset($peg2->DARAH)? ((trim($peg2->DARAH) == 'A') ? 'checked' : ''):''; ?>>
                                        <label for="darah" style="padding: 0px 2px ;"> A </label>
                                    </div>
                                    <div class="radio radio-success radio-inline">
                                        <input type="radio" id="darah" value="B" name="darah" <?php echo isset($peg2->DARAH)? ((trim($peg2->DARAH) == 'B') ? 'checked' : ''):''; ?>>
                                        <label for="darah" style="padding: 0px 2px ;"> B </label>
                                    </div>
                                    <div class="radio radio-success radio-inline">
                                        <input type="radio" id="darah" value="AB" name="darah" <?php echo isset($peg2->DARAH)? ((trim($peg2->DARAH) == 'AB') ? 'checked' : ''):''; ?>>
                                        <label for="darah" style="padding: 0px 2px ;"> AB </label>
                                    </div>
                                </div>

                                


                            </div>

                            <!--side kanan-->

                            <div class="col-lg-6">
                                <div class="form-group">
                                  <label class="col-sm-4 control-label">No. Telp</label>
                                  <div class="input-group col-sm-7">
                                    <input class="form-control" maxlength="18" type="text" id="notelp" onkeypress="return numbersonly1(this, event)" placeholder="No. Telp" name="notelp" value="<?php echo $peg2->NOTELP; ?>">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label">No. HP</label>
                                  <div class="input-group col-sm-7">
                                      <input class="form-control" onkeypress="return numbersonly1(this, event)" maxlength="13" type="text" id="nohp" placeholder="No. HP" name="nohp" value="<?php echo $peg2->NOHP; ?>">
                                  </div>
                                </div>

                                 <div class="form-group" style="display: none">
                                  <label class="col-sm-4 control-label" for="jendikcps">Jenis Pendidikan CPNS </label>
                                  <select class="form-control select2_jendikcps" name="jendikcps" id="jendikcps">
                                      
                                      <?php echo $listJendikcps; ?>
                                  </select>
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label" for="kodikcps">Pendidikan Pada Waktu Diangkat CPNS </label>
                                  <select class="form-control select2_kodikcps" name="kodikcps" id="kodikcps" >
                                      <option></option>
                                      <?php echo $listKodikcps; ?>
                                  </select>
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label">No. KARPEG</label>
                                  <div class="input-group col-sm-7">
                                      <input class="form-control" maxlength="16" type="text" id="karpeg"  placeholder="KARPEG" name="karpeg" value="<?php echo trim($peg2->KARPEG); ?>">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label">No.BPJS Kesehatan</label>
                                  <div class="input-group col-sm-7">
                                      <input class="form-control" maxlength="16" type="text" id="bpjs" placeholder="BPJS" onkeypress="return numbersonly1(this, event)" name="bpjs" value="<?php echo $peg2->BPJS; ?>">
                                  </div>
                                </div>

                               
                                <div class="form-group">
                                  <label class="col-sm-4 control-label">No. Kartu Suami/Istri</label>
                                  <div class="input-group col-sm-7">
                                      <input class="form-control" maxlength="8" type="text" id="karsu" placeholder="Kartu Suami/Istri"  name="karsu" value="<?php echo $peg2->KARSU; ?>">
                                  </div>
                                </div>

                              <div class="form-group">
                                  <label class="col-sm-4 control-label">Email</label>
                                  <div class="input-group col-sm-7">
                                      <input class="form-control" maxlength="75" type="text" id="email" placeholder="Email" name="email" value="<?php echo $peg2->EMAIL; ?>">
                                  </div>
                              </div>

                            </div> <!--end div lg-->


                        </div> <!--end div row-->
                         <span class="text-danger" id="warning"></span>
                           

                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default dim" data-dismiss="modal" id="tutupModal">Tutup</button>
                            <button type="submit" class="btn btn-primary dim">Simpan</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>          
 </div>

<div id="user-edit" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File</h4>
      </div>
      <!-- <form class="form-horizontal" id="uploadFormJabatan" role="form" enctype="multipart/form-data" method="POST"> -->
      <!-- <form action="javascript:UploadFileJabatan()" id="FormUpload" enctype="multipart/form-data" method="POST" > -->
      <form action="<?php echo site_url('profile/upload_file_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="hidden" name="nrk" id="nrk" class="form-control" required="">
                  <input type="hidden" name="tmt" id="tmt" class="form-control" required="">
                  <input type="hidden" name="kolok" id="kolok" class="form-control" required="">
                  <input type="hidden" name="kojab" id="kojab" class="form-control" required="">
                  <input type="hidden" name="jenis_riwayat" value="jabatan" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="revisi-edit" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Riwayat Jabatan Struktural (Revisi)</h4>
      </div>
      <form action="<?php echo site_url('profile/upload_file_revisi_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="hidden" name="nrk" id="r_nrk" class="form-control" required="">
                  <input type="hidden" name="tmt" id="r_tmt" class="form-control" required="">
                  <input type="hidden" name="kolok" id="r_kolok" class="form-control" required="">
                  <input type="hidden" name="kojab" id="r_kojab" class="form-control" required="">
                  <input type="hidden" name="jenis_riwayat" value="jabatan" class="form-control" required="">
                  <input type="hidden" name="filelama" id="r_filelama" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan Ulang </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="upload-pendidikan" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Pendidikan Formal</h4>
      </div>
      <!-- <form class="form-horizontal" id="uploadFormJabatan" role="form" enctype="multipart/form-data" method="POST"> -->
      <!-- <form action="javascript:UploadFileJabatan()" id="FormUpload" enctype="multipart/form-data" method="POST" > -->
      <form action="<?php echo site_url('profile/upload_file_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="text" name="nrk" id="pendidikan_nrk" class="form-control" required="">
                  <input type="text" name="jendik" id="jendik" class="form-control" required="">
                  <input type="text" name="kodik" id="kodik" class="form-control" required="">
                  <input type="text" name="tgl_ijazah" id="tgl_ijazah" class="form-control" required="">
                  <input type="hidden" name="jenis_riwayat" value="pendidikan_formal" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="revisi-pendidikan" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Pendidikan Formal (Revisi)</h4>
      </div>
      <!-- <form class="form-horizontal" id="uploadFormJabatan" role="form" enctype="multipart/form-data" method="POST"> -->
      <!-- <form action="javascript:UploadFileJabatan()" id="FormUpload" enctype="multipart/form-data" method="POST" > -->
      <form action="<?php echo site_url('profile/upload_file_revisi_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="hidden" name="nrk" id="rev_pendidikan_nrk" class="form-control" required="">
                  <input type="hidden" name="jendik" id="rev_pend_jendik" class="form-control" required="">
                  <input type="hidden" name="kodik" id="rev_pend_kodik" class="form-control" required="">
                  <input type="hidden" name="tgl_ijazah" id="rev_pend_tgl_ijazah" class="form-control" required="">
                  <input type="hidden" name="filelama" id="rev_pend_filelama" class="form-control" required="">
                  <input type="hidden" name="jenis_riwayat" value="pendidikan_formal" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="upload-pendidikan-nonformal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Pendidikan Non Formal</h4>
      </div>
      <form action="<?php echo site_url('profile/upload_file_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="hidden" name="nrk" id="nfp_nrk" class="form-control" required="">
                  <input type="hidden" name="kodik" id="nfp_kodik" class="form-control" required="">
                  <input type="hidden" name="jendik" id="nfp_jendik" class="form-control" required="">
                  <input type="hidden" name="tgl_ijazah" id="nfp_tgljazah" class="form-control" required="">
                  <input type="hidden" name="jenis_riwayat" value="pendidikan_non_formal" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="revisi-pendidikan-nonformal" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Upload File Pendidikan Non Formal (Revisi)</h4>
         </div>
         <form action="<?php echo site_url('profile/upload_file_revisi_riwayat'); ?>" id="FormUpload" enctype="multipart/form-data" method="POST" >
            <div class="modal-body">
               <div class="form-group">
                  <label for="textfield" class="control-label col-sm-3">Upload File</label>
                  <div class="col-sm-8">
                     <input type="hidden" name="nrk" id="rev_nfp_nrk" class="form-control" required="">
                     <input type="hidden" name="jendik" id="rev_nfp_jendik" class="form-control" required="">
                     <input type="hidden" name="kodik" id="rev_nfp_kodik" class="form-control" required="">
                     <input type="hidden" name="filelama" id="rev_nfp_revisi_filelama" class="form-control" required="">
                     <input type="hidden" name="tglijazah" id="rev_nfp_tgljazah" class="form-control" required="">
                     <input type="hidden" name="no_ijazah" id="rev_nfp_noijazah" class="form-control" required="">
                     <input type="hidden" name="jenis_riwayat" value="pendidikan_non_formal" class="form-control" required="">
                     <input type="file" name="gambar" id="gambar" class="form-control" required="">
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
            </div>
         </form>
      </div>
   </div>
</div>

<div id="upload-gapok" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Riwayat Gapok</h4>
      </div>
      <form action="<?php echo site_url('profile/upload_file_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="hidden" name="nrk" id="gp_nrk" class="form-control" required="">
                  <input type="hidden" name="tmt" id="gp_tmt" class="form-control" required="">
                  <input type="hidden" name="gapok" id="gp_gapok" class="form-control" required="">
                  <input type="hidden" name="jenis_riwayat" value="gapok" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="revisi-gapok" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Upload File Gapok (Revisi)</h4>
         </div>
         <form action="<?php echo site_url('profile/upload_file_revisi_riwayat'); ?>" id="FormUpload" enctype="multipart/form-data" method="POST" >
            <div class="modal-body">
               <div class="form-group">
                  <label for="textfield" class="control-label col-sm-3">Upload File</label>
                  <div class="col-sm-8">
                      <input type="hidden" name="nrk" id="rev_gp_nrk" class="form-control" required="">
                      <input type="hidden" name="tmt" id="rev_gp_tmt" class="form-control" required="">
                      <input type="hidden" name="gapok" id="rev_gp_gapok" class="form-control" required="">
                      <input type="hidden" name="filelama" id="rev_gp_filelama" class="form-control" required="">
                      <input type="hidden" name="jenis_riwayat" value="gapok" class="form-control" required="">
                      <input type="file" name="gambar" id="gambar" class="form-control" required="">
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
            </div>
         </form>
      </div>
   </div>
</div>

<div id="upload-pangkat" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Riwayat Pangkat</h4>
      </div>
      <form action="<?php echo site_url('profile/upload_file_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="hidden" name="nrk" id="pkt_nrk" class="form-control" required="">
                  <input type="hidden" name="tmt" id="pkt_tmt" class="form-control" required="">
                  <input type="hidden" name="gapok" id="pkt_gapok" class="form-control" required="">
                  <input type="hidden" name="kopang" id="pkt_kopang" class="form-control" required="">
                  <input type="hidden" name="jenis_riwayat" value="pangkat" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="revisi-pangkat" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Riwayat Pangkat (Revisi)</h4>
      </div>
      <form action="<?php echo site_url('profile/upload_file_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="hidden" name="nrk" id="rev_pkt_nrk" class="form-control" required="">
                  <input type="hidden" name="tmt" id="rev_pkt_tmt" class="form-control" required="">
                  <input type="hidden" name="gapok" id="rev_pkt_gapok" class="form-control" required="">
                  <input type="hidden" name="kopang" id="rev_pkt_kopang" class="form-control" required="">
                  <input type="hidden" name="jenis_riwayat" value="pangkat" class="form-control" required="">
                  <input type="hidden" name="filelama" id="rev_pkt_filelama" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="upload-skp" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Riwayat SKP</h4>
      </div>
      <form action="<?php echo site_url('profile/upload_file_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="hidden" name="nrk" id="skp_nrk" class="form-control" required="">
                  <input type="hidden" name="thn" id="skp_thn" class="form-control" required="">
                  <input type="hidden" name="jenis_riwayat" value="skp" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="revisi-skp" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Riwayat SKP (Revisi)</h4>
      </div>
      <form action="<?php echo site_url('profile/upload_file_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="hidden" name="nrk" id="rev_skp_nrk" class="form-control" required="">
                  <input type="hidden" name="thn" id="rev_skp_thn" class="form-control" required="">
                  <input type="hidden" name="jenis_riwayat" value="skp" class="form-control" required="">
                  <input type="hidden" name="filelama" id="rev_skp_filelama" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="upload-cuti" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Riwayat CUTI</h4>
      </div>
      <form action="<?php echo site_url('profile/upload_file_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="hidden" name="nrk" id="cuti_nrk" class="form-control" required="">
                  <input type="hidden" name="jencuti" id="cuti_jencuti" class="form-control" required="">
                  <input type="hidden" name="tgakhir" id="cuti_tgakhir" class="form-control" required="">
                  <input type="hidden" name="tgupd" id="cuti_tgupd" class="form-control" required="">
                  <input type="hidden" name="nosk" id="cuti_nosk" class="form-control" required="">
                  <input type="hidden" name="tmt" id="cuti_tmt" class="form-control" required="">
                  <input type="hidden" name="jenis_riwayat" value="cuti" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="revisi-cuti" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Riwayat SKP (Revisi)</h4>
      </div>
      <form action="<?php echo site_url('profile/upload_file_revisi_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="hidden" name="nrk" id="rev_cuti_nrk" class="form-control" required="">
                  <input type="hidden" name="jencuti" id="rev_cuti_jencuti" class="form-control" required="">
                  <input type="hidden" name="tgakhir" id="rev_cuti_tgakhir" class="form-control" required="">
                  <input type="hidden" name="tgupd" id="rev_cuti_tgupd" class="form-control" required="">
                  <input type="hidden" name="tmt" id="rev_cuti_tmt" class="form-control" required="">
                  <input type="hidden" name="nosk" id="rev_cuti_nosk" class="form-control" required="">
                  <input type="hidden" name="jenis_riwayat" value="cuti" class="form-control" required="">
                  <input type="hidden" name="filelama" id="rev_cuti_filelama" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="upload-jbf" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Riwayat Jabatan Fungsional</h4>
      </div>
      <form action="<?php echo site_url('profile/upload_file_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="hidden" name="nrk" id="jbf_nrk" class="form-control" required="">
                  <input type="hidden" name="kojab" id="jbf_kojab" class="form-control" required="">
                  <input type="hidden" name="kolok" id="jbf_kolok" class="form-control" required="">
                  <input type="hidden" name="tmt" id="jbf_tmt" class="form-control" required="">
                  <input type="hidden" name="jenis_riwayat" value="jbf" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="revisi-jbf" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Riwayat Jabatan Fungsional (Revisi)</h4>
      </div>
      <form action="<?php echo site_url('profile/upload_file_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="hidden" name="nrk" id="rev_jbf_nrk" class="form-control" required="">
                  <input type="hidden" name="kolok" id="rev_jbf_kolok" class="form-control" required="">
                  <input type="hidden" name="kojab" id="rev_jbf_kojab" class="form-control" required="">
                  <input type="hidden" name="tmt" id="rev_jbf_tmt" class="form-control" required="">
                  <input type="hidden" name="jenis_riwayat" value="jbf" class="form-control" required="">
                  <input type="hidden" name="filelama" id="rev_jbf_filelama" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan Ulang </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="upload-penghargaan" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Riwayat Penghargaan</h4>
      </div>
      <form action="<?php echo site_url('profile/upload_file_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="text" name="nrk" id="penghargaan_nrk" class="form-control" required="">
                  <input type="text" name="kdharga" id="penghargaan_kd" class="form-control" required="">
                  <input type="text" name="jenis_riwayat" value="penghargaan" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="revisi-penghargaan" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Riwayat SKP (Revisi)</h4>
      </div>
      <form action="<?php echo site_url('profile/upload_file_revisi_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="text" name="nrk" id="rev_penghargaan_nrk" class="form-control" required="">
                  <input type="text" name="kdharga" id="rev_penghargaan_kd" class="form-control" required="">
                  <input type="text" name="filelama" id="rev_penghargaan_filelama" class="form-control" required="">
                  <input type="text" name="jenis_riwayat" value="penghargaan" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="upload-hukdis" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Riwayat Hukuman Disiplin</h4>
      </div>
      <form action="<?php echo site_url('profile/upload_file_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="hidden" name="nrk" id="hukdis_nrk" class="form-control" required="">
                  <input type="hidden" name="tgsk" id="hukdis_tgsk" class="form-control" required="">
                  <input type="hidden" name="jenhukdis" id="hukdis_jnshuk" class="form-control" required="">
                  <input type="hidden" name="jenis_riwayat" value="hukdis" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="revisi-hukdis" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Riwayat Hukuman Disiplin (Revisi)</h4>
      </div>
      <form action="<?php echo site_url('profile/upload_file_revisi_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="hidden" name="nrk" id="rev_hukdis_nrk" class="form-control" required="">
                  <input type="hidden" name="tgsk" id="rev_hukdis_tgsk" class="form-control" required="">
                  <input type="hidden" name="jnhukdis" id="rev_hukdis_jnshuk" class="form-control" required="">
                  <input type="hidden" name="filelama" id="rev_hukdis_filelama" class="form-control" required="">
                  <input type="hidden" name="jenis_riwayat" value="hukdis" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="upload-hubkel" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Riwayat Hubungan Keluarga</h4>
      </div>
      <form action="<?php echo site_url('profile/upload_file_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="hidden" name="nrk" id="hubkel_nrk" class="form-control" required="">
                  <input type="hidden" name="hubklg" id="hubkel_hubkel" class="form-control" required="">
                  <input type="hidden" name="jenis_riwayat" value="hubkel" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="revisi-hubkel" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Riwayat Hubungan Keluarga (Revisi)</h4>
      </div>
      <form action="<?php echo site_url('profile/upload_file_revisi_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="hidden" name="nrk" id="rev_hubkel_nrk" class="form-control" required="">
                  <input type="hidden" name="hubklg" id="rev_hubkel_hubkel" class="form-control" required="">
                  <input type="hidden" name="filelama" id="rev_hubkel_filelama" class="form-control" required="">
                  <input type="hidden" name="jenis_riwayat" value="hubkel" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="upload-hukadm" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Riwayat Hubungan Keluarga</h4>
      </div>
      <form action="<?php echo site_url('profile/upload_file_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="hidden" name="nrk" id="hubkel_nrk" class="form-control" required="">
                  <input type="hidden" name="hubklg" id="hubkel_hubkel" class="form-control" required="">
                  <input type="hidden" name="jenis_riwayat" value="hukadm" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="revisi-hukadm" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload File Riwayat Hubungan Keluarga (Revisi)</h4>
      </div>
      <form action="<?php echo site_url('profile/upload_file_revisi_riwayat'); ?>" enctype="multipart/form-data" method="POST" >
        <div class="modal-body">
              <div class="form-group">
                <label for="textfield" class="control-label col-sm-3">Upload File</label>
                <div class="col-sm-8">
                  <input type="hidden" name="nrk" id="rev_hubkel_nrk" class="form-control" required="">
                  <input type="hidden" name="hubklg" id="rev_hubkel_hubkel" class="form-control" required="">
                  <input type="hidden" name="filelama" id="rev_hubkel_filelama" class="form-control" required="">
                  <input type="hidden" name="jenis_riwayat" value="hukadm" class="form-control" required="">
                  <input type="file" name="gambar" id="gambar" class="form-control" required="">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="edit"> <i class="fa fa-check"></i> Ajukan </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
// START JABATAN STRUKTURAL
   $(document).on('click', '#btn-dit', function (e){
      var nrk  = $(this).attr('data_nrk');
      var tmt   = $(this).attr('data_tmt');
      var kolok   = $(this).attr('data_kolok');
      var kojab  = $(this).attr('data_kojab');
      $("#nrk").val(nrk);
      $("#tmt").val(tmt)
      $("#kolok").val(kolok)
      $("#kojab").val(kojab)  
   }); 

   $(document).on('click', '#btn-revisi', function (e){
      var rnrk     = $(this).attr('revisi_nrk');
      var rtmt     = $(this).attr('revisi_tmt');
      var rkolok   = $(this).attr('revisi_kolok');
      var rkojab   = $(this).attr('revisi_kojab');
      var filelama   = $(this).attr('revisi_filelama');
      $("#r_nrk").val(rnrk);
      $("#r_tmt").val(rtmt)
      $("#r_kolok").val(rkolok)
      $("#r_kojab").val(rkojab)  
      $("#r_filelama").val(filelama)  
   }); 
// END JABATAN STRUKTURAL

// START JABATAN FUNGSIONAL
   $(document).on('click', '#btn-jbf', function (e){
      var jbf_nrk         = $(this).attr('jbf_nrk');
      var jbf_kojab         = $(this).attr('jbf_kojab');
      var jbf_kolok     = $(this).attr('jbf_kolok');
      var jbf_tmt     = $(this).attr('jbf_tmt');
      $("#jbf_nrk").val(jbf_nrk);
      $("#jbf_kojab").val(jbf_kojab);
      $("#jbf_kolok").val(jbf_kolok)
      $("#jbf_tmt").val(jbf_tmt)
   }); 

   $(document).on('click', '#btn-revisi-jbf', function (e){
      var rev_jbf_nrk       = $(this).attr('rev_jbf_nrk');
      var rev_jbf_kolok     = $(this).attr('rev_jbf_kolok');
      var rev_jbf_kojab     = $(this).attr('rev_jbf_kojab');
      var rev_jbf_tmt       = $(this).attr('rev_jbf_tmt');
      var rev_jbf_filelama  = $(this).attr('rev_jbf_filelama');
      $("#rev_jbf_nrk").val(rev_jbf_nrk);
      $("#rev_jbf_kolok").val(rev_jbf_kolok)
      $("#rev_jbf_kojab").val(rev_jbf_kojab)
      $("#rev_jbf_tmt").val(rev_jbf_tmt)
      $("#rev_jbf_filelama").val(rev_jbf_filelama)  
   }); 
// END JABATAN FUNGSIONAL

// START PENDIDIKAN FORMAL
   $(document).on('click', '#btn-pendidikan', function (e){
      var dt_nrk  = $(this).attr('dt_nrk');
      var dt_jendik   = $(this).attr('dt_jendik');
      var dt_kodik   = $(this).attr('dt_kodik');
      var dt_tglija  = $(this).attr('dt_tglija');
      $("#pendidikan_nrk").val(dt_nrk);
      $("#jendik").val(dt_jendik)
      $("#kodik").val(dt_kodik)
      $("#tgl_ijazah").val(dt_tglija)  
   }); 

   $(document).on('click', '#btn-revisi-pendidikan', function (e){
      var dt_revisi_nrk  = $(this).attr('dt_revisi_nrk');
      var dt_revisi_jendik   = $(this).attr('dt_revisi_jendik');
      var dt_revisi_kodik   = $(this).attr('dt_revisi_kodik');
      var dt_revisi_tglija  = $(this).attr('dt_revisi_tglija');
      var dt_revisi_filelama  = $(this).attr('dt_revisi_filelama');
      $("#rev_pendidikan_nrk").val(dt_revisi_nrk);
      $("#rev_pend_jendik").val(dt_revisi_jendik)
      $("#rev_pend_kodik").val(dt_revisi_kodik)
      $("#rev_pend_tgl_ijazah").val(dt_revisi_tglija)  
      $("#rev_pend_filelama").val(dt_revisi_filelama)  
   }); 
// END PENDIDIKAN FORMAL

// START PENDIDIKAN NON FORMAL
   $(document).on('click', '#btn-pendidikan-nonformal', function (e){
      var nfp_nrk       = $(this).attr('nfp_nrk');
      var nfp_kodik     = $(this).attr('nfp_kodik');
      var nfp_jendik    = $(this).attr('nfp_jendik');
      var nfp_noijazah  = $(this).attr('nfp_noijazah');
      var nfp_tgljazah  = $(this).attr('nfp_tgljazah');
      $("#nfp_nrk").val(nfp_nrk);
      $("#nfp_kodik").val(nfp_kodik)
      $("#nfp_jendik").val(nfp_jendik)
      $("#nfp_noijazah").val(nfp_noijazah)
      $("#nfp_tgljazah").val(nfp_tgljazah)
   }); 






   $(document).on('click', '#btn-revisi-pendidikan-nonformal', function (e){
      var rev_nfp_nrk               = $(this).attr('rev_nfp_nrk');
      var rev_nfp_kodik             = $(this).attr('rev_nfp_kodik');
      var rev_nfp_jendik            = $(this).attr('rev_nfp_jendik');
      var rev_nfp_tgljazah          = $(this).attr('rev_nfp_tgljazah');
      var rev_nfp_noijazah          = $(this).attr('rev_nfp_noijazah');
      var rev_nfp_revisi_filelama   = $(this).attr('rev_nfp_revisi_filelama');
      $("#rev_nfp_nrk").val(rev_nfp_nrk);
      $("#rev_nfp_kodik").val(rev_nfp_kodik)
      $("#rev_nfp_jendik").val(rev_nfp_jendik)
      $("#rev_nfp_tgljazah").val(rev_nfp_tgljazah)
      $("#rev_nfp_noijazah").val(rev_nfp_noijazah)  
      $("#rev_nfp_revisi_filelama").val(rev_nfp_revisi_filelama)  
   }); 
// END PENDIDIKAN NON FORMAL

// START GAPOK
   $(document).on('click', '#btn-gapok', function (e){
      var gp_nrk  = $(this).attr('gp_nrk');
      var gp_tmt   = $(this).attr('gp_tmt');
      var gp_gapok   = $(this).attr('gp_gapok');
      $("#gp_nrk").val(gp_nrk);
      $("#gp_tmt").val(gp_tmt)
      $("#gp_gapok").val(gp_gapok)
   }); 

   $(document).on('click', '#btn-revisi-gapok', function (e){
      var rev_gp_nrk     = $(this).attr('rev_gp_nrk');
      var rev_gp_tmt     = $(this).attr('rev_gp_tmt');
      var rev_gp_gapok   = $(this).attr('rev_gp_gapok');
      var rev_gp_filelama   = $(this).attr('rev_gp_filelama');
      $("#rev_gp_nrk").val(rev_gp_nrk);
      $("#rev_gp_tmt").val(rev_gp_tmt)
      $("#rev_gp_gapok").val(rev_gp_gapok)
      $("#rev_gp_filelama").val(rev_gp_filelama)  
   }); 
// END GAPOK

// START PANGKAT
   $(document).on('click', '#btn-pangkat', function (e){
      var pkt_nrk  = $(this).attr('pkt_nrk');
      var pkt_kopang     = $(this).attr('pkt_kopang');
      var pkt_tmt   = $(this).attr('pkt_tmt');
      var pkt_gapok   = $(this).attr('pkt_gapok');
      $("#pkt_nrk").val(pkt_nrk);
      $("#pkt_tmt").val(pkt_tmt)
      $("#pkt_kopang").val(pkt_kopang);
      $("#pkt_gapok").val(pkt_gapok)
   }); 

   $(document).on('click', '#btn-revisi-pangkat', function (e){
      var rev_pkt_kopang     = $(this).attr('rev_pkt_kopang');
      var rev_pkt_tmt     = $(this).attr('rev_pkt_tmt');
      var rev_pkt_nrk     = $(this).attr('rev_pkt_nrk');
      var rev_pkt_gapok   = $(this).attr('rev_pkt_gapok');
      var rev_pkt_filelama   = $(this).attr('rev_pkt_filelama');
      $("#rev_pkt_nrk").val(rev_pkt_nrk);
      $("#rev_pkt_kopang").val(rev_pkt_kopang);
      $("#rev_pkt_tmt").val(rev_pkt_tmt)
      $("#rev_pkt_gapok").val(rev_pkt_gapok)
      $("#rev_pkt_filelama").val(rev_pkt_filelama)  
   }); 
// END PANGKAT

// START SKP
   $(document).on('click', '#btn-skp', function (e){
      var skp_nrk     = $(this).attr('skp_nrk');
      var skp_thn     = $(this).attr('skp_thn');
      $("#skp_nrk").val(skp_nrk);
      $("#skp_thn").val(skp_thn)
   }); 

   $(document).on('click', '#btn-revisi-skp', function (e){
      var rev_skp_nrk     = $(this).attr('rev_skp_nrk');
      var rev_skp_thn     = $(this).attr('rev_skp_thn');
      var rev_skp_filelama   = $(this).attr('rev_skp_filelama');
      $("#rev_skp_nrk").val(rev_skp_nrk);
      $("#rev_skp_thn").val(rev_skp_thn);
      $("#rev_skp_filelama").val(rev_skp_filelama)  
   }); 
// END SKP

// START CUTI
   $(document).on('click', '#btn-cuti', function (e){
      var cuti_nrk         = $(this).attr('cuti_nrk');
      var cuti_nosk         = $(this).attr('cuti_nosk');
      var cuti_jencuti     = $(this).attr('cuti_jencuti');
      var cuti_tgakhir     = $(this).attr('cuti_tgakhir');
      var cuti_tgupd       = $(this).attr('cuti_tgupd');
      var cuti_tmt       = $(this).attr('cuti_tmt');
      $("#cuti_nrk").val(cuti_nrk);
      $("#cuti_tmt").val(cuti_tmt);
      $("#cuti_nosk").val(cuti_nosk)
      $("#cuti_jencuti").val(cuti_jencuti)
      $("#cuti_tgakhir").val(cuti_tgakhir)
      $("#cuti_tgupd").val(cuti_tgupd)
   }); 

   $(document).on('click', '#btn-revisi-cuti', function (e){
      var rev_cuti_nrk         = $(this).attr('rev_cuti_nrk');
      var rev_cuti_jencuti     = $(this).attr('rev_cuti_jencuti');
      var rev_cuti_tgakhir     = $(this).attr('rev_cuti_tgakhir');
      var rev_cuti_tgupd     = $(this).attr('rev_cuti_tgupd');
      var rev_cuti_tmt     = $(this).attr('rev_cuti_tmt');
      var rev_cuti_nosk     = $(this).attr('rev_cuti_nosk');
      var rev_cuti_filelama     = $(this).attr('rev_cuti_filelama');
      $("#rev_cuti_nrk").val(rev_cuti_nrk);
      $("#rev_cuti_jencuti").val(rev_cuti_jencuti);
      $("#rev_cuti_tgakhir").val(rev_cuti_tgakhir);
      $("#rev_cuti_tgupd").val(rev_cuti_tgupd);
      $("#rev_cuti_tmt").val(rev_cuti_tmt);
      $("#rev_cuti_nosk").val(rev_cuti_nosk);
      $("#rev_cuti_jencuti").val(rev_cuti_jencuti)
      $("#rev_cuti_filelama").val(rev_cuti_filelama)
   }); 
// END CUTI

// START PENGHARGAAN
   $(document).on('click', '#btn-penghargaan', function (e){
      var penghargaan_nrk         = $(this).attr('penghargaan_nrk');
      var penghargaan_kd         = $(this).attr('penghargaan_kd');
      $("#penghargaan_nrk").val(penghargaan_nrk);
      $("#penghargaan_kd").val(penghargaan_kd);
   }); 

   $(document).on('click', '#btn-revisi-penghargaan', function (e){
      var rev_penghargaan_nrk         = $(this).attr('rev_penghargaan_nrk');
      var rev_penghargaan_kd     = $(this).attr('rev_penghargaan_kd');
      var rev_penghargaan_filelama     = $(this).attr('rev_penghargaan_filelama');
      $("#rev_penghargaan_nrk").val(rev_penghargaan_nrk);
      $("#rev_penghargaan_kd").val(rev_penghargaan_kd);
      $("#rev_penghargaan_filelama").val(rev_penghargaan_filelama);
   }); 
// END PENGHARGAAN

// START HUKDIS
   $(document).on('click', '#btn-hukdis', function (e){
      var hukdis_nrk              = $(this).attr('hukdis_nrk');
      var hukdis_tgsk             = $(this).attr('hukdis_tgsk');
      var hukdis_jnshuk           = $(this).attr('hukdis_jnshuk');
      $("#hukdis_nrk").val(hukdis_nrk);
      $("#hukdis_tgsk").val(hukdis_tgsk);
      $("#hukdis_jnshuk").val(hukdis_jnshuk);
   }); 

   $(document).on('click', '#btn-revisi-hukdis', function (e){
      var rev_hukdis_nrk          = $(this).attr('rev_hukdis_nrk');
      var rev_hukdis_tgsk         = $(this).attr('rev_hukdis_tgsk');
      var rev_hukdis_jnshuk       = $(this).attr('rev_hukdis_jnshuk');
      var rev_hukdis_filelama     = $(this).attr('rev_hukdis_filelama');
      $("#rev_hukdis_nrk").val(rev_hukdis_nrk);
      $("#rev_hukdis_tgsk").val(rev_hukdis_tgsk);
      $("#rev_hukdis_jnshuk").val(rev_hukdis_jnshuk);
      $("#rev_hukdis_filelama").val(rev_hukdis_filelama);
   }); 
// END HUKDIS

// START HUBKEL
   $(document).on('click', '#btn-hubkel', function (e){
      var hubkel_nrk              = $(this).attr('hubkel_nrk');
      var hubkel_hubkel           = $(this).attr('hubkel_hubkel');
      $("#hubkel_nrk").val(hubkel_nrk);
      $("#hubkel_hubkel").val(hubkel_hubkel);
   }); 

   $(document).on('click', '#btn-revisi-hubkel', function (e){
      var rev_hubkel_nrk          = $(this).attr('rev_hubkel_nrk');
      var rev_hubkel_hubkel         = $(this).attr('rev_hubkel_hubkel');
      var rev_hubkel_filelama       = $(this).attr('rev_hubkel_filelama');
      $("#rev_hubkel_nrk").val(rev_hubkel_nrk);
      $("#rev_hubkel_hubkel").val(rev_hubkel_hubkel);
      $("#rev_hubkel_filelama").val(rev_hubkel_filelama);
   }); 
// END HUBKEL
</script>










 <!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/inspinia/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/pace/pace.min.js"></script>
<script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/inspinia/js/plugins/sweetalert/sweetalert.min.js"></script>


<script type="text/javascript">

   $(document).ready(function(){
      /* $(".select2_jendikcps").select2({
         width: "55%",
         placeholder: "Pilih Jenis Pendidikan CPS"
      });*/
      $(".select2_kodikcps").select2({
         width: "55%",
         placeholder: "Pilih Pendidikan CPS"
      });
      $(".select2_agama").select2({
         width: "55%",
         placeholder: "Pilih Agama"
      });
   });

   function numbersonly1(myfield, e, dec) 
   {   
        var key; 
        var keychar; 
        if (window.event)
            key = window.event.keyCode; 
        else if (e) 
            key = e.which; 
        else 
            return true; 
        keychar = String.fromCharCode(key); 

        // control keys 
        if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) ) 
        return true; 

        // numbers 
        else if ((("0123456789").indexOf(keychar) > -1))
         return true; 

        // decimal point jump 
        else if (dec && (keychar == ".")) 
        { 
            myfield.form.elements[dec].focus(); return false; 
        } 
        else 
            return false; 
   }
  
   function onclickbutton()
   {
      $('#modalform').modal('show');
   }

   function updateDataPeg()
   {
      var url = "<?php echo site_url('profile/UpdateDasek'); ?>";
      $.ajax({
         url: url,
         type: "POST",
         data: $("#formPass").serialize(),
         dataType: "json",
         beforeSend: function() {
            var agama = $("#agama").val();
            var jenkel = $('input[type=radio][name=jenkel]:checked').val();          
            var taspen = $("#taspen").val();
            var noppen = $("#noppen").val();
            var nokk = $("#nokk").val();
            var simpeda = $("#simpeda").val();
            var nohp = $("#nohp").val();
            var npwp = $("#npwp").val();
            var darah =  $('input[type=radio][name=darah]:checked').val(); 
            var jendikcps = $("#jendikcps").val('1');
            var kodikcps= $("#kodikcps").val();
            var email = $("#email").val();
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
            var cekmail =0;
            if(email.match(mailformat) || email == "")
            {
               cekmail=1;
            }
                            
            if(agama == ""){
            $("#warning").html("Agama Wajib Diisi");
               return false;
            }
            else if(jenkel == undefined){
               $("#warning").html("Jenis Kelamin Wajib Diisi");
               return false;
            }
               else if(noppen=="")
            {
               $("#warning").html("NIK Wajib Diisi");
               return false;
            }
            else if(nokk=="")
            {
               $("#warning").html("No. Kartu Keluarga Wajib Diisi");
               return false;
            }
            else if(simpeda=="")
            {
               $("#warning").html("No. Rekening Wajib Diisi");
               return false;
            }
            else if(npwp=="")
            {
               $("#warning").html("NPWP Wajib Diisi");
               return false;
            }
            else if(darah==undefined)
            {
               $("#warning").html("Golongan Darah Wajib Diisi");
               return false;
            }
            else if(nohp=="")
            {
               $("#warning").html("HP Wajib Diisi");
               return false;
            }
            else if(jendikcps=="")
            {
               $("#warning").html("Jenis Pendidikan Wajib Diisi");
               return false;
            }
            else if(kodikcps=="")
            {
               $("#warning").html("Pendidikan Wajib Diisi");
               return false;
            }
            else if(cekmail == "0")
            {
               $("#warning").html("Email tidak Valid");
               return false;
            }
               else{
               $("#warning").html();     
            }
         },
         success: function(data) {                               
            if(data.responupd == "2"){
              swal("Sukses!", "Perbarui Data Pegawai BERHASIL", "success");                    
              $("#tutupModal").click();
              //$("#tbl-grid").DataTable().ajax.reload();
              location.reload();
            }
            else if(data.responupd == "-2"){
              swal("Gagal!", "Perbarui Data Pegawai GAGAL", "error");                    
              //$("#tutupModal").click();
              //$("#tbl-grid").DataTable().ajax.reload();
            }
            else if(data.responupd == "1"){
              swal("Sukses!", "Tambah Data Pegawai BERHASIL", "success");                    
              $("#tutupModal").click();
              //$("#tbl-grid").DataTable().ajax.reload();
              location.reload();
            }
            else if(data.responupd == "-1"){
              swal("Gagal!", "Tambah Data Pegawai GAGAL", "error");                    
              //$("#tutupModal").click();
              //$("#tbl-grid").DataTable().ajax.reload();
            }
            else{
             swal("Gagal!", "Gagal.", "error");
            }
         },
         error: function(xhr) {                              
             
         },
         complete: function() {              
             
         }
      });
   }

   function UploadFileJabatan()
   {
      // var url = "<?php echo site_url('profile/TESTupload_file_jabatan'); ?>";
      var url = "<?php echo site_url('profile/upload_file_jabatan'); ?>";
      $.ajax({
         url: url,
         type: "POST",
         data: $("#FormUpload").serialize(),
         dataType: "json",
         beforeSend: function() {
            var nrk        = $("#nrk").val();
            var tmt        = $("#tmt").val();
            var kolok      = $("#kolok").val();
            var kojab      = $("#kojab").val();
            var upload     = $("#upload").val();
            var gambar     = $("#gambar").val();
         },
         success: function(data) {                               
            if(data.responupd == 1){
              swal("Sukses!", "Upload File Berhasil", "success");                    
              $("#tutupModal").click();
              //$("#tbl-grid").DataTable().ajax.reload();
              location.reload();
            }
            else if(data.responupd == 2)
            {
              swal("Peringatan!!", "Gagal Upload, Data Telah Ada", "error");                    
              //$("#tutupModal").click();
              //$("#tbl-grid").DataTable().ajax.reload();
            }
            else{
             swal("Gagal!", "Gagal.", "error");
            }
         },
         error: function(xhr) {                              
             
         },
         complete: function() {              
             
         }
      });
   }



   // $("#uploadFormJabatan").on('submit', (function(e) {

   //        e.preventDefault();
   //        $.ajax({
   //            url: '<?php echo site_url("profile/upload_file_jabatan"); ?>',
   //            type: 'post',
   //            // data : {'nrk':nrk, 'id_lemari':id_lemari, 'gambar':gambar},
   //            dataType: "JSON",
   //            data: new FormData(this),
   //            contentType: false,
   //            cache: false,
   //            processData: false,
   //            beforeSend: function() {

   //            },
   //            success: function(data) {
   //                if (data.response == 1) {
   //                    swal("Sukses", "Upload file berhasil", "success");
   //                    $('#gambar').val('');
   //                    location.reload();
   //                } else if (data.response == 2) {
   //                    swal("Gagal", "Lemari dan file tidak boleh kosong", "error");
   //                } else {
   //                    swal("Gagal", "Upload file gagal", "error");
   //                }

   //            },
   //            complete: function() {

   //            }
   //        });
   //    }));
</script>
<!-- Custom and plugin javascript -->   


<?php } else { redirect(base_url().'login/logout'); } ?>
