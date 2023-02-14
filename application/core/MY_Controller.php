 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

 class MY_Controller extends CI_Controller{

  public function __construct(){
     parent::__construct();

     //$this->output->cache(1);

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

      $color = isset($_SESSION['color'])?$_SESSION['color']:'light';

      if($color == 'dark')
        $this->load->view('main_layout_dark', $this->data);
      else
        $this->load->view('main_layout', $this->data);
  }

  public function isLogined(){
    if ($this->session->userdata('user_id') > 0) {
    }else{
      redirect('login');
    }
  }

  public function checkPlanID(){
	if($this->session->userdata('plan_id') == 0)
		redirect(base_url('profile'));
  }
 }