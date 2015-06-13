<?php
/**
 * Toutes les requêtes pour la table news
 */

class News extends CI_Model{

    /**
     * Permet d'ajouter une news
     * @param $login String, login de l'enseignant à l'orgine de la news
     * @param $type String, si elle concerne les modules, les contenus, etc...
     * @param $information String, message de la news
     * @param null $module String, si module, le nom
     * @param null $partie String, si contenu, la partie
     * @return boolean, true si l'ajout s'est bien passé
     */
    public function addNews ($login,$type,$information,$module = null,$partie= null){
        $this->db->set('DATE','NOW()',false);
        $this->db->set('TYPE',$type);
        $this->db->set('INFORMATION',$information);
        $this->db->set('ENSEIGNANT',$login);
        $this->db->set('module',$module);
        $this->db->set('partie',$partie);
        return $this->db->insert('news');
    }

    /**
     * Permet de retourner toutes les news ajoutées par un administrateur qui sont des informations générales non générées automatiquement
     * @return tableau avec toutes les news "générales"
     */
    public function getGeneralesNews(){
        $this->db->select('ID,DATE,INFORMATION');
        $this->db->from('news');
        $this->db->where('TYPE','generale');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Permet d'obtenir le contenu de la news à partir de son ID
     * @param $id int, numéro de ref de la news
     * @return String, contenu de la news
     */
    public function getInformation($id){
        $this->db->select('INFORMATION');
        $this->db->from('news');
        $this->db->where('ID',$id);
        $query = $this->db->get();
        return $query->row()->INFORMATION;
    }

    /**
     * Permet de supprimer une news avec son id
     * @param $id int, numéro de ref de la news
     * @return true si la supression a fonctionnée, false sinon
     */
    public function removeNews($id){
        $this->db->where('ID', $id);
        return $this->db->delete('news');
    }

    /**
     * Permet de modifier le contenu d'une news
     * @param $id int, numéro de ref de la news
     * @param $information String, contenu de la news
     * @return true si la modif est ok, false sinon
     */
    public function modifyNews($id,$information){
        $data = array(
            'INFORMATION'=>$information
        );
        $this->db->where('ID', $id);
        return $this->db->update('news',$data);
    }

    /**
     * Permet de connaitre le nombre de news dans la base
     * @return int, nombre de news
     */
    public function getNewsCount($filtre){
        $this->db->from('news');
        switch ($filtre){
            case 'generale':
                $this->db->where('TYPE',$filtre);
                break;
            case 'module':
                $this->db->where('TYPE',$filtre);
                $this->db->or_where('TYPE','delete-module');
                break;
            case 'contenu':
                $this->db->where('TYPE',$filtre);
                $this->db->or_where('TYPE','delete-contenu');
                break;
            case 'user':
                $this->db->where('TYPE',$filtre);
                break;
            default:
                break;
        }
        return $this->db->count_all_results();
    }


    /**
     * Affiche les news sur la page d'accueil, on recupere une premiere fois les news ensuite grace
     * à la liste de type de news qu'on obtient on requete la bdd pour avoir des informations
     * supplémantaires.
     * @param $nb
     * @param int $start
     * @return array|bool|null
     */
    public function getNews($nb, $start = 0,$filtre){
        if(!is_integer($nb) OR $nb < 1 OR !is_integer($start) OR $start < 0)
        {
            return false;
        };
        $data =array();
        $this->db->select('ID,TYPE,module,partie')
                ->from('news')
                ->order_by('id', 'desc')
                ->limit($nb, $start);
        switch ($filtre){
            case 'generale':
                $this->db->where('TYPE',$filtre);
                break;
            case 'module':
                $this->db->where('TYPE',$filtre);
                $this->db->or_where('TYPE','delete-module');
                break;
            case 'contenu':
                $this->db->where('TYPE',$filtre);
                $this->db->or_where('TYPE','delete-contenu');
                break;
            case 'user':
                $this->db->where('TYPE',$filtre);
                break;
            default:
                break;
        }
        $news = $this->db->get()->result_array();
        foreach($news as $new){
            switch($new['TYPE']){
                case 'generale':
                    array_push($data,$this->getNormalNews($new['ID']));
                    break;
                case 'module':
                    if($new['module']!=null){
                        $this->db->select('*')
                            ->from('module')
                            ->where('ident',$new['module']);
                        $module = $this->db->get();
                        if($module->num_rows!=0) {
                            $this->db->select('
                                        news.TYPE AS classe,
                                        module.public,
                                        module.ident,
                                        module.semestre,
                                        module.libelle,
                                        module.responsable,
                                        news.INFORMATION,
                                        enseignant.nom,
                                        enseignant.prenom,
                                        enseignant.avatar,
                                        news.ID,
                                        news.ENSEIGNANT,
                                        news.INFORMATION,
                                        DATE_FORMAT(news.DATE,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'date\'', false)
                                ->from('news')
                                ->join('module', 'news.module=module.ident')
                                ->join('enseignant', 'news.ENSEIGNANT=enseignant.login')
                                ->where('news.ID', $new['ID']);
                            array_push($data,$this->db->get()->result_array());
                        }
                        else
                            array_push($data,$this->getNormalNews($new['ID']));

                    }
                    break;
                case 'contenu':
                    if($new['module']!=null && $new['partie']!=null) {
                        $this->db->select('*')
                            ->from('module')
                            ->where('ident', $new['module']);
                        $module = $this->db->get();
                        $this->db->select('*')
                            ->from('contenu')
                            ->where('partie', $new['partie'])
                            ->where('module', $new['module']);
                        $partie = $this->db->get();
                        if ($module->num_rows != 0 && $partie->num_rows != 0){
                            $this->db->select('
                                        news.TYPE AS classe,
                                        contenu.module,
                                        module.libelle,
                                        module.semestre,
                                        module.public,
                                        contenu.type,
                                        contenu.partie,
                                        contenu.hed,
                                        contenu.enseignant,
                                        enseignant.nom,
                                        enseignant.prenom,
                                        enseignant.avatar,
                                        news.ID,
                                        news.INFORMATION,
                                        DATE_FORMAT(news.DATE,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'date\'', FALSE)
                                ->from('news')
                                ->join('module', 'news.module=module.ident')
                                ->join('contenu', 'news.module=contenu.module and news.partie=contenu.partie')
                                ->join('enseignant', 'news.ENSEIGNANT=enseignant.login')
                                ->where('news.ID', $new['ID']);
                            array_push($data,$this->db->get()->result_array());
                        }
                        else
                            array_push($data,$this->getNormalNews($new['ID']));

                    }
                    break;
                case 'user':
                    if($new['module']!=null && $new['partie']!=null) {
                        $this->db->select('*')
                            ->from('module')
                            ->where('ident', $new['module']);
                        $module = $this->db->get();
                        $this->db->select('*')
                            ->from('contenu')
                            ->where('partie', $new['partie'])
                            ->where('module', $new['module']);
                        $partie = $this->db->get();
                        if ($module->num_rows != 0 && $partie->num_rows != 0){
                            $this->db->select('
                                        news.TYPE AS classe,
                                        contenu.module,
                                        module.libelle,
                                        module.semestre,
                                        module.public,
                                        contenu.type,
                                        contenu.partie,
                                        contenu.hed,
                                        contenu.enseignant,
                                        enseignant.nom,
                                        enseignant.prenom,
                                        enseignant.avatar,
                                        news.ID,
                                        news.INFORMATION,
                                        DATE_FORMAT(news.DATE,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'date\'', FALSE)
                                ->from('news')
                                ->join('module', 'news.module=module.ident')
                                ->join('contenu', 'news.module=contenu.module and news.partie=contenu.partie')
                                ->join('enseignant', 'news.ENSEIGNANT=enseignant.login')
                                ->where('news.ID',$new['ID']);
                            array_push($data,$this->db->get()->result_array());
                        }else{
                            array_push($data,$this->getNormalNews($new['ID']));
                        }
                    }else{
                        $this->db->select('
                                        news.TYPE AS classeUser,
                                        enseignant.nom,
                                        enseignant.prenom,
                                        enseignant.avatar,
                                        news.ID,
                                        news.INFORMATION,
                                        DATE_FORMAT(news.DATE,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'date\'', FALSE)
                            ->from('news')
                            ->join('enseignant', 'news.ENSEIGNANT=enseignant.login')
                            ->where('news.module', null)
                            ->where('news.partie', null)
                            ->where('news.ID',$new['ID']);
                        array_push($data,$this->db->get()->result_array());
                    }
                    break;
                default :
                    array_push($data,$this->getNormalNews($new['ID']));
                    break;
            }
        }
        return $data;
    }

    /**
     * Permet d'obtenir  une news avec son id, le join sert à obtenir le nom et prenom plutot que le login
     * @param $id int, numéro de ref de la news
     * @return La news
     */
    public function getNormalNews($id){
        $this->db->select('
                                        news.TYPE AS classe,
                                        enseignant.nom,
                                        enseignant.prenom,
                                        enseignant.avatar,
                                        news.ID,
                                        news.INFORMATION,
                                        DATE_FORMAT(news.DATE,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'date\'', FALSE)
            ->from('news')
            ->join('enseignant', 'news.ENSEIGNANT=enseignant.login')
            ->where('news.ID',$id);
        $data = $this->db->get()->result_array();
        return $data;
    }

    /**
     * Permet de supprimer toutes les news pour un/plusieurs utilisateur(s)
     * @param $tableau_enseignants
     */
    public function deleteNewsForUsers($tableau_enseignants){
        foreach($tableau_enseignants as $enseignants){
            $this->db->where('ENSEIGNANT', $enseignants);
            $this->db->delete('news');
        }
    }
}