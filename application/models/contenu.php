<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Toutes les décharges de la table Contenu se font ici
 */

class Contenu extends CI_Model{

    /**
     * Permet d'obtenir tous les contenus pour un enseignant donné
     * @param $username Il s'agit du login de l'enseignant
     * @return null si l'enseignant n'a aucun contenu d'assigner, sinon retourne le résultat de la requête sous format tableau
     */
    public function getAllMyContenus($username){
        $this->db->select("module,partie,type,hed,semestre,public,nom,prenom,enseignant,responsable");
        $this->db->from("contenu");
        $this->db->join('module','module.ident=contenu.module');
        $this->db->join('enseignant','contenu.enseignant = enseignant.login','left');
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

    /**
     * Permet de savoir si l'enseignant était déja dans le module
     * @param $array
     * @return un tableau vide si le prof n'était déjà pas assigné au contenu, sinon renvoi le résultat
     */
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
     * Supprimer un ou plusieurs contenu(s) pour partie donnée
     * @param $array String de la partie à supprimer
     */
    public function deleteContenuModule($array){
        $module = $array['module'];
        foreach($array['partie'] as $partie){
            $this->db->where('partie',$partie);
            $this->db->where('module',$module);
            $this->db->delete('contenu');
        }
    }


    /**
     * Cette fonction peut avoir plusieurs utilisations, elle permet de retrouver tous les contenus
     * Paramètres optionnels :
     * Pour un module en particulier
     * Pour un semestre en particulier
     * Pour un enseignant en particulier
     * La jointure sert à récupérer le nom et le prénom des professeurs, plutot que d'afficher leur login
     * @param $array
     * @return mixed un tableau avec les différents résultats
     */
    public function getContenus($array){
        $this->db->select('module,partie,type,hed,module.semestre,module.public,nom,prenom,contenu.enseignant,responsable');
        $this->db->from('contenu');
        $this->db->join('module','module.ident=contenu.module');
        $this->db->join('enseignant','contenu.enseignant = enseignant.login','left');
        if($array['module'])
            $this->db->where('module',$array['module']);
        if($array['promotion']!='noProm')
            $this->db->where('public',$array['promotion']);
        if($array['semester']!='noSemester')
            $this->db->where('semestre',$array['semester']);
        if($array['teacher']!='no')
            $this->db->where('enseignant',$array['teacher']);
        $this->db->order_by('module', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Permet d'obtenir le nombre d'heures de cours déjà affectées à un professeur
     * @param $teacher String, le login de l'enseignant
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
     * Permet d'obtenir le nombre d'heure d'un contenu pour un module et une partie donnés
     * @param $module String, nom du module
     * @param $partie String, nom de la partie
     * @return Le nombre d'heure pour ce contenu
     */
    public function getHeurePourUnContenu($module,$partie){
        $this->db->select('hed');
        $this->db->from('contenu');
        $this->db->where('module',$module);
        $this->db->where('partie',$partie);
        $query = $this->db->get();
        return $query->row()->hed;
    }


    /**
     * Permet d'affecter un enseignant à un contenu
     * @param $module string, nom du module
     * @param $partie String, nom de la partie
     * @param $data, le login de l'enseignant à ajouter
     * @return boolean, vrai si la requête s'est bien passée, faux sinon
     */
    public function addEnseignanttoContenu($module,$partie,$data){
        $this->db->where('module',$module);
        $this->db->where('partie',$partie);
        $query = $this->db->update('contenu',$data);
        return $query;
    }

    /**
     * Utiliser lors de la supression d'un utilisateur, permet de supprimer le professeur de chaque contenu auquels il était effecté
     * @param $tableau_enseignants tableau de String, login des enseignants
     */
    public function removeTeacherforEachContenu($tableau_enseignants){
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

    /**
     * Permet de supprimer un enseignant d'un contenu
     * @param $module String, module du contenu
     * @param $partie String, nom de la partie
     * @param $username String, login de l'enseignant à supprimer
     * @return booelan, true si la desinscription à fonctionner, false sinon
     */
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

    /**
     * Ajoute une partie à un module, retourne ggod si l'insert réussi ou une errur
     * @param $contenu
     * @return array|string
     */
    public function addContenuToModule($contenu){
        $query = $this->db->insert('contenu',$contenu);
        if(!$query){
            $ret= array(
                "ErrorMessage" => $this->db->_error_message(),
                "ErrorNumber" => $this->db->_error_message()
            );
        }
        return ($query)?"good":$ret;
    }
}