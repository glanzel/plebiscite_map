
<?php

use Cake\Core\Configure;
$this->extend('form'); //was bedeutet der parameter
$this->start('form.after_create');
echo $this->Form->label("Bezirk");
echo $this->Form->select('Bezirk', Configure::read('Bezirke'), ['value' => $orte->Bezirk]);
echo $this->Form->label("Einwilligung zur Veröffentlichung");
echo $this->Form->select('einwilligung', [ 0=>'nein', 1=> 'ja']);
echo "<br><br>";
$this->end();

$this->start('form.before_buttons');

echo "details<br>";
echo $this->Form->control('Details.oeffnungszeiten', ['value' => $orte->Details['oeffnungszeiten']]);
echo $this->Form->control('Details.Listenabgabe', ['value' => $orte->Details['Listenabgabe']]);
echo $this->Form->control('Details.Kontakt_Ort', ['value' => $orte->Details['Kontakt_Ort']] );
echo $this->Form->control('Details.Kontakt_Kiezteam', ['value' => $orte->Details['Kontakt_Kiezteam']]);
echo "intern<br>";
echo $this->Form->control('Details_intern.Treffpunkt', ['value' => $orte->Details_intern['Treffpunkt']] );
$einwilligungDetails = isset($orte->Details_intern['Einwilligung_Details']) ? $orte->Details_intern['Einwilligung_Details'] : Null;

echo $this->Form->control('Details_intern.Einwilligung_Details', ['value' => $einwilligungDetails]);

//debug($orte->Details['oeffnungszeiten']);


$this->end();

?>
