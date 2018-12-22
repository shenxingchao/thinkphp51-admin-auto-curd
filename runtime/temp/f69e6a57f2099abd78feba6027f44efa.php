<?php /*a:2:{s:61:"E:\PHP\www\spladmin\application\admin\view\article\index.html";i:1545461495;s:54:"E:\PHP\www\spladmin\application\admin\view\iframe.html";i:1545366211;}*/ ?>
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
            padding: 10px 16px;
            background: #ffffff;
            border: 1px solid #ececec;

        }
        .opt_btn{
            margin-left: 10px;
        }
        #searchForm{
            margin-top: 0;
        }
        .form-group{
            margin-top:10px;
        }
        .control-label{
            font-size: 14px;
            font-weight: normal;
            padding: 0;
            padding-top: 7px;
            text-align: right;
        }
        .table_image{
            height:30px;
            width:auto;
            display: block;
        }
        .bootstrap-table td.bs-checkbox{
            vertical-align: middle;
        }
        .bootstrap-table td.bs-checkbox > input{
            margin-top: 4px !important;
        }
    </style>

</head>
<body>

    <div class="container-fluid content-wrapper-box">
        <div class="content-wrapper">
            <!-- 搜索表单 -->
            <form id="searchForm" class="form-inline row" action="" method="get">
                                <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <label class="control-label col-xs-4">
                        文章标题&nbsp;
                    </label>
                    <div class="col-xs-8">
                        <input type="text" name="article" data-where="like" class="form-control" placeholder="文章标题">
                    </div>
                </div>
                <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <label class="control-label col-xs-4">
                        是否显示&nbsp;
                    </label>
                    <div class="col-xs-8">
                        <select class="form-control" name="show_status" data-where="eq">
                            <option value="">请选择</option>
                            <option value="1">是</option>
                            <option value="2">否</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <label class="control-label col-xs-4">
                        发布时间&nbsp;
                    </label>
                    <div class="col-xs-8">
                        <input class="form-control dateRange" type="text" name="publish_time" data-where="between" placeholder="发布时间">
                    </div>
                </div>
                <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <label class="control-label col-xs-4">
                        文章分类id&nbsp;
                    </label>
                    <div class="col-xs-8">
                        <input type="text" name="cat_id" data-where="like" class="form-control" placeholder="文章分类id">
                    </div>
                </div>
                <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <label class="control-label col-xs-4">
                        创建时间&nbsp;
                    </label>
                    <div class="col-xs-8">
                        <input class="form-control dateRange" type="text" name="add_time" data-where="between" placeholder="创建时间">
                    </div>
                </div>

                <div class="form-group col-xs-12">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="col-xs-4"></div>
                            <div class="col-xs-8">
                                <button class="btn btn-primary" onclick="searchForm()" type="button">搜索</button>
                                <button class="btn btn-default" type="button" onclick="resetForm()">重置</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- 工具条 -->
            <div id="toolbar">
                <button class="btn btn-primary btn-sm" onclick="add()"><i class="fa fa-plus"></i> 添加</button>
                <button class="btn btn-info btn-sm" id="edit_btn" disabled onclick="editMut()"><i class="fa fa-edit"></i> 编辑</button>
                <button class="btn btn-danger btn-sm" id="delete_btn" disabled onclick="deleteMut()"><i class="fa fa-trash"></i> 删除</button>
            </div>
            <!-- 表格 -->
            <table id="table" class="table-bordered"></table>
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
        //注册switch 开关转换事件
        function statusFormatter(field,value,row,index) {
            var id=row.id;
            if(value===1){
                return '<input value="'+ id +'" data-field="'+ field +'" type="checkbox" class="switch" checked>';
            }
            else if(value===2){
                return '<input value="'+ id +'" data-field="'+ field +'" type="checkbox" class="switch" >';
            }
        }
        //注册image图片格式转换事件
        function imageFormatter(field,value,row,index) {
            if(row[field]!==''){
                return '<a href="'+ row[field] +'" target="_blank"><img class="table_image" src="'+ row[field] +'"></a>';
            }else{
                return '';
            }
        }
        //注册文件类型转换事件
        function fileFormatter(field,value,row,index) {
            if(row[field]!==''){
                return '<a class="btn btn-primary btn-xs" href="'+ row[field] +'" target="_blank" download>下载</a>';
            }else{
                return '';
            }
        }
        //注册时间戳类型转换事件
        function timeFormatter(field,value,row,index) {
            if(row[field]!==''){
                return  moment(row[field]*1000).format('YYYY-MM-DD HH:mm:ss');
            }else{
                return '';
            }
        }

        //注册操作按钮事件
        function operateFormatter(value, row, index) {
            return [
                '<button id="edit_row" type="button" class="btn btn-info btn-xs opt_btn"><i class="fa fa-edit"></i></button>',
                '<button id="delete_row" type="button" class="btn btn-danger btn-xs opt_btn"><i class="fa fa-trash"></i></button>',
            ].join('');
        }
        //按钮事件
        window.operateEvents = {
            //编辑一行数据
            'click #edit_row': function(e, value, row, index) {
                e.stopPropagation();
                handleEdit(row.id);
            },
            'click #delete_row': function(e, value, row, index) {
                handleDelete([row.id]);
            },
        };
        //表格数据组装
        var fieldList = [
            {
            valign:"middle",field:"id",title:"编号"
            },
            {
            valign:"middle",field:"article",title:"文章标题"
            },
            {
            valign:"middle",field:"article_image",title:"缩略图",formatter:function (value,row,index){return imageFormatter('article_image',value,row,index);}
            },
            {
            valign:"middle",field:"show_status",title:"是否显示",formatter:function (value,row,index){return statusFormatter('show_status',value,row,index);}
            },
            {
            valign:"middle",field:"publish_time",title:"发布时间",formatter:function (value,row,index){return timeFormatter('publish_time',value,row,index);}
            },
            {
            valign:"middle",field:"cat_id",title:"文章分类id"
            },
            {
            valign:"middle",field:"add_time",title:"创建时间",formatter:function (value,row,index){return timeFormatter('add_time',value,row,index);}
            },
            {
            valign:"middle",field:"article_cat.id",title:"编号"
            },
            {
            valign:"middle",field:"article_cat.cat_name",title:"分类名称"
            }];
        var columns = [{
            align: 'center',
            valign: 'middle',
            checkbox: 'true'
        }].concat(fieldList).concat(
            [{
                field: 'operate',
                title: '操作',
                align: 'center',
                valign: 'middle',
                events: operateEvents,
                formatter: operateFormatter
            }]
        );

        /**
         * ajax改变状态
         * @param id ID
         * @param field 更改状态的字段名
         * @param value 要更改的值
         */
        function changeState(id,field,value) {
            $.ajax({
                url:'<?php echo url("Article/changeState"); ?>',
                type:'post',
                dataType:'json',
                data:{id:id,field:field,value:value},
                success:function (response) {
                    if(response.code === 0){
                        toastr.success(response.msg);
                    }else{
                        toastr.error(response.msg);
                    }
                },
                error:function (e) {
                    toastr.error("network error!");
                }
            });
        }


        /**
         * 表单搜索提交
         */
        function searchForm() {
            $("#table").bootstrapTable('destroy');
            oTableInit();
        }

        /**
         * 重置表单
         */
        function resetForm() {
            $('#searchForm')[0].reset();
            $("#searchForm select").val("").trigger('change');
            searchForm();
        }
        
        /**
         * 工具条 添加操作
         */
        function add () {
            var area = [$(window).width() > 800 ? '800px' : '95%', $(window).height() > 520 ? '520px' : '95%'];
            layer.open({
                type: 2,
                title: '添加',
                maxmin: true,
                scrollbar:false,
                anim:0,
                shade:0,//隐藏遮罩层
                area : area,
                content: '<?php echo url("Article/add"); ?>',
                btn:['确定','重置'],
                btnAlign:'c',
                yes:function (index,layero) {
                    var iframe = layero.find("iframe")[0].contentWindow.document;
                    $(iframe).find('.submit_btn').click();
                },
                btn2:function (index,layero) {
                    var iframe = layero.find("iframe")[0].contentWindow.document;
                    $(iframe).find('.reset_btn').click();
                    return false;
                }
            });
        }

        /**
         * 工具条 编辑多个操作
         */
        function editMut() {
            var rows = $('#table').bootstrapTable('getSelections');
            $.each(rows,function (index,value) {
                //获取当前选中ids 调用编辑操作
                handleEdit(value.id);
            });
        }

        /**
         * 工具条 删除多个操作
         */
        function deleteMut() {
            var rows = $('#table').bootstrapTable('getSelections');
            var ids = [];
            $.each(rows,function (index,value) {
                //获取当前选中ids 调用编辑操作
                ids.push(value.id);
            });
            handleDelete(ids);
        }

        /**
         * 执行编辑操作
         */
        function handleEdit(id){
            var area = [$(window).width() > 800 ? '800px' : '95%', $(window).height() > 520 ? '520px' : '95%'];
            layer.open({
                type: 2,
                title: '编辑',
                maxmin: true,
                scrollbar:false,
                anim:0,
                shade:0,//隐藏遮罩层
                area : area,
                content: '<?php echo url("Article/edit"); ?>?id=' + id,
                btn:['保存','取消'],
                btnAlign:'c',
                yes:function (index,layero) {
                    var iframe = layero.find("iframe")[0].contentWindow.document;
                    $(iframe).find('.submit_btn').click();
                },
                btn2:function (index,layero) {
                    layer.close(index);
                }
            });
        }

        /**
         * 执行删除操作
         */
        function handleDelete(ids) {
            $.ajax({
                url:'<?php echo url("Article/delete"); ?>',
                type:'post',
                dataType:'json',
                data:{ids:ids},
                success:function (response) {
                    if(response.code === 0){
                        searchForm();
                        toastr.success(response.msg);
                    }else{
                        toastr.error(response.msg);
                    }
                },
                error:function (e) {
                    toastr.error("network error!");
                }
            });
        }

        /**
         * 改变按钮状态
         */
        function toggleToolBtn() {
            var rows = $('#table').bootstrapTable('getSelections');
            if(rows.length > 0){
                //激活
                $('#edit_btn').removeAttr('disabled');
                $('#delete_btn').removeAttr('disabled');
            }else {
                //禁用
                $('#edit_btn').attr('disabled', true);
                $('#delete_btn').attr('disabled', true);
            }
        }

        /**
         *  初始化时间控件
         */
        function initDateRange() {
            var locale = {
                "format": 'YYYY-MM-DD HH:mm:ss',
                "separator": " - ",
                "applyLabel": "确定",
                "cancelLabel": "取消",
                "fromLabel": "起始时间",
                "toLabel": "结束时间'",
                "customRangeLabel": "自定义",
                "weekLabel": "W",
                "daysOfWeek": ["日", "一", "二", "三", "四", "五", "六"],
                "monthNames": ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                "firstDay": 1
            };
            //日期控件初始化
            $('.dateRange').daterangepicker(
                {
                    'locale': locale,
                    //汉化按钮部分
                    ranges: {
                        '今日': [moment().startOf('day'), moment()],
                        '昨日': [moment().subtract(1,'days').startOf('day'), moment().subtract(1,'days').endOf('day')],
                        '最近7日': [moment().subtract(6,'days').startOf('day'), moment()],
                        '最近30日': [moment().subtract(29,'days').startOf('day'), moment()],
                        '本月': [moment().startOf('month'), moment().endOf('month')],
                        '上月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    timePicker : true, //是否显示小时和分钟
                    "autoUpdateInput":false, //是否自动应用初始当前日期
                },
                function (start, end) {
                    $(this)[0].element.val(start.format('YYYY-MM-DD HH:mm:ss') + ' - ' + end.format('YYYY-MM-DD HH:mm:ss'));
                }
            );
            //初始化显示当前时间为空
            $('.dateRange').val('');
        }


        /**
         * 初始化表格
         */
        function oTableInit() {
            $('#table').bootstrapTable({
                url:'<?php echo url("Article/index"); ?>',
                dataUndefinedText:'-',         //当数据为 undefined 时显示的字符。
                dataStriped:true,               //隔行变色
                dataSortName:'',                //排序列，通过url方式获取数据填写字段名，否则填写下标
                dataSortOrder:'asc',            //升序
                dataType:'json',                //ajax返回类型
                ajaxOptions:{},                 //ajax附加项
                queryParamsType : "undefined",  //查询类型
                queryParams:function (params) {
                    var param = {
                        page: params.pageNumber,
                        pageSize: params.pageSize,
                        query:{},
                        op:{}
                    };

                    $.each($('#searchForm').serializeArray(),function (index,val) {
                        if(val.value!==null && val.value !==""){
                            param['query'][val.name] = val.value;
                            param['op'][val.name] = $('[name="'+ val.name +'"]').attr('data-where');
                        }
                    });

                    return param;

                }, //查询参数
                striped: true, //表格显示条纹
                iconSize: 'sm',//按钮控件大小
                pagination:true,                //分页条
                onlyInfoPagination:false,       //仅显示总记录数
                sidePagination:'server',        //服务端分页
                pageSize:10,                    //每页显示记录数
                pageList:[10, 25, 50, 100],     //分页页数选择
                paginationHAlign:'right',       //分页条位置
                paginationPreText:'上一页',      //上一页
                paginationNextText:'下一页',     //下一页
                columns: columns,
                search:false,//禁用默认搜索太LOW
                showRefresh:true,//刷新按钮
                showToggle:false,//切换视图
                buttonsAlign:'right',//工具栏按钮的位置
                uniqueId:'id',//主键
                clickToSelect:true,//选中此行的checkbox或radio
                singleSelect:false,//复选框仅能选中一行
                checkboxHeader:true,//显示全选
                toolbar:'#toolbar',//按钮工具条
                onLoadSuccess:function(){
                    var switch_obj = $('.switch'),i=0;

                    switch_obj.bootstrapSwitch({
                        onText:"<i class='fa fa-check'></i>",
                        offText:"<i class='fa fa-close'></i>",
                        onColor:"success",
                        offColor:"danger",
                        //size:"small",//无效
                        onSwitchChange:function(event,state){
                            if(state===true){
                                changeState(this.value,$(this).attr('data-field'),1);
                            }else{
                                changeState(this.value,$(this).attr('data-field'),2);
                            }
                        }
                    });
                    switch_obj.bootstrapSwitch('size','mini');
                    for(;i < switch_obj.length;i++){
                        if(switch_obj.eq(i).is(":checked")){
                            switch_obj.eq(i).bootstrapSwitch('state',true);
                        }else{
                            switch_obj.eq(i).bootstrapSwitch('state',false);
                        }

                    }

                },
                onCheck:function (row) {
                    toggleToolBtn();
                },
                onUncheck:function (row) {
                    toggleToolBtn();
                },
                onCheckAll:function (rows) {
                    toggleToolBtn();
                },
                onUncheckAll:function (rows) {
                    toggleToolBtn();
                }
            });
        }

        $(function () {
            //初始化时间控件
            initDateRange();
            //初始化表格
            oTableInit();
        });
    </script>

</body>
</html>
