@extends('layouts.app')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <h1>New car</h1>
            <form method="post" action="{{ route('car_admin.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="label" for="mark">Mark</label>
                    <input class="form-control @error('mark') is-invalid @enderror" type="text" name="mark" id="mark">
                    @error('mark')
                        <p class="text-danger">{{ $errors->first('mark') }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="label" for="model">Model</label>
                    <input class="form-control @error('model') is-invalid @enderror" type="text" name="model" id="model">
                    @error('model')
                        <p class="text-danger">{{ $errors->first('model') }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="label" for="year">Year</label>
                    <input class="form-control @error('year') is-invalid @enderror" type="text" name="year" id="year">
                    @error('year')
                        <p class="text-danger">{{ $errors->first('year') }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="label" for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"></textarea>
                    @error('description')
                        <p class="text-danger">{{ $errors->first('description') }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="label" for="country">Country</label>
                    <input class="form-control @error('country') is-invalid @enderror" type="text" name="country" id="country">
                    @error('country')
                        <p class="text-danger">{{ $errors->first('country') }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="label" for="city">City</label>
                    <input class="form-control @error('city') is-invalid @enderror" type="text" name="city" id="city">
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
                    <input class="form-check-label" type="checkbox" name="enabled" id="enabled">
                </div>
                <button class="btn btn-primary" type="submit">Submit</button>
            </form>
        </div>
    </div>
@endsection