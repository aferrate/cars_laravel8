<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Car;
use App\Domain\Model\Car as CarDomain;
use App\Eloquent\Repositories\EloquentCarRepository;
use App\Domain\Criteria\Criteria;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EloquentCarTest extends TestCase
{
    use RefreshDatabase;

    private $carRepo;

    public function setUp(): void
    {
        $car = Car::factory()->make();
        $this->carRepo = new EloquentCarRepository($car);

        parent::setUp();
    }

    public function test_find_all_enabled()
    {
        $this->assertIsArray($this->carRepo->findAllEnabled());
    }

    public function test_find_all()
    {
        $this->assertIsArray($this->carRepo->findAll());
    }

    public function test_find_search_by_criteria()
    {
        $criteria = new Criteria($this->carRepo->translateFilter(
                'mark',
                'test'
            ),
            'desc'
        );

        $this->assertIsArray($this->carRepo->searchByCriteria($criteria, true));
    }

    public function test_find_one_by_id()
    {
        $this->assertInstanceOf(CarDomain::class, $this->carRepo->findOneById(2));
    }

    public function test_find_by_slug()
    {
        $this->assertInstanceOf(CarDomain::class, $this->carRepo->findBySlug('6127cd44656e4'));
    }
}
