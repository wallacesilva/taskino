<?php 

// pega a tarefa e retorna array ou campo especifico 
function get_company($id, $field=null){

  $CI =& get_instance();
  $CI->db->where('id', $id);
  $company = $CI->db->get('taskino_company');
  $company = $company->result();

  if( strlen($field) > 0 && isset($company[0]->$field) )
    return $company[0]->$field;
  else 
    return $company;

}

// pega empresa baseado na url
function get_company_code(){

  return get_company_session('folder_name');
}

// pega dados da empresa na sessao
function get_company_session( $field=false ){

  $CI =& get_instance();
  $company_ss = $CI->session->userdata('company');

  if( $field !== false && isset($company_ss[$field]) )
    return $company_ss[$field];

  return $company_ss;

}

// salva os dados da empresa logado no sessao
function set_company_session( $company_data ){

  $CI =& get_instance();

  $company = array('company' => $company_data);
  
  return $CI->session->set_userdata( $company );

}


function clear_company_session(){

  $CI =& get_instance();
  return $CI->session->unset_userdata('company');
  
}

function company_disk_usage( $size_type='KB' ){

  $company_id = get_member_session('company_id');

  $CI =& get_instance();

  $CI->db->select_sum('file_size');
  $CI->db->where('company_id', $company_id);
  $result = $CI->db->get('task_files')->result();

  if (isset($result[0]->file_size) && $result[0]->file_size > 0) {

    if ($size_type=='MB') 
      return number_format($result[0]->file_size/1024, 2, '.', '.'). ' MB';
    else 
      return $result[0]->file_size. ' KB'; // default
    
  }

  return 0;

}