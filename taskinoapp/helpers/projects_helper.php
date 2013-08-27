<?php 

// pega o projeto e retorna array ou campo especifico 
function get_project($id, $field=null){

  $CI =& get_instance();
  $CI->db->where('id', $id);
  $projects = $CI->db->get('projects');
  $projects = $projects->result();

  if( count($projects) < 1 )
    return false;

  if( strlen($field) > 0 && isset($projects[0]->$field) )
    return $projects[0]->$field;
  else 
    return $projects;

}
