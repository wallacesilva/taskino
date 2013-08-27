<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller 
{

  public function index(){}
  public function terms($lang='ptbr')
  {

    $data['lang'] = $lang;
    $this->load->view('pages/terms-'. $lang, $data);

  }

  public function privacy($lang='ptbr')
  {
    $data['lang'] = $lang;
    //$this->load->view('pages/policy', $data);
    $this->load->view('pages/privacy-'. $lang, $data);

  }

}
