<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>

<div class="bp-docs-section">
    <div class="row">
    </div>
    <?php foreach($userInfos as $userInfo):;?>
    <div class="row">
        <div class="col-md-1 col-no-border"></div>
        <div class="col-md-10 col-no-border">
            <div class="row custom-box">
                <div class="row">
                    <div class="col-md-2">
                        <img class="media-object img-circle" alt="64x64" src="<?php echo base_url()?>uploads/<?php echo $avatar;?>" style="width: 64px; height: 64px;">
                    </div>
                    <div class="col-md-10">
                        <h2><?php echo $userInfo['prenom']." ".$userInfo['nom'];?></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-no-border">
                        <div class="progress progress-striped active">
                            <div class="progress-bar <?php if($pourcentage>100) echo 'progress-bar-warning';else echo 'progress-bar-success';?>" style="width: <?php echo $pourcentage; ?>%"></div>
                        </div>
                    </div>
                    <div class="col-md-4 col-no-border text-center">
                        <span class="<?php if($pourcentage>100) echo 'text-warning';else echo 'text-success';?>"><?php echo $pourcentage; ?>% : <?php echo $heuresprises;?>/<?php echo $heurestotales;?> h</span>
                    </div>
                </div>
                <?php if(isset($msg)):?>
                    <div class="row">
                        <div class="alert alert-dismissable <?php if(isset($success)){ echo $success; } ?>">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <?php echo $msg; ?>
                        </div>
                    </div>
                <?php endif;?>
                <div class="row">
                    <div class="bp-component">
                        <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                            <li class="active"><a href="#infosProfile" data-toggle="tab">Informations</a></li>
                            <li class=""><a href="#profile" data-toggle="tab">Modifier mon profil</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="infosProfile">
                                <div class="row">
                                    <div class="col-md-6 col-no-border">
                                        <div class="col-md-12 col-no-border">
                                            <label for="inputStatut" class="2 col-no-border control-label">Votre statut :</label>
                                            <input disabled class="form-control" id="inputStatut" value="<?php echo $userInfo['statut'];?>" type="text">
                                        </div>
                                        <?php echo form_open('profile/modifyStatutaire','class="form-horizontal"')?>
                                        <div class="col-md-12 col-no-border">
                                            <label for="inputStatutaire" class="2 col-no-border control-label">Total d'heure à effectuer :</label>
                                            <input class="form-control" id="inputStatutaire" name="inputStatutaire" value="<?php echo $userInfo['statutaire'];?>" type="number" min="0">
                                        </div>
                                        <div class="col-md-12 col-no-border text-right">
                                            <?php echo form_submit('submit','Changer votre statutaire','class="btn btn-success"')?>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                    <div class="col-md-6 col-no-border">
                                        <?php echo form_open('profile/modifyDecharge','class="form-horizontal"')?>
                                        <div class="col-md-12 col-no-border">
                                            <label for="inputDecharge" class="2 col-no-border control-label">Decharge :</label>
                                            <input class="form-control" id="inputDecharge" name="inputDecharge" value="<?php echo $decharge;?>" type="number" min="0">
                                        </div>
                                        <div class="col-md-12 col-no-border text-right">
                                            <?php echo form_submit('submit','Changer votre décharge','class="btn btn-success"')?>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile">
                                <div class="row">
                                    <div class="col-md-6 col-no-border">
                                        <?php echo form_open('profile/changePass','class="form-horizontal"')?>
                                        <div class="col-md-12 col-no-border">
                                            <label for="oldPass" class="2 col-no-border control-label">Ancien mot de passe : </label>
                                            <?php echo form_password('oldPass','','class="form-control" id="oldPass"')?>
                                        </div>
                                        <div class="col-md-12 col-no-border">
                                            <label for="newPass1" class="2 col-no-border control-label">Nouveau password : </label>
                                            <?php echo form_password('newPass1','','class="form-control" id="newPass1"')?>
                                        </div>
                                        <div class="col-md-12 col-no-border">
                                            <label for="newPass2" class="2 col-no-border control-label">Nouveau password (confirmation) : </label>
                                            <?php echo form_password('newPass2','','class="form-control" id="newPass2"')?>
                                        </div>
                                        <div class="col-md-12 col-no-border text-right">
                                            <?php echo form_submit('submit','Confirmer','class="btn btn-success"')?>
                                        </div>
                                        <?php echo form_close()?>
                                    </div>
                                    <div class="col-md-6 col-no-border">
                                        <?php echo form_open_multipart('upload/do_upload');?>
                                        <div class="col-md-12 col-no-border">
                                            <p>Télécharger image profil : format JPG / JPEG </p>
                                            <p>Taille max : 100 MO</p>
                                        </div>
                                        <div class="col-md-12 col-no-border">
                                            <input type="file" name="userfile" size="20" />
                                        </div>
                                        <div class="col-md-6 col-no-border">
                                            <?php if(file_exists("./uploads/".$userInfo['login'].".jpg"))
                                                echo anchor('upload/remove','Supprimer image actuelle','class="btn btn-danger"');?>
                                        </div>
                                        <div class="col-md-6 col-no-border text-right">
                                            <button type="submit" class="btn btn-success" value="upload">Envoyer</button>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1 col-no-border"></div>
    </div>
    <?php endforeach ?>
</div>