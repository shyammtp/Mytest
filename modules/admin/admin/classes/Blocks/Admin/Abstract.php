<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Abstract extends Blocks_Core
{
    public function getUrl($path = '',$query = array(),$type = '')
    { 
        if(isset($query['__current']) && $query['__current'])
        {
            unset($query['__current']);
			$path = Request::detect_uri(); 
			if(App::instance()->getWebsite()->getSubfolder()) {
				$path = App::instance()->getWebsite()->getSubfolder().$path;
			} 
            $query = Arr::merge($this->getRequest()->query(),$query); 
            return App::helper('admin')->getAdminUrl($path,$query,$type);
        }
        return App::helper('admin')->getAdminUrl($path,$query,$type);
    }
	
	public function getLanguage()
	{ 
		return App::model('core/language')->getLanguages();
	}
	
    
    public function getPdfFile($html)
    {
        $this->_isExport = true;
        require_once(DOCROOT.'includes/pdf/config/lang/eng.php');
        require_once(DOCROOT.'includes/pdf/tcpdf.php');
		
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//set margins
		//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetMargins(0, 0, 0);
		$pdf->SetHeaderMargin(-10);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		//set some language-dependent strings
		$pdf->setLanguageArray($l);

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('helvetica', '', 10);

		// add a page
		$pdf->AddPage();
		
		
		$pdf->writeHTML($html, true, false, false, false, '');
		$pdf->lastPage();
		$pdf->Output($file, 'F');
        return array(
            'type'  => 'filename',
            'value' => $file,
            'rm'    => true // can delete file after use
        );
    }
	
	public function renderField($type,$attributes = array())
	{
		$block = $this->getRootBlock();
		$fieldname = Text::random().$type;
		switch($type) {
			default:
			case "text":
				return $block->createBlock('Core/Html/Language/Text',$fieldname)
						->setAttributes($attributes)
						->setLanguage($this->getLanguage())->toHtml();  
				break;
			case "textarea":
				return $block->createBlock('Core/Html/Language/Textarea',$fieldname)
						->setAttributes($attributes)
						->setLanguage($this->getLanguage())->toHtml();  
				break;
		}
		return '';
	}
}
