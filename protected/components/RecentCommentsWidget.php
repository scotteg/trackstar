<?php
/**
 * RecentCommentsWidget is a Yii widget used to display a list of recent comments
 */
class RecentCommentsWidget extends CWidget
{
    public $displayLimit = 5;
    public $projectId = NULL;
    private $_comments;

    public function init()
    {
        if ($this->projectId !== NULL) {
            $this->_comments = Comment::model()->with(array('issue'=>array('condition'=>'project_id='.$this->projectId)))->recent($this->displayLimit)->findAll();
        } else {
            $this->_comments = Comment::model()->recent($this->displayLimit)->findAll();
        }
    }

    public function getData()
    {
        return $this->_comments;
    }

    public function run()
    {
        // This is called by Ccontroller::endWidget()
        $this->render('recentCommentsWidget');
    }
}