<?php 

 class Libur_nasional extends CI_Model {

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

    

    public function get_data_libur()
    {
        $requestData = $this->input->post(); 
        // $tahun = $requestData['tahun'];

        // echo $tahun; exit();

        $columns = array( 
        // datatable column index  => database column name
            0 => 'TGL_LIBUR',
            1 => 'TGL_LIBUR',
            2 => 'KET',
            3 => 'KET'

        );

        // getting total number records without any search
        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,
                    ID_HARI_LIBUR,to_char(TGL, 'DD-MM-YYYY') TGL_LIBUR,KET FROM PERS_HARI_LIBUR
                )A";
        // echo $sql;exit();
        
        $query = $this->db->query($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM (
                    SELECT ROWNUM AS RN,
                    ID_HARI_LIBUR,to_char(TGL, 'DD-MM-YYYY') TGL_LIBUR,KET FROM PERS_HARI_LIBUR
                )A  WHERE 1 = 1  ";

        
        // getting records as per search parameters
        if( !empty($requestData['search']['value']) ){   //kode nptt
            $sql.=" AND lower(TGL_LIBUR) LIKE lower('%".$requestData['search']['value']."%') ";
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
            $nestedData[] = $row->TGL_LIBUR;
            $nestedData[] = $row->KET;
            $nestedData[] = "<button type='button' class='btn btn-outline btn-xs btn-danger' title='Hapus ' onClick='hapus_data(\"".$row->ID_HARI_LIBUR."\");'><i class='fa fa-trash'></i></button>
                <button type='button' class='btn btn-outline btn-xs btn-primary' title='Hapus ' onClick='ubah_data(\"".$row->ID_HARI_LIBUR."\");'><i class='fa fa-edit'></i></button>";
                        
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


    public function cek_libur($tgl){
        $sql = "SELECT COUNT(*) AS JML FROM PERS_HARI_LIBUR WHERE to_char(TGL, 'DD-MM-YYYY') = '".$tgl."'";

        $data = $this->db->query($sql)->row();
        $JML = $data->JML;

        return $JML;
    }

    public function save_libur($id,$tgl,$ket){

        $ket = str_replace("'", "`", $ket);
        $sql = "INSERT INTO PERS_HARI_LIBUR(ID_HARI_LIBUR,TGL,KET,TG_UPD,UPD_BY) 
                VALUES (PERS_HARI_LIBUR_SEQ.nextval,TO_DATE('".$tgl."', 'DD-MM-YYYY'),'".$ket."',TO_DATE('".date('d-m-Y')."', 'DD-MM-YYYY'),'".$id."')"; 
        // echo $sql;exit();
        $query = $this->db->query($sql);

        return $query;
    }


    public function get_data($id){
        $sql = "SELECT to_char(TGL, 'DD-MM-YYYY') AS TGL_LIBUR,KET
                FROM PERS_HARI_LIBUR
                WHERE ID_HARI_LIBUR = '".$id."' ";
        // echo $sql; exit();
        return $this->db->query($sql)->row();
    }

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
