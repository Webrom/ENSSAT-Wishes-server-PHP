<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Veuillez vous connecter</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">


</head>

<body>
<div class="container">
    <div class="row clearfix">
        <div class="col-md-4 column">
        </div>
        <div class="col-md-4 column">
            <form role="form">
                <div class="form-group">
                    <label for="exampleInputEmail1">Pseudo</label><input type="text" class="form-control" id="InputPseudo" />
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Mot de passe</label><input type="password" class="form-control" id="InputPassword1" />
                </div>
                 <button type="submit" class="btn btn-default">Se connecter</button>
            </form>
        </div>
        <div class="col-md-4 column">
        </div>
    </div>
</div>
</body>
</html>
