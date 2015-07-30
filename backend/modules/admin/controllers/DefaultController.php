<?php

namespace backend\modules\admin\controllers;

use backend\modules\admin\components\Controller;

/**
 * Backend default controller.
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {


        $behaviors = parent::behaviors();

        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['error'],
            'roles' => ['@']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['index'],
            'roles' => ['admin','superadmin']
        ];

        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ]
        ];
    }

    /**
     * Backend main page.
     */
    public function actionIndex()
    {
        $this->redirect('ChbPages/chb-pages-index/index/');
       // return $this->render('index');
    }
}
