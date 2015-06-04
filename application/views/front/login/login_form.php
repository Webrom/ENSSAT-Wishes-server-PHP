<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 12:58
 */
?>
<!-- Forms -->
<div class="bp-docs-section">
    <div class="row">

    </div>

    <div class="row">
        <div class="col-md-4 col-no-border"></div>
        <div id="loginForm" class="col-md-4 custom-box">
            <?php if(isset($msg)):?>
                <div class="alert alert-dismissable <?php if(isset($success)){ echo $success; } ?>">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <?php echo $msg; ?>
                </div>
            <?php endif;?>
            <div class="bp-component">
                <?php echo form_open('login/validate_credentials','class="form-horizontal"')?>
                    <fieldset>
                        <legend>Connexion</legend>
                        <div class="form-group">
                            <div class="col-md-12 col-no-border">
                                <label for="inputEmail" class="2 col-no-border control-label">Nom d'utilisateur</label>
                                <?php echo form_input('username','','class="form-control" id="inputEmail" placeholder="Username"')?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-no-border">
                                <label for="inputPassword" class="control-label">Mot de passe</label>
                                <?php echo form_password('password','','type="password" class="form-control" placeholder="password" id="inputPassword"')?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <?php echo form_submit('submit','Connexion','class="btn btn-success"')?>
                                <?php echo anchor('login/signUp','Inscription','class="btn btn-info"');?>
                            </div>
                        </div>
                    </fieldset>
                <?php echo form_close();?>
            </div>
        </div>
        <div class="col-md-4 col-no-border"></div>
    </div>
</div>
