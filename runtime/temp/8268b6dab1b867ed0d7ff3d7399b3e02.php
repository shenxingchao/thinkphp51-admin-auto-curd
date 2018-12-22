<?php /*a:2:{s:68:"E:\PHP\www\spladmin\application\admin\view\system_setting\index.html";i:1545450341;s:54:"E:\PHP\www\spladmin\application\admin\view\iframe.html";i:1545366211;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/public/admin/plugins/bootstrap/dist/css/bootstrap.min.css">
    <!-- 其他主题随意更换 -->
    <!--<link href="https://cdn.bootcss.com/bootswatch/3.3.7/yeti/bootstrap.min.css" rel="stylesheet">-->
    <!--cerulean,cosmo,cyborg,darkly,flatly,journal,lumen,paper,sandstone,readable,simplex,slate,spacelab,superhero,united,yeti-->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/public/admin/plugins/font-awesome/css/font-awesome.min.css">
    <!-- Datetime Picker -->
    <link rel="stylesheet" href="/public/admin/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/public/admin/plugins/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap-table -->
    <link rel="stylesheet" href="/public/admin/plugins/bootstrap-table/bootstrap-table.min.css">
    <!-- bootstrap-switch -->
    <link rel="stylesheet" href="/public/admin/plugins/bootstrap-switch/bootstrap-switch.min.css">
    <!-- toastr -->
    <link rel="stylesheet" href="/public/admin/plugins/toastr/toastr.min.css">
    <!-- Bootstrap-Iconpicker -->
    <link rel="stylesheet" href="/public/admin/plugins/bootstrap-iconpicker/bootstrap-iconpicker.min.css"/>
    <!-- jstree -->
    <link rel="stylesheet" href="/public/admin/plugins/jstree/themes/default/style.min.css"/>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- iframe.css-->
    <link rel="stylesheet" href="/public/admin/css/iframe.css">
    
<style type="text/css">
    body{
        background: #f1f1f1;
    }
    .content-wrapper-box{
        padding: 10px;
    }
    .content-wrapper{
        padding: 20px 16px;
        background: #e8edf0;
        border: 1px solid #ececec;
    }
    .setting_title{
        text-align: right;
        padding: 8px;
    }
    .tab-content{
        padding: 20px 10px;
        background: #ffffff;
    }
    .nav-tabs>li{margin-right: 3px;}
    .nav-tabs>li>a{
        background: #d8e0e6 !important;
        color: #95a5a6;
    }
    .nav-tabs>.active>a{
        border: 1px solid #ffffff !important;
        border-bottom-color: transparent !important;
        background: #ffffff !important;
    }
    .bug_show{
        display: block !important;
    }
</style>

</head>
<body>

<div class="container-fluid content-wrapper-box">
    <div class="content-wrapper">
        <ul class="nav nav-tabs">
            <?php if(is_array($group_setting['value']) || $group_setting['value'] instanceof \think\Collection || $group_setting['value'] instanceof \think\Paginator): $i = 0; $__LIST__ = $group_setting['value'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
            <li role="presentation"  <?php if($i == 1): ?>class="active"<?php endif; ?>>
                <a href="#<?php echo htmlentities($key); ?>"  data-toggle="tab"><?php echo htmlentities($val); ?></a>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <!--分组管理默认显示  其他循环显示-->
            <li role="presentation">
                <a href="#plus"  data-toggle="tab">
                    <i class="fa fa-plus"></i>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <?php if(is_array($group_setting['value']) || $group_setting['value'] instanceof \think\Collection || $group_setting['value'] instanceof \think\Paginator): $index = 0; $__LIST__ = $group_setting['value'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($index % 2 );++$index;if($key != 'group_setting'): ?>
                <div class="tab-pane fade <?php if($index == 1): ?>in active<?php endif; ?> bug_show" id="<?php echo htmlentities($key); ?>">
                    <form class="paramForm" action="<?php echo url('SystemSetting/paramSave'); ?>" type="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                <table class="table table-noborder table-striped">
                                    <thead>
                                    <tr>
                                        <th>标题</th>
                                        <th>变量名</th>
                                        <th>变量值</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($setting[$key])): if(is_array($setting[$key]) || $setting[$key] instanceof \think\Collection || $setting[$key] instanceof \think\Paginator): if( count($setting[$key])==0 ) : echo "" ;else: foreach($setting[$key] as $k=>$val): ?>
                                                <tr>
                                                    <td><?php echo htmlentities($val['title']); ?></td>
                                                    <td>
                                                        <?php switch($val['type']): case "varchar": ?>
                                                                <input type="text" class="form-control" name="<?php echo htmlentities($val['name']); ?>" value="<?php echo htmlentities($val['value']); ?>">
                                                            <?php break; case "content": ?>
                                                                <textarea name="<?php echo htmlentities($val['name']); ?>" class="form-control spl_textarea" cols="30" rows="5"><?php echo htmlentities($val['value']); ?></textarea>
                                                            <?php break; case "image": ?>
                                                                <div class="group" style="padding-top: 7px;">
                                                                    <div class="row">
                                                                        <div class="col-xs-8">
                                                                            <input type="text" class="form-control" name="<?php echo htmlentities($val['name']); ?>"  value="<?php echo htmlentities($val['value']); ?>" readonly  unselectable="on">
                                                                        </div>
                                                                        <div class="col-xs-2">
                                                                            <button type="button" class="btn btn-primary spl_file_upload_btn">
                                                                                上传
                                                                            </button>
                                                                            <input class="fileUpload form-control" type="file" name="file" style="display: none;"  data-type="image">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-12">
                                                                        <div class="row">
                                                                            <div class="spl_callback">
                                                                                <?php if($val['value'] != ''): ?>
                                                                                    <img src="<?php echo htmlentities($val['value']); ?>">
                                                                                    <button type="button" class="btn btn-danger spl-delete-file" data-src="<?php echo htmlentities($val['value']); ?>">删除</button>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php break; case "switch": ?>
                                                                <input type="checkbox" value="<?php echo htmlentities($val['value']); ?>" name="<?php echo htmlentities($val['name']); ?>" class="switch" checked>
                                                            <?php break; case "time": ?>
                                                                <div style="position: relative">
                                                                    <input  class="form-control dateTimePicker"  type="text" name="<?php echo htmlentities($val['name']); ?>"  value="<?php if($val['value'] != ''): ?><?php echo htmlentities(date('Y-m-d H:i:s',!is_numeric($val['value'])? strtotime($val['value']) : $val['value'])); ?><?php endif; ?>">
                                                                </div>
                                                            <?php break; default: ?>
                                                        <?php endswitch; ?>
                                                    </td>
                                                    <td>{$site.<?php echo htmlentities($val['name']); ?>}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger spl-delete-param">
                                                            <i class="fa  fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; endif; else: echo "" ;endif; ?>
                                        <?php endif; ?>
                                        <tr>
                                            <td></td>
                                            <td colspan="3">
                                                <input type="hidden" name="group" value="<?php echo htmlentities($key); ?>">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> 保存</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <?php else: ?>
                <div class="tab-pane fade <?php if($index == 1): ?>in active<?php endif; ?>" id="group_setting">
                    <div class="row">
                        <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1 setting_title">
                            <?php echo htmlentities($group_setting['title']); ?>
                        </div>
                        <div class="col-xs-10 col-sm-8 col-md-6 col-lg-4">
                            <form class="groupSettingForm" action="<?php echo url('SystemSetting/groupSetting'); ?>" type="post">
                                <table class="table table-noborder">
                                    <thead>
                                    <tr>
                                        <th>变量名</th>
                                        <th>变量值</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($group_setting['value']) || $group_setting['value'] instanceof \think\Collection || $group_setting['value'] instanceof \think\Paginator): if( count($group_setting['value'])==0 ) : echo "" ;else: foreach($group_setting['value'] as $key=>$val): ?>
                                    <tr>
                                        <td><input class="form-control" type="text" name="group_setting_name[]" value="<?php echo htmlentities($key); ?>"></td>
                                        <td><input  class="form-control"  type="text" name="group_setting_value[]" value="<?php echo htmlentities($val); ?>"></td>
                                        <td><button type="button" class="btn btn-danger group_delete_btn"><i class="fa fa-trash"></i></button></td>
                                    </tr>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                    <tr class="append_group">
                                        <td colspan="3">
                                            <button type="button" class="btn btn-success" id="append_group_btn"><i class="fa fa-plus"></i> 添加</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> 保存</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <div class="tab-pane fade" id="plus">
                <div class="row">
                    <form class="form-horizontal addForm col-sm-8 col-xs-12 col-md-6 col-lg-4" action="<?php echo url('SystemSetting/addParam'); ?>" method="post">
                        <div class="form-group">
                            <label class="control-label col-xs-2">
                                分组&nbsp;
                            </label>
                            <div class="col-xs-10">
                                <select class="form-control" name="group" required data-msg="请选择分组">
                                    <option value="">请选择</option>
                                    <?php if(is_array($group_setting['value']) || $group_setting['value'] instanceof \think\Collection || $group_setting['value'] instanceof \think\Paginator): if( count($group_setting['value'])==0 ) : echo "" ;else: foreach($group_setting['value'] as $key=>$val): ?>
                                    <option value="<?php echo htmlentities($key); ?>"><?php echo htmlentities($val); ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-2">
                                类型&nbsp;
                            </label>
                            <div class="col-xs-10">
                                <select class="form-control" name="type" required data-msg="请选择类型">
                                    <option value="">请选择</option>
                                    <option value="varchar">字符串</option>
                                    <option value="content">文本域</option>
                                    <option value="image">图片</option>
                                    <option value="switch">开关</option>
                                    <option value="time">时间</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-2">
                                变量名&nbsp;
                            </label>
                            <div class="col-xs-10">
                                <input type="text" name="name" class="form-control" required data-msg="变量名不能为空">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-2">
                                变量值&nbsp;
                            </label>
                            <div class="col-xs-10">
                                <input type="text" name="value" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-2">
                                标题&nbsp;
                            </label>
                            <div class="col-xs-10">
                                <input type="text" name="title" class="form-control" required data-msg="标题不能为空">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-2"></label>
                            <div class="col-xs-10">
                                <input class="btn btn-primary" type="submit" onclick="submitAddFrom()">
                                <input class="btn btn-default" type="reset">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- jQuery 3 -->
<script src="/public/admin/plugins/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/public/admin/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- bootstrap-table -->
<script src="/public/admin/plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script src="/public/admin/plugins/bootstrap-table/bootstrap-table-zh-CN.js"></script>
<!-- bootstrap-switch -->
<script src="/public/admin/plugins/bootstrap-switch/bootstrap-switch.min.js"></script>
<!-- toastr -->
<script src="/public/admin/plugins/toastr/toastr.min.js"></script>
<!-- layer -->
<script src="/public/admin/plugins/layer/layer.js"></script>
<!-- jquery-validate -->
<script src="/public/admin/plugins/jquery-validate/jquery-validate.min.js"></script>
<!-- jquery-form -->
<script src="/public/admin/plugins/jquery-form/jquery-form.min.js"></script>
<!-- jquery-fileupload -->
<script src="/public/admin/plugins/jquery-fileupload/vendor/jquery.ui.widget.js"></script>
<script src="/public/admin/plugins/jquery-fileupload/jquery.iframe-transport.js"></script>
<script src="/public/admin/plugins/jquery-fileupload/jquery.fileupload.js"></script>
<!-- daterangepicker -->
<script src="/public/admin/plugins/moment/moment.min.js"></script>
<script src="/public/admin/plugins/moment/zh-cn.js"></script>
<script src="/public/admin/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datetimepicker -->
<script src="/public/admin/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<!-- Bootstrap-Iconpicker Bundle -->
<script type="text/javascript" src="/public/admin/plugins/bootstrap-iconpicker/bootstrap-iconpicker.bundle.min.js"></script>
<!-- jstree -->
<script type="text/javascript" src="/public/admin/plugins/jstree/jstree.min.js"></script>
<!-- iframe.js-->
<script src="/public/admin/js/iframe.js"></script>

<script type="text/javascript">

    $(function () {
        //添加一个权限分组
        $('#append_group_btn').on('click',function () {
            var html = '<tr>' +
                '<td><input class="form-control" type="text" name="group_setting_name[]" value=""></td>'+
                '<td><input  class="form-control"  type="text" name="group_setting_value[]" value=""></td>'+
                '<td><button type="button" class="btn btn-danger group_delete_btn"><i class="fa fa-trash"></i></button></td></tr>';
            $('.append_group').before(html);
        });

        //删除一个权限分组
        $('body').on('click','.group_delete_btn',function () {
           $(this).parents('tr').remove();
        });

        //权限分组设置保存
        $('.groupSettingForm').on('submit', function() {
            $(this).ajaxSubmit({
                dataType:'json',
                success:function (response) {
                    if(response.code === 0){
                        //刷新
                        toastr.success(response.msg);
                        window.location.reload();
                    }else{
                        toastr.error(response.msg);
                    }
                }
            });
            return false; // 阻止表单自动提交事件
        });

        //变量设置保存
        $('.paramForm').on('submit',function () {
            $(this).ajaxSubmit({
                dataType:'json',
                success:function (response) {
                    if(response.code === 0){
                        //刷新
                        toastr.success(response.msg);
                    }else{
                        toastr.error(response.msg);
                    }
                }
            });
            return false; // 阻止表单自动提交事件
        });

        //删除一个变量
        $('.spl-delete-param').on('click',function () {
            $(this).parents('tr').remove();
        });
        //初始化开关选项
        switchInit();
        //初始化文件控件
        fileInit();
        //初始化日期控件
        dateTimePickerInit();
    });

    //添加变量到分组
    function submitAddFrom() {
        //表单验证
        $(".addForm").validate({
            keydown:true,
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    dataType:'json',
                    success:function (response) {
                        if(response.code === 0){
                            //刷新
                            toastr.success(response.msg);
                            window.location.reload();
                        }else{
                            toastr.error(response.msg);
                        }
                    }
                });
            }
        })
    }

    //初始化开关选项
    function  switchInit() {
        var switch_obj = $('.switch');
        switch_obj.bootstrapSwitch({
            onText:"<i class='fa fa-check'></i>",
            offText:"<i class='fa fa-close'></i>",
            onColor:"success",
            offColor:"danger",
            //size:"small",//无效
            onSwitchChange:function(event,state){
                $(this).prop("checked",true);//管他什么checkbox 让他选中  需求就是这样
                if(state===true){
                    $(this).val(1);
                }else{
                    $(this).val(2);
                }
            }
        });
        switchInitState();

    }
    
    function switchInitState() {

        var switch_obj = $('.switch'),i=0;
        switch_obj.bootstrapSwitch('size','small');
        for(;i < switch_obj.length;i++){
            if(switch_obj.eq(i).val()==='1'){
                switch_obj.eq(i).bootstrapSwitch('state',true);
            }else{
                switch_obj.eq(i).bootstrapSwitch('state',false);
            }
        }
        $('.bug_show').removeClass('bug_show');
    }

    //初始化文件控件
    function fileInit() {
        //单文件上传
        $('.spl_file_upload_btn').on('click',function () {
            $(this).next('input').click();
        });
        $('.fileUpload').fileupload({
            dataType: 'json',
            add: function (e, data) {
                var data_type = $(this).attr('data-type');
                $(this).fileupload('option', 'url', "<?php echo url('SystemSetting/fileUpload'); ?>?data_type="+data_type);
                data.submit();
            },
            done: function (e, data) {
                var response = data.result;
                if(response.code === 0){
                    var spl_callback_html = '';
                    switch($(this).attr('data-type')){
                        case 'file':
                            $(this).parent('div').prev('div').find('input').val(response.data);
                            spl_callback_html = '<div class=col-xs-8><button type="button" class="btn btn-danger spl-delete-file" data-src="'+
                                response.data +'">删除</button></div>';
                            break;
                        case 'image':
                            $(this).parent('div').prev('div').find('input').val(response.data);
                            spl_callback_html = '<img src="'+ response.data +'">' +
                                '<button type="button" class="btn btn-danger spl-delete-file" data-src="'+
                                response.data +'">删除</button>';
                            break;
                    }
                    $(this).parents('.group').find('.spl_callback').html(spl_callback_html);
                    $(this).parent('div').prev('div').find('input').blur();
                    toastr.success(response.msg);
                }else{
                    toastr.error(response.msg);
                }
            }
        });
        //单图预览
        $('body').on('click','.spl_callback img',function () {
            parent.window.open($(this).attr('src'));
        });
        //单文件删除
        $('body').on('click','.spl-delete-file',function () {
            var file_url = $(this).attr('data-src');
            var obj = $(this);
            $.ajax({
                url:"<?php echo url('SystemSetting/fileDelete'); ?>",
                type:'post',
                dataType:'json',
                data:{file_url:file_url},
                success:function (response) {
                    if(response.code === 0){
                        //清空容器
                        obj.parents('.group').find('input[type="text"]').val('');
                        obj.parents('.spl_callback').html('');
                        toastr.success(response.msg);
                    }else{
                        toastr.error(response.msg);
                    }
                }
            });
        });
    }

    //初始化日期控件
    function dateTimePickerInit() {
        $('.dateTimePicker').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            locale: moment.locale('zh-cn')
        });
    }

</script>

</body>
</html>
