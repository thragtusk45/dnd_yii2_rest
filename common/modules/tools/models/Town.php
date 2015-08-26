<?php

namespace common\modules\tools\models;

use Yii;

/**
 * This is the model class for table "town".
 *
 * @property integer $id
 * @property string $name
 * @property string $race
 * @property string $terrain
 * @property integer $has_river
 * @property integer $has_sea
 * @property integer $type
 * @property integer $has_mountains
 * @property integer $size
 * @property string $resources
 * @property string $artisans
 */
class Town extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'town';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'race', 'terrain'], 'required'],
            [['has_river', 'has_sea', 'type', 'has_mountains', 'size'], 'integer'],
            [['resources', 'artisans'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['race', 'terrain'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'race' => 'Race',
            'terrain' => 'Terrain',
            'has_river' => 'Has River',
            'has_sea' => 'Has Sea',
            'type' => 'Type',
            'has_mountains' => 'Has Mountains',
            'size' => 'Size',
            'resources' => 'Resources',
            'artisans' => 'Artisans',
        ];
    }

    public function beforeSave($insert) {
        $this->resources =  json_encode($this->resources);
        $this->artisans =  json_encode($this->artisans);
        parent::beforeSave($insert);
    }

    public static function findById($id) {
        $model = parent::find()->where(['id' => $id])->one();
        $model->resources =  json_decode($model->resources,true);
        $model->artisans =  json_decode($model->artisans,true);
    }

    public function __construct() {

    }

    public static function getResourceMap() {
        return [
            'metal' => [
                'common' => [
                    'iron' => 10,
                    'copper'=> 10
                ],
                'uncommon'=> [
                    'silver'=> 1,
                    'gold'=> 1
                ],
                'rare'=> [
                    'platinum'=> 0,

                ],
                'legendary'=> [
                    'adamantium'=> 0,
                ]
            ],
            'wood'=> [
                'common' => [
                    'softwood' => 10,
                    'hardwood' => 10,
                ],
                'uncommon'=> [

                ],
                'rare'=> [

                ],
                'legendary'=> [

                ]
            ],
            'mineral'=> [
                'common' => [
                    'clay' => 10,
                    'stone' => 10,
                ],
                'uncommon'=> [

                ],
                'rare'=> [

                ],
                'legendary'=> [

                ]
            ],
//            'herb'=> [
//                'common' => [
//                    'weak healing',
//                    'weak poison'
//                ],
//                'uncommon'=> [
//
//                ],
//                'rare'=> [
//
//                ],
//                'legendary'=> [
//
//                ]
//            ],

        ];
    }

    /**
     * @param int|null $key
     * @return array|string
     */
    public static function getCityTypes($key = null) {
        $types =  [
            0 => 'Default',
            1 => 'Holy',
            2 => 'Military',
            3 => 'Trading',
            4 => 'Resource',
        ];
        return is_null($key) ?  $types : $types[$key];
    }
}
