<?php
namespace common\extensions\sortgridview\actions;

use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;

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
class SortAction extends Action
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
            $class = $this->model;
            foreach($positions as $key=>$id){
                $model = $class::findOne($id);

                $model->setScenario('sort');
                $model->ordering = $key + 1;

                $model->save();
            }
		}
	}
}