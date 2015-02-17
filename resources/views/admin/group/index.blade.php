@extends('admin.layouts.jqGrid')
@section('script_cfg')
    <script type="text/javascript">
        jqGrid_cfg.colNames = ['操作', 'ID','名称','添加时间','更新','状态','状态'];
        jqGrid_cfg.jsonReader.id = 'gid';
        jqGrid_cfg.colModel = [{
            name: 'operate', index: '', width: 80, fixed: true, sortable: false, resize: false,
            formatter: 'actions',
            formatoptions: {
                keys: true,
                //delbutton: false,//disable delete button
                editformbutton: true,
                editOptions: {
                    url: '/group/edit',
                    recreateForm: true,
                    closeAfterEdit: true,
                    afterSubmit: function (response, postdata) {
                        return afterSubmitCallback(response, postdata);
                    },
                    beforeShowForm: beforeEditCallback
                },
                delOptions: {
                    url: '/group/del',
                    recreateForm: true,
                    beforeShowForm: beforeDeleteCallback,
                    afterSubmit: function (response, postdata) {
                        return afterSubmitCallback(response, postdata);
                    }
                }

            }
        },
            {name: 'id', index: 'group_id', width: 50},
            {name: 'group_name', index: 'group_name', width: 80,editable:true},
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