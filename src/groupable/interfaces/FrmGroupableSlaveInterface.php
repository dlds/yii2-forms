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
interface FrmGroupableSlaveInterface
{

    /**
     * Load model
     */
    public function __load($data, $formName = null);

    /**
     * Save model
     */
    public function __save();

    /**
     * Validate model
     */
    public function __validate();

    /**
     * Loads existing entry
     */
    public static function __find();
}
