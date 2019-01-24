<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\modules\Codnitive\Template\blocks\Main;
$block = new Main;
$block->registerAssets($this, 'Template', 'Main');
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= $block->getLanguage() ?>">
<head>
    <script>var BASE_URL = '<?= tools()->getUrl('', [], false, true) ?>';</script>
    <meta charset="<?= app()->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Omid Barza backend test for Youwe Co.">
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
<?= $this->render('html/_breadcrumbs.phtml'); ?>
<?= $this->render('html/_message.phtml'); ?>

<div class="wrapper">
<?= $content ?>
</div>
<?= $this->render('html/footer.phtml'); ?>

<?php $block->registerAssets($this, 'Template', 'CustomJS'); ?>
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
