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
	// get taskt to campany member
	$CI->db->where('company_id', get_member_session('company_id')); 

	$total_rows = $CI->db->count_all_results('tasks');

	if( $member_id > 0 ){
		$CI->db->where('assigned_to', $member_id);
		$CI->db->where('status', 1); // show active only
		$CI->db->order_by('priority', 'asc');	
	} 

	$CI->db->where('task_folder', 'inbox'); 
	$CI->db->where('company_id', get_member_session('company_id'));  // get taskt to campany member

	$CI->db->order_by('status', 'asc');	
	$CI->db->order_by('date_added', 'desc');
	$tasks = $CI->db->get('tasks', $limit, $offset)->result();
	$tasks = $tasks;

	$data_tasks = array('tasks' => $tasks, 'total_rows' => $total_rows);

	return $data_tasks;

}

function get_total_tasks( $project_id, $status=null ){

	$CI =& get_instance();
	$CI->load->model('projects_model');
	return $CI->projects_model->total_tasks($project_id, $status);

}

/**
 * Remove task + task files + task comments + task log + task ALL
 * @param integer $task_id Id to remove from task to be removed
 * @return bool True on success OR False on error
 */
function remove_task( $task_id ){

	if( (int)$task_id < 1 )
		return false;

	$CI =& get_instance();

	// remove comments
	//$CI->db->where('')

}

/** LOGS TO TASKS */

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
