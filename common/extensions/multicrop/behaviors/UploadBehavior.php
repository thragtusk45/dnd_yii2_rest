<?php
namespace common\extensions\multicrop\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\InvalidParamException;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\validators\Validator;
use yii\web\UploadedFile;
use yii\web\Session;

use common\extensions\multicrop\models\Images;

use yii\helpers\Html;

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
class UploadBehavior extends Behavior
{


    protected $filesToDelete = [];


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

    public $originalPath;

    public $imageUrl;

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
        ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
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
        if(($this->owner->scenario == 'create' || $this->owner->scenario == 'update' || $this->owner->scenario == 'admin') && $this->images){ // TODO: check scenario method
            $this->deleteEntityImages();
            $this->setEntityImages('update');
        }
    }

    public function afterInsert()
    {
        if($this->images){
            $this->setEntityImages('create');
        }
    }

    public function beforeDelete()
    {
        if($this->images){
            $this->deleteEntityImages(true);
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

    public function setImages($param)
    {
        $this->images = $param;
    }

    public function getImages()
    {
        if(!isset($this->images)){
            $this->setImagesTableName();
            Images::setPath($this->imageUrl);
            $images = Images::find()->where(['entity_id' => $this->owner->id])->all();
            $this->images = [];
            foreach($images as $image){
                $this->images[$image->name] = $image;
            }
        }
        return $this->images;
    }

    protected function setEntityImages($scenario)
    {

        foreach($this->images as $name=>$image){

            $this->setImagesTableName();
            $images = new Images(['scenario' => $scenario]);

            $attributes = [
                'name' => $name,
                'url' => $image['file'],
                'entity_id' => $this->owner->id
            ];

            if($name != 'original'){
                $attributes['crop_x'] = $image['coords']['x'];
                $attributes['crop_y'] = $image['coords']['y'];
                $attributes['crop_w'] = $image['coords']['w'];
                $attributes['crop_h'] = $image['coords']['h'];
            }

            if(isset($this->filesToDelete[$image['file']])){
                unset($this->filesToDelete[$image['file']]);
            }

            $images->setAttributes($attributes);
            $images->save();
        }

        $this->deleteFiles();

    }

    protected function deleteEntityImages($deleteOriginal = false)
    {
        $this->setImagesTableName();
        $query = Images::find()->where(['entity_id' => $this->owner->id]);
        if(!$deleteOriginal){
            $query->andWhere('name != "original"');
        }
        $images = $query->all();
        foreach($images as $image){
            $path = ($image->name == 'original') ? $this->originalPath: $this->path;
            $file = $path . '/' . $image->url;
            if (is_file($file)) {
                $this->filesToDelete[$image->url] = $file;
            }
            $image->delete();
        }
    }

    private function setImagesTableName() // TODO: this method should be called once
    {
        $model = $this->owner;
        $tableName = $model::tableName();
        if($this->owner->scenario == 'new_posts'){
            $tableName = $this->owner->type;
        }
        Images::setTableName($tableName . "_images");
    }

    protected function deleteFiles()
    {
        foreach($this->filesToDelete as $file){
            unlink($file);
        }
    }

    public function images($key, $html = true)
    {
        if(isset($this->images[$key])){
            if($html){
                $image = $this->images[$key]->image;
                if($this->owner->scenario == 'new_posts'){
                    $image = str_replace('video', $this->owner->type, $image);
                }
                return Html::img($image, ['title' => $this->owner->title, 'alt' => $this->owner->title]);
            }
            else{
                return $this->images[$key]->image;
            }
        }
        else{
            return null;
        }
    }

}