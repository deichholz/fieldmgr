<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 2/20/2016
 * Time: 6:31 PM
 */

namespace Craft;


class FieldMgr_ImportController extends BaseController
{

    /**
     * @inheritDoc BaseController::init()
     *
     * @throws HttpException
     * @return null
     */
    public function init()
    {
        craft()->userSession->requireAdmin();
    }

    public function actionFields()
    {

        // read/parse file
        $rawJson = file_get_contents(__DIR__ . '/../craft_schema.json');
        $jsonData = json_decode($rawJson, true);


        // build quick lookup array for existing field groups
        $existingFieldGroups = array();
        foreach(craft()->fields->getAllGroups() as $existingGroup)
        {
            $existingFieldGroups[$existingGroup->name] = $existingGroup;
        }

        Craft::log('Creating the Default field group.');

        foreach($jsonData['fieldGroups'] as $fieldGroupData) {

            $fieldGroupName = !empty($fieldGroupData['name']) ? $fieldGroupData['name'] : 'Default';
            $fieldList = $fieldGroupData['fields'];
            if (isset($existingFieldGroups[$fieldGroupName])) {
                $group = $existingFieldGroups[$fieldGroupName];
            } else {
                FieldMgr()->fields->createGroup($fieldGroupData);
            }

            foreach ($fieldList as $fieldData) {

                FieldMgr()->fields->createField($fieldData);
            }
        }

        die('finished with new records');

    }

    

}