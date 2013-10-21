<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Projects_model extends MY_Model {

  public $_tablename = 'projects';

  function __construct(){

    parent::__construct();

  }

  public function total_tasks( $project_id, $status=null ){

    if( $project_id < 1 )
      return 0;
    
    $this->db->where('project_id', $project_id);
    if( $status > 0 )
      $this->db->where('status', $status);
    return $this->db->count_all_results('tasks');

  }

}

// END of file: projects_model.php