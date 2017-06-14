<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Database Model base class.
 *
 * @package    Kohana/Database
 * @category   Models
 * @author     Kohana Team
 * @copyright  (c) 2008-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Model_Api_Productgallery extends Model_RestAPI {
	
	public function __construct()
	{ 		
		$this->_model = App::model('product/gallery');
	}
	
	public function get($params)
	{
		if(!isset($params['place'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing Place Id'),
				'field' => 'place',
			));
		}
		if(!isset($params['product_id'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing Product Id'),
				'field' => 'product_id',
			));
		}
		$customer = App::model('user')->load($params['user_token'],'user_token');
		$data=array();
		$gallery_image=App::model('product/gallery')->getGalleryImagesapi($params['place'],$customer->getUserId(),$params['product_id']);
		
		foreach($gallery_image as $key => $value){
			$value['file'] = App::getBaseUrl('media').$value['file'];
			$data[] = $value; 
			
		} 
		return $data; 
	}
	
	
	public function create($params)
	{
		if(!isset($params['place'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing Place Id'),
				'field' => 'place',
			));
		}
		if(!isset($params['product_id'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing Product Id'),
				'field' => 'product_id',
			));
		}
		if(!isset($params['user_token'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing User Token'),
				'field' => 'user_token',
			));
		}
		try{
			$place = $params['place'];
			$customer = App::model('user')->load($params['user_token'],'user_token');
			$data = array();
			$filename = NULL;
			if (isset($_FILES['product_image']))
			{
				$uploaddir = 'uploads/products'.DS.$params['product_id'];
				if(!file_exists(DOCROOT.$uploaddir)) {
					mkdir(DOCROOT.$uploaddir,0777,true);
				}
				$filename = $this->_save_image($_FILES['product_image'],DOCROOT.$uploaddir);
				$data['file'] = basename($filename);
				$model = App::model('product/gallery')->setProductId($params['product_id'])
						->setPlaceId($place)
						->setUserId($customer->getUserId())
						->setFile($uploaddir.DS.basename($filename))
						->setFileType($_FILES['product_image']['type'])
						->setAddedOn(date("Y-m-d H:i:s"))
						->save();
			}
			if (!$filename) {
				$data['error'] = 'There was a problem while uploading the image.
					Make sure it is uploaded and must be JPG/PNG/GIF file.';
			}
			$data['success'] = true;		
		}
		catch(Validation_Exception $ve) { 
				$errors = $ve->array->errors('validation',true); 
				$data['errors'] = $errors; 
		} catch(Kohana_Exception $ke) {
				Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
				Log::Instance()->add(Log::ERROR, $e);
		}
		return $data;
	} 	
		
	public function delete($params)
	{		
		$data = array();
		if(!isset($params['id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing id'),
				'field' => 'id',
			));
		}
		if(!isset($params['image'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing image'),
				'field' => 'image',
			));
		}
		$json = array();
		$json['success'] = false;
		if($params['image']) {
			$image = $params['image'];
			$productId = $params['id'];
			$delete = DB::delete(App::model('product/gallery')->getTableName())->where('file','=',$image)->where('product_id','=',$productId)
						->execute();
			if(file_exists(DOCROOT.$image)) {
				unlink(DOCROOT.$image);
			}
			$json['success'] = true;
		}
		return $json;
	}	
	
	
	protected function _save_image($image, $dir)
    {
        if (! Upload::valid($image) OR
            ! Upload::not_empty($image) OR
            ! Upload::type($image, array('jpg', 'jpeg', 'png', 'gif','mp4','flv','avi','wmv','mov')))
        {
            return FALSE;
        }
        $directory = $dir;
        if ($file = Upload::save($image, $image['name'], $directory)) {
            return $file;
        }
        return FALSE;
    }
	
}	
