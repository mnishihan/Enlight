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
 * @package    Enlight_Extensions
 * @copyright  Copyright (c) 2011, shopware AG (http://www.shopware.de)
 * @license    http://enlight.de/license     New BSD License
 * @version    $Id$
 * @author     Heiner Lohaus
 * @author     $Author$
 */

/**
 * @category   Enlight
 * @package    Enlight_Extensions
 * @copyright  Copyright (c) 2011, shopware AG (http://www.shopware.de)
 * @license    http://enlight.de/license     New BSD License
 */
class Enlight_Extensions_Log_Bootstrap extends Enlight_Plugin_Bootstrap_Config
{
	/**
	 * Install log plugin
	 */
	public function install()
	{
        /** @var $namespace Enlight_Plugin_Namespace_Config */
        $namespace = $this->Collection();

		$namespace->Subscriber()->registerListener(new Enlight_Event_Handler_Plugin(
            'Enlight_Bootstrap_InitResource_Log',
            null,
            $namespace,
            $this,
            'onInitResourceLog'
        ));

        $namespace->Subscriber()->registerListener(new Enlight_Event_Handler_Plugin(
            'Enlight_Controller_Front_RouteStartup',
            null,
            $namespace,
            $this,
            'onRouteStartup'
        ));
	}

	/**
	 * Resource handler for log plugin

	 * @param Enlight_Event_EventArgs $args
	 * @return Zend_Log
	 */
	public function onInitResourceLog(Enlight_Event_EventArgs $args)
	{
		return Enlight_Components_Log::factory(array(
            array('writerName' => 'Null'),
            /*array(
                'writerName' => 'Db',
                'writerParams' => array(
                    'table' => 'log',
                    'db' => $this->Application()->Db(),
                    'columnMap' => array(
                        'priority' => 'priorityName',
                        'message' => 'message',
                        'date' => 'timestamp',
                        //'remote_address' => 'remote_address',
                        //'user_agent' => 'user_agent',
                    )
                )
            ),*/
        ));
        /*
		if(!empty($config->logDb)) {
			$writer = Zend_Log_Writer_Db::factory(array(
				'db' => $this->Application()->Db(),
				'table' => 's_core_log',
				'columnMap' => array(
					'key' => 'priorityName',
					'text' => 'message',
					'datum' => 'date',
					'value2' => 'remote_address',
					'value3' => 'user_agent',
				)
			));
			$writer->addFilter(Zend_Log::ERR);
			$log->addWriter($writer);
		}
        */
        /*
		if(!empty($config->logMail)) {
			$mail = clone Shopware()->Mail();
			$mail->addTo(Shopware()->Config()->Mail);
			$writer = new Zend_Log_Writer_Mail($mail);
			$writer->setSubjectPrependText('Fehler im Shop "' . Shopware()->Config()->Shopname . '" aufgetreten!');
			$writer->addFilter(Zend_Log::WARN);
			$log->addWriter($writer);
		}
        $log->addWriter(new Zend_Log_Writer_Null());
        return $log;
        */
	}

	/**
	 * On Route add user-agent and remote-address to log component
     *
	 * @param Enlight_Event_EventArgs $args
	 */
	public function onRouteStartup(Enlight_Event_EventArgs $args)
	{
        /** @var $request Enlight_Controller_Request_RequestHttp */
		$request = $args->getSubject()->Request();


        /** @var $log Zend_Log */
		$log = $this->Application()->Log();

		$log->setEventItem('remote_address', $request->getClientIp(false));
		$log->setEventItem('user_agent', $request->getServer('HTTP_USER_AGENT'));
	}      
}
