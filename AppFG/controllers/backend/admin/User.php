<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		if(!$this->session->userdata('id')) {
            redirect(base_url().'backend/admin/login');
            exit;
		}

		$this->load->model('backend/admin/Model_common');
		$this->load->model('backend/admin/Model_user');
		
		$data['setting'] = $this->Model_common->get_setting_data();

		if (!in_array($this->session->userdata('role'), ['Superadmin'])) {
			if ($data['setting']['website_status_backend'] === "Passive") {
				$data['message'] = $data['setting']['website_status_backend_message'];
				redirect(base_url('backend/info'));
			}
		}
		
    }
	public function index()
	{
		$data['setting'] = $this->Model_common->get_setting_data();
		$data['all_users'] = $this->Model_user->get_all_user();

		$this->load->view('backend/admin/view_header',$data);
		$this->load->view('backend/admin/view_user',$data);
		$this->load->view('backend/admin/view_footer');
		
	}

	public function edit($id)
	{
		if($this->session->userdata('id') != 1){
			if($id == 1){
				redirect(base_url('backend/admin'));
			}
		}
		
		// If there is no TODO in this id, then redirect
        $tot = $this->Model_user->user_check($id);
        if (!$tot) {
            redirect(base_url() . 'backend/admin/user');
            exit;
        }

		$error = '';
		$success = '';

		$data['setting'] = $this->Model_common->get_setting_data();

		if(isset($_POST['form1'])) {

			$valid = 1;

			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error = validation_errors();
            }

            if($valid == 1) {
	            $form_data = array(
					'username'     => $this->input->post('username'),
					'email'     => $this->input->post('email')
	            );
	        	$this->Model_profile->update($form_data);
	        	$success = 'User Information is updated successfully!';
	        	
	        	$this->session->set_userdata($form_data);

	        	$this->session->set_flashdata('success',$success);
	        	redirect(base_url().'backend/admin/user');
            }
            else {
            	$this->session->set_flashdata('error',$error);
	        	redirect(base_url().'backend/admin/user');
            }
		}

		if(isset($_POST['form2'])) {
			$valid = 1;
			$path = $_FILES['photo']['name'];
		    $path_tmp = $_FILES['photo']['tmp_name'];
		    if($path!='') {
		        $ext = pathinfo( $path, PATHINFO_EXTENSION );
		        $file_name = basename( $path, '.' . $ext );
		        $ext_check = $this->Model_common->extension_check_photo($ext);
		        if($ext_check == FALSE) {
		            $valid = 0;
		            $data['error'] = 'You must have to upload jpg, jpeg, gif or png file<br>';
		        }
		    } else {
		    	$valid = 0;
		        $data['error'] = 'You must have to select a photo<br>';
		    }
		    if($valid == 1) {
		    	// removing the existing photo
		    	unlink('./public/uploads/'.$this->session->userdata('photo'));

		    	// updating the data
		    	$final_name = 'user-'.'.'.$ext;
		        move_uploaded_file( $path_tmp, './public/uploads/'.$final_name );
		    			        
				$form_data = array(
					'photo' => $final_name
	            );
	        	$this->Model_profile->update($form_data);
	        	$success = 'Photo is updated successfully!';

	        	$this->session->set_userdata($form_data);
	        	$this->session->set_flashdata('success',$success);
	        	redirect(base_url().'backend/admin/profile');
		    }
		    else {
		    	$this->session->set_flashdata('error',$error);
	        	redirect(base_url().'backend/admin/profile');
		    }
		}


		$data['user'] = $this->Model_user->get_user_data($id);

		$this->load->view('backend/admin/view_header',$data);
		$this->load->view('backend/admin/view_user_edit',$data);
		$this->load->view('backend/admin/view_footer');
	}
	
}
