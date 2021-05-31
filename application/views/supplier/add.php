<?php $this->load->view('layout/header'); ?>
<?php $this->load->view('layout/public'); ?>


<main class="lyear-layout-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header"><h4>添加/编辑供应商</h4></div>  
                        <div class="card-body">
                        <span class="form-horizontal layui-form" action="#" method="post" enctype="multipart/form-data" onsubmit="return false;">
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">供应商名称</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="suppliername" name="suppliername" value="<?=$row['suppliername']?>" lay-verify="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">访问路径</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="url" name="url" value="<?=$row['url']?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">地址</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="address" name="address"  value="<?=$row['address']?>" >
                                </div>
                            </div>
                            <div class="form-group" id="area-picker">
                                <label class="col-xs-12" for="example-email-input">所在省/市</label>
                                <div class="layui-form-item col-xs-12" id="area-picker"> 
                                    <div class="layui-input-inline" style="width: 200px;">
                                        <select name="province" class="province-selector"  data-value="<?=$row['province']?>" lay-filter="province-1">
                                            <option value="">请选择省</option>
                                        </select>
                                    </div>
                                    <div class="layui-input-inline" style="width: 200px;">
                                        <select name="city" class="city-selector" data-value="<?=$row['city']?>" lay-filter="city-1">
                                            <option value="">请选择市</option>
                                        </select>
                                    </div>     
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">联系人</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="phone" name="contactsname"  value="" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">联系电话</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="mobile" name="mobile"  value="<?=$row['mobile']?>" >
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
                            location.href="/supplier/index";
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