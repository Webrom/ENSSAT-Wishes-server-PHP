<div class="col-md-1 col-no-border"></div>
<div class="col-md-10 col-no-border">
    <?php if(isset($msg)):?>
        <div class="alert alert-dismissable <?php if(isset($success)){ echo $success; } ?>">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <?php echo $msg; ?>
        </div>
    <?php endif;?>
    <div class="row">
            <ul class="media-list">
                <?php //print_r($news);die()?>
                <?php foreach($news as $n):?>
                <li class="media comment-box">
                    <?php if(isset($n[0]['classe'])):?>
                        <div class="row media-body <?php echo $n[0]['classe']?>">
                            <div class="row">
                                <div class="col-md-2 col-no-border">
                                    <img class="media-object img-circle" alt="64x64" src="<?php echo base_url()?>uploads/<?php echo $n[0]['avatar'];?>" style="width: 64px; height: 64px;">
                                </div>
                            <?php switch($n[0]['classe']):
                                case 'generale':?>
                                <div class="col-md-10 col-no-border">
                                    <h5>Informartion générale</h5>
                                </div>
                            </div>
                            <div class="row">
                                <p><?php echo $n[0]['INFORMATION'];?></p>
                            </div>
                            <?php break;
                            case 'user':?>
                                <div class="col-md-10 col-no-border">
                                    <h5><?php echo $n[0]['INFORMATION'];?></h5>
                                </div>
                            </div>
                            <div class="row">
                            <?php if(isset($n[0]['partie'])):?>
                                <div class="col-no-border col-md-8">
                                    <ul class="n-info">
                                        <li>Enseignant : <?php echo $n[0]['nom']." ".$n[0]['prenom'];?></li>
                                        <li>Module : <?php echo $n[0]['module'];?></li>
                                        <li>Description : <?php echo $n[0]['libelle'];?></li>
                                        <li>Promotion : <?php echo $n[0]['public'];?></li>
                                        <li>Partie : <?php echo $n[0]['partie'];?></li>
                                    </ul>
                                </div>
                                <div class="col-md-4 col-no-border bp-component">
                                    <?php $data=array();
                                    foreach($n[0] as $key => $value){
                                        $data[$key]=$value;
                                    };?>
                                    <?php $this->load->view('back/home/boxModule',$data);?>
                                </div>
                            <?php else: ?>
                                <p>Le module à été supprimé, les informations ne sont plus disponibles.</p>
                            <?php endif;?>
                            </div>
                            <?php break;
                            case 'module':?>
                                <div class="col-md-10 col-no-border">
                                    <H5><?php echo $n[0]['INFORMATION'];?></H5>
                                </div>
                            </div>
                            <div class="row">
                            <?php if(isset($n[0]['ident'])):?>
                                <div class="col-md-4 col-no-border"></div>
                                <div class="col-md-8 col-no-border">
                                    <ul class="n-info">
                                        <li>Description : <?php echo $n[0]['libelle'];?></li>
                                        <li>Promotion : <?php echo $n[0]['public'];?></li>
                                        <li>Semestre : <?php echo $n[0]['semestre'];?></li>
                                        <?php if($n[0]['responsable']):?>
                                            <li>Responsable : <?php echo $n[0]['responsable'];?></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            <?php else :?>
                                <p>Le module à été supprimé, les informations ne sont plus disponibles.</p>
                            <?php endif;?>
                            </div>
                            <?php break;
                            case 'contenu':?>
                                <div class="col-md-10 col-no-border">
                                    <H5><?php echo $n[0]['INFORMATION'];?></H5>
                                </div>
                            </div>
                            <div class="row">
                            <?php if(isset($n[0]['module']) && isset($n[0]['partie'])):?>
                                <div class="col-no-border col-md-8">
                                    <ul class="n-info">
                                        <li>Module : <?php echo $n[0]['module'];?></li>
                                        <li>Description : <?php echo $n[0]['libelle'];?></li>
                                        <li>Promotion : <?php echo $n[0]['public'];?></li>
                                        <li>Partie : <?php echo $n[0]['partie'];?></li>
                                        <li>Semestre : <?php echo $n[0]['semestre'];?></li>
                                    </ul>
                                </div>
                                <div class="col-md-4 col-no-border bp-component">
                                    <?php $data=array();
                                    foreach($n[0] as $key => $value){
                                        $data[$key]=$value;
                                    };?>
                                    <?php $this->load->view('back/home/boxModule',$data);?>
                                </div>
                            <?php else : ?>
                                <p>Le module ou la partie à été supprimé, les informations ne sont plus disponibles.</p>
                            <?php endif;?>
                            </div>
                            <?php break;
                            case 'delete-contenu':?>
                                <div class="col-md-10 col-no-border">
                                    <h5>Suppression</h5>
                                </div>
                            </div>
                            <div class="row">
                                <?php echo $n[0]['INFORMATION'];?>
                            </div>
                                <?php break;
                            case 'delete-module':?>
                                <div class="col-md-10 col-no-border">
                                    <h5>Suppression</h5>
                                </div>
                            </div>
                            <div class="row">
                                <?php echo $n[0]['INFORMATION'];?>
                            </div>
                                <?php break;
                            default:?>
                                <div class="col-md-10 col-no-border">
                                    <h5><?php echo $n[0]['INFORMATION'];?></h5>
                                </div>
                                <?php break;
                            endswitch;?>
                        </div>
                    <?php elseif(isset($n[0]['classeUser'])):?>
                        <div class="<?php echo $n[0]['classeUser']?>">
                            <div class="row">
                                <div class="col-md-2 col-no-border">
                                    <img class="media-object img-circle" alt="64x64" src="<?php echo base_url()?>uploads/<?php echo $n[0]['avatar'];?>" style="width: 64px; height: 64px;">
                                </div>
                                <div class="col-md-10 col-no-border">
                                    <h5>Ajout d'un nouvel utilisateur</h5>
                                </div>
                            </div>
                            <div class="row">
                                <?php echo $n[0]['INFORMATION'];?>
                            </div>
                        </div>
                    <?php endif;?>
                    <span><?php echo $n[0]['date']; ?></span>
                    <ul>
                        <li><?php echo $n[0]['nom']?></li>
                        <li><?php echo $n[0]['prenom']?></li>
                    </ul>
                </li>
            <?php endforeach; ?>
            </ul>
    </div>
    <div class="row text-center">
        <div class="pagination"><?php echo $pagination; ?></div>
    </div>
</div>
<div class="col-md-1 col-no-border"></div>
</div>
<div id="filtre-news" class="row text-center">
    <div class="btn-group">
        <a class="btn btn-all" href="<?php echo base_url('index.php/homeNews/index')?>">Toutes</a>
        <a class="btn btn-generale" href="<?php echo base_url('index.php/homeNews/index/generale')?>">Generale</a>
        <a class="btn btn-module" href="<?php echo base_url('index.php/homeNews/index/module')?>">Module</a>
        <a class="btn btn-contenu" href="<?php echo base_url('index.php/homeNews/index/contenu')?>">Contenu</a>
        <a class="btn btn-user" href="<?php echo base_url('index.php/homeNews/index/user')?>">User</a>
    </div>
</div>