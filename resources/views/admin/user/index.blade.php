@extends('admin.layouts.jqGrid')
@section('script_cfg')
    <script type="text/javascript">
        jqGrid_cfg.colNames = ['操作', 'ID', '账号', '真实姓名', '所属组', '邮箱', '手机号', "密码", '重复密码', '最近登录时间', '最近登录IP', '加入时间','状态', '状态'];
        jqGrid_cfg.jsonReader.id = 'uid';
        jqGrid_cfg.colModel = [{
            name: 'operate', index: '', width: 80, fixed: true, sortable: false, resize: false,
            formatter: 'actions',
            formatoptions: {
                keys: true,
                //delbutton: false,//disable delete button
                editformbutton: true,
                editOptions: {
                    url: '/user/edit',
                    recreateForm: true,
                    closeAfterEdit: true,
                    afterSubmit: function (response, postdata) {
                        return afterSubmitCallback(response, postdata);
                    },
                    beforeShowForm: beforeEditCallback
                },
                delOptions: {
                    url: '/user/del',
                    recreateForm: true,
                    beforeShowForm: beforeDeleteCallback,
                    afterSubmit: function (response, postdata) {
                        return afterSubmitCallback(response, postdata);
                    }
                }

            }
        },
            {name: 'uid', index: 'uid', width: 50, sorttype: "int"},
            {name: 'name', index: 'name', width: 80},
            {name: 'real_name', index: 'real_name', width: 65, editable: true},
            {name: 'user_group', index: 'user_group', width: 90},
            {name: 'email', index: 'email', width: 200, editable: true},
            {name: 'mobile', index: 'mobile', width: 120, editable: true},
            {
                name: 'password',
                index: 'password',
                width: 90,
                hidden: true,
                edittype: 'password',
                editable: true,
                editrules: {edithidden: true}
            },
            {
                name: 'password_confirmation',
                index: 'password_confirmation',
                width: 90,
                hidden: true,
                edittype: 'password',
                editable: true,
                editrules: {edithidden: true}
            },
            {name: 'last_login_time', index: 'last_login_time', width: 160},
            {name: 'last_login_ip', index: 'last_login_ip', width: 125},
            {name: 'add_time', index: 'add_time', width: 160},
            {
                name: 'status',
                index: 'status',
                width: 90,
                hidden: true,
                editable: true,
                edittype: 'select',
                editrules: {edithidden: true},
                editoptions: {value: {'1': '正常', '0': '暂停', '-1': '已删除'}, defaultValue: '1'}
            },
            {
                name: 'status_color_name',
                index: 'status_color_name',
                width: 50,
                edittype: 'select',
                align: 'center'
            }];
    </script>
@stop