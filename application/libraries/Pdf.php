<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Pdf {
    
    function pdf()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }
 
    function load($orientation = "P")
    {
        include_once APPPATH.'/third_party/mpdf/mpdf.php'; 

        //altera o modo entre portrait e landscape
        if(strtoupper($orientation) == "L")
            $mode = "A4-L";
        else
            $mode = "A4";
        
        return new mPDF("",$mode,0,"",10,10,50,0,6,0);
    }
}