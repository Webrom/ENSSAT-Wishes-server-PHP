<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 30/05/15
 * Time: 02:23
 */

class News extends CI_Model{

    public function addNews ($login,$type,$information,$idExt = null){
        $this->db->set('DATE','NOW()',false);
        $this->db->set('TYPE',$type);
        $this->db->set('INFORMATION',$information);
        $this->db->set('ENSEIGNANT',$login);
        $this->db->set('idExt',$idExt);
        return $this->db->insert('news');
    }

    public function getGeneralesNews(){
        $this->db->select('ID,DATE,INFORMATION');
        $this->db->from('news');
        $this->db->where('TYPE','generale');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getInformation($date){
        $this->db->select('INFORMATION');
        $this->db->from('news');
        $this->db->where('ID',$date);
        $query = $this->db->get();
        return $query->row()->INFORMATION;
    }

    public function removeNews($date){
        $this->db->where('ID', $date);
        return $this->db->delete('news');
    }

    public function modifyNews($date,$information){
        $data = array(
            'INFORMATION'=>$information
        );
        $this->db->where('ID', $date);
        return $this->db->update('news',$data);
    }

    public function getNewsCount(){
        return $this->db->count_all('news');
    }

    public function getNews($nb, $start = 0){
        if(!is_integer($nb) OR $nb < 1 OR !is_integer($start) OR $start < 0)
        {
            return false;
        };
        $this->db->select('TYPE,idExt')
                ->distinct()
                ->from('news');
        $news = $this->db->get()->result_array();
        foreach($news as $new){
            switch($new['TYPE']){
                case 'generale':
                    $this->db->select('`avatar`,`nom`,`prenom`,`ID`,`TYPE`, `ENSEIGNANT`, `INFORMATION`, DATE_FORMAT(`DATE`,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'date\'', false)
                        ->from('news')
                        ->join('enseignant','news.ENSEIGNANT=enseignant.login')
                        ->order_by('id', 'desc')
                        ->where('TYPE','generale');
                    $newsGenerale = $this->db->get()->result_array();
                    break;
                case 'module':
                    $this->db->select('module.public,module.semestre,module.libelle,module.responsable,news.INFORMATION,enseignant.nom,enseignant.prenom`ID`,`TYPE`, `ENSEIGNANT`, `INFORMATION`, DATE_FORMAT(`DATE`,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'date\'', false)
                            ->from('news')
                            ->join('module','news.idExt=module.ident')
                            ->join('enseignant','news.ENSEIGNANT=enseignant.login')
                            ->where('news.TYPE','module');
                    $newsModule = $this->db->get()->result_array();
                    break;
                case 'contenu':
                   /* $contenu = explode(" ",$new['idExt']);
                    $selPartie = array(
                        "module" => $contenu[0],
                        "partie" => $contenu[1]
                    );
                    $this->db->select('module.public,module.semestre,module.libelle,module.responsable,news.INFORMATION,enseignant.nom,enseignant.prenom`ID`,`TYPE`, `ENSEIGNANT`, `INFORMATION`, DATE_FORMAT(`DATE`,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'date\'', false)
                        ->from('news')
                        ->join('module','news.idExt=module.ident')
                        ->join('enseignant','news.ENSEIGNANT=enseignant.login')
                        ->where('news.TYPE','module');
                    $newsContenu = $this->db->get()->result_array();*/
                    break;
                case 'user':
                    break;
                case 'generale':
                    break;
                default:
                    break;
            }
        }
        //var_dump($newsModule);
        /*return $this->db->select('`avatar`,`nom`,`prenom`,`ID`,`TYPE`, `ENSEIGNANT`, `INFORMATION`, DATE_FORMAT(`DATE`,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'date\'', false)
            ->from('news')
            ->join('enseignant','news.ENSEIGNANT=enseignant.login')
            ->order_by('id', 'desc')
            ->limit($nb, $start)
            ->get()
            ->result_array();
*/
    }
}