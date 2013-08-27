<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

  public function __construct(){

    parent::__construct();

    // get default language
    set_taskino_language();

  }

  public function index(){
    echo 'Wow - My Staff Area';
  }

}