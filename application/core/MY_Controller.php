 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

 class MY_Controller extends CI_Controller{

  public function __construct(){
     parent::__construct();
     $this->isLogined();
  }

  public function load_view($page_name, $params){
      $this->load->model("Dashboard_model");
      $user_accounts = $this->Dashboard_model->getUserAccounts();
      
      $this->data = array(
         "page" => APPPATH.'views/'.$page_name,
         "params" => $params,
         "accounts" => $user_accounts[0] 
      );

      $this->load->view('main_layout', $this->data);
  }

  public function isLogined(){
    if ($this->session->userdata('user_id') > 0) {
    }else{
      redirect('login');
    }
  }
 }