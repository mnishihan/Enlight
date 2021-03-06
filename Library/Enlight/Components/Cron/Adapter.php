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
 * @package    Enlight_Cron
 * @copyright  Copyright (c) 2011, shopware AG (http://www.shopware.de)
 * @license    http://enlight.de/license     New BSD License
 * @version    $Id$
 * @author     $Author$
 */

/**
 * Interface for specific cron job adapter.
 *
 * The Enlight_Components_Cron_Adapter interface provides an easy way to implement own cron job adapter.
 *
 * @category   Enlight
 * @package    Enlight_Cron
 * @copyright  Copyright (c) 2011, shopware AG (http://www.shopware.de)
 * @license    http://enlight.de/license     New BSD License
 */
interface Enlight_Components_Cron_Adapter
{

    /**
     * Used to set adapter specific options
     *
     * @abstract
     * @param array $options
     * @return Enlight_Components_Cron_CronManager
     */
    public function setOptions(array $options);

    /**
     * Updates a cron job in the cron tab
     *
     * @abstract
     * @param Enlight_Components_Cron_Job $job
     * @return Enlight_Components_Cron_CronManager
     */
    public function updateJob(Enlight_Components_Cron_Job $job);

    /**
     * Returns an array of Enlight_Components_Cron_Job from the crontab
     *
     * @abstract
     * @return array
     */
    public function getAllJobs();

    /**
     * Returns the next cron job
     *
     * @return null|Enlight_Components_Cron_Job
     */
    public function getNextJob();

    /**
     * Receives a single Cron job defined by its id from the crontab
     *
     * @abstract
     * @param Int $id
     * @return Enlight_Components_Cron_Job
     */
    public function getJobById($id);

    /**
     * Receives a single cron job by its name
     *
     * @abstract
     * @param String $name
     * @return Enlight_Components_Cron_Job
     */
    public function getJobByName($name);

    /**
     * Adds a job to the crontab
     *
     * @abstract
     * @param Enlight_Components_Cron_Job $job
     * @return void
     */
    public function addJob(Enlight_Components_Cron_Job $job);

    /**
     * Removes an job from the crontab
     *
     * @abstract
     * @param Enlight_Components_Cron_Job $job
     * @return void
     */
    public function removeJob(Enlight_Components_Cron_Job $job);

    /**
     * Receives a single job by its defined action
     *
     * @abstract
     * @param $actionName
     * @return void
     */
    public function getJobByAction($actionName);
}