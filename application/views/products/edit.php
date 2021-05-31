<?php $this->load->view('layout/header'); ?>
<?php $this->load->view('layout/public'); ?>
<script type="text/javascript">
    //全局定义一次, 加载formSelects
    layui.config({
        base: '/static/extend/lay/modules/' //此处路径请自行处理, 可以使用绝对路径
    }).extend({
        // formSelects: 'formSelects-v4'
    });
   
</script>
<style type="text/css">
    .layui-upload-img{
        width: 92px;
        height: 92px;
        margin: 0 10px 10px 0;
    }
    .layui-elem-quote{height: 250px}
    .layui-upload-img { width: 190px; height: 190px; margin: 0; }
    .pic-more { width:100%; left; margin: 10px 0px 0px 0px;}
    .pic-more li { width:190px; float: left; margin-right: 5px;}
    .pic-more li .layui-input { display: initial;}
    .pic-more li a { position: absolute; top: 0; display: block; }
    .pic-more li a i { font-size: 24px; background-color: #008800; }   
    #slide-pc-priview .item_img img{ width: 190px; height: 190px;}
    #slide-pc-priview li{position: relative;}
    #slide-pc-priview li .operate{ color: #000; display: none;}
    #slide-pc-priview li .toleft{ position: absolute;top: 90px; left: 1px; cursor:pointer;}
    #slide-pc-priview li .toright{ position: absolute;top: 90px; right: 1px;cursor:pointer;}
    #slide-pc-priview li .close{position: absolute;top: 5px; right: 5px;cursor:pointer;}
    #slide-pc-priview li:hover .operate{ display: block;}   
</style>
<main class="lyear-layout-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h4>添加产品</h4></div>    
                    <div class="card-body">

                        <form action="#" method="post" class="form-horizontal layui-form" onsubmit="return false;">

                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">产品名称</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" name="productname" id="productname"
                                           lay-verify="required" placeholder="产品名称" value="<?=$productname?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">最低投资币数</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="lowcoin" name="lowcoin"
                                           lay-verify="required|keep_number|number" placeholder="最多保留四位小数" value="<?=$lowcoin?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">最低收益百分比</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="lowprofit" name="lowprofit"
                                           lay-verify="required|keep_number|profit|number" placeholder="最多保留四位小数且不能大于最高收益" value="<?=$lowprofit?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">最高收益百分比</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="highprofit" name="highprofit"
                                           lay-verify="required|keep_number|profit|number" placeholder="最多保留四位小数且不能小于最低收益" value="<?=$highprofit?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">投资周期(天)</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="number" name="productcycle" id="productcycle"
                                           placeholder="不能小于0" lay-verify="required|positive_integer" value="<?=$productcycle?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">截止时间</label>
                                <div class="col-xs-12">
                                    <input type="text" name="deadlinetime" id="deadlinetime" value="<?=$deadlinetime?>" lay-verify="required" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">启用状态</label>
                                <div class="col-xs-12">
                                    <select name="status" id="status" lay-verify="required" autocomplete="off">
                                        <option value="1">正常</option>
                                        <option value="0">未启用</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <button class="layui-btn" lay-submit="" lay-filter="*">提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>   
        </div>

</main>
<script>
    layui.use(['form','jquery','laydate'], function() {
        var $ = layui.jquery,
                form = layui.form;
                laySku = layui.laySku;
                table = layui.table;
                server = layui.server;
                laydate = layui.laydate;

        var select1 = 'dd[lay-value=' + <?=$status?> + ']';
        $('#status').siblings("div.layui-form-select").find('dl').find(select1).click();
        laydate.render({
            trigger: 'click',
            elem: '#deadlinetime',
            type:'datetime',
            format:'yyyy-MM-dd HH:mm:ss'
        });

        form.verify({
            keep_number:function (value,item){
                if (!new RegExp("((^[1-9][0-9]{0,8})+(.?[0-9]{1,4})?$)|(^[0]+(.[0-9]{1,4})?$)").test(value)) {
                    return '请输入正数，且小数点后最多保留4位,可空';
                }
            },

            profit:function (value,item){
                let lowprofit = $("#lowprofit").val();
                let highprofit = $("#highprofit").val();
                if(lowprofit > highprofit){
                    return "最低收益百分比不能大于最高收益百分比";
                }
            },

            positive_integer:function (value,item){
                if(value <= 0){
                    return "投资周期不能小于或等于零天";
                }
            }
        });
        /**
         * 监听表单提交
         */
        form.on('submit(*)', function (data) {
            var state = Object.keys(data.field).some(function (item, index, array) {
                return item.startsWith('skus');
            });
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("products/edit").'/'.$productid; ?>',
                dataType: "json",
                data: data.field,
                success: function(data) {
                    if (data.code == 0) {
                        layer.msg(data.msg, {icon: 1, time: 3000}, function() {
                          window.location.href="/products/index";
                        });                 
                    } else {
                        layer.msg(data.msg, {icon: 5})
                    }
                }
            });
            return false;
        });



    

    })

    
    layui.use('upload', function() {
        var $ = layui.jquery
                , upload = layui.upload;

        //普通图片上传
        var uploadInst = upload.render({
            elem: '#test1'
            , url: '<?php echo base_url("Products/doupload"); ?>'
            , before: function(obj) {
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result) {
                    $('#demo1').attr('src', result); //图片链接（base64）
                });
            }
            , done: function(res) {
                //如果上传失败
                if (res.code > 0) {
                    return layer.msg('上传失败');
                } else {
                    $("#src").val(res.data.upload_data.full_path);
                }
                //上传成功
            }
            , error: function() {
                //演示失败状态，并实现重传
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function() {
                    uploadInst.upload();
                });
            }
        });
          //多图片上传
    });
   
  
</script>
<?php $this->load->view('layout/footer'); ?>