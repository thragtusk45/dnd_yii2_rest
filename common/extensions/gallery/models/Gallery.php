<?php
namespace common\extensions\gallery\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * Class Video
 * @package common\modules\video\models
 * Модель видео.
 *
 * @property integer $id ID
 * @property string $title Заголовок
 * @property string $alias Алиас
 * @property string $snippet Введение
 * @property string $content Контент
 * @property string $image_url Изображение поста
 * @property string $preview_url Превью изображение поста
 * @property integer $views Количество просмотров
 * @property integer $create_time Время создания
 * @property integer $update_time Время обновления
 */
class Gallery extends ActiveRecord
{

    public static $path;

    protected static $table;

    public static function tableName()
    {
        return self::$table;
    }

    public static function setTableName($table)
    {
        self::$table = $table;
    }

    public function scenarios()
    {
        return [
            'create' => ['entity_id', 'original', 'url', 'alt', 'title', 'caption', 'ordering', 'crop_x', 'crop_y', 'crop_w', 'crop_h'],
            'update' => ['entity_id', 'original', 'url', 'alt', 'title', 'caption', 'ordering', 'crop_x', 'crop_y', 'crop_w', 'crop_h'],
            'sort' => ['ordering']
        ];
    }

    public function getImage_Url()
    {
        return self::$path . $this->url;
    }

    public static function setPath($path)
    {
        self::$path = $path;
    }

}