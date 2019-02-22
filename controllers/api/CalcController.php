<?php

namespace app\controllers\api;

use Yii;
use yii\rest\Controller;
use app\models\RelationCalc;
use app\models\NameCalc;
use app\models\CalendarCalc;

class CalcController extends Controller
{
    /**
     * @return array
     */
    public function actionRelation()
    {
        $model = new RelationCalc();
        $relation_result = ['error_level' => -1];
        $name_result = ['error_level' => -1];

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
        $result = ['error_level' => -1];
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

    /**
     * @return array
     */
    public function actionGeneral()
    {
        $result = [];

        if (Yii::$app->request->post()) {
            $result = NameCalc::getGeneralResult(Yii::$app->request->post());
        }

        return $result;
    }

    /**
     * @return array
     */
    public function actionCalendar()
    {
        $model = new CalendarCalc();
        $result = ['error_level' => -1];

        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            $result = $model->getDateData();
        } else {
            $model->type = 'solar';
        }

        return [
            'model' => $model,
            'result' => $result,
        ];
    }
}
