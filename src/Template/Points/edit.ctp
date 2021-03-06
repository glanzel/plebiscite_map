<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $point
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $point->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $point->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Points'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="points form large-9 medium-8 columns content">
    <?= $this->Form->create($point) ?>
    <fieldset>
        <legend><?= __('Edit Point') ?></legend>
        <?php
            echo $this->Form->control('Name',  ['label' => 'Name/Ort']);
            echo $this->Form->control('Beschreibung');
            echo $this->Form->control('Strasse');
            echo $this->Form->control('Nr');
            echo $this->Form->control('PLZ');
            echo $this->Form->control('Stadt');
            //Längen- und Breitengrad müssten, m.E., nicht mit ausgegeben werden.
            //echo $this->Form->control('Laengengrad');
            //echo $this->Form->control('Breitengrad');
            echo $this->Form->control('Kategorie');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
