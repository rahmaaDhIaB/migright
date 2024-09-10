@extends('layout.app')
@section('title')
    {{__('Dashboard')}}
@endsection

@section('content')
    <div class="row my-8 h-100">
        <div class="col-lg-12 h-100">
            <div class="d-block justify-content-center align-items-center text-center h-100 my-5">
                <h1 class="display-1 text-bolder text-gradient text-danger fadeIn1 fadeInBottom mt-5">Bienvenue</h1>
                <h2 class="fadeIn3 fadeInBottom opacity-8">{{(config('app.name'))}} - {{__('Dashboard')}}</h2>
            </div>
        </div>
    </div>
@endsection
