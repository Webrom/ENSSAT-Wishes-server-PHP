<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 15:35
 */
class homeNews extends CI_Controller
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

    public function index($start = 1)
    {
        $data = array(
            "admin" => $this->session->userdata['admin'],
            'nbTotalNews' => $this->news->getNewsCount(),
        );

        if ($start > 1) {
            if ($start <= $data['nbTotalNews'])
                $nb_news = intval($start);
            else
                $nb_news = 1;
        } else
            $nb_news = 1;

        $this->pagination->initialize(array(
            'base_url' => base_url() . 'index.php/homeNews/index/',
            'total_rows' => $data['nbTotalNews'],
            'per_page' => self::NB_NEWS_PER_PAGE
        ));

        $data['pagination'] = $this->pagination->create_links();
        $data['news'] = $this->news->getNews(self::NB_NEWS_PER_PAGE, $nb_news - 1);
        //TODO fonction en doublon... faire une fonction dédiée  c'est ce que j'ai mis sur un commit?
        /* CALCUL POURCENTAGE HEURES PRISES */
        $heuresprises = $this->contenu->getHeuresPrises($this->session->userdata('username'));
        $heurestotales = $this->users->getStatutaire($this->session->userdata('username')) - $this->decharge->getHoursDecharge($this->session->userdata('username'));
        $pourcentage = round(($heuresprises / $heurestotales) * 100, 0);
        $data['pourcentage'] = $pourcentage;
        $data['heuresprises'] = $heuresprises;
        $data['heurestotales'] = $heurestotales;
        /* FIN CALCUL */

        $this->load->view('header', $data);
        $this->load->view('back/template/header');
        $this->load->view('back/home/news', $data);
        $this->load->view('footer');
    }
}