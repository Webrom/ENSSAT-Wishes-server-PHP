<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 12:51
 */
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Serveur de voeux d'enseignements</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href='<?php echo base_url();?>assets/css/bootstrap.min.css?v=2500' media="screen">
    <link rel="stylesheet" href='<?php echo base_url();?>assets/css/customcss.css' media="screen">
    <link rel="stylesheet" href='<?php echo base_url();?>assets/css/theme.min.css?v=2501'>
</head>
<body>
<div class="navbar navbar-dark navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="<?php echo base_url();?>" class="navbar-brand navbar-title">Home</a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <li>
                    <a id="linkHelp" href="#">Help</a>
                </li>
            </ul>
        </div>
        <div id="helpDisplay" class="customHide">
            <p>Connectez vous sur le panel de gestion de cours de l'ENSSAT</p>
            <p>Identifiant : première lettre du prenom, suivis des 7 premières lettres de votre nom</p>
            <p>Si vous n'êtes pas actif, vous ne pouvez pas vous connecter...</p>
            <p>Vous êtes considéré comme inactif si :</p>
            <ol>
                <li>Vous êtes en arrêt maladie</li>
                <li>Vous êtes un intervenant extérieur à l'ENSSAT</li>
            </ol>
            <p>Pour toute information complémentaire, contactez l'admin : a@b.fr</p>
        </div>
    </div>
</div>
