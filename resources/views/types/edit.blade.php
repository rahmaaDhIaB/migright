@extends('layout.app')
@section('title')
    {{ __('edit_type') }}
@endsection
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title text-wrap">{{ __('edit_type') }}</h3>
            </div>
            <div class="card-body">
                <div class="row overflow-auto">
                    <form method="POST" action="{{ route('types.update', $type->id) }}">
                        @csrf
                        @method('POST')
                        <div class="row mb-3">
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>{{ __("type_fr") }}</label>
                                <input class="form-control" name="type_fr" type="text" value="{{$type->type_fr ?? old('type_fr') }}" required/>
                            </div>
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>{{ __("type_en") }}</label>
                                <input class="form-control" name="type_en" type="text" value="{{$type->type_en ?? old('type_en') }}" required/>
                            </div>
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>{{ __("type_ar") }}</label>
                                <input class="form-control" name="type_ar" type="text" value="{{$type->type_ar ?? old('type_ar') }}" required/>
                            </div>
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>{{ __("Category") }}</label>
                                <select class="form-control" name="category" required>
                                    <option value="assistance" {{ $type->category == 'assistance' ? 'selected' : '' }}>
                                        {{ __('Assistance') }}
                                    </option>
                                    <option value="testimony" {{ $type->category == 'testimony' ? 'selected' : '' }}>
                                        {{ __('Testimony') }}
                                    </option>
                                    <option value="lost-person" {{ $type->category == 'lost-person' ? 'selected' : '' }}>
                                        {{ __('Lost Person') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="button-row d-flex mt-4">
                            <button class="btn btn-success ms-auto mb-0" id="form-submit-btn" type="submit"
                                    title="{{ __('Save') }}">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- jQuery UI for drag-and-drop functionality -->
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $(document).ready(function() {
                // Example of initializing a drag-and-drop list, if needed.
                $("#category-select").sortable({
                    items: "option:not(:first)",
                    placeholder: "ui-state-highlight"
                }).disableSelection();
            });
        </script>
    @endpush

@endsection
