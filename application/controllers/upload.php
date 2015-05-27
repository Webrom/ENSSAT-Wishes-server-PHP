<?php

class Upload extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load-> model('users');
    }

    function index()
    {
        $this->load->view('upload_form', array('error' => ' ' ));
    }

    function do_upload()
    {
        $userInfo = $this->users->getUserData();
        $config['upload_path'] = getcwd() . '/uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']	= '10000000000';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload())
        {
            $msg = array(
                'error' => $this->upload->display_errors(),
                'userInfos' => $userInfo
            );
        }
        else
        {
            $msg = array(
                'error' => "Image uploadée, bravo",
                'userInfos' => $userInfo
            );
            $data = array('upload_data' => $this->upload->data());
        }
        redirect('profile',$msg);
    }
}
?>