@extends('layout.app')
@section('title')
    {{__('list_of_users' ,[], app()->getLocale())}}
@endsection
@section('content')

    <div class="card card-index">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">{{__('list_of_users')}}</h3>
                <a
                    href="{{route('admins.create')}}"
                    class="btn btn-primary">
                    <i class="bi bi-plus cg-icon"></i> </a>
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
