@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form>
                <div class="form-group">
                    <label>Search</label>
                    <div>
                        <label><input type="radio" name="field" value="mark" checked="checked"> Mark </label>
                        <label><input type="radio" name="field" value="model"> Model </label>
                        <label><input type="radio" name="field" value="year"> Year </label>
                    </div>
                    <input type="text" class="form-control" id="search" placeholder="Enter search">
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary" id="buttonFilter">Filter</button>
                </div>
            </form>
        </div>
        <div class="row" id="carsTable">
            @include('car.carsTable', array('cars' => $cars))
        </div>
    </div>
@endsection