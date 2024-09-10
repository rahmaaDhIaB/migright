{{--@extends('layout.app')--}}
{{--@section('title')--}}
{{--    {{ __('list_of_lostPerson', [], app()->getLocale()) }}--}}
{{--@endsection--}}
{{--@section('content')--}}

{{--    <div class="card card-index">--}}
{{--        <div class="card-header">--}}
{{--            <div class="d-flex justify-content-between">--}}
{{--                <h3 class="card-title">{{ __('list_of_lostPersons') }}</h3>--}}

{{--                @if(auth()->user()->is_admin)--}}


{{--                <div>--}}
{{--                    @if(request('status') === 'pending')--}}
{{--                        <a href="{{ route('lostPerson.index', ["status" => "refused"]) }}" class="btn btn-danger">--}}
{{--                            <i class="bi bi-x-circle cg-icon"></i> {{ __('not_treated') }}--}}
{{--                        </a>--}}
{{--                        <a href="{{ route('lostPerson.index', ["status" => "done"])}}" class="btn btn-secondary">--}}
{{--                            <i class="bi bi-arrow-left cg-icon"></i> {{ __('treated_listt') }}--}}
{{--                        </a>--}}

{{--                    @else--}}

{{--                        <a href="{{ route('lostPerson.index',  ["status" => "pending"] ) }}" class="btn btn-secondary">--}}
{{--                            <i class="bi bi-arrow-left cg-icon"></i> {{ __('Back_to_pending_list') }}--}}
{{--                        </a>--}}

{{--                    @endif--}}
{{--                    <a href="{{ route('lostPerson.create', ["status" => "pending"]) }}" class="btn btn-primary">--}}
{{--                        <i class="bi bi-plus cg-icon"></i>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="card-body">--}}
{{--            <div class="row">--}}
{{--                <div class="table-responsive">--}}
{{--                    @include('datatable.datatable')--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}

{{--@push('js')--}}
{{--    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}--}}
{{--@endpush--}}
@extends('layout.app')
@section('title')
    {{ __('list_of_lostPerson', [], app()->getLocale()) }}
@endsection
@section('content')

    <div class="card card-index">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">{{ __('list_of_lostPerson') }}</h3>
                @if(auth()->user()->is_admin)

                    <div>


                        @if(request('status') === 'pending')


                            <a href="{{ route('lostPerson.index') }}" class="btn btn-reddit">
                                <i class="bi bi-check-circle cg-icon"></i> {{ __('assigned To A partner') }}
                            </a>

                            <a href="{{ route('lostPerson.index', ["status" => "closed"]) }}" class="btn btn-dark">
                                <i class="bi bi-check-circle cg-icon"></i> {{ __('closed') }}
                            </a>


                        @else


                            <a href="{{ route('lostPerson.index' , ["status" => "pending"]) }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left cg-icon"></i> {{ __('Back') }}
                            </a>

                        @endif

                        <a href="{{ route('lostPerson.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus cg-icon"></i>
                        </a>
                        @else

                            <div>
                                <a href="{{ route('lostPerson.index', ["status" => "refused"]) }}" class="btn btn-danger">
                                    <i class="bi bi-x-circle cg-icon"></i> {{ __('refused') }}
                                </a>

                                <a href="{{ route('lostPerson.index', ["status" => "accepted"]) }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle cg-icon"></i> {{ __('accepted') }}
                                </a>

                            </div>



                        @endif

                    </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="table-responsive">
                    @include('datatable.datatable')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
