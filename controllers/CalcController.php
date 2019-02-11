<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\RelationCalc;
use app\models\NameCalc;

class CalcController extends Controller
{
    public function actionRelation()
    {
        $model = new RelationCalc();
        $result = '计算结果将显示在此处。';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $result = $model->calculateRelationship();
        }

        return $this->render('relation', [
            'model' => $model,
            'result' => $result,
        ]);
    }

    public function actionName()
    {
        $model = new NameCalc();
        $result = '计算结果将显示在此处。';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $result = $model->calculateName();
        }

        return $this->render('name', [
            'model' => $model,
            'result' => $result,
        ]);
    }
}
