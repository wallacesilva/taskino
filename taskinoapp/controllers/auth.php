<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){

		parent::__construct();

		// connect to taskino database
		//$this->taskinodb = $this->load->database('taskinodb', true);

		// get default language
		set_taskino_language();

	}

	public function index(){
		/*$this->db->where('assigned_to', 1);// get_member_session('id'));
		$this->db->order_by('priority', 'asc');

		$tasks				 = $this->db->get('tasks', 0, 10);
		$data['tasks'] = $tasks->result();
		$data['my_tasks'] = '('.'usuario'.')';*/
		$data = null;

		// get messages
    $msg_error = $this->session->flashdata('msg_error');
    if( $msg_error !== false )
      $data['msg_error'] = $msg_error;

    $msg_ok = $this->session->flashdata('msg_ok');
    if( $msg_ok !== false )
      $data['msg_ok'] = $msg_ok;

		$this->load->view('login', $data);
	}

	public function check_login( $login ){

		if (strlen($login) < 3) {
			echo 'no';
		} else {

			if (check_member_login_exists($login)) {
				echo 'yes';
			} else {
				echo 'no';
			}

		}

	}

	public function choose_company(){

		// prevent access direct, required logged
		if( get_member_session('id') < 1 )
			redirect('auth');

		$data = null;

		if( isset($_POST['company_id']) ){

			if( $_POST['company_id'] > 0 ){
				
				$company_id = $_POST['company_id'];

				member_set_company_session($company_id);

				// check is ok 
				if( get_member_session('company_id') > 0 )
					redirect('dashboard');

			} 

			$data['msg_error'] = _gettxt('msg_error_incorrect_company'); //'empresa incorreta';

		}

		$data['member_companies'] = member_get_company(get_member_session('id')); //get_member_session('companies'); //member_get_company();

		$this->load->view('login', $data);

	}

	// try login
	public function login(){

		$data['msg_error'] = '';

		//$email 		= $this->input->post('email');
		$login 		= $this->input->post('login');
		$password = $this->input->post('password');
		
		if( isset($_POST['login']) && isset($_POST['password']) ){

			$logged = member_do_login($login, $password);
		
			// verifica se realizou o login			
			if( $logged == true ){
				
				redirect('dashboard');
				
				/*
				// fix multiple company
				$member_company_id = get_member_session('company_id');
				if( $member_company_id > 0 )
					redirect('dashboard');
				else 
					redirect('auth/choose_company');*/

			} else {

				$data['msg_error'] = _gettxt('msg_error_incorrect_login_pass'); //'login ou senha incorretos';

			}

		}

		$this->load->view('login', $data);

	}

	// show form to change forgot password
	public function recover_password( $activation_key = null ){

		if( strlen($activation_key) < 1 )
			redirect('auth');

		$this->db->where('activation_key', $activation_key);
		$member_with_key = $this->db->get('members')->result();
		//$member_with_key = $member_with_key[0];

		$data = array();

		if( count($member_with_key) != 1 ){

			// key not found 
			redirect('auth');

		} else {
			
			$data['member']['id'] 		= $member_with_key[0]->id;
			$data['member']['email'] 	= $member_with_key[0]->email;
			$data['member']['login'] 	= $member_with_key[0]->login;

		}

		$data['activation_key'] 	= $activation_key;
		$data['recover_password'] = true;

		$this->load->view('login', $data);

	}

	// save form to change new password
	public function save_recover_password(){

		if( strlen($this->input->post('activation_key')) < 1 )
			redirect('auth');

		$data = array();

		$data_update = array('password' 			=> sha1($this->input->post('password')),
												 'activation_key' => null 
												 );

		$this->db->where('activation_key', $this->input->post('activation_key', true) );
		$pass_changed = $this->db->update('members', $data_update);

		if( $pass_changed ){
			
			$data['msg_ok'] = _gettxt('msg_ok_pass_changed'); //'Password changed with success!';
			
		}	else {

			$data['msg_error'] = _gettxt('msg_error_pass_not_changed'); //'Error on change your password.';
			$data['activation_key'] = $this->input->post('activation_key');
			$data['recovered_pass'] = true;

		}

		$this->load->view('login', $data);		

	}

	// active to change password from url
	public function forgot_password(){

		if( $this->input->post('recover_password') == 'do_please' ){
 
			$data['msg_ok'] = ''; // 'Wow! Enviado por email';

			//$email = $this->input->post('email_recover');
			$login = $this->input->post('login');

			$this->db->where('login', $login);
			$members 	= $this->db->get('members')->result();

			if( count($members) == 1 && isset($members[0]) && $members[0]->login == $login ){	
				
				$member 	= $members[0];

				$nl = PHP_EOL;

				//$new_password = mt_rand(111111, 999999); // 6 digits
				$random_string = random_string( 'sha1' );

				//$data_update = array('password' => sha1($new_password));
				$data_update = array('activation_key' => $random_string);
				
				$this->db->where('login', $member->login);
				$pass_changed = $this->db->update('members', $data_update);

				if( $pass_changed ){

					$url_recover_pass = base_url('auth/recover_password/'. $random_string);
					//echo $url_recover_pass;

					$to 		 = $member->email;
					$subject = '[Taskino] Requested a new password';
					$message  = 'Hi, '. $member->name. $nl. $nl;
					$message .= 'You requested a new password.'. $nl;
					$message .= $url_recover_pass. $nl. $nl;
					$message .= 'With problem contact us.'. $nl. $nl;

					mail($to, $subject, $message);

					$data['msg_ok'] = _gettxt('msg_info_email_recover_pass'); //'Ueba! Enviamos o email para você!';

				} else {

					$data['msg_error'] = _gettxt('msg_error_try_again'); //'Ops! Tente novamente, dentro de instantes.';	

				}

			} else {

				$data['msg_error'] = _gettxt('msg_error_email_not_found'); //'Ops! E-Mail não encontrado';	

			}


		}

		$this->load->view('login', $data);

	}

	public function logout(){

		// helper para limpar sessao do usuario
		clear_member_session();

		redirect('/auth');
		
	}

	public function register(){

		$this->register_save();

		$data['company_register'] = true;

		$this->load->view('login', $data);

	}

	public function register_save(){

		if( isset($_POST['do_register']) && $_POST['do_register'] == 'save' ){

			$this->load->library('form_validation');

      $this->form_validation->set_rules('company_name', _gettxt('reg_company_name'), 'required');
      $this->form_validation->set_rules('member_admin_login', _gettxt('login'), 'required|is_unique[members.login]');
      $this->form_validation->set_rules('member_admin_email', _gettxt('email'), 'required|valid_email');
      $this->form_validation->set_rules('member_admin_name', _gettxt('reg_member_name'), 'required');
      $this->form_validation->set_rules('member_admin_pass', _gettxt('password'), 'required');
      $this->form_validation->set_rules('plan', _gettxt('plan'), 'required|is_natural_no_zero');

      // validate form
      if( $this->form_validation->run() !== FALSE ){


      	$company_name = $this->input->post('company_name');
      	$login 				= $this->input->post('member_admin_login');
      	$email 				= $this->input->post('member_admin_email');
      	$name 				= $this->input->post('member_admin_name');
      	$password 		= $this->input->post('member_admin_pass');
      	$plan 				= $this->input->post('plan');

      	$company_codename = url_title($company_name);
      	$this->load->helper('string');
      	$company_activate = random_string('alnum', 16);

      	// inserting new company
      	$company_data = array('name'						=> $company_name,
      												'email'						=> $email,
      												'codename'				=> $company_codename,
      												'folder_name' 		=> $company_codename, 
      												'plan_id_active' 	=> $plan,
      												'payment_status'	=> ($plan == 1) ? 'confirmed': 'pending',
      												'company_activate'=> $company_activate,
      												'date_added'			=> date('Y-m-d H:i:s')
      												);

      	$this->load->model('settings_model');
      	$this->settings_model->save( $company_data );

      	$new_company_id = $this->db->insert_id();

      	// inserting new member 
      	$member_data = array('name' 						=> $name,
      											 'company_id' 			=> $new_company_id,
      											 'login'						=> $login, 
      											 'email'  					=> $email,
      											 'password' 				=> sha1($password),
      											 'status'						=> 'inactive',//'active',
      											 'language_default'	=> 'portuguese',
      											 'is_admin' 				=> 'yes',
      											 'is_admin_master' 	=> 'yes',
      											 'date_added'				=> date('Y-m-d H:i:s')
      											);

      	$this->load->model('members_model');
      	$this->members_model->save( $member_data );

      	$to = $email;
      	$subject = sprintf(_gettxt('msg_new_company_registered_subject'), '[Taskino]');
      	$__message = _gettxt('msg_new_company_registered_message');

      	$__message = str_replace('{member_name}', $name, $__message);
      	$__message = str_replace('{company_name}', $company_name, $__message);
      	$__message = str_replace('{url_account_activate}', base_url('/auth/company_activate/'. $company_activate), $__message);

      	$message = $__message;

      	$headers = '';
      	$headers .= 'From: no-reply@in9web.com'. PHP_EOL;
      	$headers .= 'Reply-to: no-reply@in9web.com'. PHP_EOL;

      	mail($to, $subject, $message, $headers);
				
				$data['msg_ok'] = _gettxt('msg_info_sent_email_new_account'); //'Ueba! Enviamos o email para você!';
				$this->session->set_flashdata('msg_ok', $data['msg_ok']);
      	redirect('/auth');

      } else {

      	// validation error

      }

		}

	}

	public function company_activate($company_activate){

		$this->db->where('company_activate', $company_activate);
		$query = $this->db->get('taskino_company');

		if ($query->num_rows() > 0) {

			$result = $query->result();

			// update members
			$this->db->where('company_id', $result[0]->id);
			$this->db->update('members', array('status'=>'active'));

			// remove code from company
			$this->db->where('id', $result[0]->id);
			$this->db->update('taskino_company', array('company_activate'=>null));

			$data['msg_ok'] = _gettxt('msg_ok_company_activated'); //'Ueba! Enviamos o email para você!';
			$this->session->set_flashdata('msg_ok', $data['msg_ok']);
    	redirect('/auth');

		}

    redirect('/auth');
    
	}

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */