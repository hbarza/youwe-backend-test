<?php

namespace app\modules\Codnitive\Account\models;

use yii\helpers\ArrayHelper;
use app\modules\Codnitive\Core\helpers\Rules;
use dektrium\user\models\RegistrationForm as BaseRegistration;

class RegistrationForm extends BaseRegistration
{
    /** @inheritdoc */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $newLabels = [
            'username'      => __('account', 'Cellphone'),
        ];
        return ArrayHelper::merge($labels, $newLabels);
    }

    /** @inheritdoc */
    public function rules()
    {
        $rules = parent::rules();
        $rules['usernameUnique']['message'] = __('account', 'This cellphone has already been registered');
        return ArrayHelper::merge($rules, [
            Rules::phone('username'),
        ]);
    }
}
