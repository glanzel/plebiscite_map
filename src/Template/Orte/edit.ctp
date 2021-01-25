
<?php

use Cake\Core\Configure;
$this->extend('form'); //was bedeutet der parameter
$this->start('form.form.after_create');
echo $this->Form->label("Bezirk");
echo $this->Form->select('Bezirk', Configure::read('Bezirke'));
$this->end();


$this->start('form.before_buttons');

echo "details<br>";
echo $this->Form->control('Details.oeffnungszeiten', ['value' => $orte->Details['oeffnungszeiten']]);
echo $this->Form->control('Details.Listenabgabe', ['value' => $orte->Details['Listenabgabe']]);
echo $this->Form->control('Details.Kontakt_Ort', ['value' => $orte->Details['Kontakt_Ort']] );
echo $this->Form->control('Details.Kontakt_Kiezteam', ['value' => $orte->Details['Kontakt_Kiezteam']]);
echo "intern<br>";
echo $this->Form->control('Details_intern.Treffpunkt', ['value' => $orte->Details_intern['Treffpunkt']] );

//debug($orte->Details['oeffnungszeiten']);


$this->end();

?>
