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
        <div class="col-md-12 title-section">
            <h1>administration</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-no-border"></div>
        <div class="col-md-8">
            <div class="bp-component">
                <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                    <li class="active"><a href="#module" data-toggle="tab">Modules</a></li>
                    <li><a href="#profile" data-toggle="tab">Utilisateurs</a></li>
                    <li><a href="#news" data-toggle="tab">News</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="module">
                        <div class="row">
                            <div class="bp-component">
                                <div class="col-md-12 col-no-border">
                                    <?php echo form_open("",'class="form-horizontal"')?>
                                        <fieldset>
                                            <legend>Ajouter un module</legend>
                                            <div class="form-group">

                                            </div>
                                        </fieldset>
                                    <?php echo form_close()?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="bp-component">
                                <div class="col-md-12 col-no-border">
                                    <?php echo form_open("",'class="form-horizontal"')?>
                                    <fieldset>
                                        <legend>Supprimer un module</legend>
                                        <div class="form-group">

                                        </div>
                                    </fieldset>
                                    <?php echo form_close()?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile">
                        <div class="row">
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
                        <div class="row">
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
                    <div class="tab-pane fade" id="news">
                        <div class="row">
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
                        <div class="row">
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
            </div>
        </div>
        <div class="col-md-2 col-no-border"></div>
    </div>
</div>