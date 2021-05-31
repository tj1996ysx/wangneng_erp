<?php $this->load->view('layout/header'); ?>
<?php $this->load->view('layout/public'); ?>


<main class="lyear-layout-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header"><h4>添加/编辑货架</h4></div>  
                        <div class="card-body">
                        <span class="form-horizontal layui-form" action="#" method="post" enctype="multipart/form-data" onsubmit="return false;">
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">货架名称</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="shelvesname" name="shelvesname" value="<?=$row['shelvesname']?>" lay-verify="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">所属仓库</label>
                                <div class="col-xs-12">
                                    <select class="form-control" name="wid"  size="1" lay-verify="required">
                                        <option value="">--请选择所属仓库--</option>
                                        <?php foreach ($list as $key => $val) { ?>
                                            <option value="<?= $val['wid'] ?>" <?=$row['wid']==$val['wid']?"selected":""?>><?= $val['name'] ?><?=$val['status']==2?"(已关闭)":""?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">长度(cm)</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="number" id="length" name="length"  value="<?=$row['length']?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">宽度(cm)</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="number" id="width" name="width"  value="<?=$row['width']?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">高度(cm)</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="number" id="height" name="height"  value="<?=$row['height']?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">备注</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="remark" name="remark"  value="<?=$row['remark']?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12">状态</label>
                                <div class="col-xs-12">
                                    <div class="radio">
                                        <input type="radio" name="status" value="1" title="开启" <?php if(!$row||$row['status']==1){?>checked="checked"<?php }?>>
                                        <input type="radio" name="status" value="2" title="关闭" <?php if($row['status']==2){?>checked="checked"<?php }?>>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <button class="layui-btn" lay-submit lay-filter="*">提交</button>
                                </div>    
                            </div>
                        </span>

                    </div>
                </div>
            </div>   
        </div>

</main>
<script>
    //配置插件目录
    layui.config({
        base: '/static/extend/mods/'
        , version: '1.0'
    });
  
    layui.use(['layer', 'form', 'layarea'], function() {
        var $ = layui.jquery,
                form = layui.form,
                layarea = layui.layarea;
        layarea.render({
            elem: '#area-picker',

            change: function (res) {
                
                console.log(res);
            }
        });
        form.on('submit(*)', function(data) {
            var formData = data.field;
           
            $.ajax({
                type: "POST",
                url: '<?=$current_url?>',
                dataType: "json",
                async: false,
                data: formData,

                success: function(data) {
                    if (data.code == 0) {
                        layer.msg(data.msg, {icon: 1, time: 3000}, function() {
                            location.href="/shelves/index";
                        });                 
                    } else {
                        layer.msg(data.msg, {icon: 5})
                    }
                }
            });

        });

        form.render()
    })


</script>
<?php $this->load->view('layout/footer'); ?>