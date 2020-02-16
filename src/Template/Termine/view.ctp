<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Termine $termine
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Termine'), ['action' => 'edit', $termine->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Termine'), ['action' => 'delete', $termine->id], ['confirm' => __('Are you sure you want to delete # {0}?', $termine->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Termine'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Termine'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="termine view large-9 medium-8 columns content">
    <h3><?= h($termine->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Typ') ?></th>
            <td><?= h($termine->typ) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($termine->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ort') ?></th>
            <td><?= $this->Number->format($termine->ort) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Details') ?></th>
            <td><?= $this->Number->format($termine->details) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Beginn') ?></th>
            <td><?= h($termine->beginn) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ende') ?></th>
            <td><?= h($termine->ende) ?></td>
        </tr>
    </table>
</div>
