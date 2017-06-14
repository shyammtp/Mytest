<?php defined('SYSPATH') or die('No direct script access.'); 

class Controller_Report extends Controller_Core_Front {
	
	protected $_user;
	protected function _initUsers()
    {
		 
		$id = $this->getRequest()->query('id');
		if(!$id)
		{
		   $session = App::model('user/session');
		   $id = $session->getId();
		}		
        $this->_user = App::model('user',false)->load($id); 
		App::register('users',$this->_user);
        return $this->_user;
    }
	
	protected function _onlyForDoctor()
	{
		if(!$this->_user->isDoctor()) {
			$this->page404();
		} 
	}
	
	protected function _getUser()
	{
		return $this->_user; 
	}
	
	protected function _checkLogin()
	{
		$session = App::model('user/session');
		if($session->isLoggedIn()) { 
			return true;
		}
		$this->_redirectUrl('signin');
		return false;
	}
	
	public function action_generate() 
	{
		$this->loadBlocks('settings');
		if($this->getRequest()->query('on_app')) {
			$this->getBlock('content')->setTemplate('column/empty');
		}
		$app_ref_id = $this->getRequest()->query('apptid');
		$appointment_model = App::model('core/appointments',false)->load($app_ref_id,'reference_id');
		App::register('appointments',$appointment_model);
		$this->renderBlocks();
	}
	 
	public function action_settype()
	{		
		$request = $this->getRequest();
		$query = $request->query();
		if($request->post('report_type')) {
			$query['type'] = $request->post('report_type'); 
		}
		$this->_redirect('report/generate',$query);
	}
	
	public function uploadgallery($reportid = '')
	{ 
		$json = array();
		$filename = NULL;
		$fileset = array();
		
		if (isset($_FILES['uploadfile']) && $reportid)
		{
			foreach($_FILES['uploadfile']['name'] as $k => $v) {
				if($v =='') {
					continue;
				}
				$fileset[] = array('name' => $v,
									'type' => Arr::get(Arr::get($_FILES['uploadfile'],'type'),$k),
									'tmp_name' => Arr::get(Arr::get($_FILES['uploadfile'],'tmp_name'),$k),
									'error' => Arr::get(Arr::get($_FILES['uploadfile'],'error',0),$k,0),
									'size' => Arr::get(Arr::get($_FILES['uploadfile'],'size'),$k),
									);
			} 
			foreach($fileset as $file) {
				$uploaddir = 'uploads/user'.DIRECTORY_SEPARATOR.$reportid;
				if(!file_exists(DOCROOT.$uploaddir)) {
					mkdir(DOCROOT.$uploaddir,0777,true);
				}
				$filename = $this->_save_image($file,DOCROOT.$uploaddir);
				if(!$filename)  {
					continue;
				}
				$model = App::model('core/report/gallery')->setReportId($reportid)
						->setFile($uploaddir.DIRECTORY_SEPARATOR.basename($filename))
						->setFileType($file['type'])
						->setAddedOn(date("Y-m-d H:i:s"))
						->save();
			}
		}
	}

	protected function _save_image($image, $dir)
    {
        if (! Upload::valid($image) OR
            ! Upload::not_empty($image) OR
            ! Upload::type($image, array('jpg', 'jpeg', 'png', 'gif','pdf','csv','xls','docx')))
        { 
            return FALSE;
        }
        $directory = $dir;
        if ($file = Upload::save($image, $image['name'], $directory)) {
            return $file;
        }
        return FALSE;
    }
	
	public function action_save()
	{
		$request = $this->getRequest();
		$query = $request->query();
		$model = App::model('core/report',false);
		$session = App::model('user/session');
		$data = $request->post();
		$app_ref_id = $this->getRequest()->query('apptid');
		$appointment_model = App::model('core/appointments',false)->load($app_ref_id,'reference_id');
		
			 
		try {
			$column = Arr::get($data,'column');
			if($column) {
				$rows = array();
				foreach(Arr::get($column,'field1') as $key => $c) {
					$rows[] = array('column1' => $c,
									'column2' => Arr::get(Arr::get($column,'field2'),$key),
									'column3' => Arr::get(Arr::get($column,'field3'),$key),
									'column4' => Arr::get(Arr::get($column,'field4'),$key));
				}
				$data['column'] = $rows;
			}
			if($this->getRequest()->query('report_id'))
			{
				$model->setReportId($this->getRequest()->query('report_id'));
			} 
			$model->setAppointmentId($appointment_model->getId())
					->setReportType(($request->query('type') ? $request->query('type') : 1))
					->setReportDate(Date::formatted_time())
					->setReportData(json_encode($data));
			$model->setPatientId($appointment_model->getUserId());
			$model->setReportedId($appointment_model->getDoctorId());
			$model->setReportAccess(Arr::get($data,'report_access',1));
			if(!$app_ref_id){
				$reporterid = Arr::get($this->getRequest()->query(),'id',$session->getCustomer()->getId());
				$model->setAppointmentId(0)
					->setPatientId(0)
					->setReportedId($reporterid);
			}
			$model->save();
			$this->uploadgallery($model->getId());
			if($this->getRequest()->query('report_id')){
				Notice::add(Notice::SUCCESS,__('Report updated successfully'));
			}else{
				Notice::add(Notice::SUCCESS,__('Report successfully generated'));
			}
		} catch (Kohana_Exception $e) {
			
		}
		
		if(Arr::get($query,'on_app')) {
			$query['report_id'] = $model->getId();
			$this->_redirect('report/viewapp',$query);
		} /*else {
			$this->_redirect('report/view',array('report_id' => $model->getId()));
		}*/
		if($this->getRequest()->query('report_id'))
		{
			$this->_redirectUrl(App::helper('url')->getAccountUrl('account/reports'));
		}
		$this->_redirectUrl(App::helper('url')->getAccountUrl('account/reports'));
	}
	
	public function action_search()
	{
		$request = $this->getRequest();
		$query = $request->query();
		$qstring = array();
		$qstring['pt_name'] = $request->post('patient_name');
		if(Arr::get($query,'on_app')) {
			$this->_redirect('report/user',Arr::merge($query,$qstring));
		} else {
			$this->_redirectUrl(App::helper('url')->getAccountUrl('account/reports',$qstring));
		}
	}
	
	
	public function action_view()
	{
		$request = $this->getRequest();
		$query = $request->query();
		$reportid = $this->getRequest()->query('report_id');
		$session = App::model('user/session');
		$id = $session->getId();
		$report = App::model('core/report',false)->load($reportid);
		$ids = array($report->getPatientId(),$report->getReportedId());
		if(!$report->getId()) {
			$this->_redirectUrl(base64_decode(Arr::get($query,'return')));
		} 
		if(!in_array($id,$ids)) {
			Notice::add(Notice::ERROR,__('Invalid Page'));
			$this->_redirectUrl(base64_decode(Arr::get($query,'return')));
		}
		$this->loadBlocks('settings');
		App::register('report',$report);
		$this->renderBlocks();
	}
	
	public function action_viewapp()
	{
		$request = $this->getRequest();
		$query = $request->query();
		$reportid = $this->getRequest()->query('report_id');
		$report = App::model('core/report',false)->load($reportid);
		if(!$report->getId()) {
			$this->_redirectUrl(base64_decode(Arr::get($query,'return')));
		}
		$this->loadBlocks('settings');
		App::register('report',$report);
		$this->renderBlocks();
	}
	 
	public function action_edit()
	{
		$request = $this->getRequest();
		$query = $request->query();
		$reportid = $this->getRequest()->query('report_id');
		$session = App::model('user/session');
		$id = $session->getId();
		$report = App::model('core/report',false)->load($reportid);
		$ids = array($report->getPatientId(),$report->getReportedId());
		if(!$report->getId()) {
			$this->_redirectUrl(base64_decode(Arr::get($query,'return')));
		}
		if(!in_array($id,$ids)) {
			Notice::add(Notice::ERROR,__('Invalid Page'));
			$this->_redirectUrl(base64_decode(Arr::get($query,'return')));
		}
		$this->loadBlocks('settings');
		App::register('report',$report);
		$this->renderBlocks();
	}
	
	public function action_editapp()
	{
		$request = $this->getRequest();
		$query = $request->query();
		$reportid = $this->getRequest()->query('report_id');
		$report = App::model('core/report',false)->load($reportid);
		if(!$report->getId()) {
			$this->_redirectUrl(base64_decode(Arr::get($query,'return')));
		}
		$this->loadBlocks('settings');
		App::register('report',$report);
		$this->renderBlocks();
	}
	
	public function action_user()
	{
		$this->_initUsers();
		//$this->_onlyForDoctor();
		//$this->_checkLogin();
		$this->loadBlocks('settings');
		App::register('on_app',true);
		$this->renderBlocks(); 
	}
	
	public function action_backtopage()
	{
		return true;
	}
	
	public function action_export()
	{
		$request = $this->getRequest(); 
		$query = $request->query();
		if($request->query('device') == 'android' && $request->query('browser') == false) { 
			exit(__('Redirecting to the browser...'));
		}
		if(count($request->post('export_check')) <= 0 && count($request->query('export_check')) <= 0) {
			Notice::add(Notice::ERROR,__('No reports found'));
			$this->_redirect('report/view',array('report_id' => Arr::get($query,'report_id')));
		}
		$reportid = $this->getRequest()->query('report_id');
		$report = App::model('core/report',false)->load($reportid);
		if(!$report->getId()) {
			Notice::add(Notice::ERROR,__('Invalid page'));
			$this->_redirectUrl(base64_decode(Arr::get($query,'return')));
		}
		if($request->post('export_check')) {
			$report->setReportIds($request->post('export_check'));
		}
		if($request->query('export_check')) {
			$report->setReportIds($request->query('export_check'));
		}
		$this->loadBlocks('settings');
		$patientreports = $report->getPatientReports();
		
		require_once(DOCROOT.'includes/tcpdf/config/lang/eng.php');
        require_once(DOCROOT.'includes/tcpdf/tcpdf.php');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(-10);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->SetFont('dejavusans', '', 12);
		$path = DOCROOT . 'uploads'.DIRECTORY_SEPARATOR. 'export';
        $name = md5(microtime());
        $file = $path . DIRECTORY_SEPARATOR . $name . '.pdf'; 
		foreach($patientreports as $p) {
			$pdf->AddPage();
			$html = '';
			$block = $this->getBlock('content')->getRootBlock()->createBlock('Front/Account/Appointments/Report/View','slc')
					->setTemplate('account/appointments/report/view')
					->setOnlyReport(true)
					->setPdfExport(true)
					->setReport($p);
			$html .= $block->toHtml();
			$pdf->writeHTML($html, true, false, false, false, '');
		}
		$pdf->lastPage();
		$pdf->Output($file, 'F'); 
		$output =  array(
            'type'  => 'filename',
            'value' => $file,
            'rm'    => true // can delete file after use
        );
		$date = str_replace(" ","_",Date::formatted_time());
		$fileName   = 'Report_'.$date.'.pdf';
		$this->_prepareDownloadResponse($fileName, $output); 
	}
}
