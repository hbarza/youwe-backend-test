<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\modules\Codnitive\Template\blocks\Main;
$block = new Main;
$block->registerAssets($this, 'Account', 'Panel');
$block->registerAssets($this, 'Template', 'Main');
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= $block->getLanguage() ?>">
<head>
    <script>var BASE_URL = '<?= tools()->getUrl('', [], false, true) ?>';</script>
    <meta charset="<?= app()->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="bilit.com official website, to book and buy train, airplane, bus, car, event, insurance, tour tickets">
    <?= tools()->csrfMetaTags() ?>
    <title><?= tools()->encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php $block->registerAssets($this, 'Template', 'CustomCSS'); ?>
    <?php $block->registerAssets($this, 'Template', 'HeadJS'); ?>
</head>
<body id="<?= $this->context->getBodyId(); ?>" class="<?= $this->context->getBodyClass(); ?>">

<?php $this->beginBody() ?>

<?= $this->render('html/header.phtml'); ?>
<?php if (method_exists($this->context, 'renderHeaderBottom')): ?>
<?= $this->context->renderHeaderBottom(); ?>
<?php endif; ?>
<div class="super_container">
    <?php /*<?= $this->render('html/_breadcrumbs.phtml'); ?>*/ ?>
    <div class="home2"></div>
    <div class="home3">
        <div class="banner_text_inner"></div>
    </div>
    <?= $this->render('html/_message.phtml'); ?>
    <div class="container mt-2 account-wrapper">
        <div class="row">
            <?= $this->render('html/navigation.phtml'); ?>

            <div class="col-md-9">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
<?= $this->render('html/footer.phtml'); ?>

<?php if (app()->language == 'fa-IR'): ?>
<?php $block->registerAssets($this, 'Template', 'JqueryValidateFa') ?>
<?php endif; ?>

<?php $block->registerAssets($this, 'Template', 'CustomJS'); ?>
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
