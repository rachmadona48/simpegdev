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
      
        <?php if ($infoUser->ESELON!='00') { ?>           
           <div class="col-lg-12">        
                <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#1AB394">
                    <h5 style="color:#ffffff">List SKP Bawahan Mutasi</h5>
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
                                        <table id="listnilaibawahan" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>                                                
                                                    <th>Periode Awal</th>
                                                    <th>Periode Akhir</th>                                                
                                                    <th>Keterangan</th>                               
                                                    <th width="20%">Action</th>    
                                                </tr>
                                            </thead>
                                        <tbody class="contains-body">                                        
                                        </tbody>
                                    </table>                                    
                                    </div>
                                </div>
                            </div>
                    </div>
                </div> <!-- akhir div ibox content-->
                </div> <!-- akhir div ibox float e-margins -->
               
            </div>

            <div class="col-lg-12">        
                <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#1AB394">
                    <h5 style="color:#ffffff">List Hasil penilaian Mutasi</h5>
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
                                        <table id="listhasilmutasi" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>                                                
                                                    <th>Periode Awal</th>
                                                    <th>Periode Akhir</th>                                                
                                                    <th>Keterangan</th>                               
                                                    <th width="20%">Action</th>    
                                                </tr>
                                            </thead>
                                        <tbody class="contains-body">                                        
                                        </tbody>
                                    </table>                                    
                                    </div>
                                </div>
                            </div>
                    </div>
                </div> <!-- akhir div ibox content-->
                </div> <!-- akhir div ibox float e-margins -->
               
            </div>

                  
        <?php } ?>