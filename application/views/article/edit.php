<?php $this->load->view('layout/public'); ?>
    <script type="text/javascript" charset="utf-8" src="/static/extend/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/static/extend/ueditor/ueditor.all.min.js"></script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="/static/extend/ueditor/lang/zh-cn/zh-cn.js"></script>
    <main class="lyear-layout-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body" style="height: 100%">
                            <form class="form-horizontal layui-form" id="refund" action="#" method="post"
                                  enctype="multipart/form-data" onsubmit="return false;">
                                <div class="form-group">
                                    <label class="col-xs-12" for="example-email-input">标题</label>
                                    <div class="col-xs-12">
                                        <input class="form-control" type="text" id="title" name="title"
                                               lay-verify="required" value="<?=$title?>" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12" for="example-email-input">描述</label>
                                    <div class="col-xs-12">
                                        <textarea name="content" id="content" type="text/plain"
                                                  style="width:100%;height:500px;"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <button class="layui-btn hidden" id="article_edit" lay-submit
                                                lay-filter="article_edit">提交
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
    </main>
    <script>
        //配置插件目录
        layui.config({
            base: '/static/extend/mods/'
            , version: '1.0'
        });
        var ue = UE.getEditor('content');
        layui.use(['layer', 'form'], function () {
            var $ = layui.jquery,
                form = layui.form;
            UE.getEditor('content').setContent('<?=$content?>');
            // ue.addListener("ready", function () {
            //     // editor准备好之后才可以使用
            //
            // });
            form.on('submit(article_edit)', function (data) {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url("article/edit") . '/' . $articleid; ?>',
                    dataType: "json",
                    async: false,
                    data: data.field,
                    success: function (data) {
                        var index = parent.layer.getFrameIndex(window.name);
                        if (data.code == 0) {
                            layer.msg(data.msg, {icon: 1, time: 3000}, function () {
                                parent.layer.close(index);
                            });
                        } else {
                            layer.msg(data.msg, {icon: 5, time: 3000}, function () {
                                parent.layer.close(index);
                            });
                        }
                    }
                });
            })
            return false;
        })


    </script>
<?php $this->load->view('layout/footer'); ?>