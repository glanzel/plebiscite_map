Hallo! 
</br>

Du hast eine Sammelstelle eingetragen. </br>
Deine Daten kannst du unter diesem 
<?php
echo $this->Html->link('Link', ['controller'=>'Points', 'action'=> 'view', $point->id, '_full'=> true]);
?>
 einsehen.