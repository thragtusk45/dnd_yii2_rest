<?php
/**
 * Основной шаблон backend-приложения.
 * @var yii\base\View $this Предсталвение
 * @var string $content Контент
 * @var array $params Основные параметры предсталвения
 */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\NavBar;
use frontend\modules\site\widgets\alert\Alert;

$this->beginPage(); ?>
    <!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<html>
<head>
    <?= $this->render('//layouts/partials/_head'); ?>
</head>
<body>
<?php $this->beginBody(); ?>

<div id="wrapper">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
        <?= $this->render('//layouts/partials/_navbar'); ?>
        <?= $this->render('//layouts/partials/_menu'); ?>
    </nav>

    <div id="page-wrapper">
        <?php  echo $content; ?>
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>