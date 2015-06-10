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
                                            <li class="list-group-item">
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
                                    <select name="module" class="form-control" id="selectModule">
                                        <?php if($module!=""): ?>
                                            <option value="<?php echo $module;?>"><?php echo $module;?></option>
                                            <option value="">Pas de module en particulier</option>
                                        <?php else: ?>
                                            <option value="">Pas de module en particulier</option>
                                        <?php endif;?>
                                        <?php foreach($modules as $module):?>
                                            <option value="<?php echo $module['ident'];?>"><?php echo $module['ident']." Promotion: ".$module['public'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div id="searchByPromo" class="<?php if($rechercheonglet=='module' || $rechercheonglet==null)echo  'customHide';?> col-md-4 col-no-border">
                                    <label for="selectPromotion" class="control-label">Promotion</label>
                                    <select name="prom" class="form-control" id="selectPromotion">
                                        <?php if($promSelected!="noProm"): ?>
                                            <option value="<?php echo $promSelected;?>"><?php echo $promSelected;?></option>
                                            <option value="noProm">Pas de promotion en particulier</option>
                                        <?php else:?>
                                            <option value="noProm">Pas de promotion en particulier</option>
                                        <?php endif;?>
                                        <?php foreach($allProm as $allProm):?>
                                            <option value="<?php echo $allProm;?>"><?php echo $allProm;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="col-md-4 col-no-border">
                                    <label for="selectTeacher" class="control-label">Enseignant</label>
                                    <select name="teacher" class="form-control" id="selectTeacher" <?php if($checked){echo 'disabled';} ?>>
                                        <?php if(count($teacher)>0 && $teacher!="no"): ?>
                                            <option value="<?php echo $teacher[0]['login'];?>"><?php echo $teacher[0]['nom']." ".$teacher[0]['prenom'];?></option>
                                            <option value="no">Pas d'enseignant en particulier</option>
                                        <?php else: ?>
                                            <option value="no">Pas d'enseignant en particulier</option>
                                        <?php endif?>
                                        <?php foreach($enseignants as $teacher):?>
                                            <option value="<?php echo $teacher['login'];?>"><?php echo $teacher['nom']." ".$teacher['prenom'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="col-md-4 col-no-border">
                                    <label for="selectSemester" class="control-label">Semestre</label>
                                    <select name="semester" class="form-control" id="selectSemester">
                                        <?php if($semSelected!="noSemester"): ?>
                                            <option value="<?php echo $semSelected;?>"><?php echo $semSelected;?></option>
                                            <option value="noSemester">Pas de semestre en particulier</option>
                                        <?php else:?>
                                            <option value="noSemester">Pas de semestre en particulier</option>
                                        <?php endif;?>
                                        <?php foreach($allSemesters as $allSemester):?>
                                            <option value="<?php echo $allSemester;?>"><?php echo $allSemester;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="col-md-12 col-no-border">
                                    <div class="col-md-4 col-no-border">
                                        <?php echo form_button("reset","reset",'id="resetFormSearch" class="btn btn-info"');?>
                                    </div>
                                    <div class="col-md-4 col-no-border">
                                        <label for="checkboxSansEnseignant">Sans enseignant</label>
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
                                    <li class="list-group-item">
                                        <?php if($val['enseignant'])
                                            echo $val['nom']." ".$val['prenom'];
                                        else
                                            echo '<a href="'.base_url().'index.php/modules/inscriptionModule?module='.$val['module'].'&partie='.$val['partie'].'"><button type="button" class="btn btn-warning">S\'inscrire</button></a>';?>
                                    </li>
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