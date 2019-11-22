<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];

$this->registerCssFile(Yii::$app->request->baseUrl . "/css/loginlte.css");
$url_image = Yii::$app->request->baseUrl . '/img/login.jpg';

?>
<style>
    .auth-wrapper .auth-header,
    .auth-wrapper .auth-user {
        background-image: linear-gradient(rgba(227, 12, 12, 0.7), rgba(245, 246, 252, 0.1)),
            url('<?= $url_image ?>');
    }
</style>
<div class="auth-wrapper">
    <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
    <div class="auth-header">
        <div class="auth-title"><?= Yii::$app->name; ?></div>
        <div class="auth-subtitle">By Mamorasoft</div>
        <div class="auth-label">Login</div>
    </div>
    <div class="auth-body">
        <div class="auth-content">
            <?= $form
                ->field($model, 'username', $fieldOptions1)
                //->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>
            <?= $form
                ->field($model, 'password', $fieldOptions2)
                //->label(false)
                ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
        </div>
        <div class="auth-footer">
            <div class="row">
                <div class="col-xs-8">
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <?= Html::submitButton('Sign in', ['class' => 'btn btn-default btn-block btn-flat btn-login', 'name' => 'login-button']) ?>

                </div>
                <!-- /.col -->
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>