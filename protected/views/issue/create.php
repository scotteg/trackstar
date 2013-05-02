<?php
/* @var $this IssueController */
/* @var $model Issue */

$this->breadcrumbs=array(
	'Issues'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Issues', 'url'=>array('index', 'pid'=>$model->project->id)),
	array('label'=>'Manage Issue', 'url'=>array('admin', 'pid'=>$model->project->id)),
);
?>

<h1>Create Issue</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>