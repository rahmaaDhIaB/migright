{{--@extends('layout.app')--}}
{{--@section('title')--}}
{{--    {{__('news_details')}}--}}
{{--@endsection--}}
{{--@section('content')--}}
{{--    <div class="container">--}}

{{--        <div class="col-md-8 col-xl-9">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h5 class="card-title mb-0">{{__('news_details')}}</h5>--}}
{{--                </div>--}}
{{--                <div class="card-body h-300">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-6">--}}
{{--                            <h6>--}}
{{--                                {{__("title_fr")}}--}}
{{--                                : {{$news->title_fr}}--}}
{{--                            </h6>--}}
{{--                            <h6>{{__('description_fr')}}     </h6>--}}
{{--                            <h6> {!!$news->description_fr!!} </h6>--}}

{{--                            <h6>--}}
{{--                                {{__("title_en")}}--}}
{{--                                : {{$news->title_en}}--}}
{{--                            </h6>--}}
{{--                            <h6>--}}
{{--                                {{__('description_en')}} : {{$news->description_en}}--}}
{{--                            </h6>--}}
{{--                            <h6>--}}
{{--                                {{__("title_ar")}}--}}
{{--                                : {{$news->title_ar}}--}}
{{--                            </h6>--}}
{{--                            <h6>--}}
{{--                                {{__('description_ar')}} : {{$news->description_ar}}--}}
{{--                            </h6>--}}
{{--                            <h6>--}}
{{--                                {{__('date_of_publication')}} : {{$news->created_at}}--}}
{{--                            </h6>--}}
{{--                            <div class="col-md-6">--}}
{{--                                @if($news->image)--}}
{{--                                    <img src="{{ asset('storage/uploads/images/'.$news->image) }}" alt="{{ $news->title }}" class="img-fluid">--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}

{{--@endsection--}}


{{--rahma --}}
@extends('layout.app')
@section('title')
    {{__('news_details')}}
@endsection
@section('content')
    <div class="container">

        <div class="col-md-8 col-xl-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{__('news_details')}}</h5>
                </div>
                <div class="card-body h-300">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>
                                {{__("title_fr")}}
                                : {!! $news->title_fr !!}
                            </h6>
                            <h6>{{__('description_fr')}}     </h6>
                            <h6> {!! $news->description_fr !!} </h6>

                            <h6>
                                {{__("title_en")}}
                                : {!! $news->title_en !!}
                            </h6>
                            <h6>
                                {{__('description_en')}} : {!! $news->description_en !!}
                            </h6>
                            <h6>
                                {{__("title_ar")}}
                                : {!! $news->title_ar !!}
                            </h6>
                            <h6>
                                {{__('description_ar')}} : {!! $news->description_ar !!}
                            </h6>
                            <h6>
                                {{__('date_of_publication')}} : {!!$news->created_at!!}
                            </h6>
                            <div class="col-md-6">
                                @if($news->image)
                                    <img src="{{ asset('storage/uploads/images/'.$news->image) }}" alt="{{ $news->title }}" class="img-fluid">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

