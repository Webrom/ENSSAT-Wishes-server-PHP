<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 12:51
 */
?>
<body>
<p id="activePage" class="customHide"><?php if(isset($active)) echo $active;?></p>
<div class="navbar navbar-dark navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="<?php echo base_url();?>" class="navbar-brand navbar-title">Accueil</a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <li>
                    <a href="<?php echo base_url()?>index.php/modules">Modules</a>
                </li>
                <li>
                    <ul class="navbar-nav">
                        <li class="active progress progress-striped" style="margin: 15px;width: 100px;list-style: none">
                            <div class="progress-bar <?php if($pourcentage>100) echo 'progress-bar-warning';else echo 'progress-bar-success';?>" style="width: <?php echo $pourcentage; ?>%">
                            </div>
                        </li>
                        <li style="margin: 15px;list-style: none;">
                            <p style="color:#fff;margin: 0"><?php echo $pourcentage; ?>% : <?php echo $heuresprises;?>/<?php echo $heurestotales;?> h</p>
                        </li>
                    </ul>

                </li>
                <?php if(isset($admin) && $admin=="1"): ?>
                    <li class="hideMenu">
                        <a href="<?php echo base_url()?>index.php/admin">Administration</a>
                    </li>
                <?php endif;?>
                <li class="hideMenu">
                    <a href="<?php echo base_url()?>index.php/profile">
                        Profil
                    </a>
                </li>
                <li class="hideMenu">
                    <a href="<?php echo base_url()?>index.php/login/logout">Déconnexion</a>
                </li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if(isset($admin) && $admin=="1"): ?>
                <li>
                    <a href="<?php echo base_url()?>index.php/admin">Administration</a>
                </li>
                <?php endif;?>
                <li>
                    <a href="<?php echo base_url()?>index.php/profile">
                        <img class="media-object img-thumbnail" alt="25x25" src="<?php echo base_url()?>uploads/<?php echo $avatar;?>" style="width: 20px; height: 20px;float: left;margin-right: 5px;padding: 0">
                        Profil
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url()?>index.php/login/logout">Déconnexion</a>
                </li>
            </ul>

        </div>
    </div>
</div>
<div id="display-bg"></div>
<div class="container" id="descendTop">