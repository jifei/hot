@extends('admin.layouts.jqGrid')
<!-- Modal -->
<div class="modal fade" id="privilegeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">群组权限设置</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="gid">

                <div id="privilegeTree"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary submit">提交</button>
            </div>
        </div>
    </div>
</div>
@section('script_cfg')
    <script type="text/javascript">
        jqGrid_cfg.colNames = ['操作','设置权限', 'ID','名称','添加时间','更新','状态','状态'];
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
            {name: '设置权限', index: 'gid', width: 100, formatter: privilegeFmatter},
            {name: 'gid', index: 'gid', width: 50},
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

        function privilegeFmatter(cellvalue, options, rowObject) {
            // do something here
            return "<button data-id=\"" + rowObject.gid + "\" type=\"button\" class=\"btn btn-primary btn-sm privilegeModalLink\" data-toggle=\"modal\">设置权限</button>";
        }

        $("body").delegate(".privilegeModalLink", "click", function () {
            var gid = $(this).attr("data-id");
            $("#privilegeModal input[name='gid']").val(gid);
            $("#privilegeTree").replaceWith("<div id=\"privilegeTree\"></div>");
            $("#privilegeTree").jstree({
                'core': {
                    "multiple": true,
                    "data": {
                        "url": '/group/privileges/'+gid,
                        "type": "get",
                        "data": function (response) {

                        }

                    }
                },

                "checkbox": {
                    // "keep_selected_style": false,
                    "multiple": true,
                    "three_state": false
                    //"tie_selection": false
                },

                "plugins": ["wholerow", "checkbox"]
            }).bind("loaded.jstree", function (event, data) {
                data.instance.open_all();
            });
            $("#privilegeModal").modal("show");
        });

        $("#privilegeModal .submit").click(function () {
            var pids = getTreeCheckedVal($("#privilegeTree"));
            $.ajax({
                url: 'group/setPrivileges/' + $("#privilegeModal input[name='gid']").val(),
                data: {pids: pids},
                type: 'post',
                dataType: 'json',
                success: function (response) {
                    if (response.code == 200) {
                        //$(jqGrid_cfg.grid_selector).trigger('reloadGrid');
                        $("#privilegeModal").modal('hide');
                    } else {
                        alert(response.msg);
                    }
                }
            });
        });
    </script>
@stop