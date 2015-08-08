<?php

use yii\helpers\Html;

?>

<div class='load_more<?= (isset($buttonOptions['class'])) ? ' ' . $buttonOptions['class']: ""; ?>'>
    <span></span>
    <?= Html::a(Yii::t('blogs', 'Еще'), ['/' . $url . '/loadMore/'], [
        'class' => 'll-load-more',
        'data-pjax' => 0,
        'data-id' => $this->context->id
    ]); ?>
</div>