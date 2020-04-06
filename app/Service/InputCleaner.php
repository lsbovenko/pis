<?php

namespace App\Service;

/**
 * Class Reference
 *
 * @package App\Service
 */
class InputCleaner
{
    const RULE_FOR_SCRIPT_TAG  = '#<script(.*?)>(.*?)</script>#is';

    /**
     * Method to strip tags globally.
     *
     * @param  array $data
     * @param  array $onlyStripScript -  only 'script' tag strip in these fields
     * @return array
     */
    public function cleanData(array $data, array $onlyStripScript = [])
    {
        return $this->arrayStripTags($data, $onlyStripScript);
    }

    /**
     * @param array $array
     * @param array $onlyStripScript
     * @return array
     */
    public function arrayStripTags(array $array, array $onlyStripScript = [])
    {
        $result = [];

        foreach ($array as $key => $value) {
            $key = strip_tags($key);

            if (is_array($value)) {
                $result[$key] = $this->arrayStripTags($value);
            } else {
                $value = trim($value);
                if (in_array($key, $onlyStripScript)) {
                    $result[$key] = preg_replace(self::RULE_FOR_SCRIPT_TAG, '', $value);
                } else {
                    $result[$key] = strip_tags($value);
                }
            }
        }

        return $result;
    }
}
