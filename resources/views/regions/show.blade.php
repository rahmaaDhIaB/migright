@extends('layout.app')
@section('title')
    {{__('region_details')}}
@endsection
@section('content')
    <div class="container">

        <div class="col-md-8 col-xl-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{__('region_details')}}</h5>
                </div>
                <div class="card-body h-300">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>
                                {{__("name")}}
                                : {{$region->name}}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
