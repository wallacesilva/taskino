<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends MY_Controller {

	public function index(){

		$this->db->order_by('name', 'asc');
		$members = $this->db->get('members');
		$data['members'] = $members->result();

		$this->load->view('members', $data);

	}

	public function add(){

		$this->load->view('members_form_add');

	}

	public function edit( $id ){

		$where_member = array();

		if( $id > 0 )
			$where_member['id'] = $id;

		$members = $this->db->get_where('members', $where_member);
		$member  = $members->result();
		$data['member'] = $member[0];
		$this->load->view('members_form_edit', $data);

	}

	public function change_password( $id ){

		$where_member = array();

		if( $id != get_member_session('id') )
			redirect('/dashboard');

		if( $id > 0 )
			$where_member['id'] = $id;

		$members = $this->db->get_where('members', $where_member);
		$member  = $members->result();
		$data['member'] = $member[0];
		$this->load->view('members_form_password', $data);

	}

	public function save(){

		if( $_POST['form_action'] ){
			
			$name 				= $this->input->post('name');
			$email 				= $this->input->post('email');
			$password 		= $this->input->post('password');

			$members_data = array('name'			=> $name,
													'email' 			=> $email,
													'password' 		=> sha1($password),
													'status'			=> 'active', // active, inactive
													'date_added'	=> date('Y-m-d H:i:s')
													);

			$saved = false;

			// verifica se inserir ou atualizar
			if( $this->input->post('id') > 0 ){

				$this->db->where('id', $this->input->post('id'));
				$saved = $this->db->update('members', $members_data);
				
			} else {

				$saved = $this->db->insert('members', $members_data);

			}

			if( $saved )
				redirect('/members');

		}

		// so reexibe se tiver erro
		$this->add();

	}

	public function save_password(){

		if( $_POST['form_action'] ){
			
			$password 		= $this->input->post('password');

			$members_data = array('password' => sha1($password));

			$this->db->where('id', $this->input->post('id'));
			$saved = $this->db->update('members', $members_data);

			//if( $saved )
				redirect('/members');

		}

		// so reexibe se tiver erro
		//$this->change_password();

	}

	public function remove( $id ){

		$this->db->delete('members', array('id' => $id));
		redirect('/members');

	}

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */