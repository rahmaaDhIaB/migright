@extends('layout.app')
@section('title')
    {{__('create_user')}}
@endsection
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title text-wrap">{{__('create_user')}}</h3>
            </div>
            <div class="card-body">
                <div class="row overflow-auto">
                    <form method="POST" action="{{ route('admins.store') }}"
                    >
                        @csrf
                        @method('POST')
                        <div class="row mb-3">
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>  {{__("email")}} </label>
                                <input class="form-control" name="email" type="email" value="{{old('email')}}"/>
                            </div>
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>  {{__("password")}} </label>
                                <input class="form-control" name="password" type="password">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>  {{__("name")}} </label>
                                <input class="form-control" name="name" type="text" value="{{old('name')}}"/>
                            </div>
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>{{ __("User Role") }}</label>
                                <select class="form-control" name="role">
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>{{ __("Admin") }}</option>
                                    <option value="partner" {{ old('role') == 'partner' ? 'selected' : '' }}>{{ __("Partner") }}</option>
                                </select>
                            </div>

                        </div>

                        <div class="button-row d-flex mt-4">
                            <button class="btn btn-success ms-auto mb-0" id="form-submit-btn" type="submit"
                                    title="Enregistrer">{{__("save")}}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

@endsection




