<?php

namespace app\controllers\api;

use yii\rest\ActiveController;

class PersonController extends ActiveController
{
    public $modelClass = 'app\models\Person';
}
