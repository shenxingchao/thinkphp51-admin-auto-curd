<?php /*a:7:{s:59:"E:\PHP\www\spladmin\application\admin\view\index\index.html";i:1545456153;s:52:"E:\PHP\www\spladmin\application\admin\view\main.html";i:1545453642;s:61:"E:\PHP\www\spladmin\application\admin\view\public\header.html";i:1545203001;s:60:"E:\PHP\www\spladmin\application\admin\view\public\aside.html";i:1545200659;s:62:"E:\PHP\www\spladmin\application\admin\view\public\content.html";i:1545454031;s:61:"E:\PHP\www\spladmin\application\admin\view\public\footer.html";i:1544769200;s:62:"E:\PHP\www\spladmin\application\admin\view\public\control.html";i:1544421234;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SplAdmin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="data:;base64,=">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/public/admin/plugins/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/public/admin/plugins/font-awesome/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/public/admin/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/public/admin/css/skins/_all-skins.min.css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="/public/admin/css/common.css">
</head>
<body class="hold-transition skin-blue sidebar-mini fixed sidebar-open">
<div class="wrapper">
    <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo url('index/index'); ?>" class="logo">
        <span class="logo-mini">Spl</span>
        <span class="logo-lg"><b>Spl</b>Admin</span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php if(app('session')->get('admin.head_image') != ''): ?><?php echo htmlentities(app('session')->get('admin.head_image')); else: ?>/public/admin/images/user2-160x160.jpg<?php endif; ?>"
                             class="user-image" alt="User Image">
                        <span class="hidden-xs">
                            <?php if(app('session')->get('admin.nickname') != ''): ?>
                                <?php echo htmlentities(app('session')->get('admin.nickname')); else: ?>
                                <?php echo htmlentities(app('session')->get('admin.username')); ?>
                            <?php endif; ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="<?php if(app('session')->get('admin.head_image') != ''): ?><?php echo htmlentities(app('session')->get('admin.head_image')); else: ?>/public/admin/images/user2-160x160.jpg<?php endif; ?>" class="img-circle" alt="User Image">
                            <p>
                                <?php if(app('session')->get('admin.nickname') != ''): ?>
                                    <?php echo htmlentities(app('session')->get('admin.nickname')); else: ?>
                                    <?php echo htmlentities(app('session')->get('admin.username')); ?>
                                <?php endif; ?>
                            </p>
                            <p><small>上次登录时间：<?php echo htmlentities(date('Y-m-d H:i:s',!is_numeric(app('session')->get('admin.login_time'))? strtotime(app('session')->get('admin.login_time')) : app('session')->get('admin.login_time'))); ?></small></p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">设置</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo url('User/logout'); ?>" class="btn btn-default btn-flat">退出</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
    <aside class="main-sidebar">
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php if(app('session')->get('admin.head_image') != ''): ?><?php echo htmlentities(app('session')->get('admin.head_image')); else: ?>/public/admin/images/user2-160x160.jpg<?php endif; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>
                    <?php if(app('session')->get('admin.nickname') != ''): ?>
                        <?php echo htmlentities(app('session')->get('admin.nickname')); else: ?>
                        <?php echo htmlentities(app('session')->get('admin.username')); ?>
                    <?php endif; ?>
                </p>
                <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree" data-animation-speed="200">
        </ul>
    </section>
</aside>
    <div class="content-wrapper">
    <div class="content-iframe " style="background-color: #ffffff; ">
        <div class="content-tabs">
            <button class="roll-nav roll-left tabLeft" onclick="scrollTabLeft()">
                <i class="fa fa-backward"></i>
            </button>
            <nav class="tab-menu" id="tab-menu">
            </nav>
            <button class="roll-nav roll-right tabRight" onclick="scrollTabRight()">
                <i class="fa fa-forward" style="margin-left: 3px;"></i>
            </button>
            <div class="roll-nav roll-right tabMenu">
                <button class="dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fa fa-list"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu">
                    <li onclick="closeAllTab()"><a href="#">关闭全部</a></li>
                    <li onclick="closeOtherTab()"><a href="#">除此之外全部关闭</a></li>
                </ul>
            </div>
            <button class="roll-nav roll-right tabFresh" onclick="refreshTab()">
                <i class="fa fa-refresh" style="margin-left: 3px;"></i>
            </button>
        </div>
        <div class="tab-content " id="tab-content">
        </div>
    </div>
</div>
    <footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 0.0.1
    </div>
    <strong>Copyright &copy; 2018-2100 SplAdmin.</strong> All rights
    reserved.
</footer>
    
<aside class="control-sidebar control-sidebar-dark">
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="control-sidebar-home-tab">
            侧边栏
        </div>
    </div>
</aside>
<div class="control-sidebar-bg"></div>
</div>
<!-- jQuery 3 -->
<script src="/public/admin/plugins/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/public/admin/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/public/admin/js/adminlte.min.js"></script>
<script src="/public/admin/js/common.js"></script>

<script type="text/javascript">
    $(function () {
        //ajax获取菜单配置
        $.ajax({ //获取菜单
            url:'<?php echo url("Index/ajaxMenu"); ?>',
            type:'post',
            dataType:'json',
            data:{},
            success:function (response) {
                if(response.code === 0){
                    $('.sidebar-menu').addMenus(response.data);
                    $('.sidebar-menu a[target="iframe-1"]')[0].click();//默认显示的tab
                }else{
                    toastr.error(response.msg);
                }
            }
        });
    });
</script>

</body>
</html>
