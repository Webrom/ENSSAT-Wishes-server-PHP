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
                                                    <?php echo form_submit('submit','valider','class="btn btn-success"')?>
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
                                                    <?php echo form_submit('submit','valider','class="btn btn-success"')?>
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
                                        <?php echo form_open("",'class="form-horizontal"')?>
                                        <fieldset>
                                            <legend>Ajouter un utilisateur</legend>
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
                                            <legend>Supprimer un utilisateur</legend>
                                            <div class="form-group">

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