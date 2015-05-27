<?php
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 27/05/15
 * Time: 15:54
 */?>
<div class="bp-docs-section">
    <div class="row">
        <div class="col-md-12 title-section">
            <h1 id="forms">Les modules</h1>
            <?php if($module!=""): ?>
                <?php echo $module;?>
            <?php endif; ?>
            <?php if(count($teacher)>0):?>
                <?php echo $teacher[0]['nom']." ".$teacher[0]['prenom'];?>
            <?php endif?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-no-border"></div>
        <div class="col-md-8">
            <div class="col-md-12 col-no-border">
                <?php echo form_open('modules/displayModule')?>
                <div class="col-md-6 col-no-border">
                    <label for="selectModule" class="control-label">Selectionnez un module</label>
                    <select name="module" class="form-control" id="selectModule">
                        <?php if($module!=""): ?>
                            <option value="<?php echo $module;?>"><?php echo $module;?></option>
                            <option value="">...</option>
                        <?php else: ?>
                            <option value="">...</option>
                        <?php endif?>
                        <?php foreach($modules as $module):?>
                            <option value="<?php echo $module['ident'];?>"><?php echo $module['ident'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="col-md-6 col-no-border">
                    <label for="selectTeacher" class="control-label">Selectionnez un enseignant</label>
                    <select name="teacher" class="form-control" id="selectTeacher">
                        <?php if(count($teacher)>0): ?>
                            <option value="<?php echo $teacher[0]['login'];?>"><?php echo $teacher[0]['nom']." ".$teacher[0]['prenom'];?></option>
                            <option value="">...</option>
                        <?php else: ?>
                            <option value="">...</option>
                        <?php endif?>
                        <?php foreach($enseignants as $teacher):?>
                            <option value="<?php echo $teacher['login'];?>"><?php echo $teacher['nom']." ".$teacher['prenom'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="col-md-8 col-no-border"></div>
                <div class="col-md-4 col-no-border">
                    <?php echo form_button("reset","reset",'id="resetFormSearch" class="btn btn-info"');?>
                    <?php echo form_submit('submit','valider','class="btn btn-success"')?>
                </div>
                <?php echo form_close()?>
            </div>

        </div>
        <div class="col-md-2 col-no-border"></div>
    </div>
    <?php if(count($result)>0):?>
    <div class="row">
        <div class="col-md-2 col-no-border"></div>
        <div class="col-md-8 col-no-border">
            <?php foreach($result as $val):?>
                <div class="col-md-4 col-no-border bp-component">
                    <div class="list-group">
                        <a href="#" class="list-group-item <?php if(!$val['enseignant']){echo "module-not-taken";}?>">
                            <h4 class="list-group-item-heading"><?php echo $val['module'];?></h4>
                            <ul class="list-group">
                                <li class='list-group-item'>
                                    <?php echo $val['type']?>
                                </li>
                                <li class="list-group-item">
                                    <span class="badge"><?php echo $val['hed']?></span>
                                    Heure d'enseignement :
                                </li>
                                <li class="list-group-item">
                                    <?php if($val['enseignant'])
                                        echo $val['enseignant'];
                                    else
                                        echo "Pas d'enseignant";?>
                                </li>
                            </ul>

                        </a>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
        <div class="col-md-2 col-no-border"></div>
    </div>
    <?php endif;?>
</div>