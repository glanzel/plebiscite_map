<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Termine $termine
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        
        <li><?= $this->Html->link(__('Alle Termine'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="termine form large-9 medium-8 columns content">
    <?= $this->Form->create($termine) ?>
    <fieldset>
        <legend><?= __('Füge einen Termin hinzu') ?></legend>
        <?php
            /* echo $this->Form->control('beginn', ['empty' => true]);
            echo $this->Form->control('ende', ['empty' => true]); */
            echo $this->Form->select('ort', $stammorte);
            echo $this->Form->control('typ');
            echo $this->Form->control('TerminDetails.id');
            echo $this->Form->control('TerminDetails.Treffpunkt');
            // todo: die Felder aus der Tabelle TerminDetails müssen hier eingefügt werden.
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
