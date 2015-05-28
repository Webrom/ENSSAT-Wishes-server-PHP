<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>

<div class="bp-docs-section">
    <div class="row">
    </div>
    <?php foreach($userInfos as $userInfo):;?>
    <div class="row">
        <div class="col-md-2 col-no-border"></div>
        <div class="col-md-8">
            <div class="col-md-12 col-no-border">
                <div class="col-md-12 col-no-border">
                    <div class="col-md-2">
                        <img class="media-object img-circle" alt="64x64" src="<?php echo base_url()?>uploads/<?php echo $avatar;?>" style="width: 64px; height: 64px;">
                    </div>
                    <div class="col-md-10">
                        <h2><?php echo $userInfo['prenom']." ".$userInfo['nom'];?></h2>
                    </div>
                </div>
                <div class="col-md-12 col-no-border">
                    <div class="col-md-8 col-no-border">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" style="width: <?php echo $pourcentage; ?>%"></div>
                        </div>
                    </div>
                    <div class="col-md-4 col-no-border">
                        <span class="text-success"><?php echo $pourcentage; ?>% : <?php echo $heuresprises;?> h sur vos <?php echo $heurestotales;?> h</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-no-border">
                <?php echo form_open_multipart('upload/do_upload');?>
                <div class="col-md-12 col-no-border">
                    <label for="inputStatut" class="2 col-no-border control-label">Votre statut :</label>
                    <input disabled class="form-control" id="inputStatut" value="<?php echo $userInfo['statut'];?>" type="text">
                </div>
                <div class="col-md-12 col-no-border">
                    <label for="inputStatutaire" class="2 col-no-border control-label">Total d'heure à effectuer :</label>
                    <input disabled class="form-control" id="inputStatutaire" value="<?php echo $userInfo['statutaire'];?>" type="text">
                </div>
                <div class="col-md-12 col-no-border">
                    <div class="col-md-1 col-no-border"></div>
                    <div class="col-md-6 col-no-border">
                        <input type="file" name="userfile" size="20" />
                    </div>
                    <div class="col-md-5 col-no-border"></div>
                </div>
                <div class="col-md-12 col-no-border">
                    <div class="col-md-4 col-no-border">
                        <button type="submit" class="btn btn-success" value="upload">Envoyer</button>
                    </div>
                    <div class="col-md-8 col-no-border">
                        <?php if(file_exists("./uploads/".$userInfo['login'].".jpg"))
                            echo anchor('upload/remove','Supprimer image actuelle','class="btn btn-danger"');?>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="col-md-6 col-no-border">
                    <?php if(isset($msg)):?>
                    <div class="alert alert-dismissable <?php if(isset($success)){ echo $success; } ?>">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $msg; ?>
                    </div>
                    <?php endif;?>
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
                    <div class="col-md-12 col-no-border">
                        <div class="col-md-3 col-no-border"></div>
                        <div class="col-md-4 col-no-border">
                        <?php echo form_submit('submit','Confirmer','class="btn btn-success"')?>
                        </div>
                        <div class="col-md-5 col-no-border"></div>
                    </div>
                    <?php echo form_close()?>
            </div>
        </div>
        <div class="col-md-2 col-no-border"></div>
    </div>
    <?php endforeach ?>
</div>