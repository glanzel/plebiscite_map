
<?php

use Cake\Core\Configure;
$this->extend('form'); //was bedeutet der parameter
$this->start('form.after_create');
if($embedded) echo $this->Form->hidden('_done', ['value' => true]);

echo $this->Form->label("Bezirk");
echo $this->Form->select('Bezirk', Configure::read('Bezirke'),['value' => $bezirk]);
echo $this->Form->label("Einwilligung zur Veröffentlichung");
echo $this->Form->select('einwilligung', [ 0=>'nein', 1=> 'ja']);
echo "<br><br>";
$this->end();
$this->start('form.before_buttons');

echo "details<br>";
echo $this->Form->control('Details.oeffnungszeiten');
echo $this->Form->control('Details.Listenabgabe');
echo $this->Form->control('Details.Kontakt_Kiezteam');
echo "intern<br>";
echo $this->Form->control('Details_intern.Kontakt_Ort');
echo $this->Form->control('Details_intern.Treffpunkt');
echo $this->Form->control('Details_intern.Einwilligung_Details', ['label' => "Einwilligung Details (Name der Person, welche die Einwilligung zur Veröffentlichung eingeholt hat/ Datum)"]);

$this->end()

?>

