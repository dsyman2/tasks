<?php
/* 
 * Developed by David Jonatán Tirado Reyes
 * https://tasks.cencade.mx
 */
 
class Profile_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get profile by id_profile
     */
    function get_profile($id_profile)
    {
        return $this->db->get_where('profiles',array('id_profile'=>$id_profile))->row_array();
    }
        
    /*
     * Get all profiles
     */
    function get_all_profiles()
    {
        $this->db->order_by('id_profile', 'desc');
        return $this->db->get('profiles')->result_array();
    }
        
    /*
     * function to add new profile
     */
    function add_profile($params)
    {
        $this->db->insert('profiles',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update profile
     */
    function update_profile($id_profile,$params)
    {
        $this->db->where('id_profile',$id_profile);
        return $this->db->update('profiles',$params);
    }
    
    /*
     * function to delete profile
     */
    function delete_profile($id_profile)
    {
        return $this->db->delete('profiles',array('id_profile'=>$id_profile));
    }
}
