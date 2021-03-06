<?php
/* 
 * Developed by David Jonatán Tirado Reyes
 * https://tasks.cencade.mx
 */
 
class Rel_enterprise_user extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Rel_enterprise_user_model');
    } 

    /*
     * Listing of rel_enterprise_user
     */
    function index()
    {
        $data['rel_enterprise_user'] = $this->Rel_enterprise_user_model->get_all_rel_enterprise_user();
        
        $data['_view'] = 'rel_enterprise_user/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new rel_enterprise_user
     */
    function add()
    {   
        $this->load->library('form_validation');

		$this->form_validation->set_rules('enterprise_id','Enterprise Id','required|integer');
		$this->form_validation->set_rules('user_id','User Id','required|integer');
		$this->form_validation->set_rules('role_id','Role Id','required|integer');
		
		if($this->form_validation->run())     
        {   
            $params = array(
				'enterprise_id' => $this->input->post('enterprise_id'),
				'user_id' => $this->input->post('user_id'),
				'role_id' => $this->input->post('role_id'),
            );
            
            $rel_enterprise_user_id = $this->Rel_enterprise_user_model->add_rel_enterprise_user($params);
            redirect('rel_enterprise_user/index');
        }
        else
        {
			$this->load->model('Enterprise_model');
			$data['all_enterprises'] = $this->Enterprise_model->get_all_enterprises();

			$this->load->model('User_model');
			$data['all_users'] = $this->User_model->get_all_users();

			$this->load->model('Role_model');
			$data['all_roles'] = $this->Role_model->get_all_roles();
            
            $data['_view'] = 'rel_enterprise_user/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a rel_enterprise_user
     */
    function edit($id)
    {   
        // check if the rel_enterprise_user exists before trying to edit it
        $data['rel_enterprise_user'] = $this->Rel_enterprise_user_model->get_rel_enterprise_user($id);
        
        if(isset($data['rel_enterprise_user']['id']))
        {
            $this->load->library('form_validation');

			$this->form_validation->set_rules('enterprise_id','Enterprise Id','required|integer');
			$this->form_validation->set_rules('user_id','User Id','required|integer');
			$this->form_validation->set_rules('role_id','Role Id','required|integer');
		
			if($this->form_validation->run())     
            {   
                $params = array(
					'enterprise_id' => $this->input->post('enterprise_id'),
					'user_id' => $this->input->post('user_id'),
					'role_id' => $this->input->post('role_id'),
                );

                $this->Rel_enterprise_user_model->update_rel_enterprise_user($id,$params);            
                redirect('rel_enterprise_user/index');
            }
            else
            {
				$this->load->model('Enterprise_model');
				$data['all_enterprises'] = $this->Enterprise_model->get_all_enterprises();

				$this->load->model('User_model');
				$data['all_users'] = $this->User_model->get_all_users();

				$this->load->model('Role_model');
				$data['all_roles'] = $this->Role_model->get_all_roles();

                $data['_view'] = 'rel_enterprise_user/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The rel_enterprise_user you are trying to edit does not exist.');
    } 

    /*
     * Deleting rel_enterprise_user
     */
    function remove($id)
    {
        $rel_enterprise_user = $this->Rel_enterprise_user_model->get_rel_enterprise_user($id);

        // check if the rel_enterprise_user exists before trying to delete it
        if(isset($rel_enterprise_user['id']))
        {
            $this->Rel_enterprise_user_model->delete_rel_enterprise_user($id);
            redirect('rel_enterprise_user/index');
        }
        else
            show_error('The rel_enterprise_user you are trying to delete does not exist.');
    }
    
}
