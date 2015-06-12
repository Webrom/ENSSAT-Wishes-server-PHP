<?php
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 14:50
 */
?>
<div class="bp-docs-section">
    <div class="row">

    </div>

    <div class="row">
        <div class="col-md-3 col-no-border"></div>
        <div class="col-md-6 custom-box" id="signUpForm">
            <?php if(isset($msg)):?>
                <div class="alert alert-dismissable alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <?php echo $msg; ?>
                </div>
            <?php endif;?>
            <div class="bp-component">
                <?php echo form_open('login/createUser','class="form-horizontal" id="monformulaire"')?>
                    <fieldset>
                        <legend>Inscription</legend>
                        <p>Inscrivez vous au site de gestion de modules de l'ENSSAT !</p>
                        <p>A noter : pas d'accents ni d'espaces dans les champs, merci !</p>
                        <div class="col-md-6 col-no-border">
                            <div class="form-group">
                                <div class="col-md-12 col-no-border">
                                    <label for="name" class="control-label">Votre nom</label>
                                    <?php echo form_input('name','','class="form-control" placeholder="Doe" id="name" required')?>
                                </div>
                                <div class="col-md-12 col-no-border">
                                    <label for="prenom" class="control-label">Votre prenom</label>
                                    <?php echo form_input('prenom','','class="form-control" placeholder="John" id="prenom" required')?>
                                </div>
                                <div class="col-md-12 col-no-border">
                                    <label for="inputHours" class="control-label">Nombre d'heures allouées</label>
                                    <?php echo form_input('heures','','class="form-control" placeholder="ex : 12" id="inputHours" required')?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-no-border">
                            <div class="form-group">
                                <div class="col-md-12 col-no-border">
                                    <label for="inputPassword" class="control-label">Mot de passe</label>
                                    <?php echo form_password('password','','class="form-control" placeholder="password" id="inputPassword" required')?>
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
                                    <label for="inputStatusPerso" class="control-label">Votre statut</label>
                                    <?php echo form_input('status_perso','','class="form-control" placeholder="Statut" id="inputStatusPerso"')?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-no-border text-center">
                                <?php echo form_submit('submit','Inscription','class="btn btn-success"')?>
                                <?php echo anchor('login/','Retour','class="btn btn-info"');?>
                            </div>
                        </div>
                    </fieldset>
                <?php echo form_close();?>
            </div>
        </div>
    <div class="col-md-3 col-no-border"></div>
</div>
</div>