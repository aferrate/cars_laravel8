<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Application\UseCases\Car\GetCarInfo;
use App\Application\UseCases\Car\ListAllCarsEnabled;
use App\Application\UseCases\Car\ListCarsFiltered;
use App\Application\UseCases\Car\AddElasticIndexForCars;
use App\Application\UseCases\Car\DeleteElasticIndexForCars;

class CarController extends Controller
{
    public function index(ListAllCarsEnabled $listAllCarsEnabled): View
    {
        return view('car.index', ['cars' => $listAllCarsEnabled->getCarsEnabled()]);
    }

    public function getCarInfo(GetCarInfo $getCarInfo, string $slug): View
    {
        return view('car.info', ['car' => $getCarInfo->getCarDetails($slug)]);
    }

    public function searchCars(ListCarsFiltered $listCarsFiltered, Request $request): string
    {
        $search = ($request->post('search') != '') ? $request->post('search') : '';

        $searchParams = [];
        $searchParams['search'] = $search;
        $searchParams['field'] = $request->post('field');

        return $listCarsFiltered->getCarsFiltered($searchParams, false);
    }
}
