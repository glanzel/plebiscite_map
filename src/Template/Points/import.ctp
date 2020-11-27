<div class="registers form">
<?php echo $this->Form->create('Points', ['type' => 'file']);?>
	<fieldset>
		<legend><?php echo __("Importiere Orte (per csv datei)"); ?></legend>
	<?php
		echo $this->Form->control('file', ['type' => 'file']);
	?>
	</fieldset>
<?php echo $this->Form->submit('import', ['name' => "import"] );?>
<?php echo $this->Form->submit("simulate import", ['name' => "simulate"]);?>
<?php echo $this->Form->end();?>
<br>
<?if(isset($echo)) echo $echo; ?>
</div>
