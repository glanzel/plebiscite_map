<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $stammOrte
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Stamm Orte'), ['action' => 'edit', $stammOrte->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Stamm Orte'), ['action' => 'delete', $stammOrte->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stammOrte->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Stamm Orte'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Stamm Orte'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="stammOrte view large-9 medium-8 columns content">
    <h3><?= h($stammOrte->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Bezirk') ?></th>
            <td><?= h($stammOrte->bezirk) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ort') ?></th>
            <td><?= h($stammOrte->ort) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($stammOrte->id) ?></td>
        </tr>
    </table>
</div>
