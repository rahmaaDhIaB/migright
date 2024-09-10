{{--@extends('layout.app')--}}
{{--@section('title')--}}
{{--    {{__('assign_to_user')}}--}}
{{--@endsection--}}
{{--@section('content')--}}

{{--    <div class="card">--}}
{{--        <div class="card-header">--}}
{{--            <div class="d-flex justify-content-between">--}}
{{--                <h3 class="card-title text-wrap">{{__('assign_to_user')}}</h3>--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
{{--                <div class="row overflow-auto">--}}
{{--                    <form method="POST" action="{{ route('assistance.assignAssistanceDemandToUser.store',$id) }}"--}}
{{--                    >--}}
{{--                        @csrf--}}
{{--                        @method('POST')--}}
{{--                        <div class="row mb-3">--}}
{{--                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">--}}
{{--                                <label>{{ __("Choose a partner") }}</label>--}}
{{--                                <select class="form-control" name="partner">--}}
{{--                                   @foreach($partners as $partner)--}}
{{--                                       <option value="{{$partner->id}}" {{$partner->id == $assistanceDemand->demand->user_id ? 'selected' : ''}}>{{$partner->email}} </option>--}}
{{--                                   @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                        <div class="button-row d-flex mt-4">--}}
{{--                            <button class="btn btn-success ms-auto mb-0" id="form-submit-btn" type="submit"--}}
{{--                                    title="Enregistrer">{{__("save")}}</button>--}}
{{--                        </div>--}}
{{--                    </form>--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--@endsection--}}




@extends('layout.app')

@section('title')
    {{ __('assign_to_user') }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title text-wrap">{{ __('assign_to_user') }}</h3>
            </div>
            <div class="card-body">
                <div class="row overflow-auto">
                    <form method="POST" action="{{ route('assistance.assignAssistanceDemandToUser.store', $id) }}">
                        @csrf
                        @method('POST')
                        <div class="row mb-3">
                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                                <label>{{ __("Choose a partner") }}</label>
                                <select class="form-control" name="partner">
                                    @foreach($partners as $partner)
                                        <option value="{{ $partner->id }}" {{ $partner->id == $assistanceDemand->demand->user_id ? 'selected' : '' }}>
                                            {{ $partner->email }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="button-row d-flex mt-4">
                            <button class="btn btn-success ms-auto mb-0" id="form-submit-btn" type="submit" title="Enregistrer">
                                {{ __("save") }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
