<?php $this->load->view('layout/public'); ?>
<main class="lyear-layout-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <span class="form-horizontal" action="#" method="post" enctype="multipart/form-data" onsubmit="return false;">
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">菜单名称</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="name" name="name" value='<?=$row['name']?>' placeholder="菜单名称">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-select">上级菜单</label>
                                <div class="col-xs-12">
                                    <select class="form-control" id="parent" name="parent" size="1">
                                        <option value="0">--请选择上级菜单--</option>
                                        <?php foreach ($list as $key => $val) { ?>
                                        <?php if($val['level']<2){?>
                                        <option value="<?= $val['id'] ?>" 
                                            <?php if($row['parent']==$val['id']){?>selected<?php }?>><?php echo str_repeat('|--', $val['level']); ?><?= $val['name'] ?>
                                                
                                        </option>
                                        <?php }?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">模块</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="model" name="model" value='<?=$row['model']?>' placeholder="模块">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">方法</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="action" name="action" value='<?=$row['action']?>' placeholder="方法">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">排序</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="sort" name="sort" value='<?=$row['sort']?>' placeholder="排序" value="999">
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label class="col-xs-12">状态</label>
                                <div class="col-xs-12">
                                    <div class="radio">
                                        <label for="example-radio1">
                                            <label class="radio-inline" for="example-inline-radio2">
                                                <input type="radio" id="" name="status" value="1" <?php if($row['status']==1){?>checked<?php }?>>
                                                开启
                                            </label>
                                            <label class="radio-inline" for="example-inline-radio2">
                                                <input type="radio" id="" name="status" value="0" <?php if($row['status']==0){?>ckkecked<?php }?>>
                                                关闭
                                            </label>
                                        </label>
                                    </div>


                                </div>
                            </div>
                            <input type="hidden" id='id' value="<?=$row['id']?>">
                        </span>

                    </div>
                </div>
            </div>   
        </div>

</main>
