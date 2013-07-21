<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Languages extends MY_Controller {

  public function index(){

    redirect('/dashboard');

  }

  public function change_to( $lang = 'english' ){

    if( !in_array($lang, array('english', 'portuguese') ) )
      $lang = 'english';

    $this->session->set_userdata('taskino_lang', $lang);

    redirect('/dashboard');

  }



}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */