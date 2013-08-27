<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct(){

		parent::__construct();

		// connect to taskino database
		//$this->taskinodb = $this->load->database('taskinodb', true);

		if( member_check_login() == FALSE )
			redirect('/auth');

		// get default language
		set_taskino_language();
		
	}

	public function do_upload( $description = '', $task_id = null ){
		// 'upload_max_filesize', 'post_max_size'
		// table task_files: id, description, filename, file_type, full_path, full_url, is_image, file_size, created_by, date_added
		$client_codename 			= get_company_code();

		if( strlen($client_codename) < 1 )
			$client_codename 			= 'taskino/'; // get codename to this client
		
		$client_files_upload 	= 'gif|jpg|jpeg|png|pdf|xls|xlsx|doc|docx|txt|svg|zip|rar'; 


		if( strlen($client_codename) > 0 )
			$client_codename = rtrim($client_codename, '/'). '/';

		$folder_up_now = date('Y-m');

		$upload_path = dirname(BASEPATH).'/taskino-uploads/'. $client_codename. $folder_up_now. '/';

		if( !file_exists($upload_path) )
			mkdir( $upload_path, 777, true); // create dir

		$config['upload_path'] 		= $upload_path;
		$config['allowed_types'] 	= $client_files_upload;
		$config['max_size']				= '2048'; 
		$config['encrypt_name']		= true; 
		//$config['max_width']  		= '1024';
		//$config['max_height']  		= '768';

		$this->load->library('upload', $config);

		if ( !$this->upload->do_upload()){

			$error = array('error' => $this->upload->display_errors());

			return $error;

			//$this->load->view('upload_form', $error);

		}	else	{

			$updata = $this->upload->data();

			$file_data = array('description' 	=> $description,
												'task_id' 			=> $task_id, // id da tarefa para salvar arquivo
												'company_id'		=> get_member_session('company_id'), // id da empresa do usuario
												'filename' 			=> $updata['file_name'], // nome do arquivo
												'file_type' 		=> $updata['file_type'], // tipo do arquivo
												'full_path' 		=> str_replace(dirname(BASEPATH), '', $updata['full_path']), // caminho do dir principal: pasta + arquivo
												'full_url' 		 	=> base_url('/taskino-uploads/'. $client_codename. $folder_up_now.'/'.$updata['file_name']), // url direta para o arquivo
												'is_image' 			=> $updata['is_image'], // define se eh imagem ou nao
												'file_size' 		=> $updata['file_size'], // tamanho do arquivo em KB
												'created_by'		=> get_member_session('id'), // quem esta adicionando
												'date_added'		=> date('Y-m-d H:i:s') // data em que foi feito o upload e salvo
												);

			// resize image if more than 1024x768
			$is_big = (bool)( $updata['image_width'] > 1024 || $updata['image_height'] > 768 );

			if( $updata['is_image'] && $is_big ){

				$img_file = $updata['full_path'];

				$img_config['image_library'] 	= 'gd2';
				$img_config['source_image']		= $img_file; 
				//$img_config['create_thumb'] 	= TRUE;
				$img_config['maintain_ratio'] = TRUE;
				$img_config['width']	 				= 1024; 
				$img_config['height']					= 768;

				$this->load->library('image_lib', $img_config); 

				$this->image_lib->resize();

				$new_size = filesize($img_file);
				$new_size = round( ($new_size/1024), 2 );

				if( $new_size != $updata['file_size'] )
					$file_data['file_size'] = $new_size;

			}

			// save on database
			$saved = $this->db->insert('task_files', $file_data);

			// get last id
			$insert_id = $this->db->insert_id();

			$file_uploaded = array( 'file_id' 	=> $insert_id, 
															'full_url'  => $file_data['full_url'], 
															'is_image'	=> $file_data['is_image']
														);
			
			//$data = array('upload_data' => $updata);

			return $file_uploaded;

			//$this->load->view('upload_success', $data);

		}

	}

}

class Admin_Controller extends CI_Controller{

	public function __construct(){
		parent::__construct();

		echo 'loaded from Admin_Controller';

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */