<?php $this->load->view('layout/header'); ?>
<?php $this->load->view('layout/public'); ?>
<main class="lyear-layout-content">
    <style>
        .cate-box{margin-bottom: 15px;padding-bottom:10px;border-bottom: 1px solid #f0f0f0}
        .cate-box dt{margin-bottom: 10px;}
        .cate-box dt .cate-first{padding:10px 20px}
        .cate-box dd{padding:0 50px}
        .cate-box dd .cate-second{margin-bottom: 10px}
        .cate-box dd .cate-third{padding:0 40px;margin-bottom: 10px}
    </style>
    <div class="container-fluid">

        <div class="row">
            <div class="layui-card-header layuiadmin-card-header-auto">
            <h3>角色 【<?=$row['chinesename']?>】分配权限</h3>
        </div>
            <div class="layui-card-body layui-form">
                <!--<form action="<?php echo base_url('depart/editrole')?>" method="post" class="layui-form">-->    
                    <input type="hidden" id="roleid" value="<?=$id?>">
                    <?php foreach($role as $first){?>
                    <dl class="cate-box">
                        <dt>
                        <div class="cate-first"><input id="menu<?=$first['id']?>" type="checkbox" name="permissions" value="<?=$first['id']?>" title="<?=$first['name']?>" lay-skin="primary"  <?=$first['own']?>></div>
                        </dt>
                        <?php if(isset($first['_child'])){?>
                            <?php foreach($first['_child'] as $second){?>
                                <dd>
                                    <div class="cate-second"><input id="menu<?=$first['id']?>-<?=$second['id']?>" type="checkbox" name="permissions" value="<?=$second['id']?>" title="<?=$second['name']?>" lay-skin="primary" <?=$second['own']?>></div>
                                    <?php if(isset($second['_child'])){?>
                                        <div class="cate-third">
                                            <?php foreach($second['_child'] as $thild){?>
                                                <input type="checkbox" id="menu<?=$first['id']?>-<?=$second['id']?>-<?=$thild['id']?>" name="permissions" value="<?=$thild['id']?>" title="<?=$thild['name']?>" lay-skin="primary" <?=$thild['own']?>>
                                             <?php }?>
                                        </div>
                                    <?php }?>
                                </dd>
                            <?php }?>
                       <?php }?>
                    </dl>
                   <?php }?>
                    <div class="layui-form-item">
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="*">确 认</button>
                    </div>
                <!--</form>-->
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;

            form.on('checkbox', function (data) {
                var check = data.elem.checked;//是否选中
                var checkId = data.elem.id;//当前操作的选项框
                if (check) {
                    //选中
                    var ids = checkId.split("-");
                    if (ids.length == 3) {
                        //第三极菜单
                        //第三极菜单选中,则他的上级选中
                        $("#" + (ids[0] + '-' + ids[1])).prop("checked", true);
                        $("#" + (ids[0])).prop("checked", true);
                    } else if (ids.length == 2) {
                        //第二季菜单
                        $("#" + (ids[0])).prop("checked", true);
                        $("input[id*=" + ids[0] + '-' + ids[1] + "]").each(function (i, ele) {
                            $(ele).prop("checked", true);
                        });
                    } else {
                        //第一季菜单不需要做处理
                        $("input[id*=" + ids[0] + "-]").each(function (i, ele) {
                            $(ele).prop("checked", true);
                        });
                    }
                } else {
                    //取消选中
                    var ids = checkId.split("-");
                    if (ids.length == 2) {
                        //第二极菜单
                        $("input[id*=" + ids[0] + '-' + ids[1] + "]").each(function (i, ele) {
                            $(ele).prop("checked", false);
                        });
                    } else if (ids.length == 1) {
                        $("input[id*=" + ids[0] + "-]").each(function (i, ele) {
                            $(ele).prop("checked", false);
                        });
                    }
                }
                form.render();
            });
        })
        layui.use('form', function() {
        var $ = layui.jquery,
                form = layui.form;
        form.on('submit(*)', function(data) {
            //仓库
            var str = "";
            $("input[name='permissions']").each(function() { //由于复选框一般选中的是多个,所以可以循环输出 
                if ($(this).prop("checked")) {
                    str += $(this).val() + ",";
                }

            });
            if (str == "") {
                layer.msg("请选择权限", {icon: 5});
                return false;
            }
           
            var roleid = $('#roleid').val();
            
            var param = {permissions:str,roleid: roleid};
            $.ajax({
                type: "POST",
                url: '<?php echo base_url('depart/editrole')?>',
                dataType: "json",
                async: false,
                data: param,
                success: function(data) {
                    if (data.code == 0) {
                        layer.msg(data.msg, {icon: 1, time: 3000}, function() {
                            location.href = '<?php echo base_url("depart/index"); ?>'
                        });                 
                    } else {
                        layer.msg(data.msg, {icon: 5})
                    }
                }
            });

        });
    })
    </script>
<?php $this->load->view('layout/footer'); ?>
