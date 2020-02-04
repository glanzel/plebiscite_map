<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>

    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('home.css') ?>
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
</head>
<body class="home">
<h2><center>
<?php
echo "crud-app:  ";
echo $this->Html->link("Orte", ['controller' => 'Orte']);
echo " ";
echo $this->Html->link("Users", ['controller' => 'Users']);
echo " | std-app: ";
echo $this->Html->link("Points", ['controller' => 'Points']);
echo " | map-view: ";
echo '<a href="http://www.dwenteignen.de/sammelpunkte/" target="_new">karte</a></h2>'
?>
</center>
</h2>

<center><h2></center>

</body>
</html>
