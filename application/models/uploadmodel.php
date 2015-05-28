<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: colinleverger
 * Date: 28/05/15
 * Time: 10:47
 */
class uploadmodel extends CI_Model{
    //ALTER TABLE enseignant ADD path_avatar VARCHAR(255)
    public function changeAvatar($upload_data){
        $data = array(
            'path_avatar' => $upload_data[],
        );
        $this->db->where('login', $userName);
        $this->db->update('enseignant', $data);
    }
}
?>