<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Languages extends CI_Controller {

  public function index(){

    redirect('/dashboard');

  }

  public function change_to( $lang = 'english' ){

    if( !in_array($lang, array('english', 'portuguese') ) )
      $lang = 'portuguese';

    $this->session->set_userdata('taskino_lang', $lang);
    
    if( strpos($_SERVER['HTTP_REFERER'] , base_url()) !== FALSE ){
      
      redirect($_SERVER['HTTP_REFERER']);

    } else {

      redirect('/dashboard');
    }

  }



}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */