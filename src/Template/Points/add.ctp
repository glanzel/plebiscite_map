<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $point
 */
?>
<div class="points form large-9 medium-8 columns content">
    <?= $this->Form->create($point) ?>
    <fieldset>
        <legend><?= __('Erstelle Sammelstelle') ?></legend>
        <?php
            echo $this->Form->control('Strasse');
            echo $this->Form->control('Nr');
            echo $this->Form->control('PLZ');
            echo $this->Form->control('Stadt');
            //echo $this->Form->control('Laengengrad');
            //echo $this->Form->control('Breitengrad');
            //echo $this->Form->control('Kategorie');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
