define(['jquery', 'bootstrap', 'backend', 'form', 'table'], function ($, undefined, Backend, Form, Table) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'about/about/index',
                    add_url: 'about/about/add',
                    edit_url: 'about/about/edit',
                    // del_url: 'about/about/del',
                    multi_url: 'about/about/multi',
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
                        // {field: 'img_url', title: __('预览'), formatter: Controller.api.formatter.thumb, operate: false},
                        // {field: 'admin_id', title: '管理员id', visible: false, addClass: "selectpage", extend: "data-source='auth/admin/index' data-field='nickname'"},
                        {field: 'introduce', title: '昭通汽配网介绍'},
                        {field: 'regulations', title: '使用条例'},
                        {field: 'mobile_phone', title: '客服电话'},
                        {field: 'wx_user', title: '客服联系方式'},
                        {field: 'wx_url', title: '微信跳转链接'},
                        {field: 'status', title: '状态', sortable: true},

                        {
                            field: 'create_time',
                            title: '创建日期',
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
                    return '<a href="' + row.mobile_img + '" target="_blank"><img src="' + row.mobile_img + style + '" alt="" style="max-height:90px;max-width:120px"></a>';
                },
                thumbs: function(value, row, index){
                    var style = row.storage == 'upyun' ? '!/fwfh/120x90' : '';
                    return '<a href="' + row.mobile_phone + '" target="_blank"><img src="' + row.mobile_phone + style + '" alt="" style="max-height:90px;max-width:120px"></a>';
                },
                url: function (value, row, index) {
                    return '<a href="' + row.href + '" target="_blank" class="label bg-green">' + value + '</a>';
                },
            }
        }

    };
    return Controller;
});