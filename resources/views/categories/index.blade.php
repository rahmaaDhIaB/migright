@extends('layout.app')
@section('title')
    {{ __('list_of_categories', [], app()->getLocale()) }}
@endsection
@section('content')
    <div class="card card-index">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">{{ __('list_of_categories') }}</h3>
                <div>
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus cg-icon"></i>
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
