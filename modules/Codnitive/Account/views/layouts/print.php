<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\modules\Codnitive\Template\blocks\Main;
$block = new Main;
$block->registerAssets($this, 'Template', 'Main');
$block->registerAssets($this, 'Account', 'PrintMedia');
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

<div class="print-container">
<?= $content ?>
</div>

<?php if (app()->language == 'fa-IR'): ?>
<?php $block->registerAssets($this, 'Template', 'JqueryValidateFa') ?>
<?php endif; ?>

<?php $block->registerAssets($this, 'Template', 'CustomJS'); ?>
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
