<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');

		$this->load->model('crud_model');
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	// fungsi memasukkan data
	public function insert()
	{
		if($this->input->is_ajax_request()){
			$this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

			if ($this->form_validation->run() == FALSE)
                {
                    $data = array('response' => 'error', 'message' => validation_errors());
                }
                else
                {
					$ajax_data = $this->input->post();
					if ($this->crud_model->insert_entry($ajax_data)){
						$data = array('response' => 'success', 'message' => 'Berhasil memasukkan data');
					}else{
						$data = array('response' => 'success', 'message' => 'failed');
					}
                }

		}else{
			echo "No direct script access allowed";
		}

		echo json_encode($data);
	}

	// fungsi mengambil data
	public function fetch(){
		if ($this->input->is_ajax_request()) {
			$posts = $this->crud_model->get_entries();
			echo json_encode($posts);
		}
	}

	// fungsi menghapus data
	public function delete(){
			if ($this->input->is_ajax_request()) {
				$del_id = $this->input->post('del_id');

			if ($this->crud_model->delete_entry($del_id)) {
				$data = array('response' => "success");
			}else{
				$data = array('response' => "error");
			}
		}

		echo json_encode($data);	
	}
	
	// fungsi edit data
	public function edit(){
		if ($this->input->is_ajax_request()) {
			$edit_id = $this->input->post('edit_id');
			
			if ($post = $this->crud_model->single_entry($edit_id)) {
				$data = array('response' => "success", 'post' => $post);
			}else{
				$data = array('response' => "error", 'message' => 'failed');
			}
		}
		echo json_encode($data);
	}

	// fungsi memperbaharui data
	public function update(){
		if($this->input->is_ajax_request()){
			$this->form_validation->set_rules('edit_name', 'Name', 'required');
            $this->form_validation->set_rules('edit_email', 'Email', 'required|valid_email');

			if ($this->form_validation->run() == FALSE)
                {
                    $data = array('response' => 'error', 'message' => validation_errors());
                }
                else
                {
					$data['id'] = $this->input->post('edit_id');
					$data['name'] = $this->input->post('edit_name');
					$data['email'] = $this->input->post('edit_email');
					if ($this->crud_model->update_entry($data)){
						$data = array('response' => 'success', 'message' => 'Berhasil memperbaharui data');
					}else{
						$data = array('response' => 'success', 'message' => 'failed');
					}
                }
		}else{
			echo "No direct script access allowed";
		}

		echo json_encode($data);
	}
}