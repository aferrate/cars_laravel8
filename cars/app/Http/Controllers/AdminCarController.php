<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Application\UseCases\Car\ListAllCars;
use App\Application\UseCases\Car\InsertCar;
use App\Application\UseCases\Car\UpdateCar;
use App\Application\UseCases\Car\DeleteCar;
use App\Application\UseCases\Car\GetCarInfo;
use App\Application\UseCases\Car\ListCarsFiltered;
use App\Domain\Model\Car;

class AdminCarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:admincar-list|admincar-create|admincar-edit|admincar-delete', ['only' => ['list', 'searchCars']]);
        $this->middleware('permission:admincar-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:admincar-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admincar-delete', ['only' => ['delete']]);
    }

    public function list(ListAllCars $ListAllCars): View
    {
        return view('car_admin.list', ['cars' => $ListAllCars->findAllCars()]);
    }

    public function create(): View
    {
        return view('car_admin.create');
    }

    public function store(InsertCar $insertCar, Request $request): RedirectResponse
    {
        $this->validateFormFields(request());

        $insertCar->insert($request->all(), Auth::id());

        return redirect('admin');
    }

    public function edit(GetCarInfo $getCarInfo, int $id): View
    {
        return view('car_admin.edit', ['car' => $getCarInfo->getCarFromId($id)]);
    }

    public function update(UpdateCar $updateCar, Request $request, int $id): RedirectResponse
    {
        $this->validateFormFields(request());

        $updateCar->update($request->all(), Auth::id(), $id);

        return redirect('admin');
    }

    public function delete(DeleteCar $deleteCar, Request $request): bool
    {
        $deleteCar->delete(request('carid'), request('imageName'));

        return true;
    }

    public function searchCars(ListCarsFiltered $listCarsFiltered, Request $request): string
    {
        $search = ($request->post('search') != '') ? $request->post('search') : '';

        $searchParams = [];
        $searchParams['search'] = $search;
        $searchParams['field'] = $request->post('field');

        return $listCarsFiltered->getCarsFiltered($searchParams, true);
    }

    private function validateFormFields($request): void
    {
        $request->validate([
            'mark' => 'required',
            'model' => 'required',
            'year' => 'digits_between:4,4',
            'description' => ['required', 'min:5'],
            'country' => 'required',
            'city' => 'required',
            'imageFile' => 'mimes:jpeg,png,jpg,svg|max:2048'
        ]);
    }
}
