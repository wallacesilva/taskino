<?php 

// 'tasks', 'projects', 'files', 'members'
function is_company_member( $id, $object='all' ){

  if( (int)$id < 1 )
    return false;

  $company_id = 0;

  if( $object == 'all' )
    return (bool)( get_member_session('company_id') === $id );

  if( $object == 'tasks' )
    $company_id = get_task( $id, 'company_id' );
  
  if( $object == 'projects' )
    $company_id = get_project( $id, 'company_id' );

  if( $object == 'members' )
    $company_id = get_member( $id, 'company_id' );

  if( $company_id === get_member_session('company_id') )
    return true;
  
  return false;

}

function member_get_company($id){

  $CI =& get_instance();
  $CI->db->where('member_id', $id);
  $query = $CI->db->get('member_company');
  $company = $query->result();

  if( count($company) > 0 )
    return $company;
  else 
    return false;

}

function company_get_member($id){

  $CI =& get_instance();
  $CI->db->where('company_id', $id);
  $query = $CI->db->get('member_company');  
  $member = $query->result();

  if( count($member) > 0 )
    return $member;
  else 
    return false;

}

function member_add_company( $member_id ){

  $CI =& get_instance();
  $data_add = array('member_id'  => $member_id,
                    'company_id' => get_member_session('company_id'),
                    'is_admin'   => 'no',
                    'date_added' => date('Y-m-d H:i:s')
                    );
  return $CI->db->insert('member_company', $data_add);

}

function member_set_company_session( $company_id ){

  if( $company_id < 1 )
    return false;

  $member_session = get_member_session();
  $member_session['company_id'] = $company_id;

  return set_member_session($member_session);

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

  // fix multiple company
  /*$members_company = company_get_member( get_member_session('company_id') );
  foreach ($members_company as $item_member) {    
    $CI->db->or_where('id', $item_member->member_id);
  }*/

  $CI->db->or_where('company_id',  get_member_session('company_id'));

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

  if( strlen($field) > 0 ){

    if( isset($member_ss[$field]) ){
      return $member_ss[$field];      
    } else {
      return false;
    }

  }

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

// check if members is admin
function member_is_admin(){

  if( get_member_session('is_admin') == 'yes' )
    return true;

  return false;

}

function set_member_is_admin( $new_is_admin ){

  if( !in_array($new_is_admin, array('yes', 'no')))
    return false;

  if( $new_is_admin == get_member_session('is_admin') )
    return true;

  $member_session = get_member_session();
  $member_session['is_admin'] = $new_is_admin;

  return set_member_session($member_session);

}

function member_is_admin_master( $member_id ){

  if( $member_id < 1 )
    return false;

  $CI =& get_instance();
  $CI->db->where('id', $member_id);
  $member = $CI->db->get('members')->result();

  if( count($member) != 1 )
    return false;

  if( isset($member[0]->is_admin_master) && $member[0]->is_admin_master == 'yes' )
    return true;

  return false;

}

function check_member_mail_exists( $email ){

  $CI =& get_instance();

  if( strpos($email, '@') === FALSE )
    return false;

  $CI->db->where('email', $email);
  // fix multiple company
  //$CI->db->where('company_id', get_member_session('company_id'));
  $query = $CI->db->get('members');
  $members = $query->result();

  if( count($members) > 0 )
    return true;

  return false;

}

function check_member_login_exists( $login ){

  $CI =& get_instance();

  $CI->db->where('login', $login);
  $query = $CI->db->get('members');
  $members = $query->result();

  if( count($members) > 0 )
    return true;

  return false;

}

// realiza o login do usuario
function member_do_login($login, $password){

  $CI =& get_instance();

  $member_where = array('login' => $login, 'password' => sha1($password)); //, 'status'=>'active'
  $login_member = $CI->db->get_where('members', $member_where);
  //$login_member = $login_member->result();

  if( $login_member->num_rows() == 1 ){
    
    $member = $login_member->row_array();

    if ($member['status'] == 'inactive') {

      $data2['msg_error'] = _gettxt('msg_error_company_not_active'); 
      $CI->session->set_flashdata('msg_error', $data2['msg_error']);
      redirect('/auth');

    }

    // remove password from session
    unset($member['password']);

    // fix multiple company
    /*$member['company_id'] = 0;

    $companies = member_get_company( $member['id'] );

    if( count($companies) == 1 && $companies[0]->company_id > 0 ){
      $member['company_id'] = $companies[0]->company_id;
    } else {

      if( is_array($companies) )
        foreach ($companies as $item_company) 
          $member['companies'][] = $item_company->company_id;
    }*/

    // helper para adicionar usuario na sessao 
    set_member_session( $member );

    $CI->session->set_userdata('taskino_lang', $member['language_default']); 

    // update date last login
    $CI->db->where( $member_where );
    $CI->db->update( 'members', array('date_last_login' => date('Y-m-d H:i:s')) );

    //
    $company = get_company($member['company_id']);
    $company = (array)$company[0];
    set_company_session($company);

    return true;

  } 

  $msg_error_login = sprintf('Erro ao tentar logar. Login: %s And Password: %s', $login, $password);
  taskino_log($msg_error_login, 'authentication');

  return false;

}

// verifica se usuario esta logado
function member_check_login(){

  if( get_member_session('id') > 0 )
    return true;

  return false;
  
}