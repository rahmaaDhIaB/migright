@extends('layout.app')

@section('title')
    {{ __('edit_political_page', [], app()->getLocale()) }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 id="page-title" class="card-title">{{ __('edit_political_page') }}</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('privacy-policy.update', $privacyPolicy->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>{{ __('description_fr') }}</label>
                    <div id="descriptionFr" class="descriptionFr"></div>
                    <input name="description_fr" id="descriptionFrInput" type="hidden" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>{{ __('description_en') }}</label>
                    <div id="descriptionEn" class="descriptionEn"></div>
                    <input name="description_en" id="descriptionEnInput" type="hidden" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>{{ __('description_ar') }}</label>
                    <div id="descriptionAr" class="descriptionAr"></div>
                    <input name="description_ar" id="descriptionArInput" type="hidden" class="form-control"/>
                </div>
                <button type="submit" class="btn btn-success">{{ __('save') }}</button>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        var descriptionFr = new Quill('#descriptionFr', { theme: 'snow' });
        var descriptionEn = new Quill('#descriptionEn', { theme: 'snow' });
        var descriptionAr = new Quill('#descriptionAr', { theme: 'snow' });

        function updateHiddenInput(quill, inputId) {
            var html = quill.root.innerHTML;
            var input = document.getElementById(inputId);
            input.value = html;
        }

        descriptionFr.on('text-change', function () {
            updateHiddenInput(descriptionFr, 'descriptionFrInput');
        });

        descriptionEn.on('text-change', function () {
            updateHiddenInput(descriptionEn, 'descriptionEnInput');
        });

        descriptionAr.on('text-change', function () {
            updateHiddenInput(descriptionAr, 'descriptionArInput');
        });

        // Use clipboard.dangerouslyPasteHTML if the content is in HTML format
        descriptionFr.root.innerHTML = @json($privacyPolicy->description_fr);
        descriptionEn.root.innerHTML = @json($privacyPolicy->description_en);
        descriptionAr.root.innerHTML = @json($privacyPolicy->description_ar);
    </script>
@endpush
