
<?php
use Cake\Core\Configure;
$this->extend('form'); //was bedeutet der parameter
$this->start('form.after_create');
echo $this->Form->label("Bezirk");
echo $this->Form->select('Bezirk', Configure::read('Bezirke'));
$this->end();

$this->start('form.before_buttons');

echo "details<br>";
echo $this->Form->control('Details.oeffnungszeiten');
echo $this->Form->control('Details.Listenabgabe');
echo $this->Form->control('Details.Kontakt_Ort');
echo $this->Form->control('Details.Kontakt_Kiezteam');
echo "intern<br>";
echo $this->Form->control('Details_intern.Treffpunkt');

$this->end()

?>

