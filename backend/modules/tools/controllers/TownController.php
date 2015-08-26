<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 13.08.2015
 * Time: 12:24
 */

namespace backend\modules\tools\controllers;


use backend\modules\admin\components\Controller;

class TownController extends Controller{

    public function actionIndex() {

        return $this->render('index');
    }

    public function actionCreate() {
        return $this->render('create');
    }

    public function actionGenerate() {
        return $this->render('generate');
    }
} 