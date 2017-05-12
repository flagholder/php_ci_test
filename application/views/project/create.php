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
    <link rel="stylesheet" href="/php-ci-test/static/css/cropper_main.css">

    <link href="/php-ci-test/static/css/bootstrap-datepicker3min.css" rel="stylesheet" type="text/css"/>
    <link href="/php-ci-test/static/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"/>

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

    <div class="">

        <form class="form-horizontal" action="<?php echo base_url('project/submit') ?>" id="form_create_project"
              enctype="multipart/form-data"  method="post">

            <div>
                <?php echo validation_errors(); ?>
            </div>

            <!-- Textarea -->
            <div class="form-group">
                <label class="col-md-3 control-label" for="title">Project Title</label>
                <div class="col-md-6">
                    <textarea class="form-control" id="title" name="title"
                              placeholder="Give your project a great title"></textarea>
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-3 control-label" for="start_at">Start Date</label>
                <div class="col-md-3">
                    <input id="start_at" name="start_at" placeholder="Start date" class="form-control input-md"
                           type="text">

                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-3 control-label" for="end_at">End Date</label>
                <div class="col-md-3">
                    <input id="end_at" name="end_at" placeholder="End date" class="form-control input-md" type="text">

                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-3 control-label" for="school">School</label>
                <div class="col-md-3">
                    <input id="school" name="school" placeholder="Your current school" class="form-control input-md"
                           type="text">
                </div>
            </div>

            <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-3 control-label" for="grade">Grade</label>
                <div class="col-md-3">
                    <select id="grade" name="grade" class="form-control">
                        <option value="K">Grade K</option>
                        <option value="1">Grade 1</option>
                        <option value="2">Grade 2</option>
                        <option value="3">Grade 3</option>
                        <option value="4">Grade 4</option>
                        <option value="5">Grade 5</option>
                        <option value="6">Grade 6</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="cover">Project Cover</label>

                <div class="col-md-3 input-group">
                    <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Browse… <input id="cover" name="cover" style="display: none;" type="file">
                    </span>
                    </label>
                    <input id="cover_file_name" name="cover_file_name" class="form-control" readonly="" type="text">
                </div>
            </div>

            <!-- Textarea -->
            <div class="form-group">
                <label class="col-md-3 control-label" for="title">Project Content</label>
                <div class="col-md-9">
                    <textarea class="form-control" id="content" name="content"
                              placeholder="Write your project here"></textarea>
                </div>
            </div>


            <div class="clearfix form-group">&nbsp;</div>

            <div class="text-center col-sm-12 form-group">
                <button class="btn btn-info" id="btn_submit">
                    <i class="fa fa-sign-in fa-fw"></i>&nbsp;CREATE
                </button>
            </div>

        </form>
        <div class="clearfix">&nbsp;</div>


        <!--          Cover Image  -->
        <!--                    <div class="container form-group" id="crop-avatar">-->
        <!--                        <label class="col-md-3 control-label" for="">Cover Picture</label>-->
        <!--                        <div class="avatar-view" title="Upload a project cover picture">-->
        <!--                            <img src="//placehold.it/320x200" alt="Cover">-->
        <!--                        </div>-->
        <!---->
        <!--                        <!-- Cropping modal -->-->
        <!--                        <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">-->
        <!--                            <div class="modal-dialog modal-lg">-->
        <!--                                <div class="modal-content">-->
        <!--                                    <form class="avatar-form" action="http://localhost:1123/php-ci-test/upload/uploadavatar" enctype="multipart/form-data" method="post">-->
        <!--                                        <div class="modal-header">-->
        <!--                                            <button type="button" class="close" data-dismiss="modal">&times;</button>-->
        <!--                                            <h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4>-->
        <!--                                        </div>-->
        <!--                                        <div class="modal-body">-->
        <!--                                            <div class="avatar-body">-->
        <!---->
        <!--                                                <!-- Upload image and data -->-->
        <!--                                                <div class="avatar-upload">-->
        <!--                                                    <input type="hidden" class="avatar-src" name="avatar_src">-->
        <!--                                                    <input type="hidden" class="avatar-data" name="avatar_data">-->
        <!--                                                    <label for="avatarInput">Local upload</label>-->
        <!--                                                    <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">-->
        <!--                                                </div>-->
        <!---->
        <!--                                                <!-- Crop and preview -->-->
        <!--                                                <div class="row">-->
        <!--                                                    <div class="col-md-9">-->
        <!--                                                        <div class="avatar-wrapper"></div>-->
        <!--                                                    </div>-->
        <!--                                                    <div class="col-md-3">-->
        <!--                                                        <div class="avatar-preview preview-lg"></div>-->
        <!--                                                        <div class="avatar-preview preview-md"></div>-->
        <!--                                                        <div class="avatar-preview preview-sm"></div>-->
        <!--                                                    </div>-->
        <!--                                                </div>-->
        <!---->
        <!--                                                <div class="row avatar-btns">-->
        <!--                                                    <div class="col-md-9">-->
        <!--                                                        <div class="btn-group">-->
        <!--                                                            <button type="button" class="btn btn-primary" data-method="rotate" data-option="-90" title="Rotate -90 degrees">Rotate Left</button>-->
        <!--                                                            <button type="button" class="btn btn-primary" data-method="rotate" data-option="-15">-15deg</button>-->
        <!--                                                            <button type="button" class="btn btn-primary" data-method="rotate" data-option="-30">-30deg</button>-->
        <!--                                                            <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45">-45deg</button>-->
        <!--                                                        </div>-->
        <!--                                                        <div class="btn-group">-->
        <!--                                                            <button type="button" class="btn btn-primary" data-method="rotate" data-option="90" title="Rotate 90 degrees">Rotate Right</button>-->
        <!--                                                            <button type="button" class="btn btn-primary" data-method="rotate" data-option="15">15deg</button>-->
        <!--                                                            <button type="button" class="btn btn-primary" data-method="rotate" data-option="30">30deg</button>-->
        <!--                                                            <button type="button" class="btn btn-primary" data-method="rotate" data-option="45">45deg</button>-->
        <!--                                                        </div>-->
        <!--                                                    </div>-->
        <!--                                                    <div class="col-md-3">-->
        <!--                                                        <button type="submit" class="btn btn-primary btn-block avatar-save">Done</button>-->
        <!--                                                    </div>-->
        <!--                                                </div>-->
        <!--                                            </div>-->
        <!--                                        </div>-->
        <!--                                    </form>-->
        <!--                                </div>-->
        <!--                            </div>-->
        <!--                        </div><!-- /.modal -->-->
        <!---->
        <!--                        <!-- Loading state -->-->
        <!--                        <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>-->
        <!---->
        <!--                    </div>-->
        <!---->
        <!--    </div>-->

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

    <script src="/php-ci-test/static/js/vendor/bootstrap3-typeahead.min.js"></script>
    <script src="/php-ci-test/static/js/vendor/bootstrap-datepicker.min.js"></script>
    <script src="/php-ci-test/static/js/vendor/bootstrap-tagsinput.js"></script>
    <script src="/php-ci-test/static/js/vendor/cropper.js"></script>
    <script src="/php-ci-test/static/js/cropper_main.js"></script>
    <script src="/php-ci-test/static/js/vendor/froala/froala_editor.pkgd.min.js"></script>

    <script src="/php-ci-test/static/js/plugins.js"></script>
    <script src="/php-ci-test/static/js/main.js"></script>

    <!-- Initialize the editor. -->
    <script>

        $('#start_at').datepicker({
            format: "yyyy-mm-dd",
            startView: 2,
            maxViewMode: 3
        });

        $('#end_at').datepicker({
            format: "yyyy-mm-dd",
            startView: 2,
            maxViewMode: 3
        });

        $("#school").typeahead({
            source: function (query, process) {
                return $.get('http://www.greatschools.org/gsr/search/suggest/school?query=' + query, function (data) {
                    return data[0]["school_name"];
                });
            }
        });

        $(function () {
//    $('.editor').froalaEditor({initOnClick: true});
            $('#content').froalaEditor({
                imageUploadURL: 'http://localhost:1123/php-ci-test/upload/upload',
                height: 300,
                toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'fontFamily', 'fontSize', 'insertLink', 'insertImage', 'insertTable', 'undo', 'redo']
            });
        });

        $(function() {
            $('#cover').change(function () {
                var input = $(this);
                var label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.parents('.input-group').find(':text').val(label);
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