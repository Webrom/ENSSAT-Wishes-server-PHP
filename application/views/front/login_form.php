<?php
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
        <div class="col-md-12 title-section">
            <h1 id="forms">User connection</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="bp-component">
                <?php echo form_open('login/validate_credentials','class="form-horizontal"')?>
                    <fieldset>
                        <legend>Legend</legend>
                        <div class="form-group">
                            <div class="col-md-12 col-no-border">
                                <label for="inputEmail" class="2 col-no-border control-label">Email anddress</label>
                                <?php echo form_input('username','Username','class="form-control" id="inputEmail"')?>
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-md-12 col-no-border">
                                <label for="inputPassword" class="control-label">Mot de passe</label>
                                <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"> Checkbox
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <button class="btn btn-success">Connexion</button>
                                <button type="submit" class="btn btn-info">Inscription</button>
                            </div>
                        </div>
                    </fieldset>
                <?php echo form_close();?>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>