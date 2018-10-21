<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function uploads()
	{
	      $data = array();
	      if (!empty($_FILES['file']['name'])) {
	          $filesCount = count($_FILES['file']['name']);
						$filename				=	 'Jass_'.mt_rand().'_'.date("d-m-Y");
	          for ($i = 0; $i < $filesCount; $i++) {
								$_FILES['uploadFile']['name'] = str_replace(",","_",$_FILES['file']['name'][$i]);
	              $_FILES['uploadFile']['type'] = $_FILES['file']['type'][$i];
	              $_FILES['uploadFile']['tmp_name'] = $_FILES['file']['tmp_name'][$i];
	              $_FILES['uploadFile']['error'] = $_FILES['file']['error'][$i];
	              $_FILES['uploadFile']['size'] = $_FILES['file']['size'][$i];
	              //Directory where files will be uploaded
	              $uploadPath = 'uploads/';
	              $config['upload_path'] = $uploadPath;
								$file									 = explode('.',$_FILES['file']['name'][$i]);
								$ext									 = end($file);
								$config['file_name']	 = $filename.'.'.$ext;
	              // Specifying the file formats that are supported.
	              $config['allowed_types'] = 'jpg|png|pdf|doc|docx|xls|xlsx|ppt|pptx|txt|rtf';
	              $this->load->library('upload', $config);
	              $this->upload->initialize($config);
	              if ($this->upload->do_upload('uploadFile')) {
	                  $fileData = $this->upload->data();
										$config['image_library'] = 'gd2';
										$config['source_image'] = './uploads/'.$fileData["file_name"];
										$config['create_thumb'] = FALSE;
										$config['maintain_ratio'] = TRUE;
										$config['quality'] = '80';
										$config['width'] = 1200;
										$config['height'] = 628;
										$config['new_image'] = './uploads/'.$fileData["file_name"];
										$this->load->library('image_lib', $config);
										$this->image_lib->initialize($config);
										$this->image_lib->resize();
	                  $uploadData[$i]['file_name'] = $fileData['file_name'];
	              }
	          }
	          if (!empty($uploadData)) {
	              $list=array();
	              foreach ($uploadData as $value) {
	                  array_push($list, $value['file_name']);
	              }
	        echo json_encode($list);
	      	}
	    }
	}
	public function fetch_gallery()
	{
		$dir = "./uploads/";

		// Open a directory, and read its contents
		if (is_dir($dir)){
		  if ($dh = opendir($dir)){
		    while (($file = readdir($dh)) !== false){
					if ($file != "." && $file != "..") {
						$output  = '';
						$output .= '<div class="col-md-3 my-4 text-center"><img src="'.base_url().'uploads/'.$file.'" alt="" class="uploaded_img img-thumbnail">
						<button class="btn-danger form-control btn my-4 thrash" data-call="'.$file.'">Delete</button>
						</div>';
						echo $output;
					}
				}
		    closedir($dh);
		  }
		}
	}
	public function delete()
	{
		$t= $_POST['name'];
		$f = str_replace(['"','[',']'],'',$t);
		echo($f);
		unlink('uploads/'.$f);
	}
}
