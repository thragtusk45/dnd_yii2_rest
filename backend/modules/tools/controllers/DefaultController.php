<?php

namespace backend\modules\tools\controllers;



use backend\modules\admin\components\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
