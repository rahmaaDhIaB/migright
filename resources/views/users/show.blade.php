@extends('layout.app')

@section('title')
    {{ __('User Details') }}
@endsection

@section('content')
    <div class="container">
        <div class="col-md-8 col-xl-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('User Details') }}</h5>
                </div>
                <div class="card-body h-300">
                    <div class="row">
                        <div class="col-md-6">

                            <h6>
                                {{ __('Name') }}: {{ $user->name }}
                            </h6>
                            <h6>
                                {{ __('Email') }}: {{ $user->email }}
                            </h6>
                            <h6>
                                {{ __('Role') }}: {{ $user->is_admin ? __('Admin') : __('Partner') }}
                            </h6>
                            <h6>
                                {{ __('Date of Registration') }}: {{ $user->created_at }}
                            </h6>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
