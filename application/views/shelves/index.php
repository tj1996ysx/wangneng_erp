<?php $this->load->view('layout/header'); ?>
<link rel="stylesheet" href="/static/extend/css/layui.css"  media="all">

<main class="lyear-layout-content">

    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><h4><?=$menuname?></h4></div>
                    <div class="card-body">
                         <form class="form-inline" action="/products/index" method="post" onsubmit="return false;">
                                <div class="form-group">
                                    <label class="" for="example-if-email">货架名称</label>
                                    <input class="form-control" type="text"   id="shelvesname" placeholder="货架名称">
                                </div>
                                <div class="form-group">
                                    <label class="" for="example-if-email">所属仓库</label>
                                    <select class="form-control" id="wid"  size="1" lay-verify="required">
                                        <option value="">--请选择所属仓库--</option>
                                        <?php foreach ($list as $key => $val) { ?>
                                            <option value="<?= $val['wid'] ?>"><?= $val['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                    
                                </div>
                                <div class="form-group">
                                    <label class="" for="example-if-password">状态</label>
                                    <select class="form-control" id="status"  size="1">
                                        <option value="0">--全部--</option>
                                        <option value="1">启用</option>
                                        <option value="2">禁用</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button class="btn layui-btn" type="submit" id="searchBtn">查询</button>
                                </div>
                            </form>
                        <div class="table-responsive">
                            
                            <table class="layui-hide" id="test" lay-filter="test"></table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</main>

<script src="/static/extend/layui.js" charset="utf-8"></script>
<script type="text/html" id="toolbarDemo">
  <div class="layui-btn-container">
    <?php if(checkrole("shelves","add")){?>
        <button class="layui-btn layui-btn-sm" lay-event="add">添加货架</button>
    <?php }?>
  </div>
</script>

<script>
    layui.config({
        base: '/static/extend/'
    }).extend({
        treetable: 'treetable-lay/treetable',
    });
    layui.use(['table', 'treetable','upload'], function() {
        var table = layui.table;
        var $ = layui.jquery,upload = layui.upload;
        var treetable = layui.treetable;

        var dataTable=table.render({
            elem: '#test',
            url: '<?php echo base_url("shelves/index"); ?>',
            height: 700,
            size:'sm',
            toolbar: '#toolbarDemo',
            cols: [[
                    {field: 'id', title: 'ID',},
                    {field: 'shelvesname', title: '货架名称' },
                    {field: 'name', title: '所属仓库' },                 
                    {field: 'addtime', title: '添加时间'},
                    {field: 'remark', title: '备注' },
                    
                    {field: 'status', title: '状态', templet:function(res){
                        if(res['status']==1){
                            return '<a class="layui-btn layui-btn-xs">启用</a>';
                        }else if(res['status']==2){
                            return '<a class="layui-btn layui-btn-xs layui-btn-danger" >禁用</a>';
                        }
                    }},
                    {fixed: 'right', title: '操作' ,templet:function(res){
                         <?php if(checkrole("shelves","add")){?>
                            return '<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>';
                        <?php 
                       }?>
                    }},
                ]]
            , page: true
        });
         table.on('toolbar(test)', function(obj){
            var checkStatus = table.checkStatus(obj.config.id);
            if(obj.event=="add"){
                location.href='<?php echo base_url("shelves/add"); ?>'
            }
            
        });
        $("#searchBtn").click(function () {
            var shelvesname = $("#shelvesname").val()
            var wid = $("#wid").val();
            var status = $("#status").val();
            dataTable.reload({
                where:{shelvesname:shelvesname,wid:wid,status:status},
                page:{curr:1}
        })
    })
        //监听行工具事件
        table.on('tool(test)', function(obj) {
            var data = obj.data;
            if (obj.event === 'edit') {
                    location.href='<?php echo base_url("shelves/add"); ?>/'+data.id;
            }
        });
    });
     
</script>

<?php $this->load->view('layout/footer'); ?>
