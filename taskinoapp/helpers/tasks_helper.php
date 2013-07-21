<?php  

// pega a tarefa e retorna array ou campo especifico 
function get_task($id, $field=null){

	$CI =& get_instance();
	$CI->db->where('id', $id);
	$tasks = $CI->db->get('tasks');
	$tasks = $tasks->result();

	if( strlen($field) > 0 && isset($tasks[0]->$field) )
		return $tasks[0]->$field;
	else 
		return $tasks;

}

// get all task with limit
function get_tasks($offset=0, $limit=10, $member_id=null){

	$CI =& get_instance();

	if( $member_id > 0 ){
		$CI->db->where('assigned_to', $member_id);
		$CI->db->where('status', 1); // show active only
		$CI->db->order_by('priority', 'asc');		
	} 

	$total_rows = $CI->db->count_all_results('tasks');

	if( $member_id > 0 ){
		$CI->db->where('assigned_to', $member_id);
		$CI->db->where('status', 1); // show active only
		$CI->db->order_by('priority', 'asc');	
	} 

	$CI->db->where('task_folder', 'inbox'); 

	$CI->db->order_by('status', 'asc');	
	$CI->db->order_by('date_added', 'desc');
	$tasks = $CI->db->get('tasks', $limit, $offset)->result();
	$tasks = $tasks;

	$data_tasks = array('tasks' => $tasks, 'total_rows' => $total_rows);

	return $data_tasks;

}

// add activies to task log
function log_task($task_id, $description, $category='general'){

	if( $task_id < 1 ) 
		return false;

	$CI =& get_instance();

	$member_id = get_member_session('id');

	//task_id, member_id, description, category_log[general, created, assigned_to, commented], date_added
	$taskslog_data = array(	'task_id' 		=> $task_id,
													'description' => $description,
													'category_log'=> $category,
													'date_added'	=> date('Y-m-d H:i:s')
												);

	$taskslog_data['member_id'] = $member_id;

	$saved = $CI->db->insert('tasks_log', $taskslog_data);

	if( $saved ) 
		return true;

	return false;

}

// get all logs to task category(all, general, created, assigned_to, commented, finalized)
function get_logs_task($task_id, $category='all', $member_id=null){

	if( $task_id < 1 ) 
		return false;

	$CI =& get_instance();
	
	$CI->db->where('task_id', $task_id);

	if( in_array($category, array('general', 'created', 'assigned_to', 'commented', 'finalized')) )
		$CI->db->where('category_log', $category);

	if( $member_id > 0 )
		$CI->db->where('member_id', $member_id);

	$logs_task = $CI->db->get('tasks_log')->result();

	return $logs_task;

}

// get default pagination to CI work with twitter bootstrap 
function get_pagination_config( $pre_config = null ){

	if( empty($pre_config) )
		$pre_config = array();

	//$config_pag['base_url'] 			= current_url().'/page/';
	$config_pag['per_page'] 			= 10; // limit, ex 10, 15, 
	$config_pag['total_rows']			= 0; // total to show, eg. 300, 400, 1900
	$config_pag['cur_tag_open'] 	= '<li class="active"><a href="#">';
	$config_pag['cur_tag_close'] 	= '</a></li>';
	$config_pag['num_tag_open'] 	= '<li>';
	$config_pag['num_tag_close'] 	= '</li>';
	$config_pag['prev_link'] 			= ''; //&lt;
	$config_pag['next_link'] 			= ''; //&gt;
	$config_pag['prev_tag_open'] 	= '<!--';
	$config_pag['prev_tag_close'] = '-->';
	$config_pag['next_tag_open'] 	= '<!--';
	$config_pag['next_tag_close'] = '-->';

	$config_pag = array_merge($config_pag, $pre_config);

	return $config_pag;

}

// retorna o nome da prioridade
function get_priority_name( $id, $rhtml = false ){

	$priority_names[1] = _gettxt('priority_very_high'); // 'Very High';
	$priority_names[2] = _gettxt('priority_high'); // 'High';
	$priority_names[3] = _gettxt('priority_normal'); // 'Normal';
	$priority_names[4] = _gettxt('priority_low'); // 'Low';
	$priority_names[5] = _gettxt('priority_very_low'); // 'Very Low';

	if( $id == 1 )
		return ($rhtml) ? '<span class="label label-important">'. $priority_names[$id]. '</span>' : $priority_names[$id];

	if( $id == 2 )
		return ($rhtml) ? '<span class="label label-important">'. $priority_names[$id]. '</span>' : $priority_names[$id];

	if( $id == 3 )
		return ($rhtml) ? '<span class="label label-info">'. $priority_names[$id]. '</span>' : $priority_names[$id];

	if( $id == 4 )
		return ($rhtml) ? '<span class="label label-success">'. $priority_names[$id]. '</span>' : $priority_names[$id];

	if( $id == 5 )
		return ($rhtml) ? '<span class="label label-success">'. $priority_names[$id]. '</span>' : $priority_names[$id];

}

// pega o usuario e retorna array ou campo especifico 
function get_member($id, $field=null){

	$CI =& get_instance();
	$CI->db->where('id', $id);
	$member = $CI->db->get('members');
	$member = $member->result();

	if( count($member) < 1 )
		return false;

	if( strlen($field) > 0 && isset($member[0]->$field) )
		return $member[0]->$field;
	else 
		return $member;

}

// retorna todos os usuarios com option para select/html
function get_members_options($equal_value = null){

	$CI =& get_instance();
	$CI->db->order_by('name', 'asc');
	$members = $CI->db->get('members');
	$members = $members->result();

	$member_return = array();
	foreach ($members as $member) {

		$checked = '';
		if( !is_null($equal_value) && $equal_value == $member->id )
			$checked = 'selected="selected"';

		//$member_return[] = '<option value="'.$member->id.'">'.$member->name.'</option>';
		$member_return[] = sprintf('<option value="%s" %s>%s</option>', $member->id, $checked, $member->name);

	}

	return implode('', $member_return);

}

// pega dados do usuario na sessao
function get_member_session( $field=false ){

	$CI =& get_instance();
	$member_ss = $CI->session->userdata('member');

	if( $field !== false && isset($member_ss[$field]) )
		return $member_ss[$field];

	return $member_ss;

}

// salva os dados do usuario logado no sessao
function set_member_session( $member_data ){

	$CI =& get_instance();

	$member = array('member' => $member_data);
	
	return $CI->session->set_userdata( $member );

}


function clear_member_session(){

	$CI =& get_instance();
	return $CI->session->unset_userdata('member');
	
}

// realiza o login do usuario
function member_do_login($login, $password){

	$CI =& get_instance();

	$member_where = array('email' => $login, 'password' => sha1($password), 'status'=>'active');
	$login_member = $CI->db->get_where('members', $member_where);
	//$login_member = $login_member->result();

	if( $login_member->num_rows() == 1 ){
		
		$member = $login_member->row_array();

		// helper para adicionar usuario na sessao 
		set_member_session( $member );

		return true;

	} 

	return false;

}

// verifica se usuario esta logado
function member_check_login(){

	if( get_member_session('id') > 0 )
		return true;

	return false;
	
}

// get filesize from remote server 
function get_remote_file_size($url){ 

	$ch = curl_init($url); 

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
	curl_setopt($ch, CURLOPT_HEADER, TRUE); 
	curl_setopt($ch, CURLOPT_NOBODY, TRUE); 
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // if redirect

	$data = curl_exec($ch); 
	$size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD); 

	curl_close($ch); 
	return $size; 
} 


// function default to taskino send email
function taskino_mail(){

	$mail_config['useragent'] 	= 'TaskinoMail';
	$mail_config['protocol'] 		= 'smtp';
	$mail_config['smtp_host'] 	= 'smtp.gmail.com'; //ssl://smtp.googlemail.com
	$mail_config['smtp_port'] 	= '465';
	$mail_config['smtp_crypto'] = 'ssl';
	$mail_config['smtp_user'] 	= 'iclasso.com@gmail.com';
	$mail_config['smtp_pass'] 	= '000';
	$mail_config['mailtype'] 		= 'html';

	$this->load->library('email', $mail_config);
	$this->email->from( MAIL_NO_REPLY, 'Taskino' );
  $this->email->to( $member_mail );  
  $this->email->subject( $subject );  
  $this->email->message( $message );
  $result = $this->email->send();
  echo $this->email->print_debugger();

  return true;
}

// get default language
function set_taskino_language(){

	$CI =& get_instance();

	$taskino_lang = get_taskino_language();

	$CI->session->set_userdata('taskino_lang', $taskino_lang);			

	$CI->lang->load('taskino', $taskino_lang);

}

// get default language, if empty return 'english'
function get_taskino_language(){

	$CI =& get_instance();

	$taskino_lang = $CI->session->userdata('taskino_lang');

	if( !in_array($taskino_lang, array('english', 'portuguese') ) )
		$taskino_lang = 'english';

	return $taskino_lang;

}

// get translation to text
function _gettxt( $code ){

	$CI =& get_instance();
	$line = $CI->lang->line($code);

	if( strlen($line) < 1 )
		taskino_log('Error language on _gettxt:'. $code, 'error');

	return $line;

}


/**
 * taskino_log Save log from application to file
 * @param string $message Message to save in log
 * @param string $category Define category to log, eg. 'general', 'error', 'database', 'authentication', 'debug'
 * @return boolean True on success or False on error
 * @author Wallace Silva <contato [at] wallacesilva [dot] com>
 */
function taskino_log( $message, $category = 'general' ){

	if( !define('DS') ) define('DS', DIRECTORY_SEPARATOR);

  // APPPATH/logs/taskino/12-2013/general/
  $log_path = APPPATH. 'logs'. DS. 'taskino'. DS. date('m-Y'). DS. $category. DS;

  if( !file_exists($log_path) )
    mkdir( $log_path, 0777, true ); // create recursive

  $file_log = 'log_'. date('Y-m-d_H-i-s').'.php';

  $filepath = $log_path. $file_log;

  if( !file_exists($filepath) ){

    $message = '<?php die("Dont have permission to access this file."); ?>'. PHP_EOL. $message;

  } else {

    // try change permission logfile
    if( !is_writable($filepath) )
      if( !chmod($filename, 0777) )
        return false;
    
  }

  // save message
  $fp = fopen($filepath, 'a');
  flock($fp, LOCK_EX);
  fwrite($fp, $message);
  flock($fp, LOCK_UN);
  fclose($fp);

  return true;

}
