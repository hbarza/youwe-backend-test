<?php 
if (!count($items)) return;
?>
<div class="container-fluid mt-5 d-flex justify-content-center w-100 items">
    <div class="table-responsive w-100">
    <table class="table">
        <thead>
            <tr class="bg-dark text-white">
                <th class="text-center"><?= __('sales', '#') ?></th>
                <th class="text-right"></th>
                <th class="text-right"><?= __('sales', 'Type') ?></th>
                <th class="text-right"><?= __('sales', 'Price') ?></th>
                <th class="text-center"><?= __('sales', 'Quantity') ?></th>
                <th class="text-right"><?= __('sales', 'Total') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 1; foreach ($items as $item): ?>
            <?php $viewDetails = !empty($item->product_data) && isset($item->product_data['template']) ?>
            <tr class="text-right">
                <td class="text-center"><?= $i ?></td>
                <td class="text-right">
                    <?= $item->name ?>
                    <?php if ($viewDetails): ?>
                    <a class="mr-3" data-toggle="collapse" href="#view_detail_<?= $i ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <?= __('template', 'View Detail') ?>
                    </a>
                    <?php endif; ?>
                </td>
                <td class="text-right"><?= __('account', $item->ticket_type) ?></td>
                <td><?= tools()->formatRial($item->price) ?></td>
                <td class="text-center"><?= $item->qty ?></td>
                <td><?= tools()->formatRial($item->qty * $item->price) ?></td>
            </tr>
            <?php if ($viewDetails): ?>
            <tr class="text-right collapse" id="view_detail_<?= $i ?>">
                <td colspan="6">
                    <?= $this->render($item->product_data['template'], ['item' => $item]) ?>
                </td>
            </tr>
            <?php endif; ?>
            <?php $i++ ?>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>