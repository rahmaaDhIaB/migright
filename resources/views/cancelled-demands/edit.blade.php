@extends('layout.app')
@section('title')
    {{__('update_cancellation_reason')}}
@endsection
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title text-wrap">{{__('update_cancellation_reason')}}</h3>
            </div>
            <div class="card-body">
                <div class="row overflow-auto">
                    <form method="POST" action="{{ route('cancellation-reasons.update',$cancellationReason->id) }}"  enctype="multipart/form-data"
                    >
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>  {{__("Name")}} </label>
                                <input class="form-control" name="name" type="text" value="{{$cancellationReason->name ?? old('name')}}"/>
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




