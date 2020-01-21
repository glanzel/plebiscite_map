<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Point $point
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Points'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="points form large-9 medium-8 columns content">
    <?= $this->Form->create($point) ?>
    <fieldset>
        <legend><?= __('Add Point') ?></legend>
        <?php
            echo $this->Form->control('Name');
            echo $this->Form->control('Strasse');
            echo $this->Form->control('Nr');
            echo $this->Form->control('PLZ');
            echo $this->Form->control('Stadt');
            echo $this->Form->control('Beschreibung');
            echo $this->Form->control('Laengengrad');
            echo $this->Form->control('Breitengrad');
            echo $this->Form->control('Kategorie');
            echo $this->Form->control('Details');
            echo $this->Form->control('Details_intern');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
