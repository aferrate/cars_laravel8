<?php
namespace App\Eloquent;

class TranslateFilterEloquent
{
    public static function translateFilter(string $field, string $stringToSearch)
    {
        $filter = [];

        switch ($field) {
            case 'mark':
                if ($stringToSearch !== '') {
                    $filter[] = 'mark LIKE \'%' . $stringToSearch . '%\'';
                }

                break;
            case 'model':
                if ($stringToSearch !== '') {
                    $filter[] = 'model LIKE \'%' . $stringToSearch . '%\'';
                }

                break;
            case 'year':
                if ($stringToSearch !== '') {
                    $stringToSearch = (is_numeric($stringToSearch)) ? $stringToSearch : '-1';
                    $filter[] = 'year =' . $stringToSearch . '';
                }

                break;
        }

        return $filter;
    }
}
