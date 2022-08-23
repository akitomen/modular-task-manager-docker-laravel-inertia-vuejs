<?php

namespace Modules\TaskManager\Restrictions;

use Illuminate\Support\Carbon;


class Shortcuts
{

    public static function getRepeatsProperties()
    {
        $result = [];
        $types = config()->get('taskmanager.recurrencables');

        foreach ($types as $key => $class) {
            $result[$key] = [];
            foreach ($class::properties() as $value => $label) {
                $result[$key][] = [
                    'value' => $value,
                    'label' => $label
                ];
            }
        }

        return $result;
    }


    public static function getRepeatTypes()
    {
        $result = [];
        $types = config()->get('taskmanager.recurrencables');

        foreach ($types as $key => $class) {
            $result[$key] = $class::className();
        }

        return $result;
    }

}
