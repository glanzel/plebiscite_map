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
echo "crud:  ";
echo $this->Html->link("Orte", ['controller' => 'Orte']);
echo " ";
echo $this->Html->link("Users", ['controller' => 'Users']);
echo " | std: ";
echo $this->Html->link("Points", ['controller' => 'Points']);
?>
</center>
</h2>
</body>
</html>
