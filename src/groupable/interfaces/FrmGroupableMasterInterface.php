<?php

/**
 * @link http://www.digitaldeals.cz/
 * @copyright Copyright (c) 2017 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 * @author Jiri Svoboda <jiri.svoboda@dlds.cz>
 */

namespace dlds\forms\interfaces;

/**
 * This is the Master groupable form interface
 *
 * @author Jiri Svoboda <jiri.svoboda@dlds.cz>
 */
interface FrmGroupableMasterInterface
{

    /**
     * Initializes groupable master form
     */
    public function __init();

    /**
     * Loads data into slaves and master
     */
    public function __load();
    
    /**
     * Loads data into master
     */
    public function __loadMaster();

    /**
     * Process slaves saving
     */
    public function __process();
    
    /**
     * Retrieves validation rules
     */
    public function __rules();

    /**
     * Retrieves current slave model
     * @param int $id
     */
    public function __seModel($id);

    /**
     * Retrieves required slaves
     */
    public function __seRequireds();

    /**
     * Retrieves slaves rules
     */
    public function __seRules();
}