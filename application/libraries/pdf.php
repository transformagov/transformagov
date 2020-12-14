<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
    public function Header() {
        /*
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');*/
        if($this->page > 1){     
                $this->Image(base_url('images/dossie1.png'), 0, 0, 120, 30, 'PNG', '', false);
                //$this->Cell(0, 10, base_url('images/dossie1.png'), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
    }
    public function Footer() {
        if($this->page > 1){                 
                $this->Image(base_url('images/dossie2.png'), 100, 267, 120, 30, 'PNG', '', false);
                $this->SetY(-15);
                $this->SetFont('helvetica', 'I', 8);
                $this->Cell(0, 10, $this->getAliasNumPage(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                
        }
        /*
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');*/
    }
}