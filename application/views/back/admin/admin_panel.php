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
    </div>
    <div class="row">
        <div class="col-md-2 col-no-border"></div>
        <div class="col-md-8">
            <?php if($msg!=null):?>
            <div class="alert alert-dismissable <?php echo $success?>">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo $msg ?>
            </div>
            <?php endif;?>
            <div class="bp-component">
                <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                    <li class="active"><a href="#module" data-toggle="tab">Modules</a></li>
                    <li><a href="#contenu" data-toggle="tab">Contenu</a></li>
                    <li><a href="#profile" data-toggle="tab">Utilisateurs</a></li>
                    <li><a href="#news" data-toggle="tab">News</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="module">
                        <div class="row">
                            <div class="col-md-6 col-no-border">
                                <div class="bp-component">
                                    <div class="col-md-12 col-no-border">
                                        <?php echo form_open('admin/addModule','class="form-horizontal"')?>
                                        <fieldset>
                                            <legend>Ajouter un module</legend>
                                            <div class="form-group">
                                                <div class="col-md-12 col-no-border">
                                                    <label for="inputIdent" class="2 col-no-border control-label">Identifiant du module</label>
                                                    <?php echo form_input('inputIdent','','class="form-control" id="inputIdent" placeholder="ex : ALGOC1" required')?>
                                                </div>
                                                <div class="col-md-12 col-no-border">
                                                    <label for="inputLibelle" class="2 col-no-border control-label">Description du module</label>
                                                    <?php echo form_input('inputLibelle','','class="form-control" id="inputIdent" placeholder="ex : Algorithmique et language C 1" required')?>
                                                </div>
                                                <div class="col-md-12 col-no-border">
                                                    <label for="selectResponsable" class="control-label">Responsable</label>
                                                    <select name="selectResponsable" class="form-control" id="selectResponsable">
                                                        <option value="">...</option>
                                                        <?php foreach($enseignants as $enseignant):?>
                                                            <option value="<?php echo $enseignant['login'];?>"><?php echo $enseignant['nom']. " ".$enseignant['prenom'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                                <div class="col-md-12 col-no-border">
                                                    <label for="selectSemestre" class="control-label">Semestre</label>
                                                    <select name="selectSemestre" class="form-control" id="selectSemestre">
                                                        <?php foreach($semestres as $semestre):?>
                                                            <option value="<?php echo $semestre;?>"><?php echo $semestre;?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                                <div class="col-md-12 col-no-border">
                                                    <label for="selectPublic" class="control-label">Promotion</label>
                                                    <select name="selectPublic" class="form-control" id="selectPublic">
                                                        <?php foreach($publics as $public):?>
                                                            <option value="<?php echo $public["public"];?>"><?php echo $public["public"];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-8 col-no-border"></div>
                                                <div class="col-md-4 col-no-border">
                                                    <?php echo form_submit('submit','Valider','class="btn btn-success"')?>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <?php echo form_close()?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-no-border">
                                <div class="bp-component">
                                    <div class="col-md-12 col-no-border">
                                        <?php echo form_open("admin/deleteModule",'class="form-horizontal"')?>
                                        <fieldset>
                                            <legend>Supprimer un module</legend>
                                            <div class="form-group">
                                                <div class="col-md-12 col-no-border">
                                                    <label for="selectModule" class="control-label">Selectionnez Module</label>
                                                    <select name="module[]" class="form-control" id="selectModule" multiple style="height: 380.5px">
                                                        <?php foreach($modules as $module):?>
                                                            <option value="<?php echo $module['ident'];?>"><?php echo $module['ident'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-no-border">
                                                <div class="col-md-8 col-no-border"></div>
                                                <div class="col-md-4 col-no-border">
                                                    <?php echo form_submit('submit','Supprimer','class="btn btn-danger"')?>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <?php echo form_close()?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile">
                        <div class="row">
                            <div class="col-md-6 col-no-border">
                                <div class="bp-component">
                                    <div class="col-md-12 col-no-border">
                                        <?php echo form_open("admin/addUser",'class="form-horizontal"')?>
                                        <fieldset>
                                            <div class="form-group">
                                            <legend>Ajouter un utilisateur</legend>
                                            <div class="col-md-12 col-no-border">
                                                Pour ajouter un utilisateur, merci d'utiliser le panel ci-contre.
                                                Votre utilisateur aura le mot de passe par défaut, soit "servicesENSSAT".
                                                <div class="form-group">
                                                    <div class="col-md-12 col-no-border">
                                                        <label for="name" class="control-label">Nom de l'utilisateur</label>
                                                        <?php echo form_input('name','','class="form-control" placeholder="John" id="name" required')?>
                                                    </div>
                                                    <div class="col-md-12 col-no-border">
                                                        <label for="prenom" class="control-label">Prénom de l'utilisateur</label>
                                                        <?php echo form_input('prenom','','class="form-control" placeholder="Doe" id="prenom" required')?>
                                                    </div>
                                                    <div class="col-md-12 col-no-border">
                                                        <label for="inputHours" class="control-label">Nombre d'heures allouées</label>
                                                        <?php echo form_input('heures','','class="form-control" placeholder="heures" id="inputHours" required')?>
                                                    </div>
                                                    <div class="col-md-12 col-no-border">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox"> Actif ?
                                                            </label>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="col-md-12 col-no-border">
                                                    <label for="select_statut" class="control-label">Statut</label>
                                                    <select name="status_select" class="form-control" id="status_select">
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
                                                <div class="col-md-12 col-no-border">
                                                    <div class="col-md-8 col-no-border"></div>
                                                    <div class="col-md-4 col-no-border">
                                                        <?php echo form_submit('submit','valider','class="btn btn-success"')?>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <?php echo form_close()?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-no-border">
                                <div class="bp-component">
                                    <div class="col-md-12 col-no-border">
                                        <?php echo form_open("",'class="form-horizontal"')?>
                                        <fieldset>
                                            <legend>Supprimer un utilisateur</legend>
                                            <div class="form-group">
                                                <div class="col-md-12 col-no-border">
                                                    <div class="col-md-8 col-no-border"></div>
                                                    <div class="col-md-4 col-no-border">
                                                        <?php echo form_submit('submit','Supprimer','class="btn btn-danger"')?>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <?php echo form_close()?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="news">
                        <div class="row">
                            <div class="col-md-6 col-no-border">
                                <div class="bp-component">
                                    <div class="col-md-12 col-no-border">
                                        <?php echo form_open("",'class="form-horizontal"')?>
                                        <fieldset>
                                            <legend>Ajouter une news</legend>
                                            <div class="form-group">

                                            </div>
                                        </fieldset>
                                        <?php echo form_close()?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-no-border">
                                <div class="bp-component">
                                    <div class="col-md-12 col-no-border">
                                        <?php echo form_open("",'class="form-horizontal"')?>
                                        <fieldset>
                                            <legend>Supprimer une news</legend>
                                            <div class="form-group">

                                            </div>
                                        </fieldset>
                                        <?php echo form_close()?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contenu">
                        <div class="row">
                            <div class="col-md-6 col-no-border">
                                <div class="bp-component">
                                    <div class="col-md-12 col-no-border">
                                        <?php echo form_open("",'class="form-horizontal"')?>
                                        <fieldset>
                                            <legend>Ajouter un contenu à un module</legend>
                                            <div class="form-group">
                                                <div class="col-md-12 col-no-border">
                                                    <label for="selectModule" class="control-label">Selectionnez Module</label>
                                                    <select name="selectModule" class="form-control" id="selectModule">
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
                                                    <select name="selectType" class="form-control" id="selectType">
                                                        <?php foreach($moduleTypes as $moduleType):?>
                                                            <option value="<?php echo $moduleType['type'];?>"><?php echo $moduleType['type'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                                <div class="col-md-12 col-no-border">
                                                    <label for="moduleHed" class="control-label">Indiquez le nombre d'heure</label>
                                                    <?php echo form_input('moduleHed','','class="form-control" placeholder="ex : 12" id="moduleHed" required')?>
                                                </div>
                                                <div class="col-md-12 col-no-border">
                                                    <div class="col-md-8 col-no-border"></div>
                                                    <div class="col-md-4 col-no-border">
                                                        <?php echo form_submit('submit','valider','class="btn btn-success"')?>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <?php echo form_close()?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-no-border">
                                <div class="bp-component">
                                    <div class="col-md-12 col-no-border">
                                        <?php echo form_open("",'class="form-horizontal"')?>
                                        <fieldset>
                                            <legend>Supprimer un contenu d'un module</legend>
                                            <div class="form-group">
                                                <div class="col-md-12 col-no-border">
                                                    <label for="selectModule" class="control-label">Selectionnez Module</label>
                                                    <select name="selectModule" class="form-control" id="selectModule">
                                                        <?php foreach($modules as $module):?>
                                                            <option value="<?php echo $module['ident'];?>"><?php echo $module['ident']." Promotion: ".$module['public'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <?php echo form_close()?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-no-border"></div>
    </div>
</div>