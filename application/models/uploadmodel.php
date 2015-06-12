<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Permet l'upload des photos
 */
class uploadmodel extends CI_Model{

    /**
     * Permet l'upload de l'image et l'ajout de son url à la base
     * @param $upload_data, image à uploader
     * @param $userName String, login de l'enseignant
     */
    public function changeAvatar($upload_data,$userName){
        if(file_exists("./uploads/".$userName.".jpg"))
            unlink("./uploads/".$userName.".jpg");
        rename("./uploads/".$upload_data['file_name'], "./uploads/".$userName.".jpg");

        $this->cropImage("./uploads/".$userName.".jpg");

        $data = array(
            'avatar' => $userName . ".jpg"
        );

        $this->db->where('login', $userName);
        $this->db->update('enseignant', $data);
    }

    /**
     * Permet de supprimer un avatar
     * @param $userName String, login de l'enseignant
     */
    public function delAvatar($userName){
        if(file_exists("./uploads/".$userName.".jpg"))
            unlink("./uploads/".$userName.".jpg");
        $data = array(
            'avatar' => "avatar_defaut.jpg"
        );

            $this->db->where('login', $userName);
            $this->db->update('enseignant', $data);
    }

    /**
     * Permet de supprimer les avatars d'utilisateurs que l'on supprime
     * @param $userName
     */
    public function delAvatarUsers($userName){
        foreach ($userName as $login) {
            if (file_exists("./uploads/" . $login . ".jpg"))
                unlink("./uploads/" . $login . ".jpg");
        }

    }

    /**
     * fonction pour couper l'image / la redimentionner à l'upload
     * @param $filename
     */
    public function cropImage($filename){
        // Create a blank image and add some text
        $ini_filename = $filename;
        $im = imagecreatefromjpeg($ini_filename);

        $ini_x_size = getimagesize($ini_filename)[0];
        $ini_y_size = getimagesize($ini_filename)[1];

        //the minimum of xlength and ylength to crop.
        $crop_measure = min($ini_x_size, $ini_y_size);

        // Set the content type header - in this case image/jpeg
        //header('Content-Type: image/jpeg');

        $to_crop_array = array('x' =>0 , 'y' => 0, 'width' => $crop_measure, 'height'=> $crop_measure);
        $thumb_im = imagecrop($im, $to_crop_array);

        imagejpeg($thumb_im, $filename, 100);
    }
}
?>