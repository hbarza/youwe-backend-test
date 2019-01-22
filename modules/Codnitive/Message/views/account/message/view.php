<?php

$this->title = sprintf("Message from %s", $merchant->fullname);
$this->params['breadcrumbs'][10] = $this->title;

?>

<div class="row my-order invoice">
    <div class="col-lg-12">
        <div class="card px-2">
            <div class="card-body">
                <div class="container-fluid">
                    <h3 class="text-right mt-5">Invoice&nbsp;&nbsp;<?= $orderNumber ?></h3>
                    <p class="text-right mb-5">
                        <a href="<?= $entity->getUrl() ?>" target="_blank"><?= $entity->name ?></a>
                    </p>
                    <h5>Message:</h5>
                    <hr>
                </div>
                <div class="container-fluid d-flex justify-content-between">
                    <div class="col-lg-6 pl-0">
                        <?= $message->message ?>
                    </div>
                    <div class="col-lg-5 pr-0">
                        <?= $this->render('_merchant_info.php', ['merchant' => $merchant]); ?>
                    </div>
                </div>
                <div class="container-fluid mt-5 w-100"></div>
            </div>
        </div>
    </div>
</div>
