<?php

/**
 * @link http://www.digitaldeals.cz/
 * @copyright Copyright (c) 2017 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 * @author Jiri Svoboda <jiri.svoboda@dlds.cz>
 */

namespace dlds\forms\groupable;

use yii\helpers\ArrayHelper;

/**
 * This is the Master groupable form trait
 *
 * @author Jiri Svoboda <jiri.svoboda@dlds.cz>
 */
trait FrmGroupableMasterTrait
{

    /**
     * @var array slaves holder
     */
    public $__slaves;

    /**
     * @var boolean indicates if main model should be processed or slaves only
     */
    protected $__doOnlySlaves = true;

    /**
     * @var boolean indicates if partial process is allowed
     */
    protected $__doPartial = true;

    /**
     * @var boolean load result
     */
    protected $__rsLoad;

    /**
     * @var boolean process result
     */
    protected $__rsProcess;

    /**
     * @var boolean validation result
     */
    protected $__rsValidation;

    /**
     * Runs basic init
     */
    public function init()
    {
        $this->__init();
    }

    /**
     * Runs data load
     */
    public function load($data, $formName = null)
    {
        return $this->__load($data, $formName);
    }

    /**
     * Indicates if models have errors
     * @param null $attribute
     * @return bool
     */
    public function hasErrors($attribute = null)
    {
        if (parent::hasErrors($attribute)) {
            return true;
        }

        foreach ($this->__slaves as $slave) {

            if ($slave->hasErrors($attribute)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Retrieves models errors
     * @param null $attribute
     * @return array
     */
    public function getErrors($attribute = null)
    {
        $errors = parent::getErrors($attribute);

        foreach ($this->__slaves as $slave) {

            $errors = ArrayHelper::merge($errors, $slave->getErrors($attribute));
        }

        return $errors;
    }

    /**
     * Runs main process
     */
    public function process()
    {
        return $this->__process();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            [['__slaves'], '__validateSlaves'],
        ], $this->__rules());
    }

    /**
     * Initalizes slaves
     */
    public function __init()
    {
        foreach ($this->__seRules() as $id => $class) {
            $this->__slaves[$id] = $this->initSlave($class, $id);
        }
    }

    /**
     * @inheritdoc
     */
    public function __load($data, $formName = null)
    {
        foreach ($this->__slaves as $id => $model) {
            $this->addResult($model->__load(\Yii::$app->request->post(), $id), $this->__rsLoad);
        }

        if (!$this->__doOnlySlaves) {
            $this->addResult($this->__loadMaster($data, $formName), $this->__rsLoad);
        }

        return $this->__rsLoad;
    }

    /**
     * Processes profile save
     * @return boolean
     */
    public function __process()
    {
        foreach ($this->__slaves as $id => $model) {
            $this->addResult($model->__save(), $this->__rsProcess);
        }

        if (!$this->__doOnlySlaves) {
            $this->addResult($this->__save(), $this->__rsProcess);
        }

        return $this->__rsProcess;
    }

    /**
     * Retrieves slave model instance
     * @param int $id
     * @return \yii\base\Model
     */
    public function __seModel($id)
    {
        return ArrayHelper::getValue($this->__slaves, $id);
    }

    /**
     * Validates all slaves
     */
    public function __validateSlaves()
    {
        foreach ($this->__slaves as $id => $model) {
            $this->addResult($model->__validate(), $this->__rsValidation);
        }
    }

    /**
     * Tracks load result
     * @param boolean $result
     */
    protected function addResult($result, &$holder)
    {
        if (!$this->__doPartial) {
            $holder = $holder && $result;
        } else {
            $holder = $holder || $result;
        }
    }

    /**
     * Finds existing slave or create new one
     * @param string $class
     * @return mixed
     */
    protected function initSlave($class, $id)
    {
        $intrfs = class_implements($class);

        if (!ArrayHelper::isIn(interfaces\FrmGroupableSlaveInterface::class, $intrfs)) {
            throw new \yii\base\InvalidConfigException(sprintf('"%s" has to implements "%s" class', $class, interfaces\FrmGroupableSlaveInterface::class));
        }

        $model = $class::__find();

        if (!$model) {
            return new $class;
        }

        $rules = ArrayHelper::getValue($this->__seValidationRules(), $id, []);

        $model->__addRules($rules);

        return $model;
    }

}
