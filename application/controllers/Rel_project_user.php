<?php
/* 
 * Developed by David Jonatán Tirado Reyes
 * https://tasks.cencade.mx
 */
 
class Rel_project_user extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Rel_project_user_model');
    } 

    /*
     * Listing of rel_project_user
     */
    function index()
    {
        $data['rel_project_user'] = $this->Rel_project_user_model->get_all_rel_project_user();
        
        $data['_view'] = 'rel_project_user/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new rel_project_user
     */
    function add()
    {   
        $this->load->library('form_validation');

		$this->form_validation->set_rules('user_id','User Id','required');
		$this->form_validation->set_rules('project_id','Project Id','required');
		
		if($this->form_validation->run())     
        {   
            $params = array(
				'user_id' => $this->input->post('user_id'),
				'project_id' => $this->input->post('project_id'),
            );
            
            $rel_project_user_id = $this->Rel_project_user_model->add_rel_project_user($params);
            redirect('rel_project_user/index');
        }
        else
        {
			$this->load->model('User_model');
			$data['all_users'] = $this->User_model->get_all_users();

			$this->load->model('Project_model');
			$data['all_projects'] = $this->Project_model->get_all_projects();
            
            $data['_view'] = 'rel_project_user/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a rel_project_user
     */
    function edit($id)
    {   
        // check if the rel_project_user exists before trying to edit it
        $data['rel_project_user'] = $this->Rel_project_user_model->get_rel_project_user($id);
        
        if(isset($data['rel_project_user']['id']))
        {
            $this->load->library('form_validation');

			$this->form_validation->set_rules('user_id','User Id','required');
			$this->form_validation->set_rules('project_id','Project Id','required');
		
			if($this->form_validation->run())     
            {   
                $params = array(
					'user_id' => $this->input->post('user_id'),
					'project_id' => $this->input->post('project_id'),
                );

                $this->Rel_project_user_model->update_rel_project_user($id,$params);            
                redirect('rel_project_user/index');
            }
            else
            {
				$this->load->model('User_model');
				$data['all_users'] = $this->User_model->get_all_users();

				$this->load->model('Project_model');
				$data['all_projects'] = $this->Project_model->get_all_projects();

                $data['_view'] = 'rel_project_user/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The rel_project_user you are trying to edit does not exist.');
    } 

    /*
     * Deleting rel_project_user
     */
    function remove($id)
    {
        $rel_project_user = $this->Rel_project_user_model->get_rel_project_user($id);

        // check if the rel_project_user exists before trying to delete it
        if(isset($rel_project_user['id']))
        {
            $this->Rel_project_user_model->delete_rel_project_user($id);
            redirect('rel_project_user/index');
        }
        else
            show_error('The rel_project_user you are trying to delete does not exist.');
    }
    
}
