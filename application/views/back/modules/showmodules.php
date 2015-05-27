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
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-no-border"></div>
        <div class="col-md-8">
            <div class="col-md-12 col-no-border">
                <?php echo form_open()?>
                <div class="col-md-6 col-no-border">
                    <label for="selectModule" class="control-label">Selectionnez un module</label>
                    <select name="module" class="form-control" id="selectModule">
                        <?php foreach($modules as $module):?>
                            <option value="<?php echo $module['ident'];?>"><?php echo $module['ident'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="col-md-6 col-no-border">
                    <label for="selectTeacher" class="control-label">Selectionnez un enseignant</label>
                    <select name="teacher" class="form-control" id="selectTeacher">
                        <?php foreach($enseignants as $teacher):?>
                            <option value="<?php echo $teacher['login'];?>"><?php echo $teacher['nom']." ".$teacher['prenom'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="col-md-10 col-no-border"></div>
                <div class="col-md-2 col-no-border">
                    <?php echo form_submit('submit','valider','class="btn btn-success"')?>
                </div>
                <?php echo form_close()?>
            </div>

        </div>
        <div class="col-md-2 col-no-border"></div>

    </div>
</div>