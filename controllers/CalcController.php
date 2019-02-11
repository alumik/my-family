<?php

namespace app\controllers;

use app\models\NameType;
use Yii;
use yii\web\Controller;
use app\models\RelationCalc;
use app\models\NameCalc;

class CalcController extends Controller
{
    public function actionRelation()
    {
        $model = new RelationCalc();
        $relation_result = '关系计算结果将显示在此处。';
        $name_result = '称呼计算结果将显示在此处。';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $relation_result = $model->calculateRelationship();
            $name_result = $model->calculateName();
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
        $result = '计算结果将显示在此处。';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $result = $model->calculateName();
        }

        return $this->render('name', [
            'model' => $model,
            'result' => $result,
            'relations' => NameType::getNameTypeList(),
        ]);
    }
}
