@extends('layout.app')

@section('title')
    {{ __('update_news') }}
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title text-wrap">{{ __('update_news') }}</h3>
            </div>
            <div class="card-body">
                <div class="row overflow-auto">
                    <form method="POST" action="{{ route('news.update', $news->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row mb-3">
                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                                <label>{{ __("title_fr") }}</label>
                                <input class="form-control" name="title_fr" type="text" value="{{ $news->title_fr ?? old('title_fr') }}" />
                            </div>
                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                                <div class="form-group">
                                    <label>{{ __("description_fr") }}</label>
                                    <div id="descriptionFr" class="descriptionFr"></div>
                                    <input name="description_fr" id="descriptionFrInput" type="hidden" value="{{ $news->description_fr ?? old('description_fr') }}" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                                <label>{{ __("title_en") }}</label>
                                <input class="form-control" name="title_en" type="text" value="{{ $news->title_en ?? old('title_en') }}" />
                            </div>
                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                                <div class="form-group">
                                    <label>{{ __("description_en") }}</label>
                                    <div id="descriptionEn" class="descriptionEn"></div>
                                    <input name="description_en" id="descriptionEnInput" type="hidden" value="{{ $news->description_en }}" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                                <label>{{ __("title_ar") }}</label>
                                <input class="form-control" name="title_ar" type="text" value="{{ $news->title_ar ?? old('title_ar') }}" />
                            </div>
                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                                <div class="form-group">
                                    <label>{{ __("description_ar") }}</label>
                                    <div id="descriptionAr" class="descriptionAr"></div>
                                    <input name="description_ar" id="descriptionArInput" type="hidden" value="{{ $news->description_ar }}" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                                <label>{{ __("Picture") }}</label>
                                <input class="form-control" name="image" type="file" />
                            </div>
                        </div>
                        <div class="button-row d-flex mt-4">
                            <button class="btn btn-success ms-auto mb-0" id="form-submit-btn" type="submit" title="Enregistrer">{{ __("save") }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @endsection

        @push('js')
            <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
            <script type="module">
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

                descriptionFr.root.innerHTML = @json($news->description_fr);
                descriptionEn.root.innerHTML = @json($news->description_en);
                descriptionAr.root.innerHTML = @json($news->description_ar);
            </script>
    @endpush
