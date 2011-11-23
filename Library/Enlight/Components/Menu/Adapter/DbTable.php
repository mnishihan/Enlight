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
 * @category    Enlight
 * @package	    Enlight_Components_Menu
 * @copyright   Copyright (c) 2011, shopware AG (http://www.shopware.de)
 * @license	    http://enlight.de/license	 New BSD License
 * @version	    $Id$
 * @author	    Heiner Lohaus
 * @author	    $Author$
 */

/**
 * @category    Enlight
 * @package	    Enlight_Components_Menu
 * @copyright   Copyright (c) 2011, shopware AG (http://www.shopware.de)
 * @license	    http://enlight.de/license	 New BSD License
 */
class Enlight_Components_Menu_Adapter_DbTable extends Zend_Db_Table_Abstract
{
    /**
     * @var     string
     */
	protected $_name = 'menu';

    /**
     * @var     string
     */
	protected $_primary = 'id';

    /**
     * @var     array
     */
	protected $_columns = array(
		'id' => 'id',
		'parent' => 'parent',
		'uri' => 'hyperlink',
		'label' => 'name',
		'onClick' => 'onClick',
		'style' => 'style',
		'class' => 'class',
		'position' => 'position',
		'active' => 'active'
	);

    /**
     * @var     array
     */
	protected $_order = array(
		'parent', 'position', 'id'
	);

    /**
     * setOptions()
     *
     * @param   array $options
     * @return  Enlight_Components_Menu_Adapter_DbTable
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $option) {
        	if($key == 'order') {
        		$this->_order = $option;
        	} elseif(substr($key, -6) == 'Column') {
        		$this->_columns[substr($key, 0, -6)] = (string) $option;
        	}
        }
        return parent::setOptions($options);
    }

    /**
     * @param   Enlight_Components_Menu $menu
     * @return  Enlight_Components_Menu_Adapter_DbTable
     */
    public function read(Enlight_Components_Menu $menu)
    {
    	$rows = $this->fetchAll(null, $this->_order);
		$pages = array();
		foreach ($rows as $rowKey => $row) {
			$page = array('order'=>$rowKey);
			foreach ($this->_columns as $key => $column) {
				if (isset($row->{$column})) {
					$page[$key] = $row->{$column};
				}
			}
			$pages[] = $page;
		}
		$menu->addItems($pages);
        return $this;
    }

    /**
     * @param   Enlight_Components_Menu $menu
     * @return  Enlight_Components_Menu_Adapter_DbTable
     */
    public function write(Enlight_Components_Menu $menu)
    {
    	$iterator = new RecursiveIteratorIterator($menu, RecursiveIteratorIterator::CHILD_FIRST);
        /** @var Zend_Navigation_Page $page */
        foreach ($iterator as $page) {
        	$data = array();
        	$dataId = null;

			foreach ($this->_columns as $key => $column) {
				$value = $page->get($key);
				if($key=='parent') {
					if($value instanceof Zend_Navigation_Page) {
                        /** @var Zend_Navigation_Page $value */
						$value = $value->getId();
					} elseif($value !== null) {
						$value = 0;
					}
				} elseif($key == 'id') {
					$dataId = $value;
					$value = null;
				}
				if($value !== null) {
					$data[$column] = $value;
				}
			}

			if($dataId !== null) {
				$this->update($data, array($this->_columns['id'].' = ?' => $dataId));
			} else {
				$page->setId($this->insert($data));
			}
        }
        return $this;
    }
}