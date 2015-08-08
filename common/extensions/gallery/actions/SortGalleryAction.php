<?php
namespace common\extensions\gallery\actions;

use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;

use common\extensions\gallery\models\Gallery;


/**
 * SortAction действие для ручной сортировки записей в админке
 * 
 * Пример использования:
 * ```
 * ...
 * 'sort' => [
 *     'class' => SortAction::className(),
 *     'model' => SomeModule::className(),
 * ]
 * ...
 * ```
 */
class SortGalleryAction extends Action
{

    public $model;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		if ($this->model === null) {
			throw new InvalidConfigException("Empty \"{$this->model}\".");
		}
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		if (($positions = Yii::$app->request->post('item'))) {

            $model = $this->model;
            Gallery::setTableName($model::tableName() . "_gallery");

            foreach($positions as $key=>$id){
                $model = Gallery::findOne($id);

                $model->setScenario('sort');
                $model->ordering = $key + 1;

                $model->save();
            }
		}
	}
}