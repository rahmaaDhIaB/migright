@extends('layout.app')
@section('title')
    {{ __('Create_Testimony_Demand') }}
@endsection
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title text-wrap">{{ __('Create_Testimony_Demand') }}</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row overflow-auto">
                <form method="POST" action="{{ route('testimony.store') }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="row mb-3">
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('Request Type') }}</label>
                            <select class="form-control" name="request_type" >
                                @foreach($types as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('File') }}</label>
                            <input class="form-control" name="file" type="file" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('First Name') }}</label>
                            <input class="form-control" name="first_name" type="text" value="{{ old('first_name') }}" />
                        </div>
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('Last Name') }}</label>
                            <input class="form-control" name="last_name" type="text" value="{{ old('last_name') }}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('Email') }}</label>
                            <input class="form-control" name="email" type="email" value="{{ old('email') }}" />
                        </div>
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('Phone Number') }}</label>
                            <input class="form-control" name="phone_number" type="text" value="{{ old('phone_number') }}" />
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                        <label>{{ __('Description') }}</label>
                        <textarea class="form-control" name="description" > </textarea>
                        <div class="row mb-3">
                            <div class="col-12 mt-3">
                                <label>{{ __('Type') }}</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="type[]" value="anonymous" id="anonymous" {{ old('type') && in_array('anonymous', old('type')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="anonymous">{{ __('Anonymous') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="type[]" value="identified" id="identified" {{ old('type') && in_array('identified', old('type')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="identified">{{ __('Identified') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="button-row d-flex mt-4">
                        <button class="btn btn-success ms-auto mb-0" id="form-submit-btn" type="submit" title="Enregistrer">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
