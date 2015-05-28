<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: colinleverger
 * Date: 28/05/15
 * Time: 10:47
 */
class uploadmodel extends CI_Model{
    //ALTER TABLE enseignant ADD avatar VARCHAR(30) DEFAULT 'avatar_defaut.jpg'
    public function changeAvatar($upload_data,$userName){
        if(file_exists("/uploads/".$userName))
            unlink("/uploads/".$userName);
        rename("./uploads/".$upload_data['file_name'], "./uploads/".$userName.".jpg");

        $data = array(
            'avatar' => $userName . ".jpg"
        );

        $this->db->where('login', $userName);
        $this->db->update('enseignant', $data);
    }
}
?>