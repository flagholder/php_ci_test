<?php $this->load->view('public/header'); ?>

<div class="container">
    <div class="page-header">
        <h1>
            <span class="fa fa-buysellads fa-fw" aria-hidden="true"></span>&nbsp;Some Errors Happened!
        </h1>
    </div>

    <div class="well well-sm">
        <p><?php echo $errors;?></p>
        <div class="clearfix">&nbsp;</div>

    </div>

</div>

<?php $this->load->view('public/footer'); ?>
