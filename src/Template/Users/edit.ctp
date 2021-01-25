<div class="points form large-9 medium-8 columns content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Edit Benutzer ') ?><?= $user->email ?></legend>
        <?php
            use Cake\Core\Configure;
            echo $this->Form->label('bezirk');
            echo $this->Form->select('bezirk', Configure::read('Bezirke'), ['value' => $user->bezirk]);
            echo $this->Form->control('name', ['value' => $user->name]);
            echo $this->Form->control('email', ['value' => $user->email]);
            #echo $this->Form->control('password', ['label' => 'Passwort']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Speichern')) ?>
    <?= $this->Form->end() ?>
</div>

