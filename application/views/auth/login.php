<?php $this->load->view('public/header'); ?>

<!-- login form -->
<div class="container">
    <div class="page-header">
        <h1>
            <span class="fa fa-buysellads fa-fw" aria-hidden="true"></span>&nbsp;Sign In!
        </h1>
    </div>

    <div class="well well-sm">
        <form class="form-horizontal">
            <div class="form-group">
                <label for="yourName" class="control-label col-sm-3">Username</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user fa-fw" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" id="login" placeholder="Your register email">
                    </div>
                </div>
            </div>

<!--            <div class="form-group">-->
<!--                <label for="yourEmail" class="control-label col-sm-3">Email address</label>-->
<!--                <div class="col-sm-9">-->
<!--                    <div class="input-group">-->
<!--                        <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i></span>-->
<!--                        <input type="email" class="form-control" id="yourEmail" placeholder="Your Email Id">-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

            <div class="form-group">
                <label for="password" class="control-label col-sm-3">Password</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i></span>
                        <input type="password" class="form-control" id="password" placeholder="Your password">
                    </div>
                </div>
            </div>


            <div class="clearfix form-group">&nbsp;</div>

            <div class="text-center col-sm-12 form-group">
                <button type="submit" class="btn btn-info">
                    <i class="fa fa-envelope fa-fw"></i>&nbsp;SIGN IN
                </button>
            </div>
        </form>
        <div class="clearfix">&nbsp;</div>
    </div>

</div>

<?php $this->load->view('public/footer'); ?>
