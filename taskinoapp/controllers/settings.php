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

    public function payment_checkout_error($error=1)
    {
        if ((int)$error > 1)
            $this->session->set_flashdata('msg_error', 'erro :('._gettxt('msg_payment_error_'.$error));

        // 1: Ops! Erro ao processar pagamento. Tenta novamente.
        // 2: 

        redirect('settings');
    }

    public function payment_checkout()
    {
        $this->output->enable_profiler();

        define('PAGSEGURO_URL', 'https://ws.sandbox.pagseguro.uol.com.br'); // sandbox
        define('PAGSEGURO_URL_REDIRECT', 'https://sandbox.pagseguro.uol.com.br'); // sandbox
        define('PAGSEGURO_EMAIL', 'financeiro@in9web.com');
        //define('PAGSEGURO_TOKEN', 'B44EE4B116CD44B5B6105AF247297922');
        define('PAGSEGURO_TOKEN', 'F669C9735ADD410497B9543533C2F092');

        $plan_id        = 2; //$this->input->post('plan_id');

        $plan           = get_plan($plan_id);
        $company        = (object) get_company_session();

        echo '<pre>';
        print_r($plan);
        print_r($company);
        echo '</pre>';

        $timestamp      = time();

        $reference      = sprintf('REF.%s.%s.%s', $plan->id, $company->id, $timestamp);
        $description    = sprintf('Contratar plano %s para %s no TaskinoApp', $plan->name, $company->name);
        $price          = (float) $plan->price;

        $data = array(
            'email'             => PAGSEGURO_EMAIL,
            'token'             => PAGSEGURO_TOKEN,
            'currency'          => "BRL",
            'itemId1'           => $company->id,
            'itemDescription1'  => substr($description, 0, 100),
            'itemAmount1'       => number_format($price, 2),
            'itemQuantity1'     => 1,
            'reference'         => $reference,
            'senderEmail'       => $company->email,
        );

        $curl_resource  = curl_init();
        curl_setopt($curl_resource, CURLOPT_URL, PAGSEGURO_URL.'/v2/checkout/');
        curl_setopt($curl_resource, CURLOPT_POST, count($data));
        curl_setopt($curl_resource, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl_resource, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_resource, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
        $result         = curl_exec($curl_resource);

        $xml            = simplexml_load_string($result);
        $json           = json_encode($xml);
        $array          = json_decode($json,TRUE);

        if ($array['error']) {

            //echo "Houve um erro, por favor tente novamente mais tarde";
            //redirect('/settings/payment_checkout_error/1');

        } elseif ($result) {

            $code = $array['code'];

            // salva as informações do pagseguro na tabela
            $transaction_db_data = array(
                'company_id'    => $company->id,
                'plan_id'       => $plan->id,
                'member_id'     => get_member_session('id'),
                'return_code'   => $code,
                'reference'     => $reference,
                'date'          => $timestamp,
                'status'        => 'pending', 
                'date_added'    => date('Y-m-d H:i:s')
            );

            //$this->db->insert('taskino_transactions', $transaction_db_data);
            $saved = true;

            if ($saved) {

                // transação salva com sucesso, redirecionar para o pagseguro
                $this->output->set_header('Location: '.PAGSEGURO_URL_REDIRECT.'/v2/checkout/payment.html?code='. $code);
                
                //header("location: https://pagseguro.uol.com.br/v2/checkout/payment.html?code=". $code);

            } else {

                // erro ao processar pagamento
                //redirect('/settings/payment_checkout_error/1');

            }

        }

    }

}

/* End of file settings.php */
/* Location: ./application/controllers/settings.php */