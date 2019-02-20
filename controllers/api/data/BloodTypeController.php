<?php

namespace app\controllers\api\data;

use yii\rest\ActiveController;

class BloodTypeController extends ActiveController
{
    public $modelClass = 'app\models\BloodType';

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        $actions = parent::actions();

        unset($actions['delete'], $actions['create'], $actions['view'], $actions['options'], $actions['update']);

        return $actions;
    }
}
