<?php
abstract class TrackStarActiveRecord extends CActiveRecord
{
    /*
     * Set timestamp on create and update
     */
    public function behaviors()
    {
        return array(
            'CTimestampBehavior'=>array(
                'class'=>'zii.behaviors.CTimestampBehavior',
                'createAttribute'=>'create_time',
                'updateAttribute'=>'update_time',
                'setUpdateOnCreate'=>true,
            ),
        );
    }
    
    /*
     * Set create_user_id and update_user_id attributes before saving
     */
    protected function beforeSave()
    {
        $id = Yii::app()->user ? Yii::app()->user->id : 1; // user with id=1 is superuser
        if ($this->isNewRecord) $this->create_user_id = $id;
        $this->update_user_id = $id;
        return parent::beforeSave();
    }
}