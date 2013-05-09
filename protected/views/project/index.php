<?php
/* @var $this ProjectController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Projects',
);

$this->menu=array(
	array('label'=>'Create Project', 'url'=>array('create')),
	array('label'=>'Manage Project', 'url'=>array('admin')),
);
?>

<?php if ($sysMessage): ?>
    <div class="sys-message">
        <?php echo $sysMessage; ?>
    </div>
    <?php Yii::app()->clientScript->registerScript(
        'fadeAndHideEffect',
        "$('.sys-message').animate({opacity: 1.0}, 5000).fadeOut('slow');"
        ); ?>
<?php endif; ?>

<h1>Projects</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php
$key = 'TrackStar.ProjectListing.RecentComments';

// Fragment caching
if ($this->beginCache($key, array('duration'=>120))) {
    $this->beginWidget('zii.widgets.CPortlet', array('title'=>'Recent Comments'));
    $this->widget('RecentCommentsWidget');
    $this->endWidget();
    $this->endCache();
}
?>