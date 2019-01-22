<?php

namespace app\modules\Codnitive\Account\models;

use yii\helpers\ArrayHelper;
use app\modules\Codnitive\Core\helpers\Rules;
use dektrium\user\models\LoginForm as BaseLogin;

class LoginForm extends BaseLogin
{
    /** @inheritdoc */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $newLabels = [
            'login'      => __('account', 'Cellphone'),
        ];
        return ArrayHelper::merge($labels, $newLabels);
    }

    /** @inheritdoc */
    public function rules()
    {
        $rules = parent::rules();
        return ArrayHelper::merge($rules, [
            Rules::phone('login'),
        ]);
    }
}
