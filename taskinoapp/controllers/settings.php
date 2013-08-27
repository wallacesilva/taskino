<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller {

  public function index(){

    if( !member_is_admin() )
      redirect('/dashboard');

    $data = $settings_array = null;

    $this->load->model('settings_model');

    $company = $this->settings_model->find( get_member_session('company_id') );

    if( count($company) == 1 ){

      $settings_array['name'] = $company[0]->name;
      $settings_array['url_logo'] = $company[0]->url_logo;

    }

    //
    $settings = (object) $settings_array;
    $data['settings'] = $settings;

    // get messages
    $msg_error = $this->session->flashdata('msg_error');
    if( $msg_error !== false )
      $data['msg_error'] = $msg_error;

    $msg_ok = $this->session->flashdata('msg_ok');
    if( $msg_ok !== false )
      $data['msg_ok'] = $msg_ok;

    $this->load->view('settings', $data);

  }

  public function save(){

    if( $_POST['form_action'] ){

      $this->load->library('form_validation');

      $this->form_validation->set_rules('name', _gettxt('name'), 'required');

      // validate form
      if( $this->form_validation->run() !== FALSE ){

        $this->load->model('settings_model');

        $data = array('name'     => $this->input->post('name'),
                      'url_logo' => $this->input->post('url_logo')
                      );

        $saved = $this->settings_model->save_settings( $data );

        if( $saved )
          redirect('/settings');

      } // end form validate

    } // end form action

    $this->index();
    
  }

}

/* End of file settings.php */
/* Location: ./application/controllers/settings.php */