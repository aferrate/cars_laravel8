<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Domain\Model\Car;
use DateTime;

class EloquentCarTest extends TestCase
{
    public function test_car_object()
    {
        $car = new Car();
        $car->setMark('test');
        $car->setModel('test');
        $car->setYear(2000);
        $car->setDescription('test');
        $car->setSlug('test');
        $car->setEnabled(true);
        $car->setCreatedAt((new DateTime('NOW'))->format('Y-m-d H:i:s'));
        $car->setUpdatedAt((new DateTime('NOW'))->format('Y-m-d H:i:s'));
        $car->setCountry('test');
        $car->setCity('test');
        $car->setImageFilename('test.jpg');
        $car->setAuthorId(1);

        $this->assertEquals($car->getMark(), 'test');
        $this->assertEquals($car->getModel(), 'test');
        $this->assertEquals($car->getYear(), 2000);
        $this->assertEquals($car->getDescription(), 'test');
        $this->assertEquals($car->getSlug(), 'test');
        $this->assertEquals($car->getEnabled(), true);
        $this->assertIsString($car->getCreatedAt());
        $this->assertIsString($car->getUpdatedAt());
        $this->assertEquals($car->getCountry(), 'test');
        $this->assertEquals($car->getCity(), 'test');
        $this->assertEquals($car->getImageFilename(), 'test.jpg');
        $this->assertEquals($car->getAuthorId(), 1);
    }
}
