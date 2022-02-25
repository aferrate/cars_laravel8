<?php
namespace App\ElasticSearch\Repositories;

use App\Domain\Repository\CarRepositoryBackupInterface;
use App\Domain\Model\Car;
use App\Domain\Criteria\Criteria;
use App\ElasticSearch\TranslateFilterElasticSearch;
use Elasticsearch\Client;
use DateTime;

class ElasticSearchCarRepository implements CarRepositoryBackupInterface
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function findAllEnabled(int $limit = 0, int $offset = 0): array
    {
        $cars = [];

        $params = [
            'index' => 'cars',
            'body' => [
                'query' => [
                    'match' => [
                        'enabled' => true
                    ]
                ]
            ]
        ];
        $params['sort'] = ['id:desc'];

        $carsElastic = $this->getClient()->search($params);

        foreach ($carsElastic['hits']['hits'] as $car) {
            $cars[] = $car['_source'];
        }

        return $cars;
    }

    public function findAll(): array
    {
        $cars = [];

        $params = ['index' => 'cars'];
        $params['sort'] = ['id:desc'];

        $carsElastic = $this->getClient()->search($params);

        foreach ($carsElastic['hits']['hits'] as $car) {
            $cars[] = $car['_source'];
        }

        return $cars;
    }

    public function searchByCriteria(Criteria $criteria, bool $isAdmin): array
    {
        $cars = [];
        $filter = $criteria->getFilters();

        if (!$isAdmin) {
            $filter['bool']['must'][] = ['term' => ['enabled' => ['value' => true]]];
        }

        $params = [
            'index' => 'cars',
            'body' => [
                'query' => $filter
            ]
        ];
        $params['sort'] = ($criteria->getOrder() == 'desc') ? ['id:desc'] : ['id:asc'];

        $carsElastic = $this->getClient()->search($params);

        foreach ($carsElastic['hits']['hits'] as $car) {
            $cars[] = $car['_source'];
        }

        return $cars;
    }

    public function findOneById($id): Car
    {
        $params = [
            'index' => 'cars',
            'body' => [
                'query' => [
                    'match' => [
                        'id' => $id
                    ]
                ]
            ]
        ];

        $carElastic = $this->getClient()->search($params);

        if (empty($carElastic['hits']['hits'])) {
            $car = new Car();
            $car->setId(0);

            return $car;
        }

        $car = $this->returnCarDomain($carElastic['hits']['hits'][0]['_source']);

        return $car;
    }

    public function findBySlug(string $slug): Car
    {
        $params = [
            'index' => 'cars',
            'body' => [
                'query' => [
                    'match' => [
                        'slug' => $slug
                    ]
                ]
            ]
        ];

        $carElastic = $this->getClient()->search($params);

        if (empty($carElastic['hits']['hits'])) {
            $car = new Car();
            $car->setId(0);

            return $car;
        }

        $car = $this->returnCarDomain($carElastic['hits']['hits'][0]['_source']);

        return $car;
    }

    public function save(Car $car): void
    {
        $params = [
            'index' => 'cars',
            'id' => $car->getId(),
            'body' => [
                'id' => $car->getId(),
                'author_id' => $car->getAuthorId(),
                'mark' => $car->getMark(),
                'model' => $car->getModel(),
                'year' => $car->getYear(),
                'description' => $car->getDescription(),
                'slug' => $car->getSlug(),
                'enabled' => $car->getEnabled(),
                'created_at' => $car->getCreatedAt(),
                'updated_at' => $car->getUpdatedAt(),
                'country' => $car->getCountry(),
                'city' => $car->getCity(),
                'image_filename' => $car->getImageFilename()
            ]
        ];

        $this->getClient()->index($params);
    }

    public function update(Car $car): void
    {
        $params = [
            'index' => 'cars',
            'id' => $car->getId(),
            'body' => [
                'doc' => [
                    'id' => $car->getId(),
                    'author_id' => $car->getAuthorId(),
                    'mark' => $car->getMark(),
                    'model' => $car->getModel(),
                    'year' => $car->getYear(),
                    'description' => $car->getDescription(),
                    'enabled' => $car->getEnabled(),
                    'updated_at' => $car->getUpdatedAt(),
                    'country' => $car->getCountry(),
                    'city' => $car->getCity(),
                    'image_filename' => $car->getImageFilename()
                ]
            ]
        ];

        $this->getClient()->update($params);
    }

    public function delete(int $carId): void
    {
        $params = [
            'index' => 'cars',
            'id' => $carId
        ];

        $this->getClient()->delete($params);
    }

    public function createIndexCars(): void
    {
        $params = [
            'index' => 'cars',
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0
                ],
                'mappings' => [
                    '_source' => [
                        'enabled' => true
                    ],
                    'properties' => [
                        'id' => [
                            'type' => 'integer',
                            'index' => 'true'
                        ],
                        'author_id' => [
                            'type' => 'integer',
                            'index' => 'true'
                        ],
                        'mark' => [
                            'type' => 'keyword',
                            'index' => 'true',
                        ],
                        'model' => [
                            'type' => 'keyword',
                            'index' => 'true',
                        ],
                        'year' => [
                            'type' => 'integer',
                            'index' => 'true',
                        ],
                        'description' => [
                            'type' => 'text',
                            'index' => 'true',
                        ],
                        'slug' => [
                            'type' => 'text',
                            'index' => 'true',
                        ],
                        'enabled' => [
                            'type' => 'boolean',
                            'index' => 'true',
                        ],
                        'created_at' => [
                            'type' => 'date',
                            'format' => 'yyyy-MM-dd HH:mm:ss',
                            'index' => 'true',
                        ],
                        'updated_at' => [
                            'type' => 'date',
                            'format' => 'yyyy-MM-dd HH:mm:ss',
                            'index' => 'true',
                        ],
                        'country' => [
                            'type' => 'text',
                            'index' => 'true',
                        ],
                        'city' => [
                            'type' => 'text',
                            'index' => 'true',
                        ],
                        'image_filename' => [
                            'type' => 'text',
                            'index' => 'true',
                        ]
                    ]
                ]
            ]
        ];

        $this->getClient()->indices()->create($params);
    }

    public function deleteIndexCars(): void
    {
        $deleteParams = [
            'index' => 'cars'
        ];

        $this->getClient()->indices()->delete($deleteParams);
    }

    private function returnCarDomain(array $carElastic): Car
    {
        $car = new Car();

        $car->setId($carElastic['id']);
        $car->setMark($carElastic['mark']);
        $car->setModel($carElastic['model']);
        $car->setYear($carElastic['year']);
        $car->setDescription($carElastic['description']);
        $car->setSlug($carElastic['slug']);
        $car->setEnabled($carElastic['enabled']);
        $car->setCountry($carElastic['country']);
        $car->setCity($carElastic['city']);
        $car->setImageFilename($carElastic['image_filename']);
        $car->setCreatedAt($carElastic['created_at']);
        $car->setUpdatedAt($carElastic['updated_at']);
        $car->setAuthorId($carElastic['author_id']);

        return $car;
    }

    public function translateFilter(string $field, string $stringToSearch)
    {
        return TranslateFilterElasticSearch::translateFilter($field, $stringToSearch);
    }
}
