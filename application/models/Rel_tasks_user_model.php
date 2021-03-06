<?php
/* 
 * Developed by David Jonatán Tirado Reyes
 * https://tasks.cencade.mx
 */
 
class Rel_tasks_user_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get rel_tasks_user by id
     */
    function get_rel_tasks_user($id)
    {
        return $this->db->get_where('rel_tasks_users',array('id'=>$id))->row_array();
    }
        
    /*
     * Get all rel_tasks_users
     */
    function get_all_rel_tasks_users()
    {
        $this->db->order_by('id', 'desc');
        return $this->db->get('rel_tasks_users')->result_array();
    }
        
    /*
     * function to add new rel_tasks_user
     */
    function add_rel_tasks_user($params)
    {
        $this->db->insert('rel_tasks_users',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update rel_tasks_user
     */
    function update_rel_tasks_user($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('rel_tasks_users',$params);
    }
    
    /*
     * function to delete rel_tasks_user
     */
    function delete_rel_tasks_user($id)
    {
        return $this->db->delete('rel_tasks_users',array('id'=>$id));
    }

    /*
     * Get rel_tasks_user by task_id
     */
    function get_task_user($task_id)
    {
        $this->db->join('users', 'users.id_user = rel_tasks_users.user_id');
        return $this->db->get_where('rel_tasks_users',array('task_id'=>$task_id))->row_array();
    }

    /*
     * function to update rel_tasks_user
     */
    function update_rel_task_user_by_user_task($id_task, $params)
    {
        $this->db->where('task_id', $id_task);
        return $this->db->update('rel_tasks_users',$params);
    }

    /*
     * function to delete rel_tasks_user
     */
    function delete_by_task($task_id)
    {
        return $this->db->delete('rel_tasks_users',array('task_id'=>$task_id));
    }
}
