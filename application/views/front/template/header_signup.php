<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 12:51
 */
?>
</head>
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
                    <a href="#" class="" data-toggle="modal" data-target=".bp-example-modal-sm">Aide</a>
                </li>
                <li class="hideMenu">
                    <a href="<?php echo base_url()?>index.php/login">Connexion</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="<?php echo base_url()?>index.php/login">Connexion</a>
                </li>
            </ul>
        </div>

    </div>
</div>
<div class="container" id="descendTop">