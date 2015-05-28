<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 12:51
 */
?>
<body>
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
                    <a href="<?php echo base_url()?>index.php/modules">Les modules</a>
                </li>
                <?php if(isset($admin) && $admin=="1"): ?>
                    <li class="hideMenu">
                        <a href="<?php echo base_url()?>index.php/admin">Administration</a>
                    </li>
                <?php endif;?>
                <li class="hideMenu">
                    <a href="<?php echo base_url()?>index.php/profile">Profil</a>
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
                    <a href="<?php echo base_url()?>index.php/profile">Profil</a>
                </li>
                <li>
                    <a href="<?php echo base_url()?>index.php/login/logout">Déconnexion</a>
                </li>
            </ul>

        </div>
    </div>
</div>
