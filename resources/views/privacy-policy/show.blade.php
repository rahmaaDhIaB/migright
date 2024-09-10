@extends('layout.app')

@section('title', 'Privacy Policy Details')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Privacy Policy</h2>
            </div>
            <div class="card-body">
                <div class="privacy-content">
                    <h4>French</h4>
                    <div class="row">
                        {!! $privacyPolicy->description_fr !!}
                    </div>
                    <h4>English</h4>
                    <div class="row">
                        {!! $privacyPolicy->description_en !!}
                    </div>
                    <h4>Arabic</h4>
                    <div class="row">
                        {!! $privacyPolicy->description_ar !!}
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('privacy-policy.edit', $privacyPolicy->id) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('privacy-policy.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
@endsection

{{--@push('js')--}}
{{--    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>--}}
{{--    <script>--}}
{{--        var descriptionFrDisplay = new Quill('#descriptionFrDisplay', { readOnly: true, theme: 'bubble' });--}}
{{--        var descriptionEnDisplay = new Quill('#descriptionEnDisplay', { readOnly: true, theme: 'bubble' });--}}
{{--        var descriptionArDisplay = new Quill('#descriptionArDisplay', { readOnly: true, theme: 'bubble' });--}}

{{--        var descriptionFrDelta = {!! $privacyPolicy->description_fr !!};--}}
{{--        var descriptionEnDelta = {!! $privacyPolicy->description_en !!};--}}
{{--        var descriptionArDelta = {!! $privacyPolicy->description_ar !!};--}}

{{--        descriptionFrDisplay.setContents(descriptionFrDelta);--}}
{{--        descriptionEnDisplay.setContents(descriptionEnDelta);--}}
{{--        descriptionArDisplay.setContents(descriptionArDelta);--}}
{{--    </script>--}}
{{--@endpush--}}
