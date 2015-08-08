<?php
namespace common\extensions\lazyload;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;


class LazyLoad extends Widget
{

    const DEFAULT_CONTAINER = '.ll-container';
    const DEFAULT_PAGE = 'default';


    /**
     * @var array Настройки виджета по умолчанию.
     */
    public $pluginOptions = [];

    public $container;

    public $page;

    public $url;

    public $isMobile = false;

    public $buttonOptions = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if($this->container === null){
            $this->container = self::DEFAULT_CONTAINER;
        }

        if($this->page === null){
            $this->page = self::DEFAULT_PAGE;
        }

        if($this->url === null){
            $this->url = Yii::$app->controller->module->id;
        }

    }

    /**
     * @inheritdoc
     */
    public function run()
    {

        if($this->pluginOptions['total'] <= 0){
            return null;
        }
        else{
            $view = $this->getView();
            LazyLoadAsset::register($view);
            $this->pluginOptions['currentPage'] = 1;
            $this->pluginOptions['container'] = $this->container;

            $this->pluginOptions['page'] = $this->page;

            if(!Yii::$app->request->isPjax){
                $view->registerJs('window.llOptions["' . $this->id . '"] = ' . Json::encode($this->pluginOptions) . ';');
            }
            else{
                echo '<script type="text/javascript">window.llOptions["' . $this->id . '"] = ' . Json::encode($this->pluginOptions) . ';</script>';
            }

            if(!$this->isMobile){
                $viewName = 'load_button';
            }
            else{
                $viewName = 'load_button_mobile';
            }

            return $this->render($viewName, [
                'url' => $this->url,
                'buttonOptions' => $this->buttonOptions
            ]);
        }

    }

}