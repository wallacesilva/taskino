<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends MY_Controller {

	public function index(){

		if( !member_is_admin() )
			redirect('/dashboard');

		$this->db->order_by('name', 'asc');
		$this->db->where('company_id', get_member_session('company_id')); 
		$members = $this->db->get('members');
		$data['members'] = $members->result();

		// get messages
    $msg_error = $this->session->flashdata('msg_error');
    if( $msg_error !== false )
      $data['msg_error'] = $msg_error;

    $msg_ok = $this->session->flashdata('msg_ok');
    if( $msg_ok !== false )
      $data['msg_ok'] = $msg_ok;

		$this->load->view('members', $data);

	}

	public function add(){

		if( !member_is_admin() )
			redirect('/dashboard');

		$data = null;
		
		// get messages
    $msg_error = $this->session->flashdata('msg_error');
    if( $msg_error !== false )
      $data['msg_error'] = $msg_error;

    $msg_ok = $this->session->flashdata('msg_ok');
    if( $msg_ok !== false )
      $data['msg_ok'] = $msg_ok;

		$this->load->view('members_form_add', $data);

	}

	public function edit( $id ){

		$where_member = array();

		if( $id > 0 )
			$where_member['id'] = $id;

		$members = $this->db->get_where('members', $where_member);
		$member  = $members->result();
		$data['member'] = $member[0];

		// check company
		if( !is_company_member( $member[0]->company_id ) ){
			// show error dont have permission
      $this->session->set_flashdata('msg_error', _gettxt('msg_error_no_permission_access'));
      redirect('/dashboard');
		}

		$this->load->view('members_form_edit', $data);

	}

	public function change_password( $id ){

		$where_member = array();

		if( $id != get_member_session('id') ){
			// show error dont have permission
      $this->session->set_flashdata('msg_error', _gettxt('msg_error_no_permission_access'));
      redirect('/dashboard');
		}
		
		if( $id > 0 )
			$where_member['id'] = $id;

		$members = $this->db->get_where('members', $where_member);
		$member  = $members->result();
		$data['member'] = $member[0];

				// check company
		if( !is_company_member( $member[0]->company_id ) ){
			// show error dont have permission
      $this->session->set_flashdata('msg_error', _gettxt('msg_error_no_permission_access'));
      redirect('/dashboard');
		}

		$this->load->view('members_form_password', $data);

	}

	public function add_save(){

		if( $_POST['form_action'] ){
	
			$this->load->library('form_validation');

      $this->form_validation->set_rules('name', _gettxt('name'), 'required');
      $this->form_validation->set_rules('login', _gettxt('login'), 'required|is_unique[members.login]');
      $this->form_validation->set_rules('email', _gettxt('email'), 'required|valid_email');
			$this->form_validation->set_rules('password', _gettxt('password'), 'required|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', _gettxt('password_confirm'), 'required');

      // validate form
      if( $this->form_validation->run() !== FALSE ){
      	
      	$name 				= $this->input->post('name');
				$login 				= $this->input->post('login');
				$email 				= $this->input->post('email');
				$password 		= $this->input->post('password');
				$is_admin 		= ($this->input->post('is_admin') == 'yes') ? 'yes' : 'no';

				if( check_member_login_exists($login) ){

					// fix multiple company
					/*$member_checked = $this->db->where('email', $email)->get('members')->result();
					if( isset($member_checked[0]->id) )
						member_add_company( $member_checked[0]->id );*/

					// show error login exists
		      $this->session->set_flashdata('msg_error', _gettxt('msg_error_login_exists'));
		      /*if( !member_is_admin() )
						redirect('/dashboard');
					else
						redirect('/members');*/

				} else{ 

					$members_data = array('name'			=> $name,
																'email' 		=> $email,
																'login' 		=> $login,
																'password' 	=> sha1($password),
																'status'		=> 'active', // active, inactive
																'is_admin'	=> $is_admin, // yes, no
																'company_id'=> get_member_session('company_id'),
																'date_added'=> date('Y-m-d H:i:s')
																);

					$saved = false;

					$saved = $this->db->insert('members', $members_data);

					if( $saved ){

						// fix multiple company
						//member_add_company( $this->db->insert_id() );

						if( !member_is_admin() )
							redirect('/dashboard');
						else
							redirect('/members');

					} // if saved

				}

      } // end form validate

		} // end check form action

		$this->add();

	}

	public function edit_save(){

		if( $_POST['form_action'] ){

			if( $this->input->post('id') < 1 ){
				// show error dont have permission
	      $this->session->set_flashdata('msg_error', _gettxt('msg_error_try_again'));
	      if( !member_is_admin() )
					redirect('/dashboard');
				else
					redirect('/members');
			}

			// check company
			if( !is_company_member( $this->input->post('id'), 'members' ) ){
				// show error dont have permission
	      $this->session->set_flashdata('msg_error', _gettxt('msg_error_no_permission_access'));
	      if( !member_is_admin() )
					redirect('/dashboard');
				else
					redirect('/members');
			}

			$this->load->library('form_validation');

      $this->form_validation->set_rules('name', _gettxt('name'), 'required');
      $this->form_validation->set_rules('email', _gettxt('email'), 'required|valid_email');

      // validate form
      if( $this->form_validation->run() !== FALSE ){


				$name 				= $this->input->post('name');
				$email 				= $this->input->post('email');
				$language_default	= $this->input->post('language_default');
				//$status				= $this->input->post('status');

				$members_data = array('name'							=> $name,
															'email' 						=> $email,
															'language_default'  => $language_default,
															//'status'		=> $status, // active, inactive
															);

				// change is admin
				if( member_is_admin() && in_array($this->input->post('member_admin'), array('yes', 'no')) ){

					// check is try changing member admin to account
					if( member_is_admin_master($this->input->post('id')) && $this->input->post('member_admin') == 'no' ){

						// show error dont have permission
			      $this->session->set_flashdata('msg_error', _gettxt('msg_error_no_can_change_admin_master'));
			      if( !member_is_admin() )
							redirect('/dashboard');
						else
							redirect('/members');

					}

					$members_data['is_admin'] = $this->input->post('member_admin');

					if( $this->input->post('id') == get_member_session('id') ){

						// change session
						set_member_is_admin($members_data['is_admin']);

					} // check is self member

				} // check is admin AND member admin change

				$saved = false;

				$this->db->where('id', $this->input->post('id'));
				$saved = $this->db->update('members', $members_data);

				// change language session
				$this->session->set_userdata('taskino_lang', $language_default); 

				if( $saved ){

					if( !member_is_admin() )
						redirect('/dashboard');
					else
						redirect('/members');

				} // if saved

			}// if form validate

		} // if check form action

		// so reexibe se tiver erro
		$this->add();

	}

	public function save_password(){

		if( $_POST['form_action'] ){

			// only memmber or admin
			if( $this->input->post('id') != get_member_session('id') ){
				if( !member_is_admin() ){
					$this->session->set_flashdata('msg_error', _gettxt('msg_error_no_permission_access'));
		      redirect('/dashboard');
	    	}
			}

			// check company
			if( !is_company_member( $this->input->post('id'), 'members' ) ){
				// show error dont have permission
	      $this->session->set_flashdata('msg_error', _gettxt('msg_error_no_permission_access'));
	      redirect('/dashboard');
			}
			
			$password 		= $this->input->post('password');

			$members_data = array('password' => sha1($password));

			$this->db->where('id', $this->input->post('id'));
			$saved = $this->db->update('members', $members_data);

			//if( $saved )
			if( member_is_admin() )
				redirect('/members');
			else
				redirect('/dashboard');

		}

		// so reexibe se tiver erro
		//$this->change_password();

	}

	public function remove( $id ){

		// check company
		if( !is_company_member( $id, 'members' ) ){
			// show error dont have permission
      $this->session->set_flashdata('msg_error', _gettxt('msg_error_no_permission_access'));
      redirect('/dashboard');
		}

		// check is try changing member admin to account
		if( member_is_admin_master($id) ){

			// show error dont have permission
      $this->session->set_flashdata('msg_error', _gettxt('msg_error_no_can_change_admin_master'));
      if( !member_is_admin() )
				redirect('/dashboard');
			else
				redirect('/members');

		}

		$this->db->delete('members', array('id' => $id));
		redirect('/members');

	}

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */