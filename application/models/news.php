<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 30/05/15
 * Time: 02:23
 */

class News extends CI_Model{

    public function addNews ($login,$type,$information,$module = null,$partie= null){
        $this->db->set('DATE','NOW()',false);
        $this->db->set('TYPE',$type);
        $this->db->set('INFORMATION',$information);
        $this->db->set('ENSEIGNANT',$login);
        $this->db->set('module',$module);
        $this->db->set('partie',$partie);
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


    /**
     * Affiche les news sur la page d'accueil, on recupere une premiere fois les news ensuite grace
     * à la liste de type de news qu'on obtient on requete la bdd pour avoir des informations
     * supplémantaires.
     * @param $nb
     * @param int $start
     * @return array|bool|null
     */
    public function getNews($nb, $start = 0){
        if(!is_integer($nb) OR $nb < 1 OR !is_integer($start) OR $start < 0)
        {
            return false;
        };
        $data =array();
        $this->db->select('ID,TYPE,module,partie')
                ->from('news')
                ->order_by('id', 'desc')
                ->limit($nb, $start);
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
}