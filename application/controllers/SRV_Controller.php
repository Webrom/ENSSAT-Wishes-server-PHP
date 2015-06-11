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
        parent::__construct();
    }

    public function getPourcentage($userName){
        /* CALCUL POURCENTAGE HEURES PRISES */
        $heuresprises = $this->contenu->getHeuresPrises($userName);
        $heurestotales = $this->users->getStatutaire($userName) - $this->decharge->getHoursDecharge($userName);
        $pourcentage = round(($heuresprises / $heurestotales) * 100, 0);
        $data['pourcentage'] = $pourcentage;
        $data['heuresprises'] = $heuresprises;
        $data['heurestotales'] = $heurestotales;
        /* FIN CALCUL */
        return $data;
    }
}