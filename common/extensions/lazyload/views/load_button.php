<?php

use yii\helpers\Html;

?>

<div class="load_more_btn load_more_cont">
    <span></span>
    <?= Html::a(Yii::t('blogs', 'Еще'), ['/' . $url . '/loadMore/'], ['class' => 'll-load-more', 'data-pjax' => 0, 'data-id' => $this->context->id]); ?>
</div>
<hr>