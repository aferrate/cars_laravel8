<?php
namespace App\ElasticSearch;

class TranslateFilterElasticSearch
{
    public static function translateFilter(string $field, string $stringToSearch): array
    {
        switch ($field) {
            case 'mark':
                $search = TranslateFilterElasticSearch::formatSearch($stringToSearch);

                $filter2 = [
                    'wildcard' => [
                        'model' => ['wildcard' => $search]
                    ]
                ];

                break;
            case 'model':
                $search = TranslateFilterElasticSearch::formatSearch($stringToSearch);

                $filter2 = [
                    'wildcard' => [
                        'model' => ['wildcard' => $search]
                    ]
                ];

                break;
            case 'year':
                if ($stringToSearch !== '') {
                    $stringToSearch = (is_numeric($stringToSearch)) ? $stringToSearch : '-1';

                    $filter2 = [
                        'term' => [
                            'year' => ['value' => $stringToSearch]
                        ]
                    ];
                } else {
                    $filter2 = [
                        'wildcard' => [
                            'model' => ['wildcard' => '*']
                        ]
                    ];
                }

                break;
        }

        $filter = [
            'bool' => [
                'must' => [$filter2]
            ]
        ];

        return $filter;
    }

    private static function formatSearch(string $stringToSearch): string
    {
        $search = '';

        if ($stringToSearch !== '') {
            $search = '*' . $stringToSearch . '*';
        } else {
            $search = '*';
        }

        return $search;
    }
}
