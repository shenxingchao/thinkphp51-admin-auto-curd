{extend name="iframe" /}
{block name="css"}
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
{/block}

{block name="content"}
    <div class="container-fluid content-wrapper-box">
        <div class="content-wrapper">
            <form class="form-horizontal addForm" action="" method="post" enctype="multipart/form-data">
                {{addHtml}}
                <input class="btn btn-primary submit_btn" onclick="submitFrom()" type="submit">
                <input class="btn btn-default reset_btn" type="hidden" onclick="resetForm()">
            </form>
        </div>
    </div>
{/block}

{block name="script"}
    <script type="text/javascript" charset="utf-8" src="__STATIC__/plugins/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="__STATIC__/plugins/ueditor/ueditor.all.js"> </script>
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
                    $(this).fileupload('option', 'url', "{:url('{{controllerName}}/fileUpload')}?data_type="+data_type);
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
                    url:"{:url('{{controllerName}}/fileDelete')}",
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
            {{ueditorInit}}
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
{/block}