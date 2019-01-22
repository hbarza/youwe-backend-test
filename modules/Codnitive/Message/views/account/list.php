<?php

use app\modules\Codnitive\Core\helpers\Html;
use app\modules\Codnitive\Core\helpers\Tools;

$this->title = 'Messages List';
$this->params['breadcrumbs'][10] = 'Messages';

?>

<div class="row">
    <div class="col-lg-12 core mb-3">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-table"></i> Recent Messages
            </div>
            <div class="card-body">
                <div class="table-responsive data-table grid">
                <?= Html::getGridPerPage($messageGrid->showResetFilterButton(), Tools::getPerPageSize()); ?>
                <?= $messageGrid->toHtml(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
