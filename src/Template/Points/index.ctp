<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Point[]|\Cake\Collection\CollectionInterface $points
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Point'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="points index large-9 medium-8 columns content">
    <h3><?= __('Points') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Strasse') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Nr') ?></th>
                <th scope="col"><?= $this->Paginator->sort('PLZ') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Stadt') ?></th>
                <!--<th scope="col"><?= $this->Paginator->sort('Laengengrad') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Breitengrad') ?></th>-->
                <th scope="col"><?= $this->Paginator->sort('Kategorie') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($points as $point): ?>
            <tr>
                <td><?= h($point->Name) ?></td>
                <td><?= h($point->Strasse) ?></td>
                <td><?= h($point->Nr) ?></td>
                <td><?= $this->Number->format($point->PLZ) ?></td>
                <td><?= h($point->Stadt) ?></td>
                <!--<td><?= $this->Number->format($point->Laengengrad) ?></td>
                <td><?= $this->Number->format($point->Breitengrad) ?></td>-->
                <td><?= h($point->Kategorie) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('aktivieren'), ['action' => 'setActive', $point->id]) ?>
                    <?= $this->Html->link(__('View'), ['action' => 'view', $point->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $point->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $point->id], ['confirm' => __('Are you sure you want to delete # {0}?', $point->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
