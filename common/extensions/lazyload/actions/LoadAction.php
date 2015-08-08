<?php
namespace common\extensions\lazyload\actions;

use common\extensions\lazyload\models\Loader;
use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;


class LoadAction extends Action
{

    public $model;

    public $findClass;

    public $options = [];

    public $viewOptions = [];


    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->model === null) {
            throw new InvalidConfigException("Empty \"{$this->model}\".");
        }

        if (Yii::$app->request->get('viewOptions')) {
            $this->viewOptions = Yii::$app->request->get('viewOptions');
            if(!is_array($this->viewOptions)){
                throw new InvalidConfigException("\$viewOptions should be an array.");
            }
        }

        // TODO: default values for perPage and firstStackSize options


    }

    /**
     * @inheritdoc
     */
    public function run()
    {

        $page = Yii::$app->request->get('page');
        if($page && isset($this->options[$page])){
            $options = $this->options[$page];
        }
        else{
            throw new HttpException(400);
        }


        $resultModel = new Loader([
            'dataModel' => $this->model,
            'perPage' => $options['perPage'],
            'firstStackSize' => $options['firstStackSize'],
            'data' => Yii::$app->request->get('data')
        ]);


        if($resultModel->load(Yii::$app->request->get(), 'loader')){

            if(isset($options['resultsMethod'])){
                $foo = \Closure::bind($options['resultsMethod'], $resultModel);
                $results = $foo();
            }
            else{
                $results = $resultModel->getResults();
            }

            if(isset($options['viewMethod'])){
                $options['viewMethod']($results, $options['view'], $this->controller);
            }
            else{
                foreach($results as $i => $model){
                    $this->viewOptions['model'] = $model;
                    $this->viewOptions['index'] = $i;
                    echo $this->controller->renderPartial($options['view'], $this->viewOptions);
                }
            }
        }
        else{
            var_dump($resultModel->errors);
        }

    }

}