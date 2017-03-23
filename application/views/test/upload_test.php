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

    <!-- blueimp Gallery styles -->
    <link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="/php-ci-test/static/css/jquery_file_upload/jquery.fileupload.css">
    <link rel="stylesheet" href="/php-ci-test/static/css/jquery_file_upload/jquery.fileupload-ui.css">

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

    <div class="">

        <!-- The file upload form used as target for the file upload widget -->
        <form class="form-horizontal" id="fileupload" action="<?php echo base_url('upload/uploadimg') ?>" method="POST" enctype="multipart/form-data">

            <div>
                <?php echo validation_errors(); ?>
            </div>

            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class="row fileupload-buttonbar">
                <div class="col-lg-7">
                    <!-- The fileinput-button span is used to style the file input field as button -->
                    <span class="btn btn-success fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Add files...</span>
                <input type="file" name="files" multiple>
            </span>
                    <button type="submit" class="btn btn-primary start">
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>Start upload</span>
                    </button>
                    <button type="reset" class="btn btn-warning cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancel upload</span>
                    </button>
                    <button type="button" class="btn btn-danger delete">
                        <i class="glyphicon glyphicon-trash"></i>
                        <span>Delete</span>
                    </button>
                    <input type="checkbox" class="toggle">
                    <!-- The global file processing state -->
                    <span class="fileupload-process"></span>
                </div>
                <!-- The global progress state -->
                <div class="col-lg-5 fileupload-progress fade">
                    <!-- The global progress bar -->
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                    </div>
                    <!-- The extended global progress state -->
                    <div class="progress-extended">&nbsp;</div>
                </div>
            </div>
            <!-- The table listing the files available for upload/download -->
            <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
        </form>
        <!-- The blueimp Gallery widget -->
        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
            <div class="slides"></div>
            <h3 class="title"></h3>
            <a class="prev">‹</a>
            <a class="next">›</a>
            <a class="close">×</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
        </div>

        <div class="clearfix">&nbsp;</div>

    </div>

</div>


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


<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="/php-ci-test/static/js/vendor/jquery_file_upload/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="https://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- blueimp Gallery script -->
<script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>

<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="/php-ci-test/static/js/vendor/jquery_file_upload/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="/php-ci-test/static/js/vendor/jquery_file_upload/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="/php-ci-test/static/js/vendor/jquery_file_upload/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="/php-ci-test/static/js/vendor/jquery_file_upload/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="/php-ci-test/static/js/vendor/jquery_file_upload/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="/php-ci-test/static/js/vendor/jquery_file_upload/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="/php-ci-test/static/js/vendor/jquery_file_upload/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="/php-ci-test/static/js/vendor/jquery_file_upload/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="/php-ci-test/static/js/vendor/jquery_file_upload/main.js"></script>

<script src="/php-ci-test/static/js/plugins.js"></script>
<script src="/php-ci-test/static/js/main.js"></script>

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