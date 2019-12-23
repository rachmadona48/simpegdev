<?php
/**
* 
*/
class Model_public extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
        $this->load->database();
	}

    public function message_status($status_property)
    {
        $view_status = "";
        $view_url = "";

        $parameter      = $status_property['parameter'];
        $message        = $status_property['message'];
        $error_message  = $status_property['error_message'];
        $status_message = $status_property['status_message'];
        $url_process    = $status_property['url_process'];
        $error_icon     = $status_property['error_icon'];
        $error_type     = $status_property['error_type'];

        if(($status_message == "save")||($status_message == "edit"))
        {
            $view_status = "Edit";
            $view_url = $url_process;
        }
        
        $view_message = '<div class="alert '.$error_message.'">
                            <button class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="ace-icon '.$error_icon.'"></i> '.$error_type.'</strong>
                            '.$message.' <a href="'.$view_url.'" class="alert-link confirm-edit">'.$view_status.'</a>
                        </div>';

        $this->session->set_flashdata($parameter,$view_message);
    }


    public function conv_validasi_to_indonesia(){
        $this->form_validation->set_message('required','%s wajib diisi.');
        $this->form_validation->set_message('min_length','%s sekurang-kurangnya harus berisi %s karakter.');
        $this->form_validation->set_message('max_length','%s tidak boleh lebih dari %s karakter.');
        $this->form_validation->set_message('valid_email','%s harus berisi alamat email yang valid.');
        $this->form_validation->set_message('numeric','%s harus bernilai numeric yang valid.');
        $this->form_validation->set_message('integer','%s harus bernilai integer yang valid.');
        $this->form_validation->set_message('matches','%s tidak cocok dengan %s.');
        $this->form_validation->set_message('is_unique','%s sudah digunakan.');
        $this->form_validation->set_message('alpha_numeric','%s hanya boleh diisi dengan huruf dan angka.');
        $this->form_validation->set_message('alpha','%s hanya boleh diisi dengan huruf.');
    }   


}

?>