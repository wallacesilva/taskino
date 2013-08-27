<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends MY_Model {

  public $_tablename = 'taskino_company';

  function __construct(){

    parent::__construct();

  }

  public function save_settings( $data ){

    if( !is_array($data) || count($data) < 1 )
      return false;

    $this->db->where('id', get_member_session('company_id'));
    return $this->db->update( $this->_tablename, $data);

  }

}

// END of file: projects_model.php