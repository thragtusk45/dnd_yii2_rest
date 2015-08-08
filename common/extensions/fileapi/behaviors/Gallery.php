<?php
namespace common\extensions\fileapi\behaviors;

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

use common\extensions\fileapi\models\GalleryModel;

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
class Gallery extends Behavior
{

    public $attributes = [];

    protected $_events = [
        ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
        ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert'

    ];

    public function events()
    {
        return $this->_events;
    }

    public function attach($owner)
    {
        parent::attach($owner);

        if (!is_array($this->attributes) || empty($this->attributes)) {
            throw new InvalidParamException("Invalid or empty \"{$this->attributes}\" array");
        }

        GalleryModel::setTableName($owner::tableName() . "_gallery");

        /*if (empty($this->path)) {
            throw new InvalidParamException("Empty \"{$this->path}\".");
        } else {
            if (is_array($this->path)) {
                foreach ($this->path as $attribute => $path) {
                    $this->path[$attribute] = FileHelper::normalizePath($path) . DIRECTORY_SEPARATOR;
                }
            } else {
                $this->path = FileHelper::normalizePath($this->path) . DIRECTORY_SEPARATOR;
            }
        }
        if (empty($this->tempPath)) {
            throw new InvalidParamException("Empty \"{$this->tempPath}\".");
        } else {
            if (is_array($this->tempPath)) {
                foreach ($this->tempPath as $attribute => $path) {
                    $this->tempPath[$attribute] = FileHelper::normalizePath($path) . DIRECTORY_SEPARATOR;
                }
            } else {
                $this->tempPath = FileHelper::normalizePath($this->tempPath) . DIRECTORY_SEPARATOR;
            }
        }*/
    }

    public function setGallery($param)
    {
        $this->gallery = $param;
    }

    public function getGallery()
    {
        return (isset($this->gallery)) ? $this->gallery : null;
    }

    public function afterInsert()
    {
        if($this->gallery){
            $this->setEntityImages('create');
        }
    }

    public function afterUpdate()
    {

    }

    protected function setEntityImages($scenario)
    {
        foreach($this->gallery as $image){

            $model = new GalleryModel(['scenario' => $scenario]);
            $model->setAttributes(['entity_id' => $this->owner->id, 'url' => $image]);
            $model->save();

        }
    }

}