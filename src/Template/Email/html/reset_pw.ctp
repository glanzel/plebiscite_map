Hallo! 
<br><br>

Jemand hat darum gebeten, das Passwort für diesen Account zurückzusetzen.
<br> 
Wenn du das nicht warst, kannst du diese Mail ignorieren. 
<br> 
Andernfalls klicke bitte auf den Link unten und wähle ein neues Passwort: 
<br><br>
<?php
echo $this->Html->link('Setze dein Passwort zurück', ['controller'=>'Users', 'action'=> 'resetPassword', $user->token, '_full'=> true]);
?>
<br><br>
Viele Grüße
<br>
das dwe-Team
<br>