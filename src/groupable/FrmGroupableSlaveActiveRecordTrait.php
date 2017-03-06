<?php

namespace dlds\forms\groupable;

use yii\helpers\ArrayHelper;

/**
 * FrmGroupableSlaveActiveRecordTrait
 * ---
 * Handles useful functions when slave form is descendant of ActiveRecord
 */
trait FrmGroupableSlaveActiveRecordTrait
{
    protected $additionalsRules = [];

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

    /**
     * Sets additionals rules
     */
    public function __addRules(array $rules)
    {
        $this->additionalsRules = ArrayHelper::merge($this->additionalsRules, $rules);
    }

    /**
     * Retrieves additionals rules
     * @return array
     */
    public function __additionalRules()
    {
        return $this->additionalsRules;
    }

}
