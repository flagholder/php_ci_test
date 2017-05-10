<?php $this->load->view('public/header'); ?>


<div class="container">
    <div class="page-header">
        <h1>
            <span class="fa fa-buysellads fa-fw" aria-hidden="true"></span>&nbsp;Edit your profile!
        </h1>
    </div>

    <div class="row">
        <!-- left column -->
        <div class="col-md-3" id="crop-avatar">
<!--            <div class="text-center" >-->
<!--                <img src="//placehold.it/150" id="previewHolder" class="avatar img-circle" alt="avatar" width="150px" height="150px">-->
<!--                <h6>Upload a photo</h6>-->
<!---->
<!--                <input type="file" name="filePhoto" value="" id="filePhoto" class="text-center center-block well well-sm">-->
<!--            </div>-->

            <!-- Current avatar -->
            <div class="avatar-view" title="Change the avatar">
                <?php if ($avatar) {
                    echo "<img src=\"$avatar\" alt=\"Avatar\">";
                } else { ?>
                    <img src="//placehold.it/200" alt="Avatar">
                <?php } ?>
        </div>

            <!-- Cropping modal -->
            <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form class="avatar-form" action="http://localhost:1123/php-ci-test/upload/uploadavatar" enctype="multipart/form-data" method="post">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4>
                            </div>
                            <div class="modal-body">
                                <div class="avatar-body">

                                    <!-- Upload image and data -->
                                    <div class="avatar-upload">
                                        <input type="hidden" class="avatar-src" name="avatar_src">
                                        <input type="hidden" class="avatar-data" name="avatar_data">
                                        <label for="avatarInput">Local upload</label>
                                        <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
                                    </div>

                                    <!-- Crop and preview -->
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="avatar-wrapper"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="avatar-preview preview-lg"></div>
                                            <div class="avatar-preview preview-md"></div>
                                            <div class="avatar-preview preview-sm"></div>
                                        </div>
                                    </div>

                                    <div class="row avatar-btns">
                                        <div class="col-md-9">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary" data-method="rotate" data-option="-90" title="Rotate -90 degrees">Rotate Left</button>
                                                <button type="button" class="btn btn-primary" data-method="rotate" data-option="-15">-15deg</button>
                                                <button type="button" class="btn btn-primary" data-method="rotate" data-option="-30">-30deg</button>
                                                <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45">-45deg</button>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary" data-method="rotate" data-option="90" title="Rotate 90 degrees">Rotate Right</button>
                                                <button type="button" class="btn btn-primary" data-method="rotate" data-option="15">15deg</button>
                                                <button type="button" class="btn btn-primary" data-method="rotate" data-option="30">30deg</button>
                                                <button type="button" class="btn btn-primary" data-method="rotate" data-option="45">45deg</button>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-primary btn-block avatar-save">Done</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal -->

            <!-- Loading state -->
            <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>

        </div>


        <!-- edit form column -->
        <div class="col-md-9 personal-info">
            <div class="alert alert-info alert-dismissable">
                <a class="panel-close close" data-dismiss="alert">×</a>
                <i class="fa fa-coffee"></i>
                This is an <strong>.alert</strong>. Use this to show important messages to the user.
            </div>
            <h3>Personal info</h3>

            <form class="form-horizontal" role="form" id="form_profile" method="post" action="<?php echo base_url('user/editprofile'); ?>">
                <div class="form-group">
                    <label class="col-lg-3 control-label">School</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="text" name="school"  id="school" value="<?php echo $school;?>" placeholder="<?php echo $school;?>" data-provide="typeahead">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Birthday</label>
                    <div class="col-lg-4">
                        <div class="input-group">
                            <input type="text" class="form-control" id="birthday" name="birthday" data-date-end-date="2016-12-31">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label" for="grade">Grade</label>
                    <div class="col-lg-4">
                        <select id="grade" name="grade" class="form-control">
                            <option value="" selected>Choose Grade</option>
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
                    <label class="col-lg-3 control-label">Phone</label>
                    <div class="col-lg-4">
                        <input class="form-control" type="text" value="" placeholder="Input your phone number">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Tag</label>
                    <div class="col-lg-8">
                        <input class="form-control" name="tags" id="tags" type="text" value="" placeholder="Input your project tag" data-role="tagsinput">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <input type="submit" class="btn btn-primary" value="Save Changes" id="'btn_submit">
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="clearfix"> </div>

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

<script src="/php-ci-test/static/js/vendor/bootstrap3-typeahead.min.js"></script>
<script src="/php-ci-test/static/js/vendor/bootstrap-datepicker.min.js"></script>
<script src="/php-ci-test/static/js/vendor/bootstrap-tagsinput.js"></script>
<script src="/php-ci-test/static/js/vendor/cropper.js"></script>

<script src="/php-ci-test/static/js/cropper_main.js"></script>
<script src="/php-ci-test/static/js/plugins.js"></script>
<!--<script src="/php-ci-test/static/js/main.js"></script>-->
<script>
    $(document).ready(function(){
        $('#form_profile').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
    });
    $('#tags').tagsinput({
        maxTags: 5
    });
    $('#tags').tagsinput({
        maxChars: 20
    });


    $('#birthday').datepicker({
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

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#previewHolder').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#filePhoto").change(function() {
        readURL(this);
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
