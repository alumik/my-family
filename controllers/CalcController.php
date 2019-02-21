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
        $relation_result = ['error_level' => -1];
        $name_result = ['error_level' => -1];

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $relation_result = $model->getRelation();
            $name_result = $model->getName();
        }

        return $this->render('relation', [
            'model' => $model,
            'relation_result' => $relation_result,
            'name_result' => $name_result,
        ]);
    }

    public function actionName()
    {
        $model = new NameCalc();
        $result = ['error_level' => -1];
        $relation_types = NameCalc::$name_types;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $result = $model->getName();
        } else {
            $model->gender = -1;
        }

        return $this->render('name', [
            'model' => $model,
            'result' => $result,
            'relation_types' => $relation_types,
        ]);
    }
}
