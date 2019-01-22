<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Sign up');
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="home2"></div>

<section class="login-wrap">
    <div class="main_w3agile">
        <h4 class="text-center text-white"><?= Html::encode($this->title) ?></h4>
        <div class="hr"></div>

        <div class="login-form">
            <!-- signup form -->
            <div class="signin_wthree">
                <?php $form = ActiveForm::begin([
                    'id' => 'registration-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                ]); ?>

                <div class="group">
                <?= $form->field($model, 'email', ['inputOptions' => ['class' => 'form-control input', 'autofocus' => 'autofocus']]) ?>
                </div>
                <div class="group">
                <?= $form->field($model, 'username', ['inputOptions' => ['class' => 'form-control input']]) ?>
                </div>

                <?php if ($module->enableGeneratingPassword == false): ?>
                <div class="group">
                    <?= $form->field($model, 'password', ['inputOptions' => ['class' => 'form-control input']])->passwordInput() ?>
                </div>
                <?php endif ?>

                <div class="d-flex justify-content-center group text-center mt-5">
                <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <div class="hr"></div>
        <div class="foot-lnk">
            <p class="text-center">
                <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), [tools()->getUrl('/user/security/login')], ['class' => 'fz-14 text-white']) ?>
            </p>
        </div>
        <!-- //signup form -->
    </div>
</section>
