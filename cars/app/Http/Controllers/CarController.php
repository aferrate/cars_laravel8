<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\UseCases\Car\GetCarInfo;
use App\Application\UseCases\Car\ListAllCarsEnabled;
use App\Application\UseCases\Car\ListCarsFiltered;
use App\Application\UseCases\Car\AddElasticIndexForCars;
use App\Application\UseCases\Car\DeleteElasticIndexForCars;

class CarController extends Controller
{
    public function index(ListAllCarsEnabled $listAllCarsEnabled)
    {
        return view('car.index', ['cars' => $listAllCarsEnabled->getCarsEnabled(env('USE_BACKUP_REPO'))]);
    }

    public function getCarInfo(GetCarInfo $getCarInfo, string $slug)
    {
        return view('car.info', ['car' => $getCarInfo->getCarDetails($slug, env('USE_BACKUP_REPO'))]);
    }

    public function searchCars(ListCarsFiltered $listCarsFiltered, Request $request)
    {
        $search = ($request->post('search')!='') ? $request->post('search') : '';

        $searchParams = [];
        $searchParams['search'] = $search;
        $searchParams['field'] = $request->post('field');

        return $listCarsFiltered->getCarsFiltered($searchParams, false, env('USE_BACKUP_REPO'));
    }

    public function addElasticIndex(AddElasticIndexForCars $addElasticIndexForCars)
    {
        $addElasticIndexForCars->createIndexCars();

        return 'elastic index cars added';
    }

    public function deleteIndexCars(DeleteElasticIndexForCars $deleteElasticIndexForCars)
    {
        $deleteElasticIndexForCars->deleteIndexCars();

        return 'elastic index cars deleted';
    }
}
