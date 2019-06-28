<?php 

 class Spesimen_ka_bkd extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    private $ci;
    private $ekin;

    function __construct()
    {        
        parent::__construct();

         $this->ci =& get_instance();
        $this->ci->load->database(); 
        // $this->prod = $this->ci->load->database('ORP1', TRUE);
        
    } 

    

    public function get_data_ttd_ka_bkd()
    {
        $requestData = $this->input->post(); 
        // $tahun = $requestData['tahun'];

        // echo $tahun; exit();

        $columns = array( 
        // datatable column index  => database column name
            0 => 'ID',
            1 => 'NRK',
            2 => 'NAMA',
            3 => 'FILE_TTD',
            4 => 'FILE_TTD'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,TTD.ID,TTD.NRK,PG.NAMA,TTD.STATUS,TTD.FILE_TTD,TTD.FILE_LOCATION
                    FROM PERSDN_TTD_KA_BKD TTD
                    LEFT JOIN PERS_PEGAWAI1 PG ON TTD.NRK = PG.NRK
                )A";
        // echo $sql;exit();
        
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,TTD.ID,TTD.NRK,PG.NAMA,TTD.STATUS,TTD.FILE_TTD,TTD.FILE_LOCATION
                    FROM PERSDN_TTD_KA_BKD TTD
                    LEFT JOIN PERS_PEGAWAI1 PG ON TTD.NRK = PG.NRK
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND (lower(NRK) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(NAMA) LIKE lower('%".$requestData['search']['value']."%') ";
            $sql.=" OR lower(STATUS) LIKE lower('".$requestData['search']['value']."')) ";
            // echo $sql; exit(); 
        }
        
        
        
        $query= $this->db->query($sql);
        $totalFiltered = $query->num_rows();    
        
        $sql.=" AND RN > ".$requestData['start']." AND  ROWNUM <= ".$requestData['length']." "; 
        $sql.=" ORDER BY \"".$columns[$requestData['order'][0]['column']]."\"   ".$requestData['order'][0]['dir']." ";  // adding length
        
        // ECHO $sql;exit;
        // var_dump($sql);exit;
         // echo $sql;  
        $query= $this->db->query($sql);
        $n = $_POST['start'];
        $no = $n+1;
        $data = array();        

        foreach($query->result() as $row){
            $nestedData=array(); 
            $nestedData[] = $no;
            $nestedData[] = $row->NRK;
            $nestedData[] = $row->NAMA;
            $nestedData[] = '

                            <div class="profile-image">
                                <a href="'.base_url().$row->FILE_LOCATION.'/'.$row->FILE_TTD.'" data-gallery="">
                                  <img src="'.base_url().$row->FILE_LOCATION.'/'.$row->FILE_TTD.'" class="img-responsive img-thumbnail m-b-md" alt="profile">
                                </a>    
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
                ';

            if($row->STATUS=='Aktif'){
                $label_status = "<button type='button' class='btn btn-outline btn-xs btn-success' title='Aktif'><i class='fa fa-check-square-o'></i></button>";
            }else{
                $label_status = "<button type='button' class='btn btn-outline btn-xs btn-danger' title='Tidak Aktif'><i class='fa fa-times'></i></button>";
            }

            $nestedData[] = "<button type='button' class='btn btn-outline btn-xs btn-danger' title='Hapus' onClick='hapus_data(\"".$row->ID."\");'><i class='fa fa-trash'></i></button>
                <button type='button' class='btn btn-outline btn-xs btn-primary' title='Ubah' onClick='ubah_data(\"".$row->ID."\");'><i class='fa fa-edit'></i></button>
                ".$label_status;
                        
            $data[] = $nestedData;
            $no++;
        }   

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ),  
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data   
                    );

        echo json_encode($json_data); 
    }


    public function cek_pgw($nrk){
        $sql = "SELECT COUNT(*) AS JML FROM PERS_PEGAWAI1 WHERE NRK = '".$nrk."'";

        $data = $this->db->query($sql)->row();
        $JML = $data->JML;

        return $JML;
    }

    public function get_pgw($nrk){
        $sql = "SELECT NAMA FROM PERS_PEGAWAI1 WHERE NRK = '".$nrk."'";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function cek_ttd_bkd($nrk){
        $sql = "SELECT COUNT(*) AS JML FROM PERSDN_TTD_KA_BKD WHERE NRK = '".$nrk."'";

        $data = $this->db->query($sql)->row();
        $JML = $data->JML;

        return $JML;
    }

    public function insert_ttd($id_user, $nrk, $status,$gambar,$location,$date){

        $sql_id = "SELECT SEQ_PERSDN_TTD_KA_BKD.nextval as ID_BARU from dual";

        $data = $this->db->query($sql_id)->row();
        $new_id = $data->ID_BARU;
        
        $sql = "INSERT INTO PERSDN_TTD_KA_BKD(ID,NRK,STATUS,FILE_TTD,FILE_LOCATION,CREATE_USER,CREATE_DATE) 
                VALUES (".$new_id.",'".$nrk."','".$status."','".$gambar."','".$location."','".$id_user."',TO_DATE('".$date."', 'DD-MM-YYYY'))"; 
        // echo $sql;exit();
        $query = $this->db->query($sql);

        if($status=='Aktif'){
            $sql_update = "UPDATE PERSDN_TTD_KA_BKD SET STATUS ='Tidak Aktif' WHERE ID <> ".$new_id." ";
            // echo $sql;exit();
            $this->db->query($sql_update);
        }

        return True;
    }

    public function cek_status($id){
        $sql = "SELECT STATUS FROM PERSDN_TTD_KA_BKD WHERE ID = ".$id." ";

        $data = $this->db->query($sql)->row();

        return $data;
    }

    public function delete_data($id){
        $sql = "DELETE FROM PERSDN_TTD_KA_BKD WHERE ID = ".$id." ";
        // echo $sql;exit();
        $query = $this->db->query($sql);

        return $query;
    }


    public function get_data($id){
        $sql = "SELECT TTD.ID,TTD.NRK,PG.NAMA,TTD.STATUS,TTD.FILE_TTD,TTD.FILE_LOCATION
                FROM PERSDN_TTD_KA_BKD TTD
                LEFT JOIN PERS_PEGAWAI1 PG ON TTD.NRK = PG.NRK 
                WHERE TTD.ID = ".$id." ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

    public function update_status_tidak_aktif($nrk){
        $sql_update = "UPDATE PERSDN_TTD_KA_BKD SET STATUS ='Tidak Aktif' WHERE NRK <> ".$nrk." ";
            // echo $sql;exit();
        $this->db->query($sql_update);
        return True;
    }

    public function update_ttd_gambar($id_user, $nrk, $status,$gambar,$location,$date){
        $sql_update = "UPDATE PERSDN_TTD_KA_BKD SET FILE_TTD='".$gambar."',FILE_LOCATION='".$location."',STATUS ='".$status."',CREATE_USER='".$id_user."',CREATE_DATE=TO_DATE('".$date."', 'DD-MM-YYYY') WHERE NRK = ".$nrk." ";
            // echo $sql;exit();
        $this->db->query($sql_update);
        $this->update_status_tidak_aktif($nrk);
        return True;
    }

    public function update_ttd($id_user, $nrk, $status,$date){
        $sql_update = "UPDATE PERSDN_TTD_KA_BKD SET STATUS ='".$status."',CREATE_USER='".$id_user."',CREATE_DATE=TO_DATE('".$date."', 'DD-MM-YYYY') WHERE NRK = ".$nrk." ";
            // echo $sql;exit();
        $this->db->query($sql_update);
        $this->update_status_tidak_aktif($nrk);
        return True;
    }


#================================================================================================================================







    public function save_libur($id,$tgl,$ket){

        $ket = str_replace("'", "`", $ket);
        $sql = "INSERT INTO PERS_HARI_LIBUR(ID_HARI_LIBUR,TGL,KET,TG_UPD,UPD_BY) 
                VALUES (PERS_HARI_LIBUR_SEQ.nextval,TO_DATE('".$tgl."', 'DD-MM-YYYY'),'".$ket."',TO_DATE('".date('d-m-Y')."', 'DD-MM-YYYY'),'".$id."')"; 
        // echo $sql;exit();
        $query = $this->db->query($sql);

        return $query;
    }


    // public function get_data($id){
    //     $sql = "SELECT to_char(TGL, 'DD-MM-YYYY') AS TGL_LIBUR,KET
    //             FROM PERS_HARI_LIBUR
    //             WHERE ID_HARI_LIBUR = '".$id."' ";
    //     // echo $sql; exit();
    //     return $this->db->query($sql)->row();
    // }

    public function update_libur($id_user,$id,$tgl,$ket){
        $ket = str_replace("'", "`", $ket);
        $sql = "UPDATE PERS_HARI_LIBUR SET TGL=TO_DATE('".$tgl."', 'DD-MM-YYYY'), KET= '".$ket."', TG_UPD = TO_DATE('".date('d-m-Y')."', 'DD-MM-YYYY'),
                UPD_BY = '".$id_user."' WHERE ID_HARI_LIBUR = ".$id." ";
        // echo $sql;exit();
        $query = $this->db->query($sql);

        return $query;
    }
    
    public function delete_libur($id){
        $sql = "DELETE FROM PERS_HARI_LIBUR WHERE ID_HARI_LIBUR = ".$id." ";
        // echo $sql;exit();
        $query = $this->db->query($sql);

        return $query;
    }

   
    
}

?>
