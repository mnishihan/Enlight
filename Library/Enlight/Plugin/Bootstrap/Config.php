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
 * @package    Enlight_Plugin
 * @copyright  Copyright (c) 2011, shopware AG (http://www.shopware.de)
 * @license    http://enlight.de/license     New BSD License
 * @version    $Id$
 * @author     Heiner Lohaus
 * @author     $Author$
 */

/**
 * The Enlight_Plugin_Bootstrap_Config is the configuration class for a single plugin.
 *
 * @category   Enlight
 * @package    Enlight_Plugin
 * @copyright  Copyright (c) 2011, shopware AG (http://www.shopware.de)
 * @license    http://enlight.de/license     New BSD License
 */
class Enlight_Plugin_Bootstrap_Config extends Enlight_Plugin_Bootstrap
{
    /**
     * @var Enlight_Config
     */
	protected $config;

    /**
     * @var Enlight_Plugin_Namespace_Config
     */
	protected $collection;

    /**
     * Returns the application instance.
     *
     * @return  Enlight_Config
     */
    public function Config()
    {
        if($this->config === null) {
            $this->config = $this->Collection()->getConfig($this->getName());
        }
        return $this->config;
    }

    /**
     * @return  Enlight_Plugin_Namespace_Config
     */
	public function Collection()
	{
		return $this->collection;
	}

    /**
     * @param   string $event
     * @param   integer $position
     * @param   callback $listener
     * @return  Enlight_Plugin_Bootstrap_Config
     */
    public function subscribeEvent($event, $listener, $position = null)
    {
        $namespace = $this->Collection();
        $handler = new Enlight_Event_Handler_Plugin(
            $event, $namespace, $this, $listener, $position
        );
        $namespace->Subscriber()->registerListener($handler);
        return $this;
    }

    /**
     * @return void
     */
    public function install()
    {

    }
}