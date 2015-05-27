<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>

<div class="bp-docs-section">
    <div class="row">
        <div class="col-md-12 title-section">
            <h1 id="forms">Profile</h1>
        </div>
    </div>
    <?php foreach($userInfos as $userInfo){
        var_dump($userInfo);
    };?>
    <div class="row">
        <div class="col-md-2 col-no-border"></div>
        <div class="col-md-8">
            <div class="col-md-12 col-no-border">
                <div class="col-md-2">
                    <img class="media-object img-circle" alt="64x64" src="<?php echo base_url()?>assets/img/comments/01.jpg" style="width: 64px; height: 64px;">
                </div>
                <div class="col-md-10">
                    <h2><?php echo "aze";?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-no-border"></div>
    </div>
</div>