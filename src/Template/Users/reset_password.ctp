<div class="points form large-9 medium-8 columns content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Passwort vergessen?') ?></legend>
        <?php
            echo $this->Form->control('password', ['label' => 'Neues Passwort']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Neues Passwort speichern')) ?>
    <?= $this->Form->end() ?>
</div>

