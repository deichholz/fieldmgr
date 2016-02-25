<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 2/21/2016
 * Time: 11:13 PM
 */

namespace Craft;


class FieldMgr_FieldsService extends BaseApplicationComponent
{

    const GROUP_NAME_DEFAULT = 'Default';


    /**
     * @param $fieldData
     * @throws \Exception
     */
    public function createField($fieldData)
    {
        $handle = $fieldData['handle'];
        $field = craft()->fields->getFieldByHandle($handle);
        if ($field) {
            foreach ($fieldData as $paramName => $paramData) {
                if ($paramName == 'settings' && is_array($paramData)) {
                    //if
                }
                if (isset($field->$paramName) && $field->$paramName != $paramData) {
                    $field->$paramName = $paramData;
                    Craft::log("Modifying field '$handle', $paramName: {$field->$paramName} -> $paramData");
                }
            }
        }
        else {
            $fieldData = $this->applyFieldDefaults($fieldData);
            Craft::log("Creating field '$handle'");
            $field = new FieldModel($fieldData);
        }

        if (craft()->fields->saveField($field)) {
            Craft::log('Field ' . $field->handle . 'saved successfully.');
        } else {
            Craft::log("Could not save the \"{$field->handle}\" field.", LogLevel::Warning);
        }
    }


    public function createGroup($values) 
    {
        $name = !empty($values['name']) ? $values['name'] : self::GROUP_NAME_DEFAULT;
        $group = new FieldGroupModel();
        $group->name = $name;

        if (craft()->fields->saveGroup($group)) {
            Craft::log("Field group '$name' created successfully.");
        }
        else {
            Craft::log("Could not save the field group '$name'", LogLevel::Warning);
        }

        return $group;        
    }

    /**
     * @param array $fieldData
     * @return array
     */
    public function applyFieldDefaults(array $fieldData)
    {
        $fieldDefaults = [
            'type' => 'PlainText',
            'translatable' => 1,
            'context' => 'global',

            'settings' => json_encode([]),
        ];
        $fieldData = array_replace_recursive($fieldDefaults, $fieldData);
        return $fieldData;
    }


}