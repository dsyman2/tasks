<?php
/* 
 * Developed by David Jonatán Tirado Reyes
 * https://tasks.cencade.mx
 */
 
class User_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get user by id_user
     */
    function get_user($id_user)
    {
        return $this->db->get_where('users',array('id_user'=>$id_user))->row_array();
    }
        
    /*
     * Get all users
     */
    function get_all_users()
    {
        $this->db->order_by('id_user', 'desc');
        return $this->db->get('users')->result_array();
    }
        
    /*
     * function to add new user
     */
    function add_user($params)
    {
        $this->db->insert('users',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update user
     */
    function update_user($id_user,$params)
    {
        $this->db->where('id_user',$id_user);
        return $this->db->update('users',$params);
    }
    
    /*
     * function to delete user
     */
    function delete_user($id_user)
    {
        return $this->db->delete('users',array('id_user'=>$id_user));
    }


    function is_password($id_user, $password)
    {
        return $this->db->get_where('users',array('id_user'=>$id_user, 'password' => md5($password)))->num_rows();
    }
}
