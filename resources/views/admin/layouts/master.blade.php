<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>AdminLTE 2 | Dashboard</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.1 -->
    <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.2.0 -->
    <link href="/assets/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="/assets/css/ionicons.min.css" rel="stylesheet" type="text/css" />


    <!-- Theme style -->
    <link href="/assets/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        .breadcrumb .fa-home {
            font-size: 20px;
            margin-left: 2px;
            margin-right: 4px;
            vertical-align: middle;
        }
        .content-header .breadcrumb li a {
            display: inline-block;
            color: #4c8fbd;
        }
    </style>
</head>
<body class="skin-blue">
<div class="wrapper">
    <header class="main-header">
        @include('admin.includes.header')
    </header>
    <aside class="main-sidebar left-side">
        @include('admin.includes.sidebar')
    </aside>
    <div class="content-wrapper">
        <section class="content-header">
            @include('admin.includes.content_header')
        </section>
        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
    </div>
    <footer class="main-footer">
        @include('admin.includes.footer')
    </footer>
</div>
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/js/jquery-ui.min.js" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="/assets/js/app.js" type="text/javascript"></script>

<!-- AdminLTE for demo purposes -->
<script src="/assets/js/demo.js" type="text/javascript"></script>
<!-- Main content -->

    @yield('script')
</body>
</html>