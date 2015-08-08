<?php
namespace common\extensions\lazyload\models;

use Yii;
use yii\base\Model;
use yii\web\HttpException;

/**
 * Class Upload
 * @package common\extensions\fileapi\models
 * Загрузочная модель файлов.
 */
class Loader extends Model
{

    public $dataModel;

    public $perPage;

    public $orderBy;

    public $skip;

    public $currentPage;

    public $firstStackSize;

    public $data;

    public $block;

    public function rules()
    {
        return [
            [['currentPage'], 'integer'],
            [['currentPage'], 'required']
        ];
    }

    public function scenarios()
    {
        return ['default' => ['dataModel', 'perPage', 'orderBy', 'skip', 'currentPage', 'block']];
    }

    public function getResults()
    {

        $model = new $this->dataModel(['scenario' => 'loader']);

        $query = $model->find();

        if($this->data){
            if($model->load(Yii::$app->request->get(), 'data')){
                if(isset($this->data['perPage'])){
                    unset($this->data['perPage']);
                }
                $query->where($this->data);
            }
            else{
                throw new HttpException(400);
            }
        }
        if($this->orderBy){ // TODO: check does field exists in model
            $query->orderBy([$this->orderBy => SORT_DESC]);
        }
        if($this->skip){
            $query->andWhere('id != :skip', [':skip' => $this->skip]);
        }

        return $query->offset($this->offsetCount())->limit($this->perPage)->all();
    }

    public function offsetCount()
    {
        if(is_array($this->firstStackSize)){
            if($this->block !== null && isset($this->firstStackSize[$this->block])){
                $firstStack = $this->firstStackSize[$this->block];
            }
            else{
                $firstStack = 0;
            }
        }
        else{
            $firstStack = $this->firstStackSize;
        }
        return $this->currentPage * $this->perPage + ($firstStack - $this->perPage);
    }

}