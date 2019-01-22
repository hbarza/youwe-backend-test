<?php

namespace app\modules\Codnitive\Account\models;

use dektrium\user\models\User as BaseUser;
use yii\helpers\ArrayHelper;

class User extends BaseUser
{
    public const GUEST_USER_ID = 100;
    private const GUEST_USER_EMAIL = 'guest@bilit.com';
    private const GUEST_USER_USERNAME = 'bilit_guest_user_account';
    private const GUEST_USER_PASS = 'K0nhC2Xgsl_tqFoR&xI9@Ue^lpe2JaA92dZ@CwU&fmWN4V@%XvuKstVw%6f4iM7TkoO1%kQ8';
    public $cellphone;

    /** @inheritdoc */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        return ArrayHelper::merge($scenarios, [
            'settings' => ['username', 'email', 'password', 'fullname',
                'cellphone', 'dob', 'gender', /*'location', 'address'*/
            ]
        ]);
    }

    // public function rules()
    // {
    //     // exit('here');
    //     $rules = parent::rules();
    //     // add some rules
    //     $rules['cellphoneRequired'] = ['cellphone', 'required'];
    //     $rules['cellphoneLength']   = ['cellphone', 'string', 'max' => 11];
    //
    //     return $rules;
    // }


    public function loadOne(int $id, array $where = [])
    {
        if (empty($where)) {
            $where = ['id' => $id];
        }
        $object = $this->find()->where($where)->limit(1)->one();
        if (!$object) {
            return new $this;
        }
        return $object;
    }

    /** @inheritdoc */
    public function rules()
    {
        $rules = parent::rules();
        $rules['usernameUnique']['message'] = __('account', 'This cellphone has already been registered');
        return $rules;
    }
}
