<?php
namespace common\extensions\multicrop;

use Yii;
use yii\helpers\Html;
use yii\jui\InputWidget;
use yii\web\JsExpression;
use common\extensions\multicrop\assets\MultiCropAsset;

use yii\helpers\Json;

/**
 * FileAPIAdvanced Class
 * Виджет асинхроной загрузки файлов.
 * Работает на основе плагина {@link https://github.com/RubaXa/jquery.fileapi/ FileAPI}.
 * Пример использования:
 * ```
 * ...
 * echo FileAPIAdvanced::widget([
 *     'name' => 'fileapi',
 *     'settings' => [
 *         'crop' => true,
 *         'preview' => true
 *     ]
 * ]);
 * ...
 * ```
 * или
 * ```
 * ...
 * echo $form->field($model, 'file')->widget(FileAPIAdvanced::className(), [
 *     'settings' => [
 *         'crop' => true,
 *         'preview' => true
 *     ]
 * ]);
 * ...
 * ```
 */
class MultiCrop extends InputWidget
{

    public $originalImageInput = false;

    public $imagesOptions = [];

    public $originalImagePath;

    public $imagePath;

    public $settings;

    public $selector;

    public $fileVar = 'file';

    /**
     * @var string URL для удаления текущего файла.
     */
    public $deleteUrl;

    /**
     * @var string URL для удаления загруженного файла.
     * Для удаления не загруженного файла из списка загрузки плагина, нужно использовать функционал {@link https://github.com/RubaXa/jquery.fileapi/ FileAPI}.
     */
    public $deleteTempUrl;

    /**
     * @var string ID текущей моедли, или в случае её отсутсвия,
     * значение которое будет передано через AJAX запрос в метод удаления текущего файла.
     */
    public $modelId;

    /**
     * @var integer Ширина исходной картинки после resize-а.
     * Параметр валиден только в случае использования $crop.
     */
    public $cropResizeWidth;

    /**
     * @var integer Высота исходной картинки после resize-а.
     * Параметр валиден только в случае использования $crop.
     */
    public $cropResizeHeight;

    /**
     * @var string URL адрес папки где хранятся уже загруженные файлы.
     */
    public $url;

    /**
     * @var array Настройки виджета по умолчанию
     */
    protected $_defaultSettings = [
        'accept' => 'image/*',
        'autoUpload' => true,
        'maxFiles' => 1,
        'imageSize' =>  [
            'minWidth' => 100,
            'minHeight' => 100
        ],
        'elements' => [
            'progress' => '.uploader-progress-bar',
            'active' => [
                'show' => '.uploader-progress',
                'hide' => '.uploader-browse'
            ]
        ]
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {

        // Определяем контейнер превью
        parent::init();
        $this->registerTranslations();
        $this->registerCallbacks();

        $this->settings = array_merge($this->_defaultSettings, $this->settings);

        $this->registerMainClientScript();
        MultiCropAsset::register($this->getView());

        // Определяем URL
        if ($this->url !== null) {
            $fileName = $this->hasModel() ? $this->model->{$this->attribute} : $this->value;
            $this->url = $fileName ? rtrim($this->url, '/') . '/' . $fileName : null;
        }
        // Определяем ИД модели
        if ($this->modelId === null && $this->hasModel()) {
            $this->modelId = 'id';
        }
        // Отменяем авто-загрузку в случае использования кропа

    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        // Очищаем значение поля по умолчанию.
        $this->options['value'] = '';
        // Определяем ИД модели
        $modelId = $this->hasModel() ? $this->model->{$this->modelId} : $this->modelId;
        // Рендерим представление
        echo $this->render('advanced', [
            'model' => $this->model,
            'selector' => $this->getId(),
            'fileVar' => $this->fileVar,
            'url' => $this->url,
            'modelId' => $modelId,
            'name' => Html::getInputName($this->model, $this->attribute)
        ]);
    }

    /**
     * @inheritdoc
     */
    public function registerClientScript()
    {
        $view = $this->getView();

        // Инициализируем плагин виджета

        MultiCropAsset::register($view);

    }

    /**
     * @inheritdoc
     */
    public function registerCallbacks()
    {

        $id = $this->getId();

        // Определяем если нужно выводить ссылку для удаления загружаемого файла.

        $this->_defaultSettings['onFileComplete'] = new JsExpression("function (evt, uiEvt) {
				if (uiEvt.result.error) {
					alert(uiEvt.result.error);
				} else {
				    renderImagesTable(uiEvt.result, '$id');
				}
			}");
    }

    public function registerTranslations()
    {
        $i18n = Yii::$app->i18n;
        $i18n->translations['extensions/multicrop/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'ru',
            'basePath' => '@common/extensions/multicrop/messages',
            'fileMap' => [
                'extensions/multicrop/multicrop' => 'multicrop.php',
            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('extensions/multicrop/' . $category, $message, $params, $language);
    }

    /**
     * Инициализируем Javascript плагин виджета
     */
    protected function registerMainClientScript()
    {

        $id = $this->getId();

        $this->value = $this->model->{$this->attribute};
        $view = $this->getView();
        $selector = ($this->selector !== null) ? '#' . $this->selector : '#' . $id;
        $options = Json::encode($this->settings);
        // Инициализируем плагин виджета
        $view->registerJs("jQuery('$selector').fileapi($options);");
        $mcOptions = [
            'inputName' => Html::getInputName($this->model, $this->attribute),
            'originalImagePath' => $this->originalImagePath,
            'imagePath' => $this->imagePath,
            'imagesOptions' => $this->imagesOptions,
            'url' => $this->settings['url']
        ];
        $mcImages = [];

        if(!$this->model->isNewRecord && sizeof($this->model->images) != 0){
            $mcOptions['originalImage'] = $this->model->images['original']->url;
            $mcOptions['editorInitialized'] = true;
            foreach($this->model->images as $key=>$image){
                if($key == 'original') continue;
                $mcImages[$key] = [
                    'file'=>$image->url,
                    'coords' => [
                        'x' => $image->crop_x,
                        'y' => $image->crop_y,
                        'w' => $image->crop_w,
                        'h' => $image->crop_h
                    ]
                ];
            }
        }

        $view->registerJs("if(!window.mcImages) window.mcImages = {};");
        $view->registerJs("if(!window.mcOptions) window.mcOptions = {};");
        $view->registerJs("window.mcImages['$id'] = " . Json::encode($mcImages, JSON_FORCE_OBJECT) . ";");
        $view->registerJs("window.mcOptions['$id'] = " . Json::encode($mcOptions, JSON_FORCE_OBJECT) . ";");

    }


}