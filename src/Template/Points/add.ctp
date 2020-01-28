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
            echo $this->Form->control('Name', ['label' => 'Name/Ort']);
            echo $this->Form->control('Beschreibung', ['placeholder'=>'z.b. Öffnungszeiten']);
            echo $this->Form->control('Strasse');
            echo $this->Form->control('Nr');
            echo $this->Form->control('PLZ');
            echo $this->Form->control('Stadt');
            echo $this->Form->control('Email', ['label' => 'Emailadresse']);
            echo $this->Form->control('Details.Öffnungszeiten');
            echo $this->Form->label('Sammelkits vorhanden');
            echo $this->Form->checkbox('Details.Sammelkits_vorhanden');
            echo $this->Form->control('Details_intern.Telefonnummer');
            //echo $this->Form->control('Laengengrad');
            //echo $this->Form->control('Breitengrad');
            //echo $this->Form->control('Kategorie');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
