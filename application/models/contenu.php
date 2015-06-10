<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 27/05/15
 * Time: 17:14
 */

class Contenu extends CI_Model{

    /**
     * Permet d'obtenir tous les contenus pour un enseignant donné
     * @param $username Il s'agit du login de l'enseignant
     * @return null si l'enseignant n'a aucun contenu d'assigner, sinon retourne le résultat de la requête sous format tableau
     */
    public function getAllMyContenus($username){
        $this->db->select("*");
        $this->db->from("contenu");
        $this->db->join('module','module.ident=contenu.module');
        $this->db->where("enseignant",$username);
        $query = $this->db->get();

        if(!$query) {
            return null;
        }
        else {
            return $query->result_array();
        }
    }

    /**
     * Cette fonction permet d'obtenir tous les types de contenu
     * @return un tableau avec tous les types des contenus
     */
    public function getAllModuleTypes(){
        $this->db->select("type");
        $this->db->distinct();
        $this->db->from("contenu");
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Permet d'obtenir les différentes parties des contenus pour un module donné
     * @param $data String, nom du module
     * @return Tableau contenant les différentes parties (vide si il n'y a pas de contenu pour un module)
     */
    public function getTypeContenu($data){
        $this->db->select('partie');
        $this->db->from('contenu');
        $this->db->where('module',$data);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Permet d'obtenir tous les contenus pour un module donné
     * @param $data String, nom du module
     * @return tableau contenant tout les contenus pour un module donné
     */
    public function getModuleContenus($data){
        $this->db->select('*');
        $this->db->from("contenu");
        $this->db->where('module',$data);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Permet de recuperer le contenu d'un module grâce à son module et sa partie utilisée
     * @param $array tableau contenant un module et une partie
     * @return Les informations sur le contenu souhaitait
     */
    public function getModuleContenusByPartieModule($array){
        $this->db->select('*');
        $this->db->from("contenu");
        $this->db->where($array);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Modifier un contenu pour un module et une partie précise
     * @param $data les partie à modifier du contenu
     * @param $keys tableau avec un String pour le module et un String pour la partie
     * @return array|string "good" si la modification s'est passée comme prévu, le message et le numéro d'erreur dans le cas contraire
     */
    public function modifyModuleContenu($data,$keys){
        $where = 'module = "'.$keys['module'].'" AND partie = "'.$keys['partie'].'"';
        $query = $this->db->query($this->db->update_string('contenu',$data,$where));
        if(!$query){
            $ret= array(
                "ErrorMessage" => $this->db->_error_message(),
                "ErrorNumber" => $this->db->_error_message()
            );
        }else
            $ret = "good";
        return $ret;

    }

    //TODO : Je comprend pas bien, on récupére l'enseignant pour un contenu ou on lui passe en paramètre l'enseignant ?
    public function getModuleTeacher($array){
        $this->db->select('enseignant')
            ->from('contenu')
            ->where('module',$array['module'])
            ->where('partie',$array['partie'])
            ->where('enseignant',$array['teacher']);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Supprimer un contenu pour partie donnée
     * @param $array
     */
    public function deleteContenuModule($array){
        foreach($array['partie'] as $partie){
            $this->db->where('partie',$partie);
            $this->db->delete('contenu');
        }
    }


    public function getContenuByModule($array){
        $this->db->select('module,partie,type,hed,nom,prenom,contenu.enseignant,module.public');
        $this->db->from('contenu');
        $this->db->join('module','module.ident=contenu.module');
        $this->db->join('enseignant','contenu.enseignant = enseignant.login','left');
        if($array['module'])
            $this->db->where('module',$array['module']);
        if($array['semester']!='noSemester')
            $this->db->where('semestre',$array['semester']);
        if($array['teacher']!='no')
            $this->db->where('enseignant',$array['teacher']);
        $this->db->order_by('enseignant', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getContenuByPromo($array){
        $this->db->select('module,partie,type,hed,nom,prenom,contenu.enseignant,module.public');
        $this->db->from('contenu');
        $this->db->join('module','module.ident=contenu.module');
        $this->db->join('enseignant','contenu.enseignant = enseignant.login','left');
        if($array['promotion']!='noProm')
            $this->db->where('public',$array['promotion']);
        if($array['semester']!='noSemester')
            $this->db->where('semestre',$array['semester']);
        if($array['teacher']!='no')
            $this->db->where('enseignant',$array['teacher']);
        $this->db->order_by('enseignant', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * @param $teacher
     * @return int nombre d'heure qu'un professeur a
     */
    public function getHeuresPrises($teacher){
        $this->db->SELECT ("hed");
        $this->db->from ("contenu");
        $this->db->where("enseignant",$teacher);
        $query =  $this->db->get();
        $heures = 0;
        if ($query->num_rows>0) {
            $result = $query->result_array();
            foreach ($result as $heure) {
                $heures = $heures + $heure['hed'];
            }
        }
        return $heures;
    }

    /**
     * @param $module
     * @param $partie
     * @return mixed
     */
    public function getHeurePourUnContenu($module,$partie){
        $this->db->select('hed');
        $this->db->from('contenu');
        $this->db->where('module',$module);
        $this->db->where('partie',$partie);
        $query = $this->db->get();
        return $query->row()->hed;
    }

    public function addEnseignanttoContenu($module,$partie,$data){
        //$this->db->set('enseignant',$this->session->userdata('username'));
        $this->db->where('module',$module);
        $this->db->where('partie',$partie);
        $query = $this->db->update('contenu',$data);
        return $query;
    }

    public function removeALotEnseignanttoContenu($tableau_enseignants){
        foreach($tableau_enseignants as $enseignants) {
            $data = array(
                'enseignant' => null
            );
            $this->db->where('enseignant', $enseignants);
            $this->db->update('contenu',$data);
        }
    }

    /**
     * Permet de savoir un contenu existe
     * @param $module
     * @param $partie
     * @return bool vrai si le module existe, faux sinon
     */
    public function ifContenuExist($module,$partie){
        $this->db->select('*');
        $this->db->from('contenu');
        $this->db->where('module',$module);
        $this->db->where('partie',$partie);
        $query = $this->db->get();
        if ($query->num_rows<1){
            return false;
        }
        else{
            return true;
        }
    }

    /**
     * Permet de savoir si un contenu a déjà un prof d'attribué
     * @param $module
     * @param $partie
     * @return bool
     */
    public function ifThereIsTeacher($module,$partie){
        $this->db->select('enseignant');
        $this->db->from('contenu');
        $this->db->where('module',$module);
        $this->db->where('partie',$partie);
        $query = $this->db->get();
        if ($query->row()->enseignant==null){
            return false;
        }
        else{
            return true;
        }
    }

    public function desinscriptionModule($module,$partie,$username){
        $data = array(
            'enseignant' => null
        );
        //$this->db->set('enseignant',$this->session->userdata('username'));
        $this->db->where('module',$module);
        $this->db->where('partie',$partie);
        $this->db->where('enseignant',$username);
        $query = $this->db->update('contenu',$data);
        return $query;
    }
}