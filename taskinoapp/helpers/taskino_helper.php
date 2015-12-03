<?php 

function plan_check( $action ){

  if( strlen($action) < 1 )
    return false;

  $company_id = get_member_session('company_id');

  $CI =& get_instance();

  $CI->db->where('id', get_company( $company_id, 'plan_id_active' ));
  $plans = $CI->db->get('taskino_plans')->result();

  if( count($plans) == 1 ){

    if( $action == 'add_project' ){

      $CI->load->model('projects_model');

      $project_where = array('company_id' => $company_id );
      $total_projects = $CI->projects_model->countAll( $project_where );

      if( $plans[0]->max_projects >= $total_projects )
        return true;

      return false;

    } elseif( $action == 'add_file' ){

      $total_file = files_count_all() / 1024; // convert kb to mb

      if( $plans[0]->max_filesize >= $total_file )
        return true;

      return false;

    }

  } // end count plans

  return false; // dont have plans

}

//  @uses company_disk_usage() file:company_helper.php
function files_count_all(){

  return company_disk_usage();

}

function get_plan_active(){
  //plan_id_active

  $company_id = get_company_session('plan_id_active');
  if ($company_id < 1)
    return false;

  $CI =& get_instance();
  $CI->db->where('id', $company_id);
  $query = $CI->db->get('taskino_plans');

  if ($query->num_rows() > 0) {

    $plan = $query->result();
    return $plan[0];
    
  }

  return false;

}

function get_plan($plan_id)
{
  if ((int)$plan_id < 1)
    return null;

  $CI =& get_instance();
  $CI->db->where('id', $plan_id);
  $query = $CI->db->get('taskino_plans');

  if ($query->num_rows() > 0) {

    $plan = $query->result();

    if (isset($plan[0]->id) && $plan[0]->id == $plan_id)
      return $plan[0];
    
  }

  return null;

}

// get default pagination to CI work with twitter bootstrap 
function get_pagination_config( $pre_config = null ){

  if( empty($pre_config) )
    $pre_config = array();

  //$config_pag['base_url']       = current_url().'/page/';
  $config_pag['per_page']       = 10; // limit, ex 10, 15, 
  $config_pag['total_rows']     = 0; // total to show, eg. 300, 400, 1900
  $config_pag['cur_tag_open']   = '<li class="active"><a href="#">';
  $config_pag['cur_tag_close']  = '</a></li>';
  $config_pag['num_tag_open']   = '<li>';
  $config_pag['num_tag_close']  = '</li>';
  $config_pag['prev_link']      = ''; //&lt;
  $config_pag['next_link']      = ''; //&gt;
  $config_pag['prev_tag_open']  = '<!--';
  $config_pag['prev_tag_close'] = '-->';
  $config_pag['next_tag_open']  = '<!--';
  $config_pag['next_tag_close'] = '-->';

  $config_pag = array_merge($config_pag, $pre_config);

  return $config_pag;

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

  $mail_config['useragent']   = 'TaskinoMail';
  $mail_config['protocol']    = 'smtp';
  $mail_config['smtp_host']   = 'smtp.gmail.com'; //ssl://smtp.googlemail.com
  $mail_config['smtp_port']   = '465';
  $mail_config['smtp_crypto'] = 'ssl';
  $mail_config['smtp_user']   = 'iclasso.com@gmail.com';
  $mail_config['smtp_pass']   = '000';
  $mail_config['mailtype']    = 'html';

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

  // change default language codeigniter
  if( $taskino_lang != 'portuguese' )
    $CI->config->set_item('language', $taskino_lang);  

  $CI->lang->load('taskino', $taskino_lang);

}

// get default language, if empty return 'english'
function get_taskino_language(){

  $CI =& get_instance();

  $taskino_lang = $CI->session->userdata('taskino_lang');
  if( !in_array($taskino_lang, array('english', 'portuguese') ) )
    $taskino_lang = 'portuguese';

  /*$member_lang = get_member_session('language_default');
  if( !in_array($member_lang, array('english', 'portuguese') ) )
    $member_lang = 'portuguese';*/

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

  if( !defined('DS') ) define('DS', DIRECTORY_SEPARATOR);

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
