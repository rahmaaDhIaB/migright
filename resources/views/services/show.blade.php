@extends('layout.app')
@section('title')
    {{__('service_details')}}
@endsection
@section('content')
    <div class="container">

        <div class="col-md-8 col-xl-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{__('service_details')}}</h5>
                </div>
                <div class="card-body h-300">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>
                                {{__("name")}}
                                : {{$service->name}}
                            </h6>
                            <h6>
                                {{__("description")}}
                                : {{$service->description}}
                            </h6>
                            <h6>
                                {{__("address")}}
                                : {{$service->address}}
                            </h6>
                            <h6>
                                {{__("category")}}
                                : {{$service->category->name}}
                            </h6>
                            <h6>
                                {{__("region")}}
                                : {{$service->region->name}}
                            </h6>
                            <h6>
                                {{__("contact")}}
                                : {{$service->contact}}
                            </h6>
                            <h6>
                                {{__("location")}}
                                : <a href="{{$service->location_url}}" target="_blank"><i class="fa-solid fa-location-dot"></i></a>
                            </h6>
                            <h6>
                                {{__("image")}} :
                            </h6>
                            <div class="col-md-6">
                                @if($service->image)
                                    <img src="{{ asset('storage/uploads/images/'.$service->image) }}" alt="{{ $service->name }}" class="img-fluid">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
