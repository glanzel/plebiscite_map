
<?php

$this->extend('form'); //was bedeutet der parameter
$this->start('form.before_buttons');

echo "details<br>";
echo $this->Form->control('Details.oeffnungszeiten', ['value' => $orte->Details['oeffnungszeiten']]);
echo $this->Form->control('Details.Listenabgabe', ['value' => $orte->Details['Listenabgabe']]);
echo "intern<br>";
echo $this->Form->control('Details_intern.Treffpunkt', ['value' => $orte->Details_intern['Treffpunkt']] );
echo $this->Form->control('Details_intern.Kontakt', ['value' => $orte->Details_intern['Kontakt']] );

//debug($orte->Details['oeffnungszeiten']);


$this->end();

?>
