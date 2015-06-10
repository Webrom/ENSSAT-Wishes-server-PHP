<div class="list-group">
    <div class="list-group-item <?php if(!$enseignant){echo "module-not-taken";}?>">
        <h4 class="list-group-item-heading"><?php echo $module;?></h4>
        <ul class="list-group">
            <li class='list-group-item'>
                <?php echo $partie?>
            </li>
            <li class="list-group-item">
                <span class="badge"><?php echo $hed?></span>
                Heures :
            </li>
            <?php if($enseignant):?>
                <li class="list-group-item same-case">
                    <?php echo $nom." ".$prenom;?>
                </li>
            <?php else: ?>
                <li class="list-group-item same-case text-center">
                    <a href="<?php echo base_url();?>index.php/modules/inscriptionModule?module=<?php echo $module;?>&partie=<?php echo $partie;?>&page=home"><button type="button" class="btn btn-warning">S'inscrire</button></a>
                </li>
            <?php endif;?>
        </ul>
    </div>
</div>