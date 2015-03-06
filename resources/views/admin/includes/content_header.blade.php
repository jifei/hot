<h1>&nbsp;</h1>
<ol class="breadcrumb" style="float: left;left:10px;right:0px;">
    <li><i class="fa fa-home"></i><a href="/" style="font-size: 13px;">首页</a></li>
    <?php $parents =array_reverse($menu_tree->parents);?>
    @foreach($parents as $v)
        <li><a>{{$v['title']}}</a></li>
    @endforeach
    @if(!empty($menu_tree->current_id))
        <li class="active">{{$menu_tree->current_name}}</li>
    @endif

</ol>


