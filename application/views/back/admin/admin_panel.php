<?php
/**
 * Created by PhpStorm.
 * User: colinleverger
 * Date: 26/05/15
 * Time: 15:48
 */

?>
<div class="bp-docs-section">
    <div class="row">
        <p id="affiche" class="customHide"><?php echo(($activeOnglet!="")?$activeOnglet:"#addModulde");?></p>
    </div>
    <div class="row">
        <div class="col-md-2 col-no-border">
            <div class="bp-component">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    Module
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="#deleteModule #addModulde #modifyModule panel-collapse collapse in">
                            <div class="panel-body">
                                <ul class="nav nav-tabs nav-pills nav-stacked" style="max-width: 300px;">
                                    <li class="active"><a href="#addModulde" class="adminChoice btn">Ajouter</a></li>
                                    <li><a href="#modifyModule" class="adminChoice">Modifier</a></li>
                                    <li><a href="#deleteModule" class="adminChoice">Supprimer</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                    Contenu
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="#addContenu #deleteContenu #modifyContenu panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav nav-tabs nav-pills nav-stacked" style="max-width: 300px;">
                                    <li><a class="adminChoice" href="#addContenu">Ajouter</a></li>
                                    <li><a class="adminChoice" href="#deleteContenu">Supprimer</a></li>
                                    <li><a class="adminChoice" href="#modifyContenu">Modifier</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                    Utilisateurs
                                </a>
                            </h4>
                        </div>
                        <div  id="collapseThree" class="#modifyUsers #deleteUsers #addUser #acceptUsers #reinitUsers panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav nav-tabs nav-pills nav-stacked" style="max-width: 300px;">
                                    <li><a class="adminChoice" href="#acceptUsers">En attente</a></li>
                                    <li><a class="adminChoice" href="#addUser">Ajouter</a></li>
                                    <li><a class="adminChoice" href="#deleteUsers">Supprimer</a></li>
                                    <li><a class="adminChoice" href="#modifyUsers">Modifier</a></li>
                                    <li><a class="adminChoice" href="#reinitUsers">Réinitialiser mdp</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                                    News
                                </a>
                            </h4>
                        </div>
                        <div id="collapseFour" class="#modifyNews #deleteNews #addNews panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav nav-tabs nav-pills nav-stacked" style="max-width: 300px;">
                                    <li><a class="adminChoice" href="#addNews">Ajouter</a></li>
                                    <li><a class="adminChoice" href="#deleteNews">Supprimer</a></li>
                                    <li><a class="adminChoice" href="#modifyNews">Modifier</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="admin">RESET PAGE</a>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <?php if($msg!=null):?>
                <div class="alert alert-dismissable <?php echo $success?>">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <?php echo $msg ?>
                </div>
            <?php endif;?>
            <div id="addModulde" class="row admin-custom-box classeUnique">
                <div class="col-md-12 col-no-border">
                    <?php echo form_open('admin/addModule','class="form-horizontal"')?>
                    <fieldset>
                        <legend>Ajouter un module</legend>
                        <div class="form-group">
                            <div class="col-md-12 col-no-border">
                                <label for="inputIdent" class="2 col-no-border control-label">Identifiant du module</label>
                                <?php echo form_input('inputIdent','','class="form-control stuffToReinit" id="inputIdent" placeholder="ex : ALGOC1" required')?>
                            </div>
                            <div class="col-md-12 col-no-border">
                                <label for="inputLibelle" class="2 col-no-border control-label">Description du module</label>
                                <?php echo form_input('inputLibelle','','class="form-control stuffToReinit" id="inputLibelle" placeholder="ex : Algorithmique et language C 1" required')?>
                            </div>
                            <div class="col-md-12 col-no-border">
                                <label for="selectResponsable" class="control-label">Responsable</label>
                                <select name="selectResponsable" class="form-control stuffToReinit chosen-select" id="selectResponsable">
                                    <option value="">...</option>
                                    <?php foreach($enseignants as $enseignant):?>
                                        <option value="<?php echo $enseignant['login'];?>"><?php echo $enseignant['nom']. " ".$enseignant['prenom'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-md-12 col-no-border">
                                <label for="selectSemestre" class="control-label">Semestre</label>
                                <select name="selectSemestre" class="form-control stuffToReinit chosen-select" id="selectSemestre">
                                    <?php foreach($semestres as $semestre):?>
                                        <option value="<?php echo $semestre;?>"><?php echo $semestre;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-md-12 col-no-border">
                                <label for="selectPublic" class="control-label">Promotion</label>
                                <select name="selectPublic" class="form-control stuffToReinit chosen-select" id="selectPublic">
                                    <?php foreach($publics as $public):?>
                                        <option value="<?php echo $public;?>"><?php echo $public;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-no-border text-right">
                                    <?php echo form_submit('submit','Valider','class="btn btn-success"')?>
                            </div>
                        </div>
                    </fieldset>
                    <?php echo form_close()?>
                </div>
            </div>
            <div id="deleteModule" class="row admin-custom-box">
                <div class="col-md-12 col-no-border">
                    <?php echo form_open("admin/deleteModule",'class="form-horizontal"')?>
                    <fieldset>
                        <legend>Supprimer un module</legend>
                        <div class="form-group">
                            <div class="col-md-12 col-no-border">
                                <label for="selectModule" class="control-label">Module</label>
                                <select name="module[]" class="form-control chosen-select" id="selectModule" multiple style="height: 380.5px" data-placeholder="Veuillez choisir">
                                    <?php foreach($modules as $module):?>
                                        <option value="<?php echo $module['ident'];?>"><?php echo $module['ident'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-no-border text-right">
                            <?php echo form_submit('submit','Supprimer','class="btn btn-danger"')?>
                        </div>
                    </fieldset>
                    <?php echo form_close()?>
                </div>
            </div>
            <div id="acceptUsers" class="row admin-custom-box">
                <div class="col-md-12 col-no-border">
                    <fieldset>
                        <legend>Utilisateur(s) en attente(s) d'acceptation</legend>
                        <div class="bp-component">
                            <?php foreach($enseignantsToAccept as $enseignantsToAccept):?>
                                <div class="col-md-12 col-no-border <?php echo $enseignantsToAccept['login'];?>">
                                    <div class="col-md-10 col-no-border">
                                        <?php echo $enseignantsToAccept['nom']." ".$enseignantsToAccept['prenom']." | Login : ".$enseignantsToAccept['login'];?>
                                    </div>
                                    <div class="col-md-1 col-no-border">
                                        <img src="<?php echo base_url();?>/assets/img/cross.png" class="refuse_user pointer" id="<?php echo $enseignantsToAccept['login'];?>"/>
                                    </div>
                                    <div class="col-md-1 col-no-border">
                                        <img src="<?php echo base_url();?>/assets/img/checkmark2.png" class="valide_user pointer" id="<?php echo $enseignantsToAccept['login'];?>"/>
                                    </div>
                                </div>
                            <?php endforeach;?>
                            <?php if(!$enAttente):?>
                                <p>
                                    <span class="text-primary">Il n'y a pas d'utilisateurs en attente d'acceptation.</span>
                                </p>
                            <?php endif;?>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div id="addUser" class="row admin-custom-box">
                <div class="col-md-12 col-no-border">
                    <?php echo form_open("admin/addUser",'class="form-horizontal"')?>
                    <fieldset>
                        <div class="form-group">
                            <legend>Ajouter un utilisateur</legend>
                            <div class="col-md-12 col-no-border">
                                <p>Pour ajouter un utilisateur, merci d'utiliser le panel ci-contre.
                                    Votre utilisateur aura le mot de passe par défaut, soit "servicesENSSAT".</p>
                                <div class="col-md-12 col-no-border">
                                    <label for="name" class="control-label">Nom de l'utilisateur</label>
                                    <?php echo form_input('name','','class="form-control" placeholder="Doe" id="name" required')?>
                                </div>
                                <div class="col-md-12 col-no-border">
                                    <label for="prenom" class="control-label">Prénom de l'utilisateur</label>
                                    <?php echo form_input('prenom','','class="form-control" placeholder="John" id="prenom" required')?>
                                </div>
                                <div class="col-md-12 col-no-border">
                                    <label for="inputHours" class="control-label">Nombre d'heures allouées</label>
                                    <input type="number" min="0" class="form-control" id="inputHours" name="heures" placeholder="heures" required>
                                </div>
                                <div class="col-md-12 col-no-border">
                                    <label for="admin" class="control-label">Admin</label>
                                    <select class="form-control" id="select" name="admin">
                                        <option value="0">Non</option>
                                        <option value="1">Oui</option>
                                    </select>
                                </div>
                                <div class="col-md-12 col-no-border">
                                    <label for="actif" class="control-label">Actif</label>
                                    <select class="form-control" id="select" name="actif">
                                        <option value="0">Non</option>
                                        <option value="1">Oui</option>
                                    </select>
                                </div>
                                <div class="col-md-12 col-no-border">
                                    <label for="select_statut" class="control-label">Statut</label>
                                    <select name="status_select" class="form-control chosen-select" id="status_select">
                                        <?php foreach ($status as $lestatut){
                                            echo "<option value=\"$lestatut->statut\"";
                                            echo set_select('status_select', $lestatut->statut);
                                            echo ">";
                                            echo ucfirst($lestatut->statut);
                                            echo "</option>";
                                        }?>
                                        <option value="autre" <?php echo set_select('status_select','autre'); ?>>Autre</option>
                                    </select>
                                </div>
                                <div class="col-md-12 col-no-border customHide" id="StatusPerso">
                                    <label for="inputStatusPerso" class="control-label">Statut personnalisé</label>
                                    <?php echo form_input('status_perso','','class="form-control" placeholder="Statut" id="inputStatusPerso"')?>
                                </div>
                                <div class="col-md-12 col-no-border text-right">
                                    <?php echo form_submit('submit','valider','class="btn btn-success"')?>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <?php echo form_close()?>
                </div>
            </div>
            <div id="deleteUsers" class="row admin-custom-box">
                <div class="col-md-12 col-no-border">
                    <?php echo form_open("admin/deleteUser",'class="form-horizontal"')?>
                    <fieldset>
                        <legend>Suppression utilisateur(s)</legend>
                        <div class="form-group">
                            <div class="col-md-12 col-no-border">
                                <label for="selectEnseignant" class="control-label">Enseignants</label>
                                <select name="enseignants[]" class="form-control chosen-select" id="selectEnseignant" multiple style="height: 380.5px" data-placeholder="Veuillez choisir un ou plusieurs enseignant(s)">
                                    <?php foreach($enseignants as $enseignant):?>
                                        <?php if(!($enseignant['login']==$this->session->userdata('username'))):?>
                                        <option value="<?php echo $enseignant['login'];?>">
                                            <?php echo  $enseignant['nom'].' '.
                                                $enseignant['prenom'] . " " .
                                                " : ".
                                                $enseignant['login'];?>
                                        </option>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-md-12 col-no-border text-right">
                                <?php echo form_submit('submit','Supprimer','class="btn btn-danger"')?>
                            </div>
                        </div>
                    </fieldset>
                    <?php echo form_close()?>
                </div>
            </div>
            <div id="modifyUsers" class="row admin-custom-box">
                <div class="col-md-12 col-no-border">
                    <?php echo form_open("admin/modifyUser",'class="form-horizontal"')?>
                    <fieldset>
                        <legend>Modifier un utilisateur</legend>
                        <div class="form-group">
                            <div class="col-md-12 col-no-border">
                                <label for="enseignantsModify" class="control-label">Enseignants</label>
                                <select name="enseignantsModify" class="form-control chosen-select" id="enseignantsModify">
                                    <?php foreach($enseignantsModify as $enseignants):?>
                                        <option value="<?php echo $enseignants['login'];?>">
                                            <?php echo  $enseignants['nom'].' '.
                                                $enseignants['prenom'] . " " .
                                                " : ".
                                                $enseignants['login'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-md-12 col-no-border text-right">
                                <?php echo form_button('submit','valider','id="modifyUser" class="btn btn-info"')?>
                            </div>
                        </div>
                        <div class="col-md-12 col-no-border customHide" id="displayUserInfoModify">
                            <p>Pour modifier un utilisateur, merci d'utiliser le panel ci-contre.</p>
                            <p>A noter : vous ne pouvez pas modifier le nom, le prénom et le pseudo d'un utilisateur. Il faut dans
                                ce cas le supprimer et lui demmander de se réinscrire.</p>
                            <div class="col-md-12 col-no-border">
                                <label for="loginModify" class="control-label">Pseudo de l'utilisateur</label>
                                <?php echo form_input('loginModify','','class="form-control" disabled="" placeholder="jdoe" id="loginModify" required')?>
                            </div>
                            <div class="col-md-12 col-no-border">
                                <label for="nameModify" class="control-label">Nom de l'utilisateur</label>
                                <?php echo form_input('nameModify','','class="form-control" disabled="" placeholder="John" id="nameModify" required')?>
                            </div>
                            <div class="col-md-12 col-no-border">
                                <label for="prenomModify" class="control-label">Prénom de l'utilisateur</label>
                                <?php echo form_input('prenomModify','','class="form-control" disabled="" placeholder="Doe" id="prenomModify" required')?>
                            </div>
                            <div class="col-md-12 col-no-border">
                                <label for="heuresModify" class="control-label">Nombre d'heures allouées</label>
                                <input type="number" min="0" class="form-control" id="heuresModify" name="heuresModify" placeholder="heures" required>
                            </div>
                            <div class="col-md-12 col-no-border">
                                <label for="dechargeModify" class="control-label">Nombre d'heures de décharge</label>
                                <input type="number" min="0" class="form-control" id="dechargeModify" name="dechargeModify" placeholder="heures" required>
                            </div>
                            <div class="col-md-12 col-no-border">
                                <label for="actifModify" class="control-label">Actif</label>
                                <select class="form-control" id="actifModify" name="actifModify">
                                    <option value="0">Non</option>
                                    <option value="1">Oui</option>
                                </select>
                            </div>
                            <div class="col-md-12 col-no-border">
                                <label for="select_statutModify" class="control-label">Statut</label>
                                <select name="select_statutModify" class="form-control" id="select_statutModify">
                                    <?php foreach ($status as $lestatut){
                                        echo "<option value=\"$lestatut->statut\" ";
                                        echo set_select('status_selectModify', $lestatut->statut);
                                        echo ">";
                                        echo ucfirst($lestatut->statut);
                                        echo "</option>";
                                    }?>
                                    <option value="autre" <?php echo set_select('status_selectModify','autre'); ?>>Autre</option>
                                </select>
                            </div>
                            <div class="col-md-12 col-no-border">
                                <label for="select_admin" class="control-label">Administrateur</label>
                                <select name="select_admin" class="form-control" id="select_admin">
                                    <option value="0" <?php echo set_select('status_admin','0'); ?>>Non</option>
                                    <option value="1" <?php echo set_select('status_admin','1'); ?>>Oui</option>
                                </select>
                            </div>
                            <div class="col-md-12 col-no-border customHide" id="StatusPersoModify">
                                <label for="inputStatusPerso" class="control-label">Statut personnalisé</label>
                                <?php echo form_input('status_perso','','class="form-control" placeholder="Statut" id="inputStatusPerso"')?>
                            </div>
                            <div class="col-md-12 col-no-border text-right">
                                <?php echo form_submit('submit','valider','class="btn btn-success"')?>
                            </div>
                        </div>
                    </fieldset>
                    <?php echo form_close()?>
                </div>
            </div>
            <div id="reinitUsers" class="row admin-custom-box">
                <div class="col-md-12 col-no-border">
                    <?php echo form_open("admin/reinitMDP",'class="form-horizontal"')?>
                    <fieldset>
                        <legend>Réinitialiser le mot de passe d'un utilisateur</legend>
                        <div class="form-group">
                            <div class="col-md-12 col-no-border">
                                <label for="enseignantsInit" class="control-label">Enseignants</label>
                                <select name="enseignantsInit" class="form-control chosen-select" id="enseignantsModify">
                                    <?php foreach($enseignantsModify as $enseignants):?>
                                        <option value="<?php echo $enseignants['login'];?>">
                                            <?php echo  $enseignants['nom'].' '.
                                                $enseignants['prenom'] . " " .
                                                " : ".
                                                $enseignants['login'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-md-12 col-no-border text-right">
                                <?php echo form_submit('submit','Réinitialiser le mot de passe','id="initUser" class="btn btn-danger"')?>
                            </div>
                        </div>
                    </fieldset>
                    <?php echo form_close()?>
                </div>
            </div>
            <div id="addNews" class="row admin-custom-box">
                <div class="col-md-12 col-no-border">
                    <?php echo form_open("admin/createNews",'class="form-horizontal"')?>
                    <fieldset>
                        <legend>Ajouter une news</legend>
                        <div class="form-group">
                            <?php echo form_textarea('news','','class="form-control" id="inputNews" placeholder="Ecrire votre texte"')?>
                        </div>
                        <div class="col-md-12 col-no-border text-right">
                            <?php echo form_submit('submit','Envoyer la news','class="btn btn-success"')?>
                        </div>
                    </fieldset>
                    <?php echo form_close()?>
                </div>
            </div>
            <div id="deleteNews" class="row admin-custom-box">
                <div class="col-md-12 col-no-border">
                    <?php echo form_open("admin/removeNews",'class="form-horizontal"')?>
                    <fieldset>
                        <legend>Supprimer une news</legend>
                        <div class="form-group">
                            <div class="col-md-12 col-no-border">
                                <select name="supprimer_news" class="form-control chosen-select" id="supprimer_news">
                                    <option value="no">Veuillez choisir</option>
                                    <?php foreach($allnews as $onenews):?>
                                        <option value="<?php echo $onenews['ID'];?>">
                                            <?php echo  substr($onenews['DATE'],0,16).' : '.
                                                substr($onenews['INFORMATION'],0,120).'...'
                                            ;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="row" id="afficheInformation">
                                <div class="col-md-12 col-no-border" >
                                    <textarea id="informationNews" rows="8" style="width:100%" disabled></textarea>
                                </div>
                                <div class="col-md-12 col-no-border text-right">
                                    <?php echo form_submit('submit','Supprimer','class="btn btn-danger"')?>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <?php echo form_close()?>
                </div>
            </div>
            <div id="modifyNews" class="row admin-custom-box">
                <div class="col-md-12 col-no-border">
                    <?php echo form_open("admin/modifyNews",'class="form-horizontal"')?>
                    <fieldset>
                        <legend>Modifier une news</legend>
                        <div class="form-group">
                            <div class="col-md-12 col-no-border">
                                <select name="modifier_news" class="form-control chosen-select" id="modifier_news">
                                    <option value="no">Veuillez choisir</option>
                                    <?php foreach($allnews as $onenews):?>
                                        <option value="<?php echo $onenews['ID'];?>">
                                            <?php echo  substr($onenews['DATE'],0,16).' : '.
                                                substr($onenews['INFORMATION'],0,120).'...'
                                            ;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="row customHide" id="afficheInformationtoModify">
                                <div class="col-md-12 col-no-border">
                                    <textarea name="informationNewstoModify" id="informationNewstoModify" rows="8" style="width:100%"></textarea>
                                </div>
                                <div class="col-md-12 col-no-border text-right">
                                    <?php echo form_submit('submit','Modifier','class="btn btn-success"')?>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <?php echo form_close()?>
                </div>
            </div>
            <div id="addContenu" class="row admin-custom-box">
                <div class="col-md-12 col-no-border">
                    <?php echo form_open("admin/addContenuToModule",'class="form-horizontal"')?>
                    <fieldset>
                        <legend>Ajouter un contenu à un module</legend>
                        <div class="form-group">
                            <div class="col-md-12 col-no-border">
                                <label for="selectModule" class="control-label">Selectionnez un module</label>
                                <select name="selectModule" class="form-control chosen-select" id="selectModule">
                                    <?php foreach($modules as $module):?>
                                        <option value="<?php echo $module['ident'];?>"><?php echo $module['ident']." Promotion: ".$module['public'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-md-12 col-no-border">
                                <label for="moduleType" class="control-label">Type de module (doit etre unique)</label>
                                <?php echo form_input('moduleType','','class="form-control" placeholder="ex : TP1, CM2, ..." id="moduleType" required')?>
                            </div>
                            <div class="col-md-12 col-no-border">
                                <label for="selectType" class="control-label">Type</label>
                                <select name="selectType" class="form-control chosen-select" id="selectType">
                                    <?php foreach($moduleTypes as $moduleType):?>
                                        <option value="<?php echo $moduleType['type'];?>"><?php echo $moduleType['type'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-md-12 col-no-border">
                                <label for="moduleHed" class="control-label">Indiquez le nombre d'heure</label>
                                <input type="number" min="0" name="moduleHed" class="form-control" placeholder="ex : 12" id="moduleHed" required/>
                            </div>
                            <div class="col-md-12 col-no-border text-right">
                                <?php echo form_submit('submit','valider','class="btn btn-success"')?>
                            </div>
                        </div>
                    </fieldset>
                    <?php echo form_close()?>
                </div>
            </div>
            <div id="deleteContenu" class="row admin-custom-box">
                <div class="col-md-12 col-no-border">
                    <?php echo form_open("admin/deleteModuleContenu",'class="form-horizontal"')?>
                    <fieldset>
                        <legend>Supprimer un contenu d'un module</legend>
                        <div class="form-group">
                            <div class="col-md-12 col-no-border">
                                <label for="selectModuleShowContenu" class="control-label">Selectionnez un module</label>
                                <select name="selectModuleShowContenu" class="form-control chosen-select-deselect" id="getContenu">
                                    <?php foreach($modules as $module):?>
                                        <option value="<?php echo $module['ident'];?>"><?php echo $module['ident']." Promotion: ".$module['public'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-md-12 col-no-border text-right">
                                <?php echo form_button('submit','valider','id="getModuleContenus" class="getContenu ajaxFunction btn btn-info"')?>
                            </div>
                            <div id="displaygetModuleContenus" class="customHide">
                                <div  class=" col-md-12 col-no-border">
                                    <label for="selectContenuModule" class="control-label">Selectionnez la/les partie(s) à supprimer</label>
                                    <select name="selectContenuModule[]" class="form-control" id="selectContenuModule" multiple data-placeholder="Veuillez choisir">
                                    </select>
                                </div>
                                <div  class=" col-md-12 col-no-border text-right">
                                    <?php echo form_submit('submit','Supprimer','id="deleteModuleContenu" class="delContenu btn btn-danger"')?>
                                </div>
                            </div>
                            <div id="noContenuRemove" class="customHide">
                                <p>Aucun contenu pour ce module</p>
                            </div>
                        </div>
                    </fieldset>
                    <?php echo form_close()?>
                </div>
            </div>
            <div id="modifyContenu" class="row admin-custom-box">
                <div class="col-md-12 col-no-border">
                    <?php echo form_open("admin/modifyModuleContenu",'class="form-horizontal"')?>
                    <fieldset>
                        <legend>Modifier le contenu d'un module</legend>
                        <div class="form-group">
                            <div class="col-md-12 col-no-border">
                                <div class="col-md-6 col-no-border">
                                    <div class="col-md-12 col-no-border">
                                        <label for="selectModuleShowContenu" class="control-label">Selectionnez Module</label>
                                        <select name="selectModuleShowContenu" class="form-control chosen-select" id="obtContenu">
                                            <?php foreach($modules as $module):?>
                                                <option value="<?php echo $module['ident'];?>"><?php echo $module['ident']." Promotion: ".$module['public'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div class="col-md-12 col-no-border text-right">
                                        <?php echo form_button('recuperation','valider','id="setModuleContenusType" class="obtContenu ajaxFunction btn btn-info"')?>
                                    </div>
                                </div>
                                <div id="displaysetModuleContenusType" class="customHide col-md-6 col-no-border">
                                    <div class="col-md-12 col-no-border">
                                        <label for="selectContenuModuleModification" class="control-label">Selectionnez la/les partie(s)</label>
                                        <select name="selectContenuModuleModification" class="form-control" id="dtcContenu">
                                        </select>
                                    </div>
                                    <div class="col-md-12 col-no-border">
                                        <div class="col-md-8 col-no-border"></div>
                                        <div class="col-md-4 col-no-border">
                                            <?php echo form_button('submit','valider','id="setModuleContenus" class="dtcContenu ajaxFunction btn btn-info"')?>
                                        </div>
                                    </div>
                                </div>
                                <div id="noContenuModify" class="customHide col-md-6 col-no-border customHide">
                                    <p>Aucun contenu pour ce module</p>
                                </div>
                            </div>
                            <div id="displaysetModuleContenus" class="customHide">
                                <div class="col-md-12 col-no-border">
                                    <label for="modulePartieAjax" class="control-label">Partie de module (doit etre unique)</label>
                                    <?php echo form_input('modulePartieAjax','','class="form-control" placeholder="ex : TP1, CM2, ..." id="modulePartieAjax" required')?>
                                </div>
                                <div class="col-md-12 col-no-border">
                                    <label for="selectTypeAjax" class="control-label">Type</label>
                                    <select name="selectTypeAjax" class="form-control chosen-select" id="selectTypeAjax">
                                        <?php foreach($moduleTypes as $moduleType):?>
                                            <option class="typeModuleAjax" value="<?php echo $moduleType['type'];?>"><?php echo $moduleType['type'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="col-md-12 col-no-border">
                                    <label for="selectTeacher" class="control-label">Professeur</label>
                                    <select name="selectTeacher" class="form-control chosen-select" id="selectTeacher">
                                        <option id="teacherModuleAjax" value=""></option>
                                        <?php foreach($enseignantsContenu as $enseignant2):?>
                                            <option value="<?php echo $enseignant2['login'];?>"><?php echo $enseignant2['nom']." ".$enseignant2['prenom'];?></option>
                                        <?php endforeach;?>
                                        <option value="">Aucun</option>
                                    </select>
                                </div>
                                <div class="col-md-12 col-no-border">
                                    <label for="moduleHedAjax" class="control-label">Indiquez le nombre d'heure</label>
                                    <input type="number" min="0" name="moduleHedAjax" class="form-control" placeholder="ex : 12" id="moduleHedAjax" required/>
                                </div>
                                <div class="col-md-12 col-no-border text-right">
                                    <?php echo form_submit('submit','Modifier','id="getModuleContenus" class="  btn btn-success"')?>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <?php echo form_close()?>
                </div>
            </div>
            <div id="modifyModule" class="row admin-custom-box">
                <div class="col-md-12 col-no-border">
                    <fieldset>
                        <legend>Modifier un module</legend>
                        <?php echo form_open('admin/modifyModule');?>
                        <div class="form-group">
                            <div class="col-md-12 col-no-border">
                                <label for="selectModifyModule" class="control-label">Module</label>
                                <select name="selectModModule" class="form-control chosen-select" id="selectModM" data-placeholder="Veuillez choisir">
                                    <?php foreach($modules as $module):?>
                                        <option value="<?php echo $module['ident'];?>"><?php echo $module['ident'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-no-border text-right">
                            <?php echo anchor('#','Rechercher','id="modifyModuleAjax" class="selectModModule ajaxFunction btn btn-info"')?>
                        </div>
                        <div id="displayModuleContentModify" class="customHide">
                            <div class="col-md-12 col-no-border">
                                <label for="inputLibelle" class="2 col-no-border control-label">Description du module</label>
                                <?php echo form_input('inputLibelle','','class="form-control" id="inputLibelleModifyModule" placeholder="ex : Algorithmique et language C 1" required')?>
                            </div>
                            <div class="col-md-12 col-no-border">
                                <label for="selectResponsable" class="control-label">Responsable</label>
                                <select name="selectResponsable" class="form-control" id="selectResponsableModifyModule">
                                    <option value="">...</option>
                                    <?php foreach($enseignantsModifyModule as $enseignant):?>
                                        <option value="<?php echo $enseignant['login'];?>"><?php echo $enseignant['nom']. " ".$enseignant['prenom'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-md-12 col-no-border text-right">
                                <?php echo form_submit('submit','Valider','class="btn btn-success"');?>
                            </div>
                        </div>
                        <?php echo form_close();?>
                    </fieldset>
                </div>
            </div>
    </div>
</div>

<?php $this->load->view('js/ajax');$this->load->view('js/jsAdminLoad');?>
