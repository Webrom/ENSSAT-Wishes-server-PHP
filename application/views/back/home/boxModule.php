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
            <li class="list-group-item">
                <?php if($enseignant)
                    echo $enseignant;
                else
                    echo '<a href="'.base_url().'index.php/modules/inscriptionModule?module='.$module.'&partie='.$partie.'"><button type="button" class="btn btn-warning">S\'inscrire</button></a>';?>
            </li>
        </ul>
    </div>
</div>