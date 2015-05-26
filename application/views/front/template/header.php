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
    <title>srv_voeux</title>
    <link rel="stylesheet" href='<?php echo base_url();?>assets/css/bootstrap.min.css?v=2500' media="screen">
    <link rel="stylesheet" href='<?php echo base_url();?>assets/css/theme.min.css?v=2501'>
</head>
<body>
<div class="navbar navbar-dark navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="/" class="navbar-brand navbar-title">Trendy</a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Themes <span class="caret"></span></a>
                    <ul class="dropdown-menu" aria-labelledby="themes">
                        <li><a href="#">Default</a></li>
                        <li class="divider"></li>
                        <li><a href="#">link</a></li>
                        <li><a href="#">link</a></li>
                        <li><a href="#">link</a></li>
                        <li><a href="#">link</a></li>
                        <li><a href="#">link</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Help</a>
                </li>
                <li>
                    <a href="#">Blog</a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <form class="navbar-form navbar-left" role="search">
                    <input type="text" class="form-control" placeholder="Search">
                    <button type="submit" class="btn glyphicon glyphicon-search"></button>
                </form>
            </ul>

        </div>
    </div>
</div>
