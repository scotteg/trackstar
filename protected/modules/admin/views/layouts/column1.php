<?php /* @var $this Controller */ ?>
<?php /* @var $this Controller */ ?>

<!-- By not specifying an input file for beginContent(), the default layout specified in AdminModule will be used ($this->layout = 'main') -->
<?php $this->beginContent(); ?>
<div id="content">
	<?php echo $content; ?>
</div><!-- content -->
<?php $this->endContent(); ?>