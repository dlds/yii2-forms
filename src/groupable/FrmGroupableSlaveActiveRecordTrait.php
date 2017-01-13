<?php

namespace dlds\forms\groupable;

/**
 * FrmGroupableSlaveActiveRecordTrait
 * ---
 * Handles useful functions when slave form is descendant of ActiveRecord
 */
trait FrmGroupableSlaveActiveRecordTrait
{

    /**
     * @inheritdoc
     */
    public function __load($data, $formName = null)
    {
        return $this->load($data, $formName);
    }

    /**
     * @inheritdoc
     */
    public function __save()
    {
        return $this->save();
    }

    /**
     * @inheritdoc
     */
    public function __validate()
    {
        return $this->validate();
    }

}
