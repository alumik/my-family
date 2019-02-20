<?php

namespace app\controllers\api\data;

use yii\rest\ActiveController;

class GenderController extends ActiveController
{
    public $modelClass = 'app\models\Gender';

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
