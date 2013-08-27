<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks_model extends MY_Model {

  public $_tablename = 'tasks';

  function __construct(){

    parent::__construct();

  }

  /**
   * Remove task + task files + task comments + task log + task ALL
   * @param integer $task_id Id to remove from task to be removed
   * @return bool True on success OR False on error
   */
  public function removeTask( $task_id ){

    if( (int)$task_id < 1 )
      return false;

    // remove files
    $this->db->where('task_id', $task_id);
    $this->db->where('hosted_on', 'taskino');
    $this->db->where('company_id', get_member_session('company_id'));
    $task_files = $this->db->get('task_files')->result();

    if( count($task_files) > 0 ){

      foreach ($task_files as $file) {

        $file_path = dirname(BASEPATH). $file->full_path;

        // remove file from server
        if( file_exists($file_path) ){          
          if( !@unlink( $file_path ) ){
            // register log
            $msg_file_log = 'Erro ao remover arquivo. Data'. date('Y-m-d H:i:s').' | Arquivo: '. $file_path. '';
            taskino_log( $msg_file_log, 'error');
          }
        }

      }// end foreach task files

    } // end if count files to task

    // remove file from database
    $this->db->where('task_id', $task_id);
    $this->db->where('hosted_on', 'taskino');
    $this->db->where('company_id', get_member_session('company_id'));
    $this->db->delete('task_files');

    // remove task logs 
    $this->db->where('task_id', $task_id);
    $this->db->delete( 'tasks_log' );

    // remove comments
    $this->db->where('task_id', $task_id);
    $this->db->delete( 'task_comments' );

    // REMOVE THE TASK, WOW
    $this->db->where('id', $task_id);
    $this->db->where('company_id', get_member_session('company_id'));
    $this->db->delete('tasks');

    return true;

  } // end method removeTask
    
}

// END of file: tasks_model.php