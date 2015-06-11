<?php
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 27/05/15
 * Time: 15:54
 */?>
<div class="bp-docs-section">
    <div class="row">
        <div class="col-md-1 col-no-border"></div>
        <div class="col-md-10 col-no-border ">
            <?php if(isset($msg)):?>
                <div class="alert alert-dismissable <?php if(isset($success)){ echo $success; } ?>">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <?php echo $msg; ?>
                </div>
            <?php endif;?>
            <div class="row custom-box">
                <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                    <li class='<?php if($onglet==null) echo "active";?>'><a id="displayMyModules" href="#mymodules" data-toggle="tab">Mes modules</a></li>
                    <li class='<?php if($onglet=="Recherche") echo "active";?>'><a href="#recherche" data-toggle="tab">Recherche</a></li>
                    <li class='<?php if($onglet=="Reporting") echo "active";?>'><a href="#reporting" data-toggle="tab">Reporting</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class='tab-pane fade <?php if($onglet==null) echo "active in"?>' id="mymodules">
                        <legend>Mes modules</legend>
                        <?php foreach($myModules as $val):?>
                            <div class="col-md-4 col-no-border bp-component">
                                <div class="list-group">
                                    <div class="list-group-item">
                                        <h4 class="list-group-item-heading">
                                            <?php echo $val['module'];?>
                                        </h4>
                                        <ul class="list-group">
                                            <li class='list-group-item'>
                                                <?php echo $val['partie'];?>
                                            </li>
                                            <li class='list-group-item'>
                                                <?php echo $val['public'];?>
                                            </li>
                                            <li class="list-group-item">
                                                <span class="badge">
                                                    <?php echo $val['hed'];?>
                                                </span>
                                                Heures :
                                            </li>
                                            <li class="list-group-item text-center">
                                                <?php echo '<a href="'.base_url().'index.php/modules/desinscriptionModule?module='.$val['module'].'&partie='.$val['partie'].'"><button type="button" class="btn btn-danger">Se désinscrire</button></a>';?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="tab-pane fade <?php if($onglet=="Recherche") echo "active in"?>" id="recherche">
                        <div class="row">
                            <legend>Rechercher un module</legend>
                            <div class="row">
                                <div class="auto-margin-menu-search">
                                    <ul class="nav nav-pills nav-custom">
                                        <li <?php if($rechercheonglet=='module' || $rechercheonglet==null)echo  'class="active"';?>><a href="#searchByModule" <?php if($rechercheonglet=='module' || $rechercheonglet==null)echo  'class="btn"';?>>Nom du module</a></li>
                                        <li <?php if($rechercheonglet=='promo')echo  'class="active"';?>><a href="#searchByPromo" <?php if($rechercheonglet=='promo')echo  'class="btn"';?>>Promotion</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <?php echo form_open('modules/displayModule')?>
                                <div id="searchByModule" class="<?php if($rechercheonglet=='promo')echo  'customHide ';?>col-md-4 col-no-border">
                                    <label for="selectModule" class="control-label">Module</label>
                                    <select name="module" data-placeholder="Pas de module en particulier..." class="form-control chosen-select-deselect" id="selectModule">
                                        <option value=""></option>
                                        <?php foreach($modules as $module):?>
                                            <option value="<?php echo $module['ident'];?>" <?php if(isset($moduleSelected) && $moduleSelected == $module['ident']) echo 'selected="selected"';?>><?php echo $module['ident']." Promotion: ".$module['public'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div id="searchByPromo" <?php if($rechercheonglet=='module' || $rechercheonglet==null)echo  'style="display:none;"';?> class="col-md-4 col-no-border">
                                    <label for="selectPromotion" class="control-label">Promotion</label>
                                    <select name="prom" data-placeholder="Pas de promotion en particulier..." class="form-control chosen-select-deselect" id="selectPromotion">
                                        <option value="noProm"></option>
                                        <?php foreach($allProm as $allProm):?>
                                            <option value="<?php echo $allProm;?>" <?php if(isset($promSelected) && $promSelected == $allProm) echo 'selected="selected"';?>><?php echo $allProm;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="col-md-4 col-no-border">
                                    <label for="selectTeacher" class="control-label">Enseignant</label>
                                    <p id="reveal-without-teacher" style="width: 100%;font-size: 13px;margin-bottom: 0px;line-height: 24px;" class="customHide">Sans enseignants</p>
                                    <select name="teacher" data-placeholder="Pas d'enseignant en particulier..." class="form-control chosen-select-deselect" id="selectTeacher" <?php if($checked){echo 'disabled';} ?>>
                                        <option value="no"></option>
                                        <?php foreach($enseignants as $teacher):?>
                                            <option value="<?php echo $teacher['login'];?>" <?php if(isset($teacherSelected) && $teacherSelected[0]['login'] == $teacher['login']) echo 'selected="selected"';?>><?php echo $teacher['nom']." ".$teacher['prenom'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="col-md-4 col-no-border">
                                    <label for="selectSemester" class="control-label">Semestre</label>
                                    <select name="semester" data-placeholder="Pas de semestre en particulier..." class="form-control chosen-select-deselect" id="selectSemester">
                                        <option value="noSemester"></option>
                                        <?php foreach($allSemesters as $allSemester):?>
                                            <option value="<?php echo $allSemester;?>" <?php if(isset($semSelected) && $semSelected == $allSemester) echo 'selected="selected"';?>><?php echo $allSemester;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="col-md-12 col-no-border">
                                    <div class="col-md-4 col-no-border">
                                        <?php echo form_button("reset","reset",'id="resetFormSearch" class="btn btn-info"');?>
                                    </div>
                                    <div class="col-md-4 col-no-border">
                                        <label for="checkboxSansEnseignant">Sans enseignants</label>
                                        <input type="checkbox" name="checkboxSansEnseignant" id="checkboxSansEnseignant" <?php if($checked) echo 'checked="checked"'?>/>
                                    </div>
                                    <div class="col-md-4 col-no-border text-right">
                                        <?php echo form_submit('submit','Rechercher','class="btn btn-success"')?>
                                    </div>
                                </div>
                                <div class="col-md-12 col-no-border">
                                    <div class="col-md-8 col-no-border">
                                        <label for="checkboxExport">Export & téléchargement resultat recherche, format .CVS</label>
                                        <input type="checkbox" name="checkboxExport" id="checkboxExport" <?php if($checked) echo 'exportChecked="checked"'?>/>
                                    </div>
                                    <div class="col-md-4 col-no-border text-right">
                                    </div>
                                </div>
                                <input type="text" name="searchType" hidden="hidden" value="<?php if($rechercheonglet)echo $rechercheonglet; else echo 'module';?>" id="searchType"/>
                                <?php echo form_close()?>
                            </div>
                        </div>
                    </div>
                    <div class='tab-pane fade <?php if($onglet=="Reporting") echo "active in"?>' id="reporting">
                        <legend>Reporting</legend>

                    </div>
                </div>
            </div>
        </div>
    <div class="col-md-1 col-no-border"></div>
    </div>
    <?php if(count($result)>0):?>
        <div class="row" id="modules_result">
            <div class="col-md-1 col-no-border"></div>
            <div class="col-md-10 col-no-border">
                <?php foreach($result as $val):?>
                    <div class="col-md-4 col-no-border bp-component">
                        <div class="list-group">
                            <div class="list-group-item <?php if(!$val['enseignant']){echo "module-not-taken";}?>">
                                <h4 class="list-group-item-heading"><?php echo $val['module'];?></h4>
                                <ul class="list-group">
                                    <li class='list-group-item'>
                                        <?php echo $val['partie']?>
                                    </li>
                                    <li class='list-group-item'>
                                        <?php echo $val['public']?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="badge"><?php echo $val['hed']?></span>
                                        Heures :
                                    </li>
                                    <?php if($val['enseignant']):?>
                                        <li class="list-group-item same-case">
                                            <?php echo $val['nom']." ".$val['prenom'];?>
                                        </li>
                                    <?php else: ?>
                                        <li class="list-group-item same-case text-center">
                                            <a href="<?php echo base_url();?>index.php/modules/inscriptionModule?module=<?php echo $val['module'];?>&partie=<?php echo $val['partie'];?>"><button type="button" class="btn btn-warning">S'inscrire</button></a>
                                        </li>
                                    <?php endif;?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-md-1 col-no-border"></div>
        </div>
    <?php endif;?>
</div>