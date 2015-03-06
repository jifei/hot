@extends('admin.layouts.master')
@section('content')
    <link
            href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"
            rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/jqGrid/css/ui.jqgrid.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/jqGrid.bootstrap.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/jstree/dist/themes/default/style.min.css"/>
    <table id="grid-table"></table>
    <div id="grid-pager"></div>
@stop
@section('script')
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="/assets/jqGrid/js/i18n/grid.locale-cn.js" type="text/javascript"></script>
    <script src="/assets/jqGrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>
    <script src="/assets/jstree/dist/jstree.min.js"></script>
    <script type="text/javascript">
        var jqGrid_cfg = {
            min_width: 800,
            max_width: 2000,
            min_height: 500,
            grid_selector: "#grid-table",
            pager_selector: "#grid-pager",
            colNames: [],
            jsonReader: {
                root: "items",
                page: "current_page",
                total: "last_page",
                records: "total",
                repeatitems: false,
                sortorder: 'desc',
                id: "uid"
            },
            colModel: [], rowNum: 20,
            rowList: [20, 50, 100],
            caption: " ",
            editurl: "{{Request::segment(1)}}/edit",
            delurl: "{{Request::segment(1)}}/del",
            addurl: "{{Request::segment(1)}}/add",
            url: "{{Request::segment(1)}}/data",
            filters:{},
            navOptions: { 	//navbar options
                edit: true,
                editicon: 'fa fa-pencil blue',
                add: true,
                addicon: 'fa fa-plus-circle purple',
                del: true,
                delicon: 'fa fa-trash-o red',
                search: true,
                searchicon: 'fa fa-search orange',
                refresh: true,
                refreshicon: 'fa fa-refresh green',
                view: true,
                viewicon: 'fa fa-search-plus grey'
            },
            beforeSubmitCallback: 'beforeSubmitCallback',
            afterShowFormCallback: 'afterShowFormCallback',
            tree_id: '',
            tree_url: ''
        };
        function style_edit_form(form) {
            //enable datepicker on "sdate" field and switches for "stock" field
            form.find('input[name=sdate]').datepicker({format: 'yyyy-mm-dd', autoclose: true})

            form.find('input[name=stock]').addClass('ace ace-switch ace-switch-5').after('<span class="lbl"></span>');
            //don't wrap inside a label element, the checkbox value won't be submitted (POST'ed)
            //.addClass('ace ace-switch ace-switch-5').wrap('<label class="inline" />').after('<span class="lbl"></span>');


            //update buttons classes
            var buttons = form.next().find('.EditButton .fm-button');
            buttons.addClass('btn btn-sm').find('[class*="-icon"]').hide();//ui-icon, s-icon
            buttons.eq(0).addClass('btn-primary').prepend('<i class="ace-icon fa fa-check"></i>');
            buttons.eq(1).prepend('<i class="ace-icon fa fa-times"></i>')

            buttons = form.next().find('.navButton a');
            buttons.find('.ui-icon').hide();
            buttons.eq(0).append('<i class="ace-icon fa fa-chevron-left"></i>');
            buttons.eq(1).append('<i class="ace-icon fa fa-chevron-right"></i>');
        }

        function style_delete_form(form) {
            var buttons = form.next().find('.EditButton .fm-button');
            buttons.addClass('btn btn-sm btn-white btn-round').find('[class*="-icon"]').hide();//ui-icon, s-icon
            buttons.eq(0).addClass('btn-danger').prepend('<i class="ace-icon fa fa-trash-o"></i>');
            buttons.eq(1).addClass('btn-default').prepend('<i class="ace-icon fa fa-times"></i>')
        }

        function style_search_filters(form) {
            form.find('.delete-rule').val('X');
            form.find('.add-rule').addClass('btn btn-xs btn-primary');
            form.find('.add-group').addClass('btn btn-xs btn-success');
            form.find('.delete-group').addClass('btn btn-xs btn-danger');
        }

        function style_search_form(form) {
            var dialog = form.closest('.ui-jqdialog');
            var buttons = dialog.find('.EditTable')
            buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'ace-icon fa fa-retweet');
            buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'ace-icon fa fa-comment-o');
            buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'ace-icon fa fa-search');
        }

        function beforeAddCallBack(e) {
            $('#tr_password', e).show();
            $('#tr_password_confirmation', e).show();
            var form = $(e[0]);
            style_edit_form(form);

        }

        function beforeDeleteCallback(e) {
            var form = $(e[0]);
            if (form.data('styled')) return false;

            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
            style_delete_form(form);

            form.data('styled', true);
        }

        function beforeEditCallback(e) {
            //$('#tr_password', e).hide();
            // $('#tr_password_confirmation', e).hide();
            var form = $(e[0]);
            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
            style_edit_form(form);
        }

        function afterShowFormCallback(e) {

        }

        function afterShowTreeFormSingleCallback(e) {
            $("#" + jqGrid_cfg.tree_id).jstree({
                'core': {
                    "multiple": false,
                    "data": {
                        "url": jqGrid_cfg.tree_url+'?id='+$("input[name='grid-table_id']").val(),
                        "type": "get",
                        "data": function (response) {

                        }

                    }
                },

                "checkbox": {
                    // "keep_selected_style": false,
                    "multiple": false,
                    "three_state": false
                    //"tie_selection": false
                },

                "plugins": ["wholerow", "checkbox"]
            }).bind("loaded.jstree", function (event, data) {
                data.instance.open_all();
            }).bind("check_node.jstree", function (event, data) {
                        if (data.selected.length > 1) {
                            for (var i = 0 in data.selected) {
                                if (i < data.selected.length) {
                                    data.instance.uncheck_node(data.instance.get_node(data.selected[i]));
                                }
                            }
                        }
                    }
            );
        }


        //unlike navButtons icons, action icons in rows seem to be hard-coded
        //you can change them like this in here if you want
        function updateActionIcons(table) {

//             var replacement =
//             {
//                 'ui-ace-icon fa fa-pencil' : 'ace-icon fa fa-pencil blue',
//                 'ui-ace-icon fa fa-trash-o' : 'ace-icon fa fa-trash-o red',
//                 'ui-icon-disk' : 'ace-icon fa fa-check green',
//                 'ui-icon-cancel' : 'ace-icon fa fa-times red'
//             };
//             $(table).find('.ui-pg-div span.ui-icon').each(function(){
//						var icon = $(this);
//						var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
//						if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
//					})

        }

        //replace icons with FontAwesome icons like above
        function updatePagerIcons(table) {
            var replacement =
            {
                'ui-icon-seek-first': 'fa fa-angle-double-left bigger-140',
                'ui-icon-seek-prev': 'fa fa-angle-left bigger-140',
                'ui-icon-seek-next': 'fa fa-angle-right bigger-140',
                'ui-icon-seek-end': 'fa fa-angle-double-right bigger-140'
            };
            $('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function () {
                var icon = $(this);
                var $class = $.trim(icon.attr('class').replace('ui-icon', ''));

                if ($class in replacement) icon.attr('class', 'ui-icon ' + replacement[$class]);
            })
        }

        function enableTooltips(table) {
            $('.navtable .ui-pg-button').tooltip({container: 'body'});
            $(table).find('.ui-pg-div').tooltip({container: 'body'});
        }

        function beforeSubmitCallback(postdata, formid) {
            return [true, ''];
        }

        /**
         * 获取tree值
         * @param $tree
         * @returns {string}
         */
        function getTreeCheckedVal($tree) {
            var checked_ids = [];
            var checked=$tree.jstree("get_checked", null, true);
            for(var i in checked)
            {
                checked_ids.push(checked[i]);
            }
            return checked_ids.join(",");
        }
        function beforeTreeSubmitCallback(postdata, formid) {
            postdata[jqGrid_cfg.tree_id] = getTreeCheckedVal($("#" + jqGrid_cfg.tree_id));
            return [true, ''];
        }

        function afterSubmitCallback(response, postdata) {
            var json = response.responseText; //in my case response text form server is "{sc:true,msg:''}"
            var result = eval("(" + json + ")"); //create js object from server reponse
            return [result.code != 200 ? false : true, result.msg, null];
        }


        function treeElem(value, options) {
//            var el = document.createElement("input");
//            el.type="text";
//            el.value = value;
            var el = "<div id=\"jstree_demo_div\">" + value + "</div>";
            return el;
        }

        function treeValue(elem, operation, value) {
            if (operation === 'get') {
                return $(elem).val();
            } else if (operation === 'set') {
                $('input', elem).val(value);
            }
        }
    </script>
    @yield('script_cfg')
    <script type="text/javascript">
        $(function () {
            if (jqGrid_cfg.tree_id != '') {
                jqGrid_cfg.beforeSubmitCallback = 'beforeTreeSubmitCallback';
            }
            $('.ui-jqgrid-hdiv').hide();
            //resize to fit page size
            $(window).on('resize.jqGrid', function () {
                $(jqGrid_cfg.grid_selector).jqGrid('setGridWidth', Math.min(Math.max(parseInt($(".content").width()), jqGrid_cfg.min_width), jqGrid_cfg.max_width));
                $(jqGrid_cfg.grid_selector).jqGrid('setGridHeight', Math.max(parseInt($(window).height() - 310), jqGrid_cfg.min_height));
            })
            $(jqGrid_cfg.grid_selector).on('reloadGrid', function () {
                $(jqGrid_cfg.grid_selector).jqGrid('setGridWidth', Math.min(Math.max(parseInt($(".content").width()), jqGrid_cfg.min_width), jqGrid_cfg.max_width));
                $(jqGrid_cfg.grid_selector).jqGrid('setGridHeight', Math.max(parseInt($(window).height() - 310), jqGrid_cfg.min_height));
                //here the userData is old data not the reloaded one.
            })
            $(jqGrid_cfg.grid_selector).on('jqGridAfterLoadComplete', function () {
                $(jqGrid_cfg.grid_selector).jqGrid('setGridWidth', Math.min(Math.max(parseInt($(".content").width()), jqGrid_cfg.min_width), jqGrid_cfg.max_width));
                $(jqGrid_cfg.grid_selector).jqGrid('setGridHeight', Math.max(parseInt($(window).height() - 310), jqGrid_cfg.min_height));
                //here the userData is old data not the reloaded one.
            })

            jQuery(jqGrid_cfg.grid_selector).jqGrid({
                        datatype: "json",
                        url: jqGrid_cfg.url,
                        jsonReader: jqGrid_cfg.jsonReader,
                        //height:'auto',
                        shrinkToFit: false,
                        //subGrid : true,
                        colNames: jqGrid_cfg.colNames,
                        colModel: jqGrid_cfg.colModel,
                        sortname: jqGrid_cfg.jsonReader.id,
                        sortorder: jqGrid_cfg.jsonReader.sortorder,
                        viewrecords: true,
                        hidegrid: false,
                        rowNum: jqGrid_cfg.rowNum,
                        rowList: jqGrid_cfg.rowList,
                        pager: jqGrid_cfg.pager_selector,
                        altRows: true,
                        multiselect: true,
                        multiboxonly: true,
                        loadComplete: function () {
                            var table = this;
                            setTimeout(function () {
                                //styleCheckbox(table);
                                updateActionIcons(table);
                                updatePagerIcons(table);
                                enableTooltips(table);
                            }, 0);
                        },
                        editurl: jqGrid_cfg.editurl,//nothing is saved
                        //addurl:"/user/add",
                        grouping: true,
                        caption: jqGrid_cfg.caption,
                        postData: { filters: JSON.stringify(jqGrid_cfg.filters)}
                    }
            );

            //navButtons
            jQuery(jqGrid_cfg.grid_selector).jqGrid('navGrid', jqGrid_cfg.pager_selector,
                    jqGrid_cfg.navOptions,
                    {
                        //edit record form
                        //closeAfterEdit: true,
                        //width: 700,
                        url: jqGrid_cfg.editurl,
                        recreateForm: true,
                        closeAfterEdit: true,
                        reloadAfterSubmit: true,
                        beforeShowForm: function (e) {
                            beforeEditCallback(e);
                        },
                        afterShowForm: function (e) {
                            window[jqGrid_cfg.afterShowFormCallback](e);
                        },
                        afterSubmit: function (response, postdata) {
                            return afterSubmitCallback(response, postdata);
                        },
                        beforeSubmit: function (postdata, formid) {
                            return window[jqGrid_cfg.beforeSubmitCallback](postdata, formid);
                        }
                    },
                    {
                        //new record form
                        //width: 700,
                        url: jqGrid_cfg.addurl,
                        closeAfterAdd: true,
                        recreateForm: true,
                        viewPagerButtons: false,
                        beforeShowForm: function (e) {
                            beforeAddCallBack(e);
                        },
                        afterShowForm: function (e) {
                            window[jqGrid_cfg.afterShowFormCallback](e);
                        },
                        afterSubmit: function (response, postdata) {
                            return afterSubmitCallback(response, postdata);
                        },
                        beforeSubmit: function (postdata, formid) {
                            return window[jqGrid_cfg.beforeSubmitCallback](postdata, formid);
                        }
                    },
                    {
                        //delete record form
                        url: jqGrid_cfg.delturl,
                        recreateForm: true,
                        beforeShowForm: function (e) {
                            beforeDeleteCallback(e);
                        },
                        onClick: function (e) {
                            //alert(1);
                        },
                        afterSubmit: function (response, postdata) {
                            return afterSubmitCallback(response, postdata);
                        }
                    },
                    {
                        //search form
                        recreateForm: true,
                        afterShowSearch: function (e) {
                            var form = $(e[0]);
                            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                            style_search_form(form);
                        },
                        afterRedraw: function () {
                            style_search_filters($(this));
                        }
                        ,
                        multipleSearch: true
                        /**
                         multipleGroup:true,
                         showQuery: true
                         */
                    },
                    {
                        //view record form
                        recreateForm: true,
                        beforeShowForm: function (e) {
                            var form = $(e[0]);
                            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                        }
                    }
            )

//            jQuery("#gridTable").jqGrid('navGrid','#gridPager',
//                    {edit:true,add:true,del:true,search:true},
//                    {height:200,reloadAfterSubmit:true}
//            );


            // Setup filters
            // jQuery(grid_selector).jqGrid('filterToolbar',{defaultSearch:true,stringResult:true});

            //var selr = jQuery(grid_selector).jqGrid('getGridParam','selrow');

            $(document).one('ajaxloadstart.page', function (e) {
                $(jqGrid_cfg.grid_selector).jqGrid('GridUnload');
                $('.ui-jqdialog').remove();
            });


            // Set grid width to #content
            // $("#gridTable").jqGrid('setGridWidth', $("#content").width(), true);

        });
    </script>
@stop