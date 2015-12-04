<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends MY_Controller {

  public function index(){
    
    $total_per_page = 10;
    $page_start     = 0;
    $project_where  = null;

    $page = $this->uri->segment(4);

    // define actual page
    if( $page > 0 )
      $page_start = $page; //($page - 1) * $total_per_page;

    $project_where = array('company_id' => get_member_session('company_id'));

    $this->load->model('projects_model');

    $total_rows = $this->projects_model->countAll( $project_where );

    // get projects
    $find_options = array('offset' => $page_start, 'limit' => $total_per_page );
    $find_options['where'] = $project_where;

    $data_projects = $this->projects_model->findAll( $find_options );
    $data['projects'] = $data_projects;
    
    $pre_config = array('base_url'    => base_url('/projects/index/page/'),
                        'per_page'    => $total_per_page,
                        'total_rows'  => $total_rows
                      );
    
    // configs to pagination 
    $pagination_config = get_pagination_config( $pre_config );

    // library pagination
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

    $this->load->view('projects', $data);

  }

  public function show( $project_id ){

    if( $project_id < 0 )
      redirect('/projects');

    $this->load->model('projects_model');
    $project = $this->projects_model->find( $project_id );

    // if have project 
    if( !isset($project[0]->id) || $project[0]->id < 1 ){
      $this->session->set_flashdata('msg_error', _gettxt('msg_error_project_not_found'));
      redirect('/projects');
    }

    // check if him company
    if( !is_company_member($project[0]->company_id) ){

      // show error dont have permission
      $this->session->set_flashdata('msg_error', _gettxt('msg_error_no_permission_access'));
      redirect('/projects');

    } else {

      $project = $project[0];
      $data_project = null;
      $data_project['project'] = $project;

      $this->load->model('tasks_model');


      // get tasks from project
      $task_find_options['where'] = array('project_id' => $project->id);
      $task_find_options['order'] = array(
        "status" => "asc",
        "task_due_date" => "asc"
      );

      $task_find_options['limit'] = 0; // show all
      $tasks = $this->tasks_model->findAll( $task_find_options );
      $data_project['tasks'] = $tasks;

      $where_task_files=null;
      if( count($tasks) > 0 ){

        foreach ($tasks as $task)
          $where_task_files[] = 'task_id = '. $task->id;

        $this->db->where( implode(' OR ', $where_task_files) );

        // get comments task
        $this->db->order_by('date_added', 'desc');
        $task_comments = $this->db->get('task_comments', 0, 10)->result();
        $data_project['task_comments'] = $task_comments;

        $this->db->where( implode(' OR ', $where_task_files) );

        // get tasks files
        $task_files = $this->db->get('task_files')->result();
        $data_project['task_files'] = $task_files;

        //echo $this->db->last_query();

      }

      //print_r($this->db->queries);

      $this->load->view('project_view', $data_project);

    }

  } // end method show

  public function add(){

    $plan = get_plan_active();

    $this->load->model('projects_model');
    $total_projects = $this->projects_model->countAll( array('company_id' => get_member_session('company_id')) );

    if( $total_projects >= $plan->max_projects ){

      /// set limit projects 
      // show error dont have permission
      $this->session->set_flashdata('msg_error', _gettxt('msg_error_plan_project_no_more'));
      redirect('/projects');

    }

    $this->load->view('project_form_add');

  }

  public function edit( $project_id ){

    $data_project = null;
    $project = get_project( $project_id );

    if( isset($project[0]) )
      $data_project['project'] = $project[0];

    $this->load->view('project_form_edit', $data_project);

  }

  public function save(){

    if( $this->input->post('form_action') == 'save' ){

      $this->load->library('form_validation');

      $this->form_validation->set_rules('name', _gettxt('name'), 'required');
      $this->form_validation->set_rules('description', _gettxt('description'), 'required');

      // validate form
      if( $this->form_validation->run() !== FALSE ){

        $name         = $this->input->post('name');
        $description  = $this->input->post('description');

        $data_save_project = array( 'name'        => $name, 
                                    'description' => $description
                                  );
        // update
        if( $this->input->post('id') > 0 ){

          $data_save_project['id'] = $this->input->post('id');

        } else { // insert

          $data_save_project['company_id'] = get_member_session('company_id');
          $data_save_project['date_added'] = date('Y-m-d H:i:s');
          $data_save_project['priority']   = 2; //
          $data_save_project['created_by'] = get_member_session('id');

        } 

        $this->load->model('projects_model');
        $saved = $this->projects_model->save( $data_save_project );

        //if( $saved )
        redirect('/projects');

      } else {
        // validation erro
      }

    }// end if check form_action

    // 
    if( $this->input->post('id') > 0 )
      $this->edit( $this->input->post('id') );
    else
      $this->add();

  }

  public function remove( $project_id ){

    if( (int)$project_id < 1 )
      redirect('/projects');

    // check company
    if( !is_company_member($project_id, 'projects') ){
      // show error dont have permission
      $this->session->set_flashdata('msg_error', _gettxt('msg_error_no_permission_access'));
      redirect('/projects');
    }

    $this->load->model('tasks_model');

    $find_options['where'] = array('project_id' => $project_id, 'company_id' => get_member_session('company_id'));
    $find_options['limit'] = 0; // to return all
    $project_tasks = $this->tasks_model->findAll( $find_options );

    // remove All tasks(logs, comments, files e more)
    if( count($project_tasks) > 0 )
      foreach ($project_tasks as $task) 
        $this->tasks_model->removeTask( $task->id );
        
    // remove project WOW
    $this->db->where('id', $project_id);
    $this->db->delete('projects');

    redirect('/projects');

    // remove tasks
      // remove task files
      // remove task comments
      // remove task log

  }

}

/* End of file projects.php */
/* Location: ./application/controllers/projects.php */