<div class="registers form">
<?php echo $this->Form->create('Points', ['type' => 'file']);?>
	<fieldset>
		<legend><?php echo __("Importiere Orte"); ?></legend>
	<?php
		echo $this->Form->control('file', ['type' => 'file']);
	?>
	</fieldset>
<?php echo $this->Form->submit('import', ['name' => "import"] );?>
<?php echo $this->Form->submit("simulate import", ['name' => "simulate"]);?>
<?php echo $this->Form->end();?>
<br>
<? 
    if(isset($save) && isset($path) ){
         echo "<b>Simuliere importieren:</b> <br><br>".
         $this->Form->postLink( "Import jetzt durchführen", ["action" => "import", 1],[ "data" => ['file.tmp_name' => $path]]);  
    }

?>

<?if(isset($echo)) echo $echo; ?>
</div>
