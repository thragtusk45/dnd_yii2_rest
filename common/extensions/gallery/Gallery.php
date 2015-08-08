<?php
namespace common\extensions\gallery;

use Yii;
use yii\helpers\Html;
use yii\jui\InputWidget;
use yii\web\JsExpression;
use common\extensions\gallery\assets\GalleryAsset;

use yii\helpers\Json;
use yii\web\View;

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
class Gallery extends InputWidget
{

    public $imagesOptions = [];

    public $imagePath;

    public $settings;

    public $selector;

    public $fileVar = 'file';

    /**
     * @var string URL для удаления текущего файла.
     */
    public $deleteUrl;

    /**
     * @var string ID текущей моедли, или в случае её отсутсвия,
     * значение которое будет передано через AJAX запрос в метод удаления текущего файла.
     */
    public $modelId;

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

    protected $_defaultMultipleSettings = [
        'multiple' => true,
        'autoUpload' => true,
        'elements' => [
            'dnd' => [
                'el' => '.uploader-dnd',
                'hover' => 'uploader-dnd-hover',
                'fallback' => '.uploader-dnd-not-supported'
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

        $this->_defaultSettings = $this->_defaultMultipleSettings;

        $this->registerTranslations();
        $this->registerCallbacks();

        $this->settings = array_merge($this->_defaultSettings, $this->settings);

        $this->registerMainClientScript();
        GalleryAsset::register($this->getView());

        // Определяем URL
        if ($this->url !== null) {
            $fileName = $this->hasModel() ? $this->model->{$this->attribute} : $this->value;
            $this->url = $fileName ? rtrim($this->url, '/') . '/' . $fileName : null;
        }
        // Определяем ИД модели
        if ($this->modelId === null && $this->hasModel()) { // TODO: show error if widget does not have model
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
//        $modelId = $this->hasModel() ? $this->model->{$this->modelId} : $this->modelId;
        // Рендерим представление

        return $this->render('multiple', ['selector' => $this->getId(), 'fileVar' => $this->fileVar, 'name' => Html::getInputName($this->model, $this->attribute)]);
    }

    /**
     * @inheritdoc
     */
    /*public function registerClientScript()
    {
        $view = $this->getView();

        // Инициализируем плагин виджета

        MultiCropAsset::register($view);

    }*/

    /**
     * @inheritdoc
     */
    public function registerCallbacks()
    {

        // Определяем если нужно выводить ссылку для удаления загружаемого файла.


//        $input = $this->hasModel() ? Html::activeHiddenInput($this->model, 'gallery[{%key}]' . $this->attribute, $this->options) : Html::hiddenInput('[{%key}]' . $this->name, $this->value, $this->options);

        $this->_defaultSettings['onFileComplete'] = new JsExpression("function (evt, uiEvt) {
				if (uiEvt.result.error) {
					alert(uiEvt.result.error);
				} else {
				    renderPreview(uiEvt.result);
				}
			}");

        /*$this->_defaultSettings['onFileComplete'] = new JsExpression("function (evt, uiEvt) {
				if (uiEvt.result.error) {
					alert(uiEvt.result.error);
				} else {
				    renderImagesTable(uiEvt.result);
				}
			}");*/
    }

    public function registerTranslations()
    {
        $i18n = Yii::$app->i18n;
        $i18n->translations['extensions/gallery/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'ru',
            'basePath' => '@common/extensions/gallery/messages',
            'fileMap' => [
                'extensions/gallery/gallery' => 'gallery.php',
            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('extensions/gallery/' . $category, $message, $params, $language);
    }

    /**
     * Инициализируем Javascript плагин виджета
     */
    protected function registerMainClientScript()
    {
        $this->value = $this->model->{$this->attribute};
        $view = $this->getView();
        $selector = ($this->selector !== null) ? '#' . $this->selector : '#' . $this->getId();
        $options = Json::encode($this->settings);
        // Инициализируем плагин виджета
        $view->registerJs("jQuery('$selector').fileapi($options);");

        $galOptions = [
            'inputName' => Html::getInputName($this->model, $this->attribute),
            'imagePath' => $this->imagePath,
            'deleteUrl' => $this->settings['deleteUrl'],
            'sortUrl' => $this->settings['sortUrl'],
            'url' => $this->settings['url'],
            'totalImages' => sizeof($this->value),
            'isNewRecord' => $this->model->isNewRecord,
            'width' => $this->imagesOptions['width'],
            'height' => $this->imagesOptions['height']
        ];

        $galImages = [];

        if(!$this->model->isNewRecord){
            foreach($this->model->gallery as $image){
                $galImages[] = [
                    'image' => $image->url,
                    'original' => $image->original,
                    'coords' => [
                        'x' => $image->crop_x,
                        'y' => $image->crop_y,
                        'w' => $image->crop_w,
                        'h' => $image->crop_h
                    ]
                ];
            }

        }

        $view->registerJs('window.galOptions = ' . Json::encode($galOptions) . ';', View::POS_HEAD);
        $view->registerJs('window.galImages = ' . Json::encode($galImages, JSON_FORCE_OBJECT) . ';', View::POS_HEAD);

    }


}