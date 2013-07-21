<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){

		parent::__construct();

		// connect to taskino database
		$this->taskinodb = $this->load->database('taskinodb', true);

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

		$this->load->view('login', $data);
	}

	// try login
	public function login(){

		$data['msg_error'] = '';

		$email 		= $this->input->post('email');
		$password = $this->input->post('password');
		
		if( isset($_POST['email']) && isset($_POST['password']) ){

			$logged = member_do_login($email, $password);
		
			// verifica se realizou o login			
			if( $logged == true ){
			
				redirect('dashboard');

			} else {

				$data['msg_error'] = 'E-mail ou senha incorretos';

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
			
			$data['msg_ok'] = 'Password changed with success!';
			
		}	else {

			$data['msg_error'] = 'Error on change your password.';
			$data['activation_key'] = $this->input->post('activation_key');
			$data['recovered_pass'] = true;

		}

		$this->load->view('login', $data);		

	}

	// active to change password from url
	public function forgot_password(){

		if( $this->input->post('recover_password') == 'do_please' ){
 
			$data['msg_ok'] = 'Wow! Enviado por email';

			$email = $this->input->post('email_recover');

			$this->db->where('email', $email);
			$members 	= $this->db->get('members')->result();
			$member 	= $members[0];

			if( count($members) == 1 && $member->email == $email ){	

				$nl = PHP_EOL;

				//$new_password = mt_rand(111111, 999999); // 6 digits
				$random_string = random_string( 'sha1' );

				//$data_update = array('password' => sha1($new_password));
				$data_update = array('activation_key' => $random_string);
				
				$this->db->where('email', $member->email);
				$pass_changed = $this->db->update('members', $data_update);

				if( $pass_changed ){

					$url_recover_pass = base_url('auth/recover_password/'. $random_string);
					//echo $url_recover_pass;

					$to 		 = $member->email;
					$subject = '[Taskino] Requested a new passoword';
					$message  = 'Hi, '. $member->name. $nl. $nl;
					$message .= 'You requested a new password.'. $nl;
					$message .= $url_recover_pass. $nl. $nl;
					$message .= 'With problem contact us.'. $nl. $nl;

					mail($to, $subject, $message);

					$data['msg_ok'] = 'Ueba! Enviamos o email para você!';

				} else {

					$data['msg_error'] = 'Ops! Tente novamente, dentro de instantes.';	

				}

			} else {

				$data['msg_error'] = 'Ops! E-Mail não encontrado';	

			}


		}

		$this->load->view('login', $data);

	}

	public function logout(){

		// helper para limpar sessao do usuario
		clear_member_session();

		redirect('auth');
		
	}

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */