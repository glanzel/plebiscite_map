<?php
$this->extend('form'); //was bedeutet der parameter
$this->start('form.before_buttons');

echo "details<br>";
echo $this->Form->control('Details.oeffnungszeiten');
echo $this->Form->control('Details.Listenabgabe');
echo "intern<br>";
echo $this->Form->control('Details_intern.Treffpunkt');
echo $this->Form->control('Details_intern.Kontakt');

$this->end()


?>
