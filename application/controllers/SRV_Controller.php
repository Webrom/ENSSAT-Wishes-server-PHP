<?php
/**
 * Created by PhpStorm.
 * User: colinleverger
 * Date: 11/06/15
 * Time: 11:23
 */

class SRV_Controller extends CI_Controller{

    public function __construct()
    {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('login');
        }else {
            parent::__construct();
        }
    }

    public function getPourcentage(){

    }
}