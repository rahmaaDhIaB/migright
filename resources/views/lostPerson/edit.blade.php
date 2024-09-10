@extends('layout.app')
@section('title', __('Edit_lostPerson_Demand'))
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title text-wrap">{{ __('Edit_lostPerson_Demand') }}</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row overflow-auto">
                <form method="POST" action="{{ route('lostPerson.update', $lostPerson->id) }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="row mb-3">
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('First Name') }}</label>
                            <input class="form-control" name="first_name" type="text" value="{{ old('first_name') }}"/>
                        </div>
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('Last Name') }}</label>
                            <input class="form-control" name="last_name" type="text" value="{{ old('last_name') }}"/>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('Region') }}</label>
                            <select name="region" class="form-control">
                                @foreach($regions as $region)
                                    <option
                                        value="{{$region->name}}" {{$lostPerson->region == $region->name ? 'selected' : ''}}>{{$region->name}}</option>
                                @endforeach
                            </select></div>
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('Date') }}</label>
                            <input class="form-control" name="date" type="date"
                                   value="{{ old('date', $lostPerson->date) }}"/>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('Notification Sender') }}</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="notification_sender[]"
                                       value="parent"
                                       id="parent" {{ (is_array(old('notification_sender', explode(',', $lostPerson->demand->notification_sender))) && in_array('parent', old('notification_sender', explode(',', $lostPerson->demand->notification_sender)))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="parent">{{ __('Parent') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="notification_sender[]"
                                       value="friend"
                                       id="friend" {{ (is_array(old('notification_sender', explode(',', $lostPerson->demand->notification_sender))) && in_array('friend', old('notification_sender', explode(',', $lostPerson->demand->notification_sender)))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="friend">{{ __('Friend') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="notification_sender[]"
                                       value="neighbor"
                                       id="neighbor" {{ (is_array(old('notification_sender', explode(',', $lostPerson->demand->notification_sender))) && in_array('neighbor', old('notification_sender', explode(',', $lostPerson->demand->notification_sender)))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="neighbor">{{ __('Neighbor') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="notification_sender[]"
                                       value="other"
                                       id="other" {{ (is_array(old('notification_sender', explode(',', $lostPerson->demand->notification_sender))) && in_array('other', old('notification_sender', explode(',', $lostPerson->demand->notification_sender)))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="other">{{ __('Other') }}</label>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('Missing Person Gender') }}</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="missing_person_gender[]"
                                       value="female"
                                       id="female" {{ (is_array(old('missing_person_gender', explode(',', $lostPerson->demand->missing_person_gender))) && in_array('female', old('missing_person_gender', explode(',', $lostPerson->demand->missing_person_gender)))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="female">{{ __('Female') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="missing_person_gender[]"
                                       value="male"
                                       id="male" {{ (is_array(old('missing_person_gender', explode(',', $lostPerson->demand->missing_person_gender))) && in_array('male', old('missing_person_gender', explode(',', $lostPerson->demand->missing_person_gender)))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="male">{{ __('Male') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('Missing Person Age') }}</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="missing_person_age[]"
                                       value="minor"
                                       id="minor" {{ (is_array(old('missing_person_age', explode(',', $lostPerson->demand->missing_person_age))) && in_array('minor', old('missing_person_age', explode(',', $lostPerson->demand->missing_person_age)))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="minor">{{ __('Minor') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="missing_person_age[]"
                                       value="adult"
                                       id="adult" {{ (is_array(old('missing_person_age', explode(',', $lostPerson->demand->missing_person_age))) && in_array('adult', old('missing_person_age', explode(',', $lostPerson->demand->missing_person_age)))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="adult">{{ __('Adult') }}</label>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('Nationality') }}</label>
                            <select name="nationality" class="form-control">
                                @foreach($nationalities as $nationality)
                                    <option
                                        value="{{$nationality}}" {{$nationality == $lostPerson->nationality ? 'selected' : ''}}>{{$nationality}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('Description') }}</label>
                            <textarea class="form-control"
                                      name="description">{{ old('description', $lostPerson->demand->description) }}</textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>{{ __('Group Type') }}</label><br>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group_type" value="single" id="single" {{ $lostPerson->group_type === 'single' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="single">{{ __('Single') }}</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group_type" value="group" id="group" {{ $lostPerson->group_type === 'group' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="group">{{ __('Group') }}</label>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>{{ __('location') }}</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="location" value="sea" id="sea" {{ old('location') == 'sea' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="single">{{ __('sea') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="location" value="land" id="land" {{ old('location') == 'land' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="group">{{ __('land') }}</label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0" id="number_of_missing_persons_container" style="{{ $lostPerson->group_type === 'group' ? '' : 'display: none;' }}">
                                <label>{{ __('Number of Missing Persons') }}</label>
                                <input class="form-control" name="number_of_missing_persons" type="number" value="{{ old('number_of_missing_persons', $lostPerson->number_of_missing_persons) }}"/>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>{{ __('File') }}</label>
                            <input class="form-control" name="file" type="file"/>
                            @if ($lostPerson->demand->file)
                                <p>{{ __('Current File') }}: <a
                                        href="{{ asset('storage/' . $lostPerson->demand->file) }}">{{ $lostPerson->demand->file }}</a>
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="button-row d-flex mt-4">
                        <button class="btn btn-primary ms-auto mb-0" id="form-submit-btn" type="submit"
                                title="{{ __('Update') }}">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const groupTypeRadios = document.querySelectorAll('input[name="group_type"]');
            const numberOfMissingPersonsContainer = document.getElementById('number_of_missing_persons_container');

            groupTypeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'group') {
                        numberOfMissingPersonsContainer.style.display = 'block';
                    } else {
                        numberOfMissingPersonsContainer.style.display = 'none';
                    }
                });
            });
        });
    </script>

@endsection
