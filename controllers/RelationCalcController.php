<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\RelationCalc;

class RelationCalcController extends Controller
{
    public function actionIndex()
    {
        $model = new RelationCalc();
        $result = '计算结果将显示在此处。';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $result = $model->calculateRelationship();
        }

        return $this->render('index', [
            'model' => $model,
            'result' => $result,
        ]);
    }
}
