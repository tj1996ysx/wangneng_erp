<?php $this->load->view('layout/header'); ?>
<?php $this->load->view('layout/public'); ?>


<main class="lyear-layout-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header"><h4>添加/编辑物流公司</h4></div>  
                        <div class="card-body">
                        <span class="form-horizontal layui-form" action="#" method="post" enctype="multipart/form-data" onsubmit="return false;">
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">物流公司名称</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="expressname" name="expressname" value="<?=$row['expressname']?>" lay-verify="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">简码</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="code" name="code"  value="<?=$row['code']?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">访问路径</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="url" name="url" value="<?=$row['url']?>">
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
    
  
    layui.use(['layer', 'form'], function() {
        var $ = layui.jquery,
                form = layui.form;
       
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
                            location.href="/express/index";
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