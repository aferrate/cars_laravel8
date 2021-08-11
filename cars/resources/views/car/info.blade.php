@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Mark</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Description</th>
                    <th>Last update</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>Photo</th>
                </tr>
                </thead>
                <tbody>
                    @if ($car->getId() == 0)
                        <tr>
                            <td colspan="9">no car found</td>
                        </tr>
                    @else
                        <tr>
                            <td>
                                {{ $car->getId() }}
                            </td>
                            <td>
                                {{ $car->getMark() }}
                            </td>
                            <td>
                                {{ $car->getModel() }}
                            </td>
                            <td>
                                {{ $car->getYear() }}
                            </td>
                            <td>
                                {{ $car->getDescription() }}
                            </td>
                            <td>
                                {{ $car->getUpdatedAt() }}
                            </td>
                            <td>
                                {{ $car->getCountry() }}
                            </td>
                            <td>
                                {{ $car->getCity() }}
                            </td>
                            <td>
                                @if ($car->getImageFilename() !== '')
                                    <img class="car-img" src="/uploads/car_image/{{ $car->getImageFilename() }}">
                                @else
                                    no photo yet
                                @endif
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection