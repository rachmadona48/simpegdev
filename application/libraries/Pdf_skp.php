<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once dirname(__FILE__) . '/tcpdf/tcpdf/tcpdf.php';
 
class Pdf_skp extends TCPDF
{
    function __construct()
    {
        parent::__construct('P','mm','A4',true,'UTF-8',false,false);
    }

    //var $top_margin = 20;
    public function Header() {
        // Logo
        // $image_file = K_PATH_IMAGES.'tcpdf_logo.jpg';
        
        // echo $image_file;exit();
        // $this->Image($image_file, 10, 10, 35, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);



        // Set font
        // $this->SetFont('helvetica', 'B', 15);
        
        // $this->Cell(0, 5, 'Daftar Riwayat Hidup', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->Ln();
        // $this->SetFont('helvetica', 'B', 15);
        // $this->Cell(0, 5, 'Daftar Riwayat Hidup', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        // $this->Ln();
        // $this->SetFont('helvetica', '', 11);
        // $this->Cell(0, 5, 'PEMERINTAH PROVINSI DAERAH KHUSUS IBUKOTA JAKARTA', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->Ln();
        // $this->SetFont('helvetica', '', 11);
        // $this->Cell(0, 5, 'Jalan Medan Merdeka Selatan No.8-9 ', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->Ln();
        // $this->SetFont('helvetica', '', 11);
        // $this->Cell(0, 5, 'J A K A R T A', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        
        // $this->top_margin = $this->GetY() - 20;
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        //$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
 
/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */