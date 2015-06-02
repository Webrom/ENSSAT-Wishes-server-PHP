





<div class="col-md-2 col-no-border"></div>
<div class="col-md-8 col-no-border">
    <div class="row">
        <div class="pagination"><?php echo $pagination; ?></div>
    </div>
    <div class="row">
        <ul class="media-list">
            <?php foreach($newsInformations as $newsInformation): ?>
            <li class="media comment-box">
                <a class="pull-left" href="#">
                    <img class="media-object img-circle" alt="64x64" src="<?php echo base_url()?>uploads/<?php echo $newsInformation['avatar'];?>" style="width: 64px; height: 64px;">
                </a>
                <div class="media-body">
                    <p class="<?php echo $newsInformation['TYPE']?>"><?php echo nl2br(htmlentities($newsInformation['INFORMATION'])); ?></p>
                    <span><?php echo $newsInformation['date']; ?></span>
                    <ul>
                        <li><?php echo $newsInformation['nom']?></li>
                        <li><?php echo $newsInformation['prenom']?></li>
                    </ul>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="row">
        <div class="pagination"><?php echo $pagination; ?></div>
    </div>
</div>
<div class="col-md-2 col-no-border"></div>
