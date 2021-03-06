<?php
/* 
 * Developed by David Jonatán Tirado Reyes
 * https://tasks.cencade.mx
 */
 
class Task_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get task by id_task
     */
    function get_task($id_task)
    {
        return $this->db->get_where('tasks',array('id_task'=>$id_task))->row_array();
    }
        
    /*
     * Get all tasks
     */
    function get_all_tasks()
    {
        $this->db->order_by('id_task', 'desc');
        return $this->db->get('tasks')->result_array();
    }
        
    /*
     * function to add new task
     */
    function add_task($params)
    {
        $this->db->insert('tasks',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update task
     */
    function update_task($id_task,$params)
    {
        $this->db->where('id_task',$id_task);
        return $this->db->update('tasks',$params);
    }
    
    /*
     * function to delete task
     */
    function delete_task($id_task)
    {
        $this->load->model('Evidence_model');
        $this->load->model('Development_model');
        $this->load->model('Rel_tasks_user_model');
        $this->load->model('Rel_tasks_project_model');
        $this->Evidence_model->delete_evidence_by_task($id_task);
        $this->Development_model->delete_development_by_task($id_task);
        $this->Rel_tasks_user_model->delete_by_task($id_task);
        $this->Rel_tasks_project_model->delete_by_task($id_task);
        return $this->db->delete('tasks',array('id_task'=>$id_task));
    }


    function delete_tasks_project($project_id)
    {
        $this->db->delete('tasks',array('id_task'=>$id_task));
        $this->db->delete('tasks',array('id_task'=>$id_task));
        return $this->db->delete('tasks',array('id_task'=>$id_task));
    }

    public function get_tasks_project($project_id)
    {
        $this->db->select('name, date_view, date_process, date_delivered');
        $this->db->join('tasks t', 't.id_task = tp.task_id');
        $this->db->where('tp.project_id', $project_id);
        return $this->db->get('rel_tasks_project tp');
    }

    public function get_all_tasks_project($project_id)
    {
        $this->db->join('tasks t', 't.id_task = tp.task_id');
        $this->db->where('tp.project_id', $project_id);
        return $this->db->get('rel_tasks_project tp');
    }


    function task_user($id, $type)
    {
        $this->db->select("CONCAT_WS(' ', name, lastname) AS fullname");
        if ($type == 'task') {
            $this->db->join('rel_tasks_users tu', 'tu.user_id = u.id_user');
            $this->db->where('tu.task_id', $id);
        }else{
            $this->db->join('rel_project_user pu', 'pu.user_id = u.id_user');
            $this->db->where('pu.project_id', $id);
        }
        
        return $this->db->get('users u')->row_array();
    }


    function tasks_by_user($user_id)
    {
        $this->db->join('rel_tasks_users tu', 'tu.task_id = t.id_task');
        $this->db->where('tu.user_id', $user_id);
        return $this->db->get('tasks t')->result_array();
    }


    /*
     * function to update tasks by users
     */
    function update_task_color_user($user_id, $color)
    {
        return $this->db->query("UPDATE tasks t INNER JOIN rel_tasks_users tu ON tu.task_id = t.id_task SET t.color = '$color' WHERE tu.user_id = $user_id;");
    }

    function task_users_colors()
    {
        $this->db->distinct();
        $this->db->select("u.id_user, CONCAT_WS(' ',u.name,u.lastname) AS fullname, t.color");
        $this->db->join('rel_tasks_users tu', 'tu.task_id = t.id_task');
        $this->db->join('users u', 'tu.user_id = u.id_user');
        return $this->db->get('tasks t')->result_array();
    }
}
