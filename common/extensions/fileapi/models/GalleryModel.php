<?php
namespace common\extensions\fileapi\models;

//use common\modules\tags\models\Tag;
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
class GalleryModel extends ActiveRecord
{

    protected static $table;

    /*public function __get($name)
    {
        var_dump($name);
        parent::__get($name);
    }*/

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
            'create' => ['entity_id', 'url'],
            'update' => ['entity_id', 'url']
        ];
    }

}