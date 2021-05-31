<?php $this->load->view('layout/public'); ?>
<main class="lyear-layout-content">

	<div class="container-fluid">

		<div class="row">
			<div class="col-md-6">
				<div class="card">

					<div class="card-body">

                        <span class="form-horizontal" action="#" method="post" enctype="multipart/form-data" onsubmit="return false;">

                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">用户名</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="username" name="username" placeholder="用户名">
                                </div>
                            </div>
							 <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">密码</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="password" id="password" name="password" placeholder="密码">
                                </div>
                            </div>
							 <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">姓名</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="realname" name="realname" placeholder="姓名">
                                </div>
                            </div>
							<div class="form-group">
                                <label class="col-xs-12" for="example-email-input">手机</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="mobile" name="mobile" placeholder="手机">
                                </div>
                            </div>
							 <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">所属部门</label>
                                <div class="col-xs-12">

									<select class="form-control" id="roleid" name="roleid">
										<?PHP foreach ($departinfo as $k=>$v){?>
											<OPTION value="<?=$v['roleid']?>"><?=$v['chinesename']?></OPTION>
										<?php } ?>

									</select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12">状态</label>
                                <div class="col-xs-12">
                                    <div class="radio">
                                        <label for="example-radio1">
                                            <label class="radio-inline" for="example-inline-radio2">
                                                <input type="radio" id="" name="ipallow" value="1" checked>
                                                开启
                                            </label>
                                            <label class="radio-inline" for="example-inline-radio2">
                                                <input type="radio" id="" name="ipallow" value="0">
                                                关闭
                                            </label>
                                        </label>
                                    </div>


                                </div>
                            </div>


                        </span>

					</div>
				</div>
			</div>
		</div>

</main>
