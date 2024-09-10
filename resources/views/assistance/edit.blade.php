@extends('layout.app')
@section('title', __('edit_assistance_demand'))
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title text-wrap">{{ __('edit_assistance_demand') }}</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row overflow-auto">
                <form method="POST" action="{{ route('assistance.update', $assistance->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row mb-3">
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('Region') }}</label>
                            <select class="form-control" name="region">
                                @foreach($regions as $region)
                                    <option value="{{$region->id}}" {{ $region->id == $assistance?->region ? 'selected' : '' }}>{{$region->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('First Name') }}</label>
                            <input class="form-control" name="first_name" type="text" value="{{ old('first_name', $assistance->demand->first_name) }}" />
                        </div>
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('Last Name') }}</label>
                            <input class="form-control" name="last_name" type="text" value="{{ old('last_name', $assistance->demand->last_name) }}"  />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('Email') }}</label>
                            <input class="form-control" name="email" type="email" value="{{ old('email', $assistance->demand->email) }}" />
                        </div>
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('Phone Number') }}</label>
                            <input class="form-control" name="phone_number" type="text" value="{{ old('phone_number', $assistance->demand->phone_number) }}"  />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('File') }}</label>
                            <input class="form-control" name="file" type="file" />
                            @if ($assistance->demand->file)
                                <p>{{ __('Current File') }}: <a href="{{ asset('storage/' . $assistance->demand->file) }}">{{ $assistance->demand->file }}</a></p>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                            <label>{{ __('description') }}</label>
                            <textarea class="form-control" name="description" type="text" value="{{$assistance->demand->description ?? old('description') }}"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 mt-3">
                            <label>{{ __('Request Submitter') }}</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="requestSubmitter[]" value="concernedPerson" id="concernedPerson" {{ old('requestSubmitter') && in_array('concernedPerson', old('requestSubmitter')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="concernedPerson">{{ __('Concerned Person') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="requestSubmitter[]" value="otherPerson" id="otherPerson" {{ old('requestSubmitter') && in_array('otherPerson', old('requestSubmitter')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="otherPerson">{{ __('Other Person') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="button-row d-flex mt-4">
                        <button class="btn btn-primary ms-auto mb-0" id="form-submit-btn" type="submit" title="{{ __('Update') }}">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
