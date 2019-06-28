<?php 

 class Mlogin_api extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {        
        parent::__construct();        
    }
    
    function login_api($data)
    {
        $db_ekin = $this->load->database('default', TRUE);

        $username = $data['username'];      

        $sql = "select 1 from \"master_user\" where \"user_id\" ='".$username."' AND \"user_enable\"='t' ";
        $query = $db_ekin->query($sql);
        return $query->result();
    }

    function read_user_information($username)
    {   
        $db_ekin = $this->load->database('default', TRUE);

        // $sql = "select * from \"master_user\" where \"user_id\" ='".$username."'";
        // $query = $db_ekin->query($sql);
        $sql = "select * from \"master_user\" where \"user_id\" ='".$username."'";
        $query = $this->db->query($sql)->result();
		if($query[0]->user_group_id == 1){
			return $this->read_user_information2($query[0]->user_id);
		}else{
	        return $query;
		}
    }
    
    function read_user_information2($username)
    {
    	
        $sql="SELECT A.*, B.KOPANG FROM \"master_user\" A LEFT JOIN \"vw_jabatan_terakhir\" B ON A.\"user_id\" = B.NRK WHERE A.\"user_group_id\" = 1 AND A.\"user_id\" = '".$username."'";
        
        $query = $this->db->query($sql);
        return $query->result();
    }

	function get_golongan($username)
	{
		$query = "SELECT KOPANG FROM \"vw_jabatan_terakhir\" where \"NRK\" ='".$username."'";
		$res = $this->db->query($query);
		return $res->row();
	}

    function getPegawai()
    {        
        $db_ekin = $this->load->database('default', TRUE);

        $sql = "SELECT AGAMA FROM PERS_AGAMA_RPT OFFSET 2 ROWS FETCH NEXT 1 ROWS ONLY";
        $query = $db_ekin->query($sql);
        return $query->result();
    }
    
     function cekMenuAccessGroupId($user_group_id)
    {
         $db_ekin = $this->load->database('default', TRUE);

         //$sql="select * from \"menu_access_user\" where \"user_group_id\"='".$user_group_id."'";
         $sql= "SELECT a.\"menu_access_id\",a.\"act_view\",a.\"user_group_id\",b.\"nama_menu\",b.\"jenis_menu\" 
                FROM \"menu_access_user\" a
                LEFT JOIN \"menu_master\" b ON a.\"menu_id\" = b.\"id_menu\"
                WHERE a.\"user_group_id\"=1 AND b.\"jenis_menu\"=0 AND b.\"status_aktif\"='Y'";
         $query = $db_ekin->query($sql);
         return $query->result();
    }

    function updateMode($post)
    {
        $out='-';
        if(isset($post['mode']))
        {
            $mode = $post['mode'];

            $q = "UPDATE MAINTENANCE_MODE SET STATUS = '$mode'";
            $res = $this->db->query($q);
            
            if($res)
            {
                $sql = "SELECT STATUS FROM MAINTENANCE_MODE";
                $query = $this->db->query($sql)->row();
                $out = $query->STATUS;
            }    
        }
        
        
        return $out;
    }


    function cek_user($data)
    {
        $db_ekin = $this->load->database('default', TRUE);

        $user = $data['user'];      

        $sql = "select 1 from \"master_user\" where \"user_id\" ='".$user."' AND \"user_enable\"='t' ";
        // echo $sql;exit();
        $query = $db_ekin->query($sql);
        return $query->result();
    }


}

?>