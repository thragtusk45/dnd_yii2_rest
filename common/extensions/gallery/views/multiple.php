<?php
/**
 * Представление мульти-загрузки.
 * @var yii\base\View $this Представление
 */

use common\extensions\gallery\Gallery;

?>
<div id="<?= $selector; ?>" class="gallery uploader">
    <div class="uploader-controls">
        <div class="uploader-browse btn btn-default js-fileapi-wrapper">
            <span><?= Gallery::t('gallery', 'Добавить файл'); ?></span>
            <input type="file" name="<?= $fileVar ?>" />
        </div>
    </div>
    <div class="uploader-dnd"><?= Gallery::t('gallery', 'Drag and Drop') ?></div>
    <div class="uploader-dnd-not-supported"><?= Gallery::t('gallery', 'Браузер не поддерживает "Drag and Drop"'); ?></div>

</div>

<table class="table" style="margin: 10px 0; padding-left: 15px" id="gal-previews">
    <thead>
    <tr>
        <th><?= Gallery::t('gallery', 'Изображение'); ?></th>
        <th><?= Gallery::t('gallery', 'Подпись'); ?></th>
        <th><?= Gallery::t('gallery', 'Html атрибуты'); ?></th>
        <th><?= Gallery::t('gallery', 'Управление'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php if($this->context->value): ?>

        <?php foreach($this->context->value as $key=>$image): ?>
            <tr class="gal-preview" style="text-align: center; margin-bottom: 10px;" id="item_<?= $image->id; ?>">
                <td class="col-sm-2">
                    <div style="height: 100px; width: 100%; line-height: 100px;">
                        <img style="max-height: 100px; max-width: 100px;" src="<?= $image->image_url; ?>" class="gal-image-<?= $key; ?>">
                    </div>
                </td>
                <td class="col-sm-5">
                    <input type="text" name="<?= $name; ?>[<?= $key; ?>][caption]" value="<?= $image->caption ?>" class="form-control input-sm">
                </td>
                <td class="col-sm-3">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">Alt</div>
                            <input type="text" name="<?= $name; ?>[<?= $key; ?>][alt]" value="<?= $image->alt; ?>" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">Title</div>
                            <input type="text" name="<?= $name; ?>[<?= $key; ?>][title]" value="<?= $image->title; ?>" class="form-control input-sm">
                        </div>
                    </div>
                </td>
                <td class="col-sm-1">
                    <div style="margin-top: 10px;">
                        <a href="#" class="btn btn-danger btn-sm gal-remove-image" data-key="<?= $key; ?>" data-image="<?= $image->url; ?>" data-id="<?= $image->id; ?>"><i class="glyphicon glyphicon-trash"></i></a>
                        <a href="#" class="btn btn-info btn-sm gal-crop" data-key="<?= $key; ?>"><i class="glyphicon glyphicon-pencil"></i></a>
                    </div>
                </td>
                <input type="hidden" name="<?= $name; ?>[<?= $key; ?>][image]" value="<?= $image->url; ?>">
                <input type="hidden" name="<?= $name; ?>[<?= $key; ?>][original]" value="<?= $image->original; ?>">
                <input type="hidden" name="<?= $name; ?>[<?= $key; ?>][coords][x]" value="<?= $image->crop_x; ?>">
                <input type="hidden" name="<?= $name; ?>[<?= $key; ?>][coords][y]" value="<?= $image->crop_y; ?>">
                <input type="hidden" name="<?= $name; ?>[<?= $key; ?>][coords][w]" value="<?= $image->crop_w; ?>">
                <input type="hidden" name="<?= $name; ?>[<?= $key; ?>][coords][h]" value="<?= $image->crop_h; ?>">
            </tr>
        <?php endforeach; ?>

    <?php endif; ?>
    </tbody>
</table>

<table id="gal-preview-template" style="display: none;">
    <tbody>
    <tr class="gal-preview">
        <td class="col-sm-2">
            <div style="height: 100px; width: 100%; line-height: 100px;">
                <img style="max-height: 100px; max-width: 100px;" src="">
            </div>
        </td>
        <td class="col-sm-5">
            <input type="text" class="form-control input-sm gal-caption">
        </td>
        <td class="col-sm-3">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">Alt</div>
                    <input type="text" class="form-control input-sm gal-alt">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">Title</div>
                    <input type="text" class="form-control input-sm gal-title">
                </div>
            </div>
        </td>
        <td class="col-sm-1">
            <div style="margin-top: 10px;">
                <a href="#" class="btn btn-danger btn-sm gal-remove-image"><i class="glyphicon glyphicon-trash"></i></a>
                <a href="#" class="btn btn-info btn-sm gal-crop"><i class="glyphicon glyphicon-pencil"></i></a>
            </div>
        </td>
    </tr>
    </tbody>
</table>

<!-- Modal -->
<div id="modal-crop" class="gal-modal-crop">
    <div class="modal-crop-body">
        <div class="uploader-crop">
            <img>
        </div>
        <button type="button" class="btn btn-primary gal-save-image" style="display: block; margin: 15px auto 0;"><?= Gallery::t('multicrop', 'Сохранить') ?></button>
    </div>
</div>
<!--/ Modal -->