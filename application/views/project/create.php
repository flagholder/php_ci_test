<?php $this->load->view('public/header'); ?>

<!-- login form -->
<div class="container">
    <div class="page-header">
        <h1>
            <span class="fa fa-buysellads fa-fw" aria-hidden="true"></span>&nbsp;Create a new project
        </h1>
    </div>

    <div class="">

        <form class="form-horizontal" action="<?php echo base_url('project/create') ?>" id="form_create_project" method="post">

            <div>
                <?php //echo validation_errors(); ?>
            </div>

            <!-- Textarea -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="title">Project Title</label>
                <div class="col-md-4">
                    <textarea class="form-control" id="title" name="title" placeholder="Give your project a great title"></textarea>
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="start_at">Start Date</label>
                <div class="col-md-3">
                    <input id="start_at" name="start_at" placeholder="Start date" class="form-control input-md"
                           type="text">

                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="end_at">End Date</label>
                <div class="col-md-3">
                    <input id="end_at" name="end_at" placeholder="End date" class="form-control input-md" type="text">

                </div>
            </div>

            <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="grade">Grade</label>
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


            <div class="clearfix form-group">&nbsp;</div>

            <div class="text-center col-sm-12 form-group">
                <button class="btn btn-info" id="btn_submit">
                    <i class="fa fa-sign-in fa-fw"></i>&nbsp;CREATE
                </button>
            </div>

        </form>
        <div class="clearfix">&nbsp;</div>

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