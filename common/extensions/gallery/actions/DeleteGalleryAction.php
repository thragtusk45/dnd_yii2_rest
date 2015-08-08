<?php
namespace common\extensions\gallery\actions;

use common\extensions\gallery\models\Gallery;
use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;
use yii\helpers\Json;

use yii\web\HttpException;

//use common\extensions\fileapi\models\Upload;

/**
 * DeleteAction действие для удаления загруженных файлов.
 * 
 * Пример использования:
 * ```
 * ...
 * 'deleteTempAvatar' => [
 *     'class' => DeleteAction::className(),
 *     'path' => Yii::getAlias('@my/path'),
 * ]
 * ...
 * ```
 */
class DeleteGalleryAction extends Action
{

    public $tableName;

	/**
	 * @var string Путь к папке где хранятся файлы.
	 */
	public $path;

	/**
	 * @var string Название переменной в которой хранится имя файла.
	 */
	public $fileVar = 'image';

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		if ($this->path === null) {
			throw new InvalidConfigException("Empty \"{$this->path}\".");
		} else {
			$this->path = FileHelper::normalizePath($this->path) . DIRECTORY_SEPARATOR;
		}
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		if (($file = Yii::$app->request->getBodyParam($this->fileVar))) {
            $id = Yii::$app->request->getBodyParam('id');
            if($id && is_numeric($id)){
                Gallery::setTableName($this->tableName . '_gallery');
                $model = Gallery::findOne($id);
                if(!$model){
                    throw new HttpException(404);
                }
                else{
                    $model->delete();
                }
            }
			if (is_file($this->path . $file)) {
				unlink($this->path . $file);
                return Json::encode(['success' => true]);
			}
            else{
                return Json::encode(['error' => 'File does not exists']);
            }
		}
        else{
            throw new HttpException(400);
        }
	}
}