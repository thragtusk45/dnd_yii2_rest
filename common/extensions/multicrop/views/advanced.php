<?php
/**
 * Представление advanced загрузки.
 * @var yii\base\View $this Представление
 */

use common\extensions\multicrop\MultiCrop;

?>
<div class="multicrop mc-widget mc-container-<?= $this->context->getId(); ?>" data-wid="<?= $this->context->getId(); ?>">
    <div id="<?= $selector; ?>" class="uploader">
        <div class="btn btn-default js-fileapi-wrapper">
            <div class="uploader-browse">
                <?php if($this->context->value){
                    echo \yii\helpers\Html::tag('span', MultiCrop::t('multicrop', 'Изменить изображение'));
                } else {
                    echo \yii\helpers\Html::tag('span', MultiCrop::t('multicrop', 'Загрузить изображение'), ['class' => 'mc-button-title']);
                } ?>
                <input type="file" name="<?= $fileVar ?>">
            </div>
            <div class="uploader-progress">
                <div class="progress progress-striped active">
                    <div class="uploader-progress-bar progress-bar progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-8">
            <table class="table" id="mc-preview-table">
                <tbody>
                <?php if($this->context->value): ?>

                    <?php foreach($this->context->value as $key=>$image): ?>
                        <?php if($key == 'original') continue; ?>
                        <tr>
                            <td style="width: 100px;">
                                <img src="<?= $this->context->imagePath . $image->url; ?>" class="cb-key-<?= $image->name; ?>" style="max-width: 150px; max-height: 150px;">
                            </td>
                            <td style="width: 150px;">
                                <div>
<!--                                    <strong>--><?//= MultiCrop::t('multicrop', 'Размер'); ?><!--</strong>-->
                                    <small><?= $this->context->imagesOptions[$key]['width'] . 'x' . $this->context->imagesOptions[$key]['height']; ?></small>
                                </div>
                                <div>
                                    <a href="#" class="btn btn-info cb-crop" data-key="<?= $image->name; ?>"><i class="glyphicon glyphicon-pencil"></i> <?= MultiCrop::t('multicrop', 'Редактирование'); ?></a>
                                </div>
                            </td>
                        </tr>
                        <input type="hidden" name="<?= $name . "[$key]"; ?>[file]" value="<?= $image->url; ?>">
                        <input type="hidden" name="<?= $name . "[$key]"; ?>[coords][x]" value="<?= $image->crop_x; ?>">
                        <input type="hidden" name="<?= $name . "[$key]"; ?>[coords][y]" value="<?= $image->crop_y; ?>">
                        <input type="hidden" name="<?= $name . "[$key]"; ?>[coords][w]" value="<?= $image->crop_w; ?>">
                        <input type="hidden" name="<?= $name . "[$key]"; ?>[coords][h]" value="<?= $image->crop_h; ?>">
                    <?php endforeach; ?>

                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- TODO: preview should be moved to another view -->
    <table id="mc-preview-template" style="display: none;">
        <tr>
            <td style="width: 100px;">
                <img style="max-width: 150px; max-height: 150px;">
            </td>
            <td style="width: 150px;">
                <div>
<!--                    <strong>--><?//= MultiCrop::t('multicrop', 'Размер'); ?><!--</strong>-->
                    <small class="mc-size"></small>
                </div>
                <div>
                    <a href="#" class="btn btn-info cb-crop"><i class="glyphicon glyphicon-pencil"></i> <?= MultiCrop::t('multicrop', 'Редактирование'); ?></a>
                </div>
            </td>
        </tr>
    </table>

    <!-- Modal -->
    <div id="modal-crop" class="mc-modal-crop mc-widget" data-wid="<?= $this->context->getId(); ?>">
        <div class="modal-crop-body">
            <div class="uploader-crop">
                <img>
            </div>
            <button type="button" class="btn btn-primary mc-save-image" style="display: block; margin: 15px auto 0;"><?= MultiCrop::t('multicrop', 'Сохранить') ?></button>
        </div>
    </div>
</div>
<!--/ Modal -->