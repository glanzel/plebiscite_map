<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $stammOrte
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $stammOrte->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $stammOrte->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Stamm Orte'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="stammOrte form large-9 medium-8 columns content">
    <?= $this->Form->create($stammOrte) ?>
    <fieldset>
        <legend><?= __('Edit Stamm Orte') ?></legend>
        <?php
            echo $this->Form->control('bezirk');
            echo $this->Form->control('ort');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
