<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <title> ERP管理系统 </title>
        <link rel="icon" href="favicon.ico" type="image/ico">
        <meta name="keywords" content="LightYear,光年,后台模板,后台管理系统,光年HTML模板">
        <meta name="description" content="LightYear是一个基于Bootstrap v3.3.7的后台管理系统的HTML模板。">
        <link href="/static/css/bootstrap.min.css" rel="stylesheet">
        <link href="/static/css/materialdesignicons.min.css" rel="stylesheet">
        <link href="/static/css/style.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="lyear-layout-web">
            <div class="lyear-layout-container">
                <!--左侧导航-->
                <aside class="lyear-layout-sidebar">

                    <!-- logo -->
                    <div id="logo" class="sidebar-header">
                        <a href="/"><img src="/static/images/cc.jpg" title="LightYear" alt="LightYear" /></a>
                    </div>
                    <div class="lyear-layout-sidebar-scroll"> 

                        <nav class="sidebar-main">
                            <ul class="nav nav-drawer">
                                <li class="nav-item active"> <a href="/"><i class="mdi mdi-home"></i> 后台首页</a> </li>
                                <?php
                                    $menu = getmenu();
                                    foreach ($menu as $value) {
                                ?>
                                <li class="nav-item nav-item-has-subnav <?php if(in_array($this->router->class,explode('|',$value['model']))){?>open<?php }?>">
                                    <a href="javascript:void(0)"><i class="mdi <?=$value['action']?>"></i><?=$value['name']?></a>
                                    <?php if(isset($value['child'])){ ?>
                                    <ul class="nav nav-subnav">
                                        <?php
                                            foreach ($value['child'] as $val) {
                                        ?>
                                        
                                        <li <?php if($this->router->class==$val['model']&&$val['action']==$this->router->method){?>class="active"<?php }?>> <a href="<?php echo base_url($val['model']."/".$val['action']);?>"><?=$val['name']?></a> </li>
                                        
                                        <?php }?>
                                    </ul>
                                    <?php }?>
                                </li>
                                <?php }?>

                            </ul>
                        </nav>
                    </div>

                </aside>
                <!--End 左侧导航-->

                <!--头部信息-->
                <header class="lyear-layout-header">

                    <nav class="navbar navbar-default">
                        <div class="topbar">

                            <div class="topbar-left">
                                <div class="lyear-aside-toggler">
                                    <span class="lyear-toggler-bar"></span>
                                    <span class="lyear-toggler-bar"></span>
                                    <span class="lyear-toggler-bar"></span>
                                </div>
                            </div>

                            <ul class="topbar-right">

                                <li> <a href="/login/loginout"><i class="mdi mdi-logout-variant"></i> 退出</a> </li>
                                <li class="">
									<?php if($this->session->userdata('admin_user_info')){?>
                                    用户名[<span style="color:#33cabb"><?php echo $this->session->userdata('admin_user_info')['username'] ?></span>]
									<?php }?>
                                </li>

                            </ul>

                        </div>
                    </nav>

                </header>
