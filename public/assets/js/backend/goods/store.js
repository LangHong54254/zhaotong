define(['jquery', 'bootstrap', 'backend', 'form', 'table'], function ($, undefined, Backend, Form, Table) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'goods/store/index',
                    add_url: 'goods/store/add',
                    edit_url: 'goods/store/edit',
                    del_url: 'goods/store/del',
                    multi_url: 'goods/store/multi',
                    table: 'attachment'
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                sortName: 'id',
                columns: [
                    [
                        {field: 'state', checkbox: true,},
                        {field: 'id', title:'id'},
                        {field: 'store_logo_img', title: __('LOGO预览'), formatter: Controller.api.formatter.thumb, operate: false},
                        {field: 'store_img', title: __('商家图片预览'), formatter: Controller.api.formatter.thumbs, operate: false},
                        // {field: 'admin_id', title: '管理员id', visible: false, addClass: "selectpage", extend: "data-source='auth/admin/index' data-field='nickname'"},
                        // {field: 'zhiding', title: '应用端', sortable: true},
                        {field: 'store_name', title: '商家名称',sortable: true},
                        // {field: 'store_name', title: '商家名称', visible: false, addClass: "selectpage", extend: "data-source='user/user/index' data-field='nickname'"},
                        {field: 'goods_id', title: '所属分类', visible: false, addClass: "selectpage", extend: "data-source='goods/store/goodsList' data-field='nickname'"},
                        {field: 'sort', title: '排序', sortable: true},
                        {field: 'store_address', title: '商家地址', sortable: true},
                        {field: 'store_phone', title: '商家手机号', sortable: true},
                        {field: 'store_describe', title: '商家描述', sortable: true},
                        {field: 'province', title: '省', sortable: true},
                        {field: 'city', title: '市', sortable: true},
                        {field: 'area', title: '区', sortable: true},
                        // {field: 'img_url', title: '物理路径', sortable: true},
                        // {field: 'href', title: '跳转链接', formatter: Controller.api.formatter.url},
                        {field: 'status', title: '状态', visible: false, addClass: "selectpage", extend: "data-source='goods/store/statusList' data-field='name'"},
                        {
                            field: 'create_time',
                            title: '创建日期',
                            formatter: Table.api.formatter.datetime,
                            operate: 'RANGE',
                            addclass: 'datetimerange',
                            sortable: true
                        },
                        {
                            field: 'update_time',
                            title: '修改日期',
                            formatter: Table.api.formatter.datetime,
                            operate: 'RANGE',
                            addclass: 'datetimerange',
                            sortable: true
                        },
                        {
                            field: 'operate',
                            title: __('Operate'),
                            table: table,
                            events: Table.api.events.operate,
                            formatter: Table.api.formatter.operate
                        }
                    ]
                ],
            });

            // 为表格绑定事件
            Table.api.bindevent(table);

        },
        select: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'banner/banner/select',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                sortName: 'id',
                columns: [
                    [
                        {field: 'state', checkbox: true,},
                        {field: 'id', title: __('Id')},
                        {field: 'admin_id', title: __('Admin_id'), visible: false},
                        {field: 'user_id', title: __('User_id'), visible: false},
                        {field: 'url', title: __('Preview'), formatter: Controller.api.formatter.thumb, operate: false},
                        {field: 'imagewidth', title: __('Imagewidth'), operate: false},
                        {field: 'imageheight', title: __('Imageheight'), operate: false},
                        {
                            field: 'mimetype', title: __('Mimetype'), operate: 'LIKE %...%',
                            process: function (value, arg) {
                                return value.replace(/\*/g, '%');
                            }
                        },
                        {field: 'createtime', title: __('Createtime'), formatter: Table.api.formatter.datetime, operate: 'RANGE', addclass: 'datetimerange', sortable: true},
                        {
                            field: 'operate', title: __('Operate'), events: {
                                'click .btn-chooseone': function (e, value, row, index) {
                                    var multiple = Backend.api.query('multiple');
                                    multiple = multiple == 'true' ? true : false;
                                    Fast.api.close({url: row.url, multiple: multiple});
                                },
                            }, formatter: function () {
                                return '<a href="javascript:;" class="btn btn-danger btn-chooseone btn-xs"><i class="fa fa-check"></i> ' + __('Choose') + '</a>';
                            }
                        }
                    ]
                ]
            });

            // 选中多个
            $(document).on("click", ".btn-choose-multi", function () {
                var urlArr = new Array();
                $.each(table.bootstrapTable("getAllSelections"), function (i, j) {
                    urlArr.push(j.url);
                });
                var multiple = Backend.api.query('multiple');
                multiple = multiple == 'true' ? true : false;
                Fast.api.close({url: urlArr.join(","), multiple: multiple});
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            },
            formatter: {
                thumb: function (value, row, index) {
                    // if (row.mimetype.indexOf("image") > -1) {
                    var style = row.storage == 'upyun' ? '!/fwfh/120x90' : '';
                    //     return '<a href="' + row.fullurl + '" target="_blank"><img src="' + row.fullurl + style + '" alt="" style="max-height:90px;max-width:120px"></a>';
                    // } else {
                    //     return '<a href="' + row.fullurl + '" target="_blank"><img src="https://tool.fastadmin.net/icon/' + row.imagetype + '.png" alt=""></a>';
                    // }
                    return '<a href="' + row.store_logo_img + '" target="_blank"><img src="' + row.store_logo_img + style + '" alt="" style="max-height:90px;max-width:120px"></a>';
                },
                thumbs: function(value, row, index){
                    var style = row.storage == 'upyun' ? '!/fwfh/120x90' : '';
                    return '<a href="' + row.store_img + '" target="_blank"><img src="' + row.store_img + style + '" alt="" style="max-height:90px;max-width:120px"></a>';
                },
                url: function (value, row, index) {
                    return '<a href="' + row.href + '" target="_blank" class="label bg-green">' + value + '</a>';
                },
            }
        }

    };
    return Controller;
});