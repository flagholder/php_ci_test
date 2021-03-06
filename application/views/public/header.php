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
    <link rel="stylesheet" href="/php-ci-test/static/css/cropper.css">
    <link rel="stylesheet" href="/php-ci-test/static/css/cropper_main.css" >

    <link href="/php-ci-test/static/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
    <link href="/php-ci-test/static/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />

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
                <li class="active"><a href="http://localhost:1123/php-ci-test/">Home</a></li>
                <li><a href="http://localhost:1123/php-ci-test/project/create">Create</a></li>
                <li><a href="http://localhost:1123/php-ci-test/project/">My Projects</a></li>
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
                <li><a href="#">Static top</a></li>
                <li class="active"><a href="#">Fixed top <span class="sr-only">(current)</span></a></li>
                <?php if (isset($username) && $username) {?>
                    <li>
                        <a href="http://localhost:1123/php-ci-test/user/showprofile">
                            <span class="fa fa-user fa-fw"></span>&nbsp;<?php echo $username; ?>
                        </a>

                        <a href="http://localhost:1123/php-ci-test/auth/signout">
                            <span class="fa fa-sign-out fa-fw"></span>&nbsp;Sign Out
                        </a>
                    </li>
                <?php } else { ?>
                    <li>
                        <a href="http://localhost:1123/php-ci-test/auth/">
                            <span class="fa fa-sign-in fa-fw"></span>&nbsp;Sign In
                        </a>
                    </li>
                <?php } ?>

            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
