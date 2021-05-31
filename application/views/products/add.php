<?php $this->load->view('layout/header'); ?>
<?php $this->load->view('layout/public'); ?>
    <script type="text/javascript" charset="utf-8" src="/static/extend/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/static/extend/ueditor/ueditor.all.min.js"></script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="/static/extend/ueditor/lang/zh-cn/zh-cn.js"></script>
    <!-- <link rel="stylesheet" href="/static/extend/dist/formSelects-v4.css" /> -->
    <script type="text/javascript">
        //全局定义一次, 加载formSelects
        layui.config({
            base: '/static/extend/lay/modules/' //此处路径请自行处理, 可以使用绝对路径
        }).extend({
            // formSelects: 'formSelects-v4'
        });

    </script>
    <style type="text/css">
        .pic-more li {
            width: 190px;
            float: left;
            margin-right: 5px;
        }

        .pic-more li .layui-input {
            display: initial;
        }

        .pic-more li a {
            position: absolute;
            top: 0;
            display: block;
        }

        .pic-more li a i {
            font-size: 24px;
            background-color: #008800;
        }

        #slide-pc-priview .item_img img {
            width: 190px;
            height: 190px;
        }

        #slide-pc-priview li {
            position: relative;
        }

        body {
            style="overflow-y:hidden";
        }

        .form-group {
            width: 50%;
        }
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
                                               lay-verify="required" placeholder="产品名称">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12" for="example-email-input">最低投资币数</label>
                                    <div class="col-xs-12">
                                        <input class="form-control" type="text" id="lowcoin" name="lowcoin"
                                               lay-verify="required|keep_number|number" placeholder="最多保留三位小数">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12" for="example-email-input">最低收益百分比</label>
                                    <div class="col-xs-12">
                                        <input class="form-control" type="text" id="lowprofit" name="lowprofit"
                                               lay-verify="required|keep_number|profit|number" placeholder="最多保留三位小数且不能大于最高收益">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12" for="example-email-input">最高收益百分比</label>
                                    <div class="col-xs-12">
                                        <input class="form-control" type="text" id="highprofit" name="highprofit"
                                               lay-verify="required|keep_number|profit|number" placeholder="最多保留三位小数且不能小于最低收益">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12" for="example-email-input">投资周期(天)</label>
                                    <div class="col-xs-12">
                                        <input class="form-control" type="number" name="productcycle" id="productcycle"
                                               placeholder="不能小于0" lay-verify="required|positive_integer">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12" for="example-email-input">截止时间</label>
                                    <div class="col-xs-12">
                                        <input type="text" name="deadlinetime" id="deadlinetime" lay-verify="required" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12" for="example-email-input">启用状态</label>
                                    <div class="col-xs-12">
                                        <select name="status" xm-select="select14"  lay-verify="required">
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
        layui.use(['form', 'jquery','laydate'], function () {
            var $ = layui.jquery,
                form = layui.form;
            laySku = layui.laySku;
            table = layui.table;
            server = layui.server;
            laydate = layui.laydate;
            laydate.render({
                trigger: 'click',
                elem: '#deadlinetime',
                type:'datetime',
                // format:'yyyy-MM-dd HH:mm:ss',
                btns: ['clear', 'confirm']
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
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url("products/add"); ?>',
                    dataType: "json",
                    data: data.field,
                    success: function (data) {
                        if (data.code == 0) {
                            layer.msg(data.msg, {icon: 1, time: 3000}, function () {
                                window.location.href = "/products/index";
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