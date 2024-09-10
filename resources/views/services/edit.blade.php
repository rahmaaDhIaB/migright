@extends('layout.app')
@section('title')
    {{__('update_service')}}
@endsection
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title text-wrap">{{__('update_service')}}</h3>
            </div>
            <div class="card-body">
                <div class="row overflow-auto">
                    <form method="POST" action="{{ route('services.update',$service->id) }}"  enctype="multipart/form-data"
                    >
                        @csrf
                        @method('POST')
                        <div class="row mb-3">
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>  {{__("name")}} </label>
                                <input class="form-control" name="name" type="text" value="{{$service->name ?? old('name')}}"/>
                            </div>
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>  {{__("Description")}} </label>
                                <input class="form-control" name="description" type="text"
                                       value="{{$service->description ?? old('description')}}"/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>{{__("address")}}</label>
                                <input class="form-control" name="address" type="text" value="{{$service->address ?? old('address')}}"/>
                            </div>
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>{{__("category")}}</label>
                                <select class="form-control" name="category_id">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{ $category->id == $service?->category_id ? 'selected' : '' }}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>{{__("region")}}</label>
                                <select class="form-control" name="region_id">
                                    @foreach($regions as $region)
                                        <option value="{{$region->id}}" {{ $region->id == $service?->region_id ? 'selected' : '' }}>{{$region->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>{{__("contact")}}</label>
                                <input class="form-control" name="contact" type="text" value="{{$service->contact}}"/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>{{__("image")}}</label>
                                <input type="file" name="image" class="form-control"/>
                            </div>
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>{{__("location")}}</label>
                                <input class="form-control" name="location_url" type="text" placeholder="{{__('enter_location_url')}}" value="{{$service->location_url}}"/>
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




