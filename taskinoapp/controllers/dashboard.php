<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function index(){

		$data['my_tasks'] = '<span class="label label-inverse">('.get_member_session('name').')</span>';
		$data['is_dashboard'] = true;

		$total_per_page = 15;
		$page_start 		= 0;

		$page = $this->uri->segment(4);

		// define actual page
		if( $page > 0 )
			$page_start = $page; //($page - 1) * $total_per_page;

		// get tasks
		$data_tasks = get_tasks( $page_start, $total_per_page, get_member_session('id') );
		$data['tasks'] 	= $data_tasks['tasks'];
		$total_rows 		= $data_tasks['total_rows'];

		$pre_config = array('base_url' 		=> base_url('/dashboard/index/page/'),
												'per_page' 		=> $total_per_page,
												'total_rows'  => $total_rows
											);
		
		// configs to pagination 
		$pagination_config = get_pagination_config( $pre_config );

		// librarie pagination
		$this->load->library('pagination');
		$this->pagination->initialize($pagination_config); 

		$data['pagination'] = $this->pagination->create_links();

		// get messages
    $msg_error = $this->session->flashdata('msg_error');
    if( $msg_error !== false )
      $data['msg_error'] = $msg_error;

    $msg_ok = $this->session->flashdata('msg_ok');
    if( $msg_ok !== false )
      $data['msg_ok'] = $msg_ok;
		
		$this->load->view('dashboard', $data);

	}

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */