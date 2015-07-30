<?php
use \common\modules\multilingual\widgets\LanguageSwitcherWidget\BackendLanguageSwitcherWidget;
?>
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">proactive.fm</a>

</div>
<!-- /.navbar-header -->

<ul class="nav navbar-top-links navbar-right">
<li>
<?php //echo BackendLanguageSwitcherWidget::widget(); ?>
</li>

<!-- /.dropdown -->
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-user">
        <!--<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
        </li>
        <li class="divider"></li>-->
        <li><a href="/logout/"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
        </li>
    </ul>
    <!-- /.dropdown-user -->
</li>
<!-- /.dropdown -->
</ul>
<!-- /.navbar-top-links -->

