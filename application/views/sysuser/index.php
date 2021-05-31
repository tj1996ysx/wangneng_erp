<?php $this->load->view('layout/header'); ?>
<link rel="stylesheet" href="/static/extend/css/layui.css"  media="all">
<main class="lyear-layout-content">

	<div class="container-fluid">

		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header"><h4>人员管理</h4></div>
					<div class="card-body">

						<div class="table-responsive">
							<div class="layui-btn-container">
								<?php if(checkrole("sysuser","add")){?>
									<button class="layui-btn layui-btn-sm add">添加</button>
								<?php } ?>

							</div>
							<table class="layui-hide" id="test" lay-filter="test"></table>

						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

</main>
<script src="/static/extend/layui.js" charset="utf-8"></script>

<script type="text/html" id="barDemo">
	<?php if(checkrole("sysuser","edit")){?>
	<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
	<?php } ?>
	<?php if(checkrole("sysuser","del")){?>
	<!-- <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a> -->
	<?php } ?>
</script>

<script>

	layui.use(['table'], function() {
		var table = layui.table;


		$('.add').on('click', function() {
			layer.open({
				type: 2,
				title: '添加',
				maxmin: true,
				shadeClose: true, //点击遮罩关闭层
				area: ['800px', '520px'],
				btn: ['确认', '关闭'],
				content: '<?php echo base_url("sysuser/add"); ?>',
				yes: function(index, layero) {
					var param = {};
					var frame = layer.getChildFrame('body', index);
					var username = frame.find("#username").val();
					var password = (frame.find("#password").val());
					var realname = frame.find("#realname").val();
					var mobile = frame.find("#mobile").val();
					var roleid = frame.find("#roleid").val();
					var ipallow = frame.find('input:radio[name="ipallow"]:checked').val();
					var createtime = frame.find("#createtime").val();
 					param.username = username;
 					param.ipallow = ipallow;
					param.password = password;
					param.realname = realname;
					param.mobile = mobile;
					param.roleid = roleid;

					param.createtime = createtime;
					$.ajax({
						type: "POST",
						url: '<?php echo base_url("sysuser/add"); ?>',
						dataType: "json",
						async: false,
						data: param,
						success: function(data) {
							if (data.code == 0) {
								layer.close(index);
								layer.msg(data.msg, {
									icon: 1,
									time: 2000 //2秒关闭（如果不配置，默认是3秒）
								}, function() {
									location.reload();//重载父页表格，参数为表格ID
								});
							} else {

								layer.msg(data.msg, {icon: 5});
								layer.close(index);
							}
						}
					});
				},
			});
		});
		table.render({
			elem: '#test'
			, url: '<?php echo base_url("sysuser/index"); ?>',

			height: 650
			, cols: [[
				{field: 'username', title: '用户名', width: '15%', },
				{field: 'realname', title: '姓名', width: '15%', },
				{field: 'mobile', title: '手机', width: "15%"},
				{field: 'rolename', title: '所属部门', width: '15%', },
				
				{field: 'ipallow', title: '状态', width: "10%", templet: function(res) {
                            if (res['ipallow'] == 1) {
                                return '<button type="button" class="layui-btn layui-btn-xs">开启</button>';
                            } else if (res['ipallow'] == 0) {
                                return '<button type="button" class="layui-btn layui-btn-xs layui-btn-danger">关闭</button>';
                            } 
                        }
                    },
				{field: 'createtime', title: '创建时间', width: "15%"},
				{fixed: 'right', title: '操作', toolbar: '#barDemo', width: "15%"},
			]]
			, page: false
		});
		$("#zk").click(function() {
			treetable.expandAll("#test");
		})

		$("#zd").click(function() {
			treetable.foldAll("#test");
		})


		//监听行工具事件
		table.on('tool(test)', function(obj) {
			var data = obj.data;

			if (obj.event === 'del') {
				layer.confirm('真的删除行么', function(index) {
					$.ajax({
						url: '<?php echo base_url("sysuser/del"); ?>',
						type: "POST",
						data: {"userid": data.userid},
						dataType: "json",
						success: function(data) {
							if (data.code == "0") {

								obj.del();
								layer.close(index);
								layer.msg(data.msg, {
									icon: 1,
									time: 2000 //2秒关闭（如果不配置，默认是3秒）
								}, function() {
									location.reload();//重载父页表格，参数为表格ID
								});

							} else {
								layer.msg(data.msg, {icon: 5});
								layer.close(index);
							}
						}


					});
				});
			} else if (obj.event === 'edit') {
				layer.open({
					type: 2,
					title: '编辑',
					maxmin: true,
					shadeClose: true, //点击遮罩关闭层
					area: ['800px', '520px'],
					btn: ['确认', '关闭'],
					content: '<?php echo base_url("sysuser/edit"); ?>' + '?userid=' + data.userid,
					yes: function(index, layero) {
						var param = {};
						var frame = layer.getChildFrame('body', index);
						var username = frame.find("#username").val();
						var realname = frame.find("#realname").val();
						var roleid = frame.find("#roleid").val();
						var password = frame.find("#password").val();
						var mobile = frame.find("#mobile").val();
						var userid = frame.find("#userid").val();
						var ipallow = frame.find('input:radio[name="ipallow"]:checked').val();
						param.ipallow = ipallow;
						param.username = username;
						param.password = password;
						param.roleid = roleid;
						param.realname = realname;
						param.mobile = mobile;
						param.userid = userid;
						$.ajax({
							type: "POST",
							url: '<?php echo base_url("sysuser/edit"); ?>',
							dataType: "json",
							async: false,
							data: param,
							success: function(data) {
								console.log(data)
								if (data.code == 0) {
									layer.close(index);
									layer.msg(data.msg, {
										icon: 1,
										time: 2000 //2秒关闭（如果不配置，默认是3秒）
									}, function() {
										location.reload();//重载父页表格，参数为表格ID
									});
								} else {

									layer.msg(data.msg, {icon: 5});
									layer.close(index);
								}
							}
						});
					},
				});
			}
		});
	});
</script>

<?php $this->load->view('layout/footer'); ?>
