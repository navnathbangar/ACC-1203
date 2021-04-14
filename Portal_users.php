<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Portal_users extends AUTH_Controller
{

  public $sidebar = '';

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('dealer/Portal_user_model', 'dealer/Role_model', 'Country_city_model'));
    $this->load->helper(array('send_mail'));

    // if($this->session->userdata('role')==ADMIN)
    // {
    //         $data['title']='';
    //         dealer('errors/cli/error_404',$data);
    // }
    switch ($this->session->userdata('role')) {
      case DEALER:
        $this->sidebar = '1';
        break;

      case ADMIN:
        $this->sidebar = '2';
        break;

      case PM:
        $this->sidebar = '3';
        break;

      default:
        show_error('The page you requested was not found.', 403, $heading = 'Permission Error');
    }
  }

  public function index()
  {

    // $data['userdata'] = $this->userdata;
    $data['PageTitle'] = 'User List';
    $data['all_pu'] = $this->Portal_user_model->view_portal_user('all_pu');
    //echo "<pre>";print_r($data['all_pu']);exit;
    $data['link'] = '';
    if ($this->sidebar == 1) {

      proptia('dealer_portal/Users/portal-user', $data);
    } elseif ($this->sidebar == 3) {

      pm('pm_portal/Users/portal-user', $data);
    } else {

      isuite('dealer_portal/Users/portal-user', $data);
    }

    // dealer('dealer_portal/Users/portal-user',$data);


  }


  public function allUserList()
	{
		$userlist = $this->Portal_user_model->view_portal_user('all_pu');
		$temp = [];

		if (!empty($userlist)) {
			foreach ($userlist as $key => $value) {
				
				$temp[$key]['first_name'] = $value->first_name;
				$temp[$key]['last_name'] = $value->last_name;
				$temp[$key]['mobile'] = $value->mobile;
				$temp[$key]['email'] = $value->email;
				$temp[$key]['address'] = $value->address;
				$temp[$key]['role'] = $value->role;
				$temp[$key]['added_date'] = date($this->_full_month_date_time_frmt, strtotime($value->added_date));
        $temp[$key]['updated_date'] = date($this->_full_month_date_time_frmt, strtotime($value->updated_date));
        $temp[$key]['edit_url'] = site_url('dealer/Portal_users/Edit/' . base64_encode($value->admin_id));
        $temp[$key]['id'] = $value->id;
        $temp[$key]['admin_id'] = $value->admin_id;
				$temp[$key]['delete_url'] =  site_url('dealer/Portal_users/delete');
				
      }
		}
		return $temp;
	}
	/**
	 * User List
	 * @return string
	 */
	public function userList()
	{

		echo json_encode($this->allUserList());
	}


  public function Add()
  {
    $data['link'] = '';
    $data['all_role'] = $this->Role_model->view_role('all_role');
    $pass = rand(10000, 99999);
    $preexisted = 0;

    if ($this->form_validation->run('portal_user') === FALSE) {


      $data['title'] = 'Add User';
      $data['cities'] = $this->Country_city_model->get_cities_us();

      if ($this->sidebar == 1) {

        dealer('dealer_portal/Users/add-portal-user', $data);
      } elseif ($this->sidebar == 3) {
        pm('pm_portal/Users/add-portal-user', $data);
      } else {

        isuite('dealer_portal/Users/add-portal-user', $data);
      }

      // dealer('dealer_portal/Users/add-portal-user',$data);


    } else {

      if ($this->Helper_model->data_exist('email', 'tbl_admin', $this->input->post('email'))) {

        $data['title'] = 'Add User';
        $data['cities'] = $this->Country_city_model->get_cities_us();
        $this->session->set_flashdata('msg', '<p class="btn-danger" style="font-size:13px;padding:10px;margin-left:10px;">Email ID already exists</p>');

        if ($this->sidebar == 1) {

          dealer('dealer_portal/Users/add-portal-user', $data);
        } elseif ($this->sidebar == 3) {

          pm('pm_portal/Users/add-portal-user', $data);
        } else {

          isuite('dealer_portal/Users/add-portal-user', $data);
        }

        // dealer('dealer_portal/Users/add-portal-user',$data);


      }
      $AddUser = $this->Portal_user_model->add_user($pass, $preexisted);
      if ($AddUser) {

        $to = $this->input->post('email');
        $data['email'] = $to;
        $data['pass'] = $pass;
        $data['name'] = $this->input->post('f_name');
        send_mail($to, welcomeMailSubject, 'email_template/email_password', $data);

        $this->session->set_flashdata('msg', '<p class="btn-success" style="font-size:13px;padding:10px;margin-left:10px;">User Added Successfully</p>');
        redirect('dealer/Portal_users');
      } else {
        $this->session->set_flashdata('msg', '<p class="btn-danger" style="font-size:13px;padding:10px;margin-left:10px;">Something Went Wrong</p>');

        if ($this->sidebar == 1) {

          dealer('dealer_portal/Users/add-portal-user', $data);
        } elseif ($this->sidebar == 3) {

          pm('pm_portal/Users/add-portal-user', $data);
        } else {

          isuite('dealer_portal/Users/add-portal-user', $data);
        }

        // dealer('dealer_portal/Users/add-portal-user',$data);

      }
    }
  }

  public function add_data(){  
    $data['title'] = "Add User";
    $data['cities'] = $this->Country_city_model->get_cities_us();
    $data['states'] = $this->Country_city_model->get_state();
    $data['all_role'] = $this->Role_model->view_role('all_role');
    echo json_encode($data);
  }

  public function add_user_data(){
    $pass = rand(10000, 99999);
    $preexisted = 0;
    $AddUser = $this->Portal_user_model->add_user($pass, $preexisted);
    if ($AddUser) {

      $to = $this->input->post('email');
      $data['email'] = $to;
      $data['pass'] = $pass;
      $data['name'] = $this->input->post('f_name');
      send_mail($to, welcomeMailSubject, 'email_template/email_password', $data);

      $msg = ['status' => true, 'message' => 'User Added Successfully', 'class' => 'success'];
    }else{
      $msg = ['status' => false, 'message' => 'Something Went Wrong', 'class' => 'error'];
    }
    echo json_encode($msg);
  }


  public function edit_data(){
    $id = $this->input->post('id');    
    $data['title'] = "Edit User";
    $data['id'] = $id;
    $data['cities'] = $this->Country_city_model->get_cities_us();
    $data['states'] = $this->Country_city_model->get_state();
    $data['data'] = $this->Portal_user_model->view_portal_user('puby_id', $id);
    $data['all_role'] = $this->Role_model->view_role('all_role');
    echo json_encode($data);
  }

  public function Edit($id)
  {

    $id = base64_decode($id);
    $data['title'] = "Edit User";
    $data['id'] = $id;
    $data['cities'] = $this->Country_city_model->get_cities_us();
    $data['link'] = '';
    if ($this->form_validation->run('portal_user') === FALSE) {
      $data['data'] = $this->Portal_user_model->view_portal_user('puby_id', $id);
      
      $data['all_role'] = $this->Role_model->view_role('all_role');

      if ($this->sidebar == 1) {

        dealer('dealer_portal/Users/edit-portal-user', $data);
      } elseif ($this->sidebar == 3) {

        pm('pm_portal/Users/edit-portal-user', $data);
      } else {

        isuite('dealer_portal/Users/edit-portal-user', $data);
      }

      // dealer('dealer_portal/Users/edit-portal-user',$data);


    } else {

      if ($this->Helper_model->data_exist('email', 'tbl_admin', $this->input->post('email'), $id)) {
        $data['data'] = $this->Portal_user_model->view_portal_user('puby_id', $id);
        $data['all_role'] = $this->Role_model->view_role('all_role');
        $this->session->set_flashdata('msg', '<p class="btn-danger" style="font-size:13px;padding:10px;margin-left:10px;">Email ID already exists</p>');

        if ($this->sidebar == 1) {

          dealer('dealer_portal/Users/edit-portal-user', $data);
        } elseif ($this->sidebar == 3) {

          pm('pm_portal/Users/edit-portal-user', $data);
        } else {

          isuite('dealer_portal/Users/edit-portal-user', $data);
        }

        // dealer('dealer_portal/Users/edit-portal-user',$data);

      } else if ($this->Portal_user_model->edit_user($id)) {
        $this->session->set_flashdata('msg', '<p class="btn-success" style="font-size:13px;padding:10px;margin-left:10px;">User Updated Successfully</p>');
        redirect('dealer/Portal_users');
      }
    }
  }

  public function update_user_data(){
    $id = $this->input->post('id');
    if($this->Portal_user_model->edit_user($id)){
      $msg = ['status' => true, 'message' => 'User Updated Successfully', 'class' => 'success'];
    }else{
      $msg = ['status' => false, 'message' => 'Something Went Wrong', 'class' => 'error'];
    }
    echo json_encode($msg);
  }

  
  public function delete_data()
  {
    $id = $this->input->post('id');
    $data['title'] = 'User';
    if ($this->Portal_user_model->delete($id)) {
      $msg = ['status' => true, 'message' => 'User Deleted Successfully', 'class' => 'success'];
    }else{
      $msg = ['status' => false, 'message' => 'Something Went Wrong', 'class' => 'error'];
    }
    echo json_encode($msg);
  }

  public function delete()
  {
    $id = $this->input->post('id');
    $data['title'] = 'User';
    if ($this->Portal_user_model->delete($id)) {
      echo "1";
    }
  }
}

/* End of file Pegawai.php */
/* Location: ./application/controllers/Pegawai.php */