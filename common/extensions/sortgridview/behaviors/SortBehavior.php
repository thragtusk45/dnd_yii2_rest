<?php
namespace common\extensions\sortgridview\behaviors;

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
class SortBehavior extends Behavior
{

	/**
	 * @var array Массив аттрибутов.
	 */
	public $attributes = [];

	/**
	 * @var array Массив сценариев в которых поведение должно срабатывать.
	 */
	public $scenarios = [];


	/**
	 * @var array Массив событий поведения
	 */
	protected $_events = [
		ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',

	];

	/**
	 * @inheritdoc
	 */
	public function events()
	{
		return $this->_events;
	}

	/**
	 * Функция срабатывает в момент создания новой записи моедли.
	 */
	public function beforeInsert()
	{
        $model = $this->owner;
        $this->owner->ordering = $model::find()->max('ordering') + 1;
	}

}