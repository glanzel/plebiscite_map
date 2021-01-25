Hallo! 
</br>


Du hast eine Sammelstelle eingetragen. </br>
Deine Daten kannst du unter diesem 
<?php
echo $this->Html->link('Link', ['controller'=>'Orte', 'action'=> 'view', $point->id, '_full'=> true]);
?>
 einsehen.<br>


<?php
echo $this->Html->link('hier kannst du Sie editieren', ['controller'=>'Orte', 'action'=> 'edit', $point->id, '_full'=> true]);
?>
(bitte diesen Link nicht weitergeben)
<br>

 
 Der Ort muss noch vom Kiezteam freigeschaltet werden und wird dann auf der Karte erscheinen.<br>
  Sollte das nicht innerhalb der nächsten Woche passieren, wende dich direkt an das Kiezteam deines Bezirks<br> 
 (Kontakt unter https://www.dwenteignen.de/mitmachen/).
 