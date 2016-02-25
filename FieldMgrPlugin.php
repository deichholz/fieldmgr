<?php
namespace Craft;

use ReflectionClass;

/**
 * Field Manager Plugin
 *
 * This plugin provides tools for managing release of field changes in a multi environment release process.
 *
 * Class FieldMgrPlugin
 * @package Craft
 * @subpackage FieldMgr
 * @author Dan Eichholz <deichholz@nerdery.com>
 */

class FieldMgrPlugin extends BasePlugin
{
    /**
     * Plugin name
     * @var string $_name
     */
    public $_name = 'Field Manager';

    /**
     * Plugin version
     * @var string $_version
     */
    public $_version = '0.1';

    /**
     * Plugin developer URL
     * @var string $_developerUrl
     */
    public $_developerUrl = 'http://nerdery.com';

    /**
     * Plugin developer
     * @var string $_developer
     */
    public $_developer = 'Dan Eichholz (The Nerdery)';

    /**
     * Getter for $_name
     * @return null|string
     */
    public function getName()
    {
        return Craft::t($this->_name);
    }

    /**
     * Getter for $_version
     * @return null|string
     */
    public function getVersion()
    {
        return Craft::t($this->_version);
    }

    /**
     * Getter for $_developer
     * @return null|string
     */
    public function getDeveloper()
    {
        return Craft::t($this->_developer);
    }

    /**
     * Getter for $_developerUrl
     * @return null|string
     */
    public function getDeveloperUrl()
    {
        return Craft::t($this->_developerUrl);
    }

    /**
     * Get a plugin's handle
     *
     * @return string
     *      The plugin's handle
     */
    public function getHandle()
    {
        $reflector = new ReflectionClass(get_class($this));
        $pluginDir = dirname($reflector->getFileName());
        $pluginHandle = end(explode(DIRECTORY_SEPARATOR, $pluginDir));
        return $pluginHandle;
    }

    public function init()
    {
        parent::init();
        // todo: Load bootstrap
        // todo: load composer autoloader
    }

}


require_once __DIR__ . '/FieldMgr.php';
/**
 * Globally available convenience function that returns the plugin equivalent to webApp class that serves up services.
 *
 * @return FieldMgr
 */
function FieldMgr()
{
    return FieldMgr::app();
}
