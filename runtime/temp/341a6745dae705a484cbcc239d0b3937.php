<?php /*a:2:{s:59:"E:\PHP\www\spladmin\application\admin\view\article\add.html";i:1545461495;s:54:"E:\PHP\www\spladmin\application\admin\view\iframe.html";i:1545366211;}*/ ?>
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
        .addForm{
            margin-top: 20px;
        }
        .submit_btn{
            display: none;
        }
        @media (min-width: 768px){
            .bootstrap-switch{
                margin-top: 7px;
            }
        }
    </style>

</head>
<body>

    <div class="container-fluid content-wrapper-box">
        <div class="content-wrapper">
            <form class="form-horizontal addForm" action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                    <label class="control-label col-xs-2">
                        文章标题&nbsp;
                    </label>
                    <div class="col-xs-8">
                        <input type="text" name="article" class="form-control" required data-msg="文章标题不能为空">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-2">
                        缩略图&nbsp;
                    </label>
                    <div class="col-xs-8">
                        <input type="text" class="form-control" name="article_image" readonly  unselectable="on" required data-msg="请上传缩略图">
                    </div>
                    <div class="col-xs-2">
                        <button type="button" class="btn btn-primary spl_file_upload_btn">
                            上传
                        </button>
                        <input class="fileUpload form-control" type="file" name="file" style="display: none;"  data-type="image">
                    </div>
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-2"></div>
                            <div class="col-xs-8 spl_callback"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-2">
                        SEO描述&nbsp;
                    </label>
                    <div class="col-xs-8">
                        <textarea name="seo_content" class="form-control spl_textarea" required data-msg="SEO描述不能为空" cols="30" rows="5"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-2">
                        文章详情&nbsp;
                    </label>
                    <div class="col-xs-8">
                        <textarea id="article_editor" name="article_editor" required data-msg="文章详情不能为空" cols="30" rows="5"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-2">
                        是否显示&nbsp;
                    </label>
                    <div class="col-xs-8">
                        <input type="checkbox" value="1" name="show_status" class="switch" checked>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-2">
                        发布时间&nbsp;
                    </label>
                    <div class="col-xs-8">
                        <input  class="form-control dateTimePicker"  type="text" name="publish_time" required data-msg="请设置发布时间">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-2">
                        文章分类id&nbsp;
                    </label>
                    <div class="col-xs-8">
                        <input type="text" name="cat_id" class="form-control" required data-msg="文章分类id不能为空">
                    </div>
                </div>

                <input class="btn btn-primary submit_btn" onclick="submitFrom()" type="submit">
                <input class="btn btn-default reset_btn" type="hidden" onclick="resetForm()">
            </form>
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

    <script type="text/javascript" charset="utf-8" src="/public/admin/plugins/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/public/admin/plugins/ueditor/ueditor.all.js"> </script>
    <script type="text/javascript">
        $(function () {
            //初始化开关选项
            switchInit();
            //初始化日期控件
            dateTimePickerInit();
            //初始化文件控件
            fileInit();
            //初始化编辑器
            ueditorInit();
        });
        //初始化开关选项
        function  switchInit() {
            var switch_obj = $('.switch'),i=0;
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
            switch_obj.bootstrapSwitch('size','mini');
            for(;i < switch_obj.length;i++){
                if(switch_obj.eq(i).val()==='1'){
                    switch_obj.eq(i).bootstrapSwitch('state',true);
                }else{
                    switch_obj.eq(i).bootstrapSwitch('state',false);
                }
            }
        }
        //初始化日期控件
        function dateTimePickerInit() {
            $('.dateTimePicker').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                locale: moment.locale('zh-cn')
            });
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
                    $(this).fileupload('option', 'url', "<?php echo url('Article/fileUpload'); ?>?data_type="+data_type);
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
                                spl_callback_html = '<div class="col-xs-3">' +
                                    '<img src="'+ response.data +'">' +
                                    '<button type="button" class="btn btn-danger spl-delete-file" data-src="'+
                                    response.data +'">删除</button>' +
                                    '</div>';
                                break;
                        }
                        $(this).parents('.form-group').find('.spl_callback').html(spl_callback_html);
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
                    url:"<?php echo url('Article/fileDelete'); ?>",
                    type:'post',
                    dataType:'json',
                    data:{file_url:file_url},
                    success:function (response) {
                        if(response.code === 0){
                            //清空容器
                            obj.parents('.form-group').find('input[type="text"]').val('');
                            obj.parents('.spl_callback').html('');
                            toastr.success(response.msg);
                        }else{
                            toastr.error(response.msg);
                        }
                    }
                });
            });
        }
        //初始化编辑器
        function ueditorInit() {
            
            UE.getEditor('article_editor', {
                autoHeight: false,
                initialFrameWidth:'100%'
            });
        }

        //提交表单
        function submitFrom() {
            var  frameIndex= parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            //表单验证
            $(".addForm").validate({
                keydown:true,
                submitHandler: function(form) {
                    $(form).ajaxSubmit({
                        dataType:'json',
                        success:function (response) {
                            if(response.code === 0){
                                parent.toastr.success(response.msg);
                            }else{
                                parent.toastr.error(response.msg);
                            }
                            //刷新数据表格
                            parent.layer.close(frameIndex);
                            parent.searchForm();
                        }
                    });
                }
            })
        }
        function resetForm() {
            $('.addForm')[0].reset();
            switchInit();
        }
    </script>

</body>
</html>
