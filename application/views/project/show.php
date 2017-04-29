<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Create and show project for kids!">
    <meta name="author" content="Jerry Shen">
    <link rel="icon" href="static/favicon.ico">

    <title>Create and show projects</title>

    <!-- Bootstrap core CSS -->
    <link href="/php-ci-test/static/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/php-ci-test/static/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <link rel="stylesheet" href="/php-ci-test/static/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
    <!-- Include Editor style. -->
    <link href="/php-ci-test/static/css/froala/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css"/>
    <link href="/php-ci-test/static/css/froala/froala_style.min.css" rel="stylesheet" type="text/css"/>


    <!-- Custom styles for this template -->
    <!--    <link href="https://getbootstrap.com/examples/navbar-fixed-top/navbar-fixed-top.css" rel="stylesheet">-->
    <link href="/php-ci-test/static/css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">X-Projects</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Nav header</li>
                        <li><a href="#">Separated link</a></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="../navbar-static-top/">Static top</a></li>
                <li class="active"><a href="./">Fixed top <span class="sr-only">(current)</span></a></li>
                <li><a href="http://localhost:1123/php-ci-test/auth/"><span class="fa fa-sign-in fa-fw"></span>&nbsp;Sign
                        In</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>


<!-- Project create form -->
<div class="container">
    <div class="page-header">
        <h1>
            <span class="fa fa-buysellads fa-fw" aria-hidden="true"></span>&nbsp;Create a new project
        </h1>
    </div>

    <div>
        <div class="col-lg-3">
            <!-- Sidebar -->
            <nav class="navbar" id="sidebar-wrapper" role="navigation">
                <ul class="nav sidebar-nav">
                    <li class="">
                        <a href="#">
                            <i class="fa fa-user" aria-hidden="true"></i> My Projects
                        </a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-rocket" aria-hidden="true"></i> My Grade Projects</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-home" aria-hidden="true"></i>
                            My School Projects</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-file" aria-hidden="true"></i>
                            Other Projects</a>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Works <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="dropdown-header">Dropdown heading</li>
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li><a href="#">Separated link</a></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /#sidebar-wrapper -->
        </div>
        <div class="col-lg-9">
            <h3>Project Title</h3>
            <div>
                <p>Project content</p>
                <p>
                    <?php
                    if (isset($records)) {
                        print_r($records);
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>

</div>

<?php //$this->load->view('public/footer'); ?>

<div class="container">
    <!-- FOOTER -->
    <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; 2017 X-Projects, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
    </footer>
</div>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/php-ci-test/static/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

<script src="/php-ci-test/static/js/vendor/bootstrap.min.js"></script>
<script src="/php-ci-test/static/js/vendor/froala/froala_editor.pkgd.min.js"></script>
<script src="/php-ci-test/static/js/plugins.js"></script>
<script src="/php-ci-test/static/js/main.js"></script>

<!-- Initialize the editor. -->
<script>
    $(function () {
//    $('.editor').froalaEditor({initOnClick: true});
        $('#content').froalaEditor({
            imageUploadURL: 'http://localhost:1123/php-ci-test/upload/upload'
        });
    });
</script>

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
    (function (b, o, i, l, e, r) {
        b.GoogleAnalyticsObject = l;
        b[l] || (b[l] =
            function () {
                (b[l].q = b[l].q || []).push(arguments)
            });
        b[l].l = +new Date;
        e = o.createElement(i);
        r = o.getElementsByTagName(i)[0];
        e.src = '//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e, r)
    }(window, document, 'script', 'ga'));
    ga('create', 'UA-XXXXX-X', 'auto');
    ga('send', 'pageview');
</script>

</body>
</html>