<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Abstract extends Blocks_Core
{
    protected $_isExport = false; 
    public function getUrl($path = '',$query = array(),$withdomain = true)
    {
        if(isset($query['__current']) && $query['__current'])
        {
            unset($query['__current']);
			
            $path = Request::detect_uri(); 
            $query = Arr::merge($this->getRequest()->query(),$query);
			$helper = App::helper('front');
			if(isset($query['__noroute'])) {
				$helper->setNoRoutepath(true);
				unset($query['__noroute']);
			}
			 
            return $helper->getUrl($path,$query,$withdomain);
        }
        return App::helper('front')->getUrl($path,$query,$withdomain);
    }
    
    public function getPdfFile()
    {
        $this->_isExport = true; 
        require_once(DOCROOT.'includes'.DS.'tcpdf'.DS.'config'.DS.'lang'.DS.'eng.php');
        require_once(DOCROOT.'includes'.DS.'tcpdf'.DS.'tcpdf.php');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT); 
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->SetFont('helvetica', '', 10);
		$pdf->SetFont('aealarabiya', '', 18);
		$pdf->AddPage(); 
        $path = DOCROOT . 'uploads'.DIRECTORY_SEPARATOR. 'export';
        $name = md5(microtime());
        $file = $path . DIRECTORY_SEPARATOR . $name . '.pdf';
        
		$html = $this->toHtml();
		$pdf->writeHTML($html, true, false, false, false, '');
		$pdf->lastPage();
		$pdf->Output($file, 'F');
        return array(
            'type'  => 'filename',
            'value' => $file,
            'rm'    => true // can delete file after use
        );
    }
}
