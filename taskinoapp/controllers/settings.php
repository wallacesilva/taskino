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

  public function report_error(){

    $data = array();

    $data_save = $this->report_error_save();

    $data = array_merge($data, $data_save);

    // get messages
    $msg_error = $this->session->flashdata('msg_error');
    if( strlen($msg_error) > 0 )
      $data['msg_error'] = $msg_error;

    $msg_ok = $this->session->flashdata('msg_ok');
    if( strlen($msg_ok) > 0 )
      $data['msg_ok'] = $msg_ok;

    $this->load->view('report_error', $data);

  }

  public function report_error_save(){

    if (isset($_POST['do_report']) && $_POST['do_report'] == 'bug') {

      $title       = $this->input->post('report_title');
      $where       = $this->input->post('report_where');
      $description = $this->input->post('report_description');

      $bug_data = array('member_id'   => get_member_session('id'),
                        'company_id'  => get_member_session('company_id'),
                        'title'       => $title,
                        'where_find'  => $where,
                        'description' => $description,
                        'date_added'  => date('Y-m-d H:i:s'),
                       );

      $this->db->insert('report_bug', $bug_data);

      $data['msg_ok'] = _gettxt('msg_ok_report_sent'); // obrigado pela ajuda

      return $data;

    }

    return array();

  }

}

/* End of file settings.php */
/* Location: ./application/controllers/settings.php */