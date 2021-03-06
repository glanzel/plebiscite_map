<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $point
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Point'), ['action' => 'edit', $point->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Point'), ['action' => 'delete', $point->id], ['confirm' => __('Are you sure you want to delete # {0}?', $point->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Points'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Point'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="points view large-9 medium-8 columns content">
    <h3><?= h($point->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($point->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($point->Name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Beschreibung') ?></th>
            <td><?= h($point->Beschreibung) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Strasse') ?></th>
            <td><?= h($point->Strasse) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nr') ?></th>
            <td><?= h($point->Nr) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Stadt') ?></th>
            <td><?= h($point->Stadt) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Kategorie') ?></th>
            <td><?= h($point->Kategorie) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('PLZ') ?></th>
            <td><?= $this->Number->format($point->PLZ) ?></td>
        </tr>
        <!--Längen- und Breitengrad wichtig für Benutzer_innen? -->
        <tr>
            <th scope="row"><?= __('Laengengrad') ?></th>
            <td><?= $this->Number->format($point->Laengengrad) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Breitengrad') ?></th>
            <td><?= $this->Number->format($point->Breitengrad) ?></td>
        </tr>
    </table>
</div>
