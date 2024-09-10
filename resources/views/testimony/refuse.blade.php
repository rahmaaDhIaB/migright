@extends('layout.app')
@section('title')
    {{ __('list_of_testimony', [], app()->getLocale()) }}
@endsection
@section('content')

    <div class="card card-index">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">{{ __('list_of_testimony') }}</h3>

                <div>
                    <a href="{{ route('testimony.index') }}" class="btn btn-secondary">
                        {{ __('Back to accepted testimony') }}
                    </a>
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
