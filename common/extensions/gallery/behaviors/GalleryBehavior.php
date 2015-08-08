<?php
namespace common\extensions\gallery\behaviors;

use common\extensions\gallery\models\Gallery;
use Yii;
use yii\base\Behavior;
use yii\base\InvalidParamException;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\helpers\FileHelper;
use yii\validators\Validator;
use yii\web\UploadedFile;
use yii\web\Session;


/**
 * Class UploadBehavior
 * @package common\extensions\fileapi\behaviors
 * Поведение для загрузки файлов.
 *
 * Пример использования:
 * ```
 * ...
 * 'uploadBehavior' => [
 *     'class' => UploadBehavior::className(),
 *     'attributes' => ['avatar_url'],
 *     'deleteScenarios' => [
 *         'avatar_url' => 'delete-avatar',
 *     ],
 *     'scenarios' => ['signup', 'update'],
 *     'path' => Yii::getAlias('@my/path'),
 *     'tempPath' => Yii::getAlias('@my/tempPath'),
 * ]
 * ...
 * ```
 */
class GalleryBehavior extends Behavior
{

    /**
     * @event Событие которое вызывается после успешной загрузки файла
     */
    const EVENT_AFTER_UPLOAD = 'afterUpload';

    /**
     * @var array Массив аттрибутов.
     */
    public $attributes = [];

    /**
     * @var array Массив сценариев в которых поведение должно срабатывать.
     */
    public $scenarios = [];

    /**
     * @var array Массив сценариев в которых нужно удалить указанные атрибуты и их файлы.
     */
    public $deleteScenarios = [];

    /**
     * @var string|array Путь к папке в которой будут загружены файлы.
     */
    public $path;

    public $galleryUrl;

    /**
     * @var string|array Путь к временой папке в которой загружены файлы.
     */
    public $tempPath;

    /**
     * @var boolean В случае true текущий файл из атрибута модели будет удалён.
     */
    public $deleteOnSave = true;

    /**
     * @var array Массив событий поведения
     */
    protected $_events = [
        ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
        ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',

    ];

    /**
     * @inheritdoc
     */
    public function events()
    {
        return $this->_events;
    }

    public function afterUpdate()
    {
        if($this->gallery && ($this->owner->scenario == 'create' || $this->owner->scenario == 'update' || $this->owner->scenario == 'admin')){ // TODO: create method to validate scenario
            $this->deleteEntityGallery();
            $this->setEntityGallery('update');
        }
    }

    public function afterInsert()
    {
        if($this->gallery){
            $this->setEntityGallery('create');
        }
    }

    public function afterDelete()
    {
        if($this->gallery){
            $this->deleteEntityGallery();
        }
    }

    /**
     * @param string $attribute Атрибут для которого нужно вернуть путь загрузки.
     * @return string Путь загрузки файла.
     */
    public function getPath($attribute, $old = false)
    {
        if ($old === true) {
            $fileName = $this->owner->getOldAttribute($attribute);
        } else {
            $fileName = $this->owner->$attribute;
        }
        if (is_array($this->path) && isset($this->path[$attribute])) {
            $path = $this->path[$attribute];
        } else {
            $path = $this->path;
        }
        if (FileHelper::createDirectory($path)) {
            return $path . $fileName;
        }
        return null;
    }

    /**
     * @param string $fileName Атрибут для которого нужно вернуть путь загрузки.
     * @return string Временный путь загрузки файла.
     */
    public function getTempPath($attribute)
    {
        $fileName = $this->owner->$attribute;
        if (is_array($this->tempPath) && isset($this->tempPath[$attribute])) {
            $path = $this->tempPath[$attribute];
        } else {
            $path = $this->tempPath;
        }
        return $path . $fileName;
    }

    public function setGallery($param)
    {
        $this->gallery = $param;

    }

    public function getGallery()
    {
        if(!isset($this->gallery)){
            $this->setGalleryTableName();
            Gallery::setPath($this->galleryUrl);
            $images = Gallery::find()->where(['entity_id' => $this->owner->id])->limit(5)
                ->orderBy(['ordering' => SORT_ASC])->all();
            $this->gallery = [];
            foreach($images as $image){
                $this->gallery[] = $image;
            }
        }
        return $this->gallery;
    }

    protected function setEntityGallery($scenario)
    {

        foreach($this->gallery as $key=>$image){
            $this->setGalleryTableName();
            $images = new Gallery(['scenario' => $scenario]);

            $attributes = [
                'url' => $image['image'],
                'original' => $image['original'],
                'alt' => $image['alt'],
                'title' => $image['title'],
                'caption' => $image['caption'],
                'entity_id' => $this->owner->id,
                'ordering' => $key,
                'crop_x' => $image['coords']['x'],
                'crop_y' => $image['coords']['y'],
                'crop_w' => $image['coords']['w'],
                'crop_h' => $image['coords']['h']
            ];

            $images->setAttributes($attributes);
            $images->save();
        }

    }

    protected function deleteEntityGallery()
    {
        $this->setGalleryTableName();
        $images = Gallery::find()->where(['entity_id' => $this->owner->id])->all();
        foreach($images as $image){
            $file = $this->path . '/' . $image->url;
            if (is_file($file)) {
                unlink($file);
            }
            $image->delete();
        }
    }

    private function setGalleryTableName() // TODO: this method should be called once
    {
        $model = $this->owner;
        Gallery::setTableName($model::tableName() . "_gallery");
    }

}