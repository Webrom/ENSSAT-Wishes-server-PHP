<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 15:35
 */

class homeNews extends CI_Controller {
    public function index(){
        echo "azeaze";
        $this->load->view('back/template/header');
        $this->load->view('back/template/footer');
    }
}