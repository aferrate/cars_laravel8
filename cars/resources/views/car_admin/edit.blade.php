@extends('layouts.app')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <h1>Update car</h1>
            @if ($car->getId() == 0)
                No car found
            @else
                <form method="post" action="/admin/update/{{ $car->getId() }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="label" for="mark">Mark</label>
                        <input class="form-control @error('mark') is-invalid @enderror" type="text" name="mark" id="mark" value="{{ $car->getMark() }}">
                        @error('mark')
                            <p class="text-danger">{{ $errors->first('mark') }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="label" for="model">Model</label>
                        <input class="form-control @error('model') is-invalid @enderror" type="text" name="model" id="model" value="{{ $car->getModel() }}">
                        @error('model')
                            <p class="text-danger">{{ $errors->first('model') }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="label" for="year">Year</label>
                        <input class="form-control @error('year') is-invalid @enderror" type="text" name="year" id="year" value="{{ $car->getYear() }}">
                        @error('year')
                            <p class="text-danger">{{ $errors->first('year') }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="label" for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{ $car->getDescription() }}</textarea>
                        @error('description')
                            <p class="text-danger">{{ $errors->first('description') }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="label" for="country">Country</label>
                        <input class="form-control @error('country') is-invalid @enderror" type="text" name="country" id="country" value="{{ $car->getCountry() }}">
                        @error('country')
                            <p class="text-danger">{{ $errors->first('country') }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="label" for="city">City</label>
                        <input class="form-control @error('city') is-invalid @enderror" type="text" name="city" id="city" value="{{ $car->getCity() }}">
                        @error('city')
                            <p class="text-danger">{{ $errors->first('city') }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="imageFile">Choose file</label>
                        <input type="file" class="form-control-file" id="imageFile" name="imageFile">
                        @error('city')
                            <p class="text-danger">{{ $errors->first('imageFile') }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="label" for="enabled">Enabled</label>
                        <input class="form-check-label" type="checkbox" name="enabled" id="enabled" @if ($car->getEnabled() == 1) checked="checked" @endif>
                    </div>
                    <div class="form-group">
                        <label class="label" for="defImg">Set default image</label>
                        <input class="form-check-label" type="checkbox" name="defImg" id="defImg">
                    </div>
                    <div class="form-group">
                        <p>Actual image</p>
                        <img name="actualImg" id="actualImg" src="/uploads/car_image/{{ $car->getImageFilename() }}">
                    </div>
                    <input type="hidden" id="imageFileOld" name="imageFileOld" value="{{ $car->getImageFilename() }}">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </form>
            @endif
        </div>
    </div>
@endsection