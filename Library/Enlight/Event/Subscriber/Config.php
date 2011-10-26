<?php
/**
 * Enlight
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://enlight.de/license
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@shopware.de so we can send you a copy immediately.
 *
 * @category   Enlight
 * @package    Enlight_Event
 * @copyright  Copyright (c) 2011, shopware AG (http://www.shopware.de)
 * @license    http://enlight.de/license     New BSD License
 * @version    $Id$
 * @author     Heiner Lohaus
 * @author     $Author$
 */

/**
 * @category   Enlight
 * @package    Enlight_Event
 * @copyright  Copyright (c) 2011, shopware AG (http://www.shopware.de)
 * @license    http://enlight.de/license     New BSD License
 */
class Enlight_Event_Subscriber_Config extends Enlight_Event_Subscriber
{
    /**
     * @var array
     */
    protected $listeners;

    /**
     * @var Enlight_Config
     */
    protected $storage;

    /**
     * @param   null $options
     */
    public function __construct($options = null)
    {
        if(!is_array($options)) {
            $options = array('storage' => $options);
        }
        if(isset($options['storage']) && is_string($options['storage'])) {
            $this->storage = new Enlight_Config($options['storage'], array(
                'allowModifications' => true,
                'adapter' => isset($options['storageAdapter']) ? $options['storageAdapter'] : null,
                'section' => isset($options['section']) ? $options['section'] : 'production'
            ));
        } elseif(isset($options['storage']) && $options['storage'] instanceof Enlight_Config) {
            $this->storage = $options['storage'];
        } else {
            throw new Enlight_Event_Exception('');
        }
    }

    /**
     * Retrieve a list of listeners registered.
     *
     * @return  array
     */
    public function getListeners()
    {
        if($this->listeners === null) {
            $this->read();
        }
        return $this->listeners;
    }

    /**
     * Register a listener to an event.
     *
     * @param   Enlight_Event_Handler $handler
     * @return  Enlight_Event_Subscriber
     */
    public function registerListener(Enlight_Event_Handler $handler)
    {
        $this->listeners[] = $handler;
        return $this;
    }

    /**
     * Remove an event listener from storage.
     *
     * @param   Enlight_Event_Handler $handler
     * @return  Enlight_Event_Subscriber
     */
    public function removeListener(Enlight_Event_Handler $handler)
    {
        $this->listeners = array_diff($this->listeners, array($handler));
        return $this;
    }

    /**
     * @return  Enlight_Event_Subscriber_Config
     */
    public function write()
    {
        $listeners = array();
        foreach($this->listeners as $handler) {
           $listeners[] =  $handler->toArray();
        }
        $this->storage->listeners = $listeners;
        $this->storage->write();
        return $this;
    }

    /**
     * Loads the event listener from storage.
     *
     * @return  Enlight_Event_Subscriber_Config
     */
    public function read()
    {
        $this->listeners = array();

        if($this->storage->listeners !== null)
        foreach($this->storage->listeners as $entry) {
            if(!$entry instanceof Enlight_Config) {
                continue;
            }
            $this->listeners[] = new Enlight_Event_Handler_Default(
                $entry->name,
                $entry->position,
                $entry->listener
            );
        }
        return $this;
    }
}