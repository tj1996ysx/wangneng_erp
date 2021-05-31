<?php $this->load->view('layout/public'); ?>
<main class="lyear-layout-content">

	<div class="container-fluid">

		<div class="row">
			<div class="col-md-6">
				<div class="card">

					<div class="card-body">

                        <span class="form-horizontal" action="#" method="post" enctype="multipart/form-data" onsubmit="return false;">

                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">中文名称</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="chinesename" name="chinesename" placeholder="中文名称">
                                </div>
                            </div>
							 <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">英文名称</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="rolename" name="rolename" placeholder="英文名称">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">排序</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="orderno" name="orderno" placeholder="排序">
                                </div>
                            </div>


                        </span>

					</div>
				</div>
			</div>
		</div>

</main>
