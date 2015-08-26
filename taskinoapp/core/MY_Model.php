<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model{

  public $_tablename = '';

  public function __construct(){
    
    parent::__construct();

  }

  public function countAll( $where=null ){

    if( is_array($where) )
      $this->db->where( $where );

    $total_results = $this->db->count_all_results( $this->_tablename );

    return $total_results;

  }

  public function find( $id ){

    if( $id < 1 )
      return false;

    $this->db->where('id', $id);
    return $this->db->get( $this->_tablename )->result();

  }

  /**
   * findAll - method to get results
   * @param array $options Get options to find rows 
   * @example $options =  array('where' => array('id'   => 1), 
   *                            'order' => array('name' => 'asc'), 
   *                            'offset' => 0, 
   *                            'limit' => 10)
   * @return array Return array with rows
   * @author Wallace Silva
   */
  public function findAll( $options = null ){

    if( !is_array($options) )
      return false;

    $default = array('where' => null, 'order' => null, 'offset' => 0, 'limit' => 10);

    $options = array_merge($default, $options);

    if( is_array($options['where']) )
      $this->db->where( $options['where'] );

    if( is_array($options['order']) )
      foreach ($options['order'] as $order_key => $order_value) 
        $this->db->order_by( $order_key, $order_value );

    if( $options['limit'] > 0 && $options['offset'] >= 0 )
      $this->db->limit($options['limit'], $options['offset']);

    $result = $this->db->get( $this->_tablename );

    return $result->result();

  }

  public function getAll( $offset=0, $limit=10 ){

    $this->db->limit($limit, $offset);

    $result = $this->db->get( $this->_tablename );

    return $result->result();    

  }

  public function save( $data ){

    if( !is_array($data) )
      return false;

    if( isset($data['id']) ){

      $id = $data['id'];
      $this->db->where('id', $id); // set id
      unset($data['id']);

      $this->db->update( $this->_tablename, $data );
      
    } else {

      $this->db->insert( $this->_tablename, $data );

    }

  }

}