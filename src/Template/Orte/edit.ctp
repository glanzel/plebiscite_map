
<?php

use Cake\Core\Configure;
$this->extend('form'); //was bedeutet der parameter
$this->start('form.after_create');
echo $this->Form->label("Bezirk");
echo $this->Form->select('Bezirk', Configure::read('Bezirke'), ['value' => $orte->Bezirk]);
//echo $this->Form->label("Einwilligung zur Veröffentlichung");
//echo $this->Form->select('einwilligung', [ 0=>'nein', 1=> 'ja'], ['value' => $orte->einwilligung]);
echo $this->Form->checkbox('einwilligung', [ 0=>'nein', 1=> 'ja']); echo("  ");
echo $this->Form->label("Einwilligung zur Veröffentlichung");

echo "<br><br>";
$this->end();

$this->start('form.before_buttons');

echo $this->Form->checkbox('Listenannahme', ['checked' => $orte->Listenannahme]); echo("  ");
echo $this->Form->label("Listenannahme");
echo("<br>");
echo $this->Form->checkbox('Listenausgabe', ['checked' => $orte->Listenausgabe]); echo("  ");
echo $this->Form->label("Listenausgabe");

echo "<br><br>";


echo "details<br>";
echo $this->Form->control('Details.oeffnungszeiten', ['value' => $orte->Details['oeffnungszeiten']]);
//echo $this->Form->control('Details.Listenabgabe', ['value' => $orte->Details['Listenabgabe']]);
echo $this->Form->control('Details.Kontakt_Kiezteam', ['value' => $orte->Details['Kontakt_Kiezteam']]);
echo "intern<br>";
$kontakt_ort = isset($orte->Details_intern['Kontakt_Ort']) ? $orte->Details_intern['Kontakt_Ort'] : '';
echo $this->Form->control('Details_intern.Kontakt_Ort', ['value' => $kontakt_ort] );
echo $this->Form->control('Details_intern.Treffpunkt', ['value' => $orte->Details_intern['Treffpunkt']] );
$einwilligungDetails = isset($orte->Details_intern['Einwilligung_Details']) ? $orte->Details_intern['Einwilligung_Details'] : Null;

echo $this->Form->control('Details_intern.Einwilligung_Details', ['value' => $einwilligungDetails, 'label' => "Einwilligung Details (Name der Person, welche die Einwilligung zur Veröffentlichung eingeholt hat/ Datum)"]);

//debug($orte->Details['oeffnungszeiten']);


$this->end();

?>
