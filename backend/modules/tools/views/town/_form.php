<?php
use yii\bootstrap\ActiveForm;
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 13.08.2015
 * Time: 12:35
 */

$form = ActiveForm::begin([
    'options'=>[
        'class'=>'cb-track-changes'
    ],
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
    'validateOnChange' => false,
//    'beforeValidate' => new JsExpression('function ($form, attribute, messages) { window.errorScroll = false; if (attribute.name === "content") { CKEDITOR.instances["post-content"].updateElement(); } return true; }'),
    'afterValidate' => new JsExpression('function($form, attribute, messages){ if(!window.errorScroll) scrollToError(attribute, messages); }')

]);?>

    <div class="row">
        <div class="col-sm-8">
            <?= $form->field($model, 'title') .
            $form->field($model, 'category')->dropDownList($categoryArray);
            ?>
        </div>
    </div>

<?php

$form->end();
?>