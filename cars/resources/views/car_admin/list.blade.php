@extends('layouts.app')

@section('header')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
@endsection

@section('content')
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p id="deleteMsg">Are you sure about deleting car?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                    <button id="deleteCar" type="button" class="btn btn-danger" data-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <p>
                <a href="{{ route('car_admin.create') }}">
                    <button type="button" class="btn btn-primary" id="buttonNewCar">Add new car</button>
                </a>
            </p>
        </div>
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
            @include('car_admin.carsTable', array('cars' => $cars))
        </div>
    </div>
@endsection