<?php
class query extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
        $this->load->database();
        
	}

	public function SingleValue($tquery)
    {                
        $query = $this->db->query($tquery);
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)                      
            return $row;
        }
        else
            return  NULL;
    } 

	public function MultiValue($tquery)
    {           
        $query = $this->db->query($tquery);
            
        if ($query->num_rows() > 0)     
            return $query->result();                
        else 
            return array(); 
    }












































































































































































}

?>