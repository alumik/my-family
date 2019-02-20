<?php

namespace app\controllers\api;

use Yii;
use yii\rest\Controller;
use app\models\RelationCalc;
use app\models\NameCalc;

class CalcController extends Controller
{
    /**
     * @return array
     */
    public function actionRelation()
    {
        $model = new RelationCalc();
        $relation_result = [
            'error_level' => 0,
            'data' => '关系计算结果将显示在此处。',
        ];
        $name_result = [
            'error_level' => 0,
            'data' => '称呼计算结果将显示在此处。',
        ];

        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            $relation_result = $model->getRelation();
            $name_result = $model->getName();
        }

        return [
            'model' => $model,
            'relation_result' => $relation_result,
            'name_result' => $name_result,
        ];
    }

    /**
     * @return array
     */
    public function actionName()
    {
        $model = new NameCalc();
        $result = [
            'error_level' => 0,
            'data' => '计算结果将显示在此处。',
        ];
        $relation_types = NameCalc::$name_types;

        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            $result = $model->getName();
        }

        return [
            'model' => $model,
            'result' => $result,
            'relation_types' => $relation_types,
        ];
    }
}
