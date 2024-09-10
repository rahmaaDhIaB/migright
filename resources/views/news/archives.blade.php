@extends('layout.app')

@section('title', __('List of Archived News'))

@section('content')
    <div class="card card-index">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">{{ __('List of Archived News') }}</h3>
                <div>
                    <a href="{{ route('news.index') }}" class="btn btn-secondary">
                        {{ __('Back to News') }}
                    </a>
                </div>
            </div>
        </div>


            <div class="card-body">
                <div class="row">
                    <div class="table-responsive">
                                            {!! $dataTable->table(['class' => 'table table-striped table-bordered']) !!}

{{--                        @include('datatable.datatable')--}}
                    </div>
                </div>

        </div>
    </div>
@endsection

@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
