<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\RelationCalc;
use app\models\NameCalc;
use app\models\NameType;

class CalcController extends Controller
{
    public function actionRelation()
    {
        $model = new RelationCalc();
        $relation_result = '关系计算结果将显示在此处。';
        $name_result = [
            'error_level' => 0,
            'data' => '称呼计算结果将显示在此处。',
        ];

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
        $result = [
            'error_level' => 0,
            'data' => '计算结果将显示在此处。',
        ];

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $result = $model->getName();
        }

        return $this->render('name', [
            'model' => $model,
            'result' => $result,
            'relation_types' => NameType::getNameTypeList(),
        ]);
    }
}
