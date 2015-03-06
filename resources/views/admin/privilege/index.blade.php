@extends('admin.layouts.jqGrid')
@section('script_cfg')
    <script type="text/javascript">
        jqGrid_cfg.colNames = ['操作', '权限ID', '权限名称', '权限类型','权限类型', '父级ID', '父级名称', '链接地址', '添加时间', '更新时间', '状态', '状态'];
        jqGrid_cfg.jsonReader.id = 'pid';
        jqGrid_cfg.tree_id = "ppid";
        jqGrid_cfg.tree_url = "/privilege/all";
        jqGrid_cfg.afterShowFormCallback = 'afterShowTreeFormSingleCallback';

        jqGrid_cfg.colModel = [{
            name: 'operate', index: '', width: 80, fixed: true, sortable: false, resize: false,
            formatter: 'actions',
            formatoptions: {
                keys: true,
                //delbutton: false,//disable delete button
                editformbutton: true,
                editOptions: {
                    url: '/privilege/edit',
                    recreateForm: true,
                    closeAfterEdit: true,
                    afterShowForm: function (e) {
                        window[jqGrid_cfg.afterShowFormCallback](e);
                    },
                    afterSubmit: function (response, postdata) {
                        return afterSubmitCallback(response, postdata);
                    },
                    beforeSubmit: function (postdata, formid) {
                        return window[jqGrid_cfg.beforeSubmitCallback](postdata, formid);
                    },
                    beforeShowForm: beforeEditCallback
                },
                delOptions: {
                    url: '/privilege/del',
                    recreateForm: true,
                    beforeShowForm: beforeDeleteCallback,
                    afterSubmit: function (response, postdata) {
                        return afterSubmitCallback(response, postdata);
                    }
                }

            }
        },
            {name: 'pid', index: 'pid', width: 50},
            {name: 'title', index: 'title', width: 80, editable: true},
            {
                name: 'type_name',
                index: 'type_name',
                width: 60
            },
            {
                name: 'type', index: 'type', width: 80, hidden: true, editable: true, edittype: 'select',
                editrules: {edithidden: true},
                editoptions: {value: {'1': '菜单', '2': '按钮'}, defaultValue: '1'}
            },
            {
                name: 'ppid',
                index: 'ppid',
                width: 80,
                editable: true,
                edittype: 'custom',
                editoptions: {custom_element: treeElem, custom_value: treeValue}
            },
            {name: 'p_title', index: 'p_title', width: 80},
            {name: 'url', index: 'url', width: 80, editable: true},
            {name: 'add_time', index: 'add_time', width: 160},
            {name: 'update_time', index: 'update_time', width: 160},
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