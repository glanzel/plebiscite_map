<div class="points form large-9 medium-8 columns content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Bitte registriere dich, um Sammelort zu administrieren (und anderes)') ?></legend>
        <?php
            use Cake\Core\Configure;
            echo $this->Form->label('bezirk');
            echo $this->Form->select('bezirk', Configure::read('Bezirke'));
            echo $this->Form->control('email');
            echo $this->Form->control('password', ['label' => 'Passwort']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Registrieren')) ?>
    <?= $this->Form->end() ?>
</div>

