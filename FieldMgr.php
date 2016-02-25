<?php
/**
 * Class FieldMgr
 * @package Craft
 */
namespace Craft;

/**
 * @property FieldMgr_FieldsService $fields FieldMgr Fields Service
 * @property FieldMgr_SectionsService $sections FieldMgr Sections Service
 */
class FieldMgr {

    /**
     * Return singleton instance of the Nerdery plugin service manager
     * @return FieldMgr
     */
    public static function app()
    {
        $className = get_called_class();
        static $inst = null;
        if ( $inst === null) {
            $inst = new $className();
        }
        return $inst;
    }

    /**
     * Magic method to return member services. Must manually define each service in the class doc-block to
     * get code hinting to work. This functionality is identical to craft()->[serviceName].
     *
     * @param $memberName
     * @return mixed|void
     */
    public function __get($memberName)
    {
        $className = join('', array_slice(explode('\\', get_class($this)), -1));
        $craftName = lcfirst($className) . '_' . strtolower($memberName);
        return craft()->$craftName;
    }

}
