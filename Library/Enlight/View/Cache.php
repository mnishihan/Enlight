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
 * @package    Enlight_View
 * @copyright  Copyright (c) 2011, shopware AG (http://www.shopware.de)
 * @license    http://enlight.de/license     New BSD License
 * @version    $Id$
 * @author     Heiner Lohaus
 * @author     $Author$
 */

/**
 * The Enlight_View_Cache defines an interface to implement the view caching.
 * If you want to implement your own view class then you have to implement this interface to support the view caching.
 *
 * @category   Enlight
 * @package    Enlight_View
 * @copyright  Copyright (c) 2011, shopware AG (http://www.shopware.de)
 * @license    http://enlight.de/license     New BSD License
 */
interface Enlight_View_Cache
{
    /**
     * @param   bool $value
     * @return  Enlight_View_Cache
     */
    public function setCaching($value = true);

    /**
     * @return bool
     */
    public function isCached();

    /**
     * @param   string|array $cache_id
     * @return  Enlight_View_Cache
     */
    public function setCacheId($cache_id = null);

    /**
     * @param   string|array $cache_id
     * @return  Enlight_View_Cache
     */
    public function addCacheId($cache_id);
}