<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends MY_Controller {

	public function index(){

		$total_per_page = 10;
		$page_start 		= 0;

		$page = $this->uri->segment(4);

		// define actual page
		if( $page > 0 )
			$page_start = $page; //($page - 1) * $total_per_page;

		// get tasks
		$data_tasks = get_tasks( $page_start, $total_per_page );
		$data['tasks'] 	= $data_tasks['tasks'];
		$total_rows 		= $data_tasks['total_rows'];

		$pre_config = array('base_url' 		=> base_url('/tasks/index/page/'),
												'per_page' 		=> $total_per_page,
												'total_rows'  => $total_rows
											);
		
		// configs to pagination 
		$pagination_config = get_pagination_config( $pre_config );

		// librarie pagination
		$this->load->library('pagination');
		$this->pagination->initialize($pagination_config);

		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->view('dashboard', $data);

	}

	public function add(){

		$this->load->view('tasks_form_add');

	}

	public function edit( $id ){

		$where_task = array();

		if( $id > 0 )
			$where_task['id'] = $id;

		$tasks = $this->db->get_where('tasks', $where_task);
		$task  = $tasks->result();
		$data['task'] = $task[0];
		$this->load->view('tasks_form_edit', $data);

	}

	public function save(){

		if( $_POST['form_action'] ){

			$msg_task_log = '';
			
			$name 					= $this->input->post('name');
			$description 		= $this->input->post('description');
			$assigned_to 		= $this->input->post('assigned_to');
			$priority 			= $this->input->post('priority');
			$total_percent	= $this->input->post('total_percent');

			$tasks_data = array('name'					=> $name,
													'description' 	=> $description,
													'priority' 			=> $priority,
													);

			$saved = false;

			$task_due_date = strtotime($this->input->post('task_due_date'));

			if( $task_due_date >= time() )
				$tasks_data['task_due_date']	= date('Y-m-d H:i:s', $task_due_date);
				//$task_due_date = date('Y-m-d H:i:s', strtotime('+1 week'))

			if( $assigned_to > 0 )
				$tasks_data['assigned_to'] 		= $assigned_to;

			// verifica se inserir ou atualizar
			if( $this->input->post('id') > 0 ){

				if( $total_percent > 0 )
					$tasks_data['total_percent'] 	= $total_percent;

				$this->db->where('id', $this->input->post('id'));
				$saved = $this->db->update('tasks', $tasks_data);

				// register log
				$msg_task_log = 'Tarefa foi atualizada com sucesso';
				log_task( $this->input->post('id'), $msg_task_log, 'general');
				
			} else {
					
				
				$tasks_data['date_added']	= date('Y-m-d H:i:s');
				$tasks_data['created_by'] = get_member_session('id');
				$tasks_data['status'] 		= 1; // 1=pendente, 2=finalizado

				$saved = $this->db->insert('tasks', $tasks_data);

				$insert_id = $this->db->insert_id();

				// register log
				$msg_task_log = 'Tarefa foi criada com sucesso';				
				log_task( $insert_id, $msg_task_log, 'created');
				
			}

			if( $this->input->post('notify_by_email') ){

				$nl 				 = PHP_EOL;
				$from 			 = MAIL_NO_REPLY;
				$member_data = get_member( $assigned_to );
				$member_data = $member_data[0];
				$member_mail = $member_data->email;
				$member_name = $member_data->name;
				$subject		 = '[Taskino] New task to you';
				$message		 = 'Hey, '. $member_name. $nl;
				$message		.= 'See your new task.'. $nl. $nl;
				$message		.= 'Name: '. $name. $nl;
				$message		.= 'Priority: '. get_priority_name( $priority ). $nl;
				$message		.= 'Due date: '. date('d/m/Y', $task_due_date). $nl;
				$message		.= $nl. 'Good job to you.'. $nl;

				//$message = nl2br($message);

				$header = '';
				$header .= 'From: ' . $from. $nl;
				//$header .= 'MIME-Version: 1.0'. $nl;
				//$header .= 'Content-type: text/html; charset=utf-8'. $nl;
				
				mail( $member_mail, $subject, $message, $header );

				// register log	
				$msg_task_log = sprintf('Usuario %s[%s] notificado da tarefa %s[%s] por email', $member_name, $member_data->id, $name, $insert_id);
				log_task( $insert_id, $msg_task_log, 'general');

			}

			if( $saved )
				redirect('/dashboard');

		}

		// so reexibe se tiver erro
		$this->add();

	}

	public function finalize( $id, $goto = 'dashboard' ){

		$task_update = array(	'status' 					=> 2, // 2 = finalizado
													'total_percent' 	=> 100, // se concluiu percent 100
													'date_finalized' 	=> date('Y-m-d H:i:s')
												); 

		$this->db->where('id', $id);
		$updated = $this->db->update('tasks', $task_update); 

		// register log
		$msg_task_log = 'Tarefa foi finalizada em '.date('Y-m-d H:i:s');				
		log_task( $id, $msg_task_log, 'finalized');

		redirect('/'.$goto);

	}

	// altera a percentagem da tarefa realizada
	public function task_change_percent( $id ){

		$data = array();

		if( $this->input->post('save_progress') == 'save' ){

			$task_update = array(	'total_percent' => $this->input->post('total_percent') ); 

			$this->db->where('id', $id);
			$updated = $this->db->update('tasks', $task_update); 

			// register log
			$msg_task_log = 'Tarefa teve a percentagem alterada para '. $this->input->post('total_percent');
			log_task( $id, $msg_task_log, 'general');

			$data['saved'] = true;

		}
		$this->db->where('id' , $id);
		$task = $this->db->get('tasks')->result();

		$data['task_id'] = $id;
		$data['task'] = $task[0];

		$this->load->view('tasks_form_progress', $data);

		//redirect('/dashboard');

	}

	// altera quem deve realizar a tarefa
	public function task_assigned_to( $id ){

		$task_update = array(	'assigned_to' => $this->input->post('assigned_to') ); 

		$this->db->where('id', $id);
		$updated = $this->db->update('tasks', $task_update); 

		// register log
		$m_log = get_member( $this->input->post('assigned_to'), 'name').' (id:'. $this->input->post('assigned_to').')';
		$msg_task_log = 'Tarefa foi encaminhada para '. $m_log;
		log_task( $id, $msg_task_log, 'assigned_to');

		redirect('/dashboard');

	}

	public function remove( $id ){

		// register log
		$msg_task_log = 'Tarefa foi REMOVIDA com sucesso. ID:'. $id;				
		log_task( $id, $msg_task_log, 'general');


		/**
			******************************************************************
		  * ADICIONAR REMOVER COMENTARIOS E ARQUIVOS E TUDO LIGADO A TAREFA
		  *
		  * REMOVER LOGs?
		  ******************************************************************
		  */

		//$this->db->delete('tasks', array('id' => $id));
		$task_update = array(	'task_folder' => 'trash' ); 

		$this->db->where('id', $id);
		$updated = $this->db->update('tasks', $task_update); 

		redirect('/dashboard');

	}

	public function show( $id ){

		// se nao for id valido sai 
		if( $id < 1 )
			redirect('/dashboard');

		// get task data
		$this->db->where('id' , $id);
		$task = $this->db->get('tasks')->result();

		// se nao existir tal tarefa cai fora
		if( empty($task) )
			redirect('/dashboard');

		// get task comments
		$this->db->where('task_id' , $id);
		$this->db->order_by('date_added', 'desc');
		$task_comments = $this->db->get('task_comments', 0, 10)->result();

		$this->db->where('task_id' , $id);
		$task_files = $this->db->get('task_files')->result();

		$data['task'] 					= $task[0];
		$data['task_files'] 		= $task_files;
		$data['task_comments'] 	= $task_comments;

		$this->load->view('task_view', $data);

		// register log
		$msg_task_log = 'Tarefa visualizada por '. get_member_session('name'). ' (id:'. get_member_session('id'). ')';
		log_task( $id, $msg_task_log, 'general');		

	}

	// save comments to task
	public function comment_save(){

		if( $this->input->post('task_id') < 1 )
			redirect('/dashboard');

		$task_id = $this->input->post('task_id');

		$comment_data = array('task_id' 		=> $task_id,
													'subject' 		=> $this->input->post('subject'),
													'comment'			=> $this->input->post('comment'),
													'created_by'	=> get_member_session('id'),
													'date_added'	=> date('Y-m-d H:i:s')
													);

		$saved = $this->db->insert('task_comments', $comment_data);

		$insert_id = $this->db->insert_id();

		// register log
		$msg_task_log = 'Tarefa recebeu novo comentario.';				
		log_task( $insert_id, $msg_task_log, 'commented');

		// redirect to task comment with new comment
		redirect('/tasks/show/'.$task_id);

	}
	public function upload( $task_id = null ){

		$data = null;

		$data['task_id'] 	= $task_id;
		$data['saved'] 		= false;

		if( isset($_POST['save_upload']) ){

			$description = '';
			if( strlen($this->input->post('description')) > 0 )
				$description = $this->input->post('description');

			if( $task_id < 1 )
				$task_id = $this->input->post('task_id');

			$upload_saved = $this->do_upload($description, $task_id);

			if( !isset($upload_saved['error']) )
				$data['saved'] = true;

			// register log
			$msg_task_log = 'Tarefa recebeu novo arquivo. Link: file_id:'. $upload_saved['file_id']. '/ full_url:'. $upload_saved['full_url'];
			log_task( $task_id, $msg_task_log, 'general');

		}


		$this->load->view('tasks_upload_file', $data);

	}

	public function file( $action='download', $file_id ){

		if( $file_id < 1 )
			die('Incorrect file id');

		$this->db->where('id', $file_id);
		$files 	= $this->db->get('task_files')->result();
		$file 	= $files[0];

		$full_path 	= dirname(BASEPATH). $file->full_path;
		$file_name 	= $file->filename;
		$task_id 		= $file->task_id;

		// downlod file
		if( $action == 'download' ){
			
			$this->load->helper('download');

			$file_data = file_get_contents($full_path); // Read the file's contents
			force_download( $file_name, $file_data );			
		}

		// remove file
		if( $action == 'remove' ){

			// remove file from folder
			if( file_exists($full_path) )
				@unlink( $full_path );

			// remove from database
			$this->db->where('id', $file_id);
			$this->db->delete('task_files'); 

			if( $task_id > 0 )
				redirect('/tasks/show/'. $task_id);

			// register log
			$msg_task_log = 'Arquivo ('.$file_name.') foi removido da tarefa e sistema';
			log_task( $task_id, $msg_task_log, 'general');

			redirect('/dashboard');

		}


	}

}

/* End of file tasks.php */
/* Location: ./application/controllers/tasks.php */