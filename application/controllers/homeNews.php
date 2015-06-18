<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 15:35
 */

include 'SRV_Controller.php';

class homeNews extends SRV_Controller
{
    const NB_NEWS_PER_PAGE = 10;

    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('is_logged_in')) {
            redirect('login');
        } else {
            //charger les différents modèles
            $this->load->model('users');
            $this->load->model('contenu');
            $this->load->model('decharge');
            $this->load->model('news');
            $this->load->library('pagination');
        }
    }

    /**
     * Affichage des news (10 par pages) en fonction du filtre de l'url
     * @param string $filtre
     * @param int $start
     */
    public function index($filtre="tous",$start = 1)
    {
        if (isset($this->session->userdata['success'])){
            $success = $this->session->userdata['success'];
        }
        else{
            $success = null;
        }
        if (isset($this->session->userdata['msg'])){
            $msg = $this->session->userdata['msg'];
        }
        else{
            $msg = null;
        }
        $this->session->unset_userdata('success');
        $this->session->unset_userdata('msg');
        $data = array(
            "admin" => $this->session->userdata['admin'],
            'nbTotalNews' => $this->news->getNewsCount($filtre),
            'success' => $success,
            'msg' => $msg
        );

        if ($start > 1) {
            if ($start <= $data['nbTotalNews'])
                $nb_news = intval($start);
            else
                $nb_news = 1;
        } else
            $nb_news = 1;

        $this->pagination->initialize(array(
            'base_url' => base_url() . 'index.php/homeNews/index/'.$filtre.'/',
            'uri_segment' => 4,
            'total_rows' => $data['nbTotalNews'],
            'per_page' => self::NB_NEWS_PER_PAGE,
            'display_pages' => TRUE,
            'full_tag_open' => '<ul class="pagination pagination-sm">',
            'full_tag_close' => '</ul>',
            'first_tag_open' => '<li class="disabled">',
            'first_tag_close' => '</li>',
            'last_tag_open' => '<li>',
            'last_tag_close' => '</li>',
            'next_tag_open' => '<li>',
            'next_tag_close' => '</li>',
            'prev_tag_open' => '<li>',
            'prev_tag_close' => '</li>',
            'cur_tag_open' => '<li class="active"><a href="#">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li>',
            'num_tag_close' => '</li>'
        ));

        $data['pagination'] = $this->pagination->create_links();
        $data['news'] = $this->news->getNews(self::NB_NEWS_PER_PAGE, $nb_news - 1,$filtre);


        $dataPercentage = $this->getPercentage($this->session->userdata('username'));
        $data['pourcentage'] = $dataPercentage['pourcentage'];
        $data['heuresprises'] = $dataPercentage['heuresprises'];
        $data['heurestotales'] = $dataPercentage['heurestotales'];
        $data['avatar'] = $this->users->getAvatar($this->session->userdata('username'));

        $this->load->view('header', $data);
        $this->load->view('back/template/header');
        $this->load->view('back/home/news', $data);
        $this->load->view('footer');


    }
}