<?php
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 12:57
 */
?>
<div class="modal fade bp-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Aide</h4>
            </div>
            <?php //TODO css ?>
            <div class="modal-body">
                <p>Connectez vous sur le panel de gestion de cours de l'ENSSAT
                    Identifiant : première lettre du prenom, suivis des 7 premières lettres de votre nom
                    Si vous n'êtes pas actif, vous ne pouvez pas vous connecter...
                    Vous êtes considéré comme inactif si :</p>
                <ol>
                    <li>Vous êtes en arrêt maladie</li>
                    <li>Vous êtes un intervenant extérieur à l'ENSSAT</li>
                </ol>
                <p>Pour toute information complémentaire, contactez l'admin : admin@bvozel.fr</p>
                <p>Vous avez oublié votre mot de passe ? Contactez l'administrateur par mail en lui fournissant votre identifiant !</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

