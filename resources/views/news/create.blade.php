@extends('layout.app')
@section('title')
    {{__('create_news')}}
@endsection
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title text-wrap">{{__('create_news')}}</h3>
            </div>
            <div class="card-body">
                <div class="row overflow-auto">
                    <form method="POST" action="{{ route('news.store') }}" enctype="multipart/form-data"
                    >
                        @csrf
                        @method('POST')
                        <div class="row mb-3">
                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                                <label>  {{__("title_fr")}} </label>
                                <input class="form-control" name="title_fr" type="text" value="{{old('title_fr')}}"/>
                            </div>
                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                                <div class="form-group">
                                    <label>  {{__("description_fr")}} </label>
                                    <div id="descriptionFr" class="descriptionFr"></div>
                                    <input name="description_fr" id="descriptionFrInput" type="hidden"
                                           class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                                <label>  {{__("title_en")}} </label>
                                <input class="form-control" name="title_en" type="text" value="{{old('title_en')}}"/>
                            </div>
                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                                <div class="form-group">
                                    <label>  {{__("description_en")}} </label>
                                    <div id="descriptionEn" class="descriptionEn"></div>
                                    <input name="description_en" id="descriptionEnInput" type="hidden"
                                           class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                                <label>  {{__("title_ar")}} </label>
                                <input class="form-control" name="title_ar" type="text" value="{{old('title_ar')}}"/>
                            </div>
                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                                <div class="form-group">
                                    <label>  {{__("description_ar")}} </label>
                                    <div id="descriptionAr" class="descriptionAr"></div>
                                    <input name="description_ar" id="descriptionArInput" type="hidden"
                                           class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                                <label>{{__("Picture")}}</label>
                                <input class="form-control" name="image" type="file"/>
                            </div>
                        </div>

                        <div class="button-row d-flex mt-4">
                            <button class="btn btn-success ms-auto mb-0" id="form-submit-btn" type="submit"
                                    title="Enregistrer">{{__("save")}}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        @endsection
        @push('js')
            <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

            <script type="module">

                var descriptionFr = new Quill('#descriptionFr', {
                    theme: 'snow'
                });

                var descriptionEn = new Quill('#descriptionEn', {
                    theme: 'snow'
                });

                var descriptionAr = new Quill('#descriptionAr', {
                    theme: 'snow'
                });


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

                descriptionFr.setContents(JSON.parse(document.getElementById("descriptionFrInput").value));
                descriptionEn.setContents(JSON.parse(document.getElementById("descriptionEnInput").value));
                descriptionAr.setContents(JSON.parse(document.getElementById("descriptionArInput").value));

            </script>

    @endpush



{{--rahma's code with ckeditor--}}
{{--@extends('layout.app')--}}
{{--@section('title')--}}
{{--    {{__('create_news')}}--}}
{{--@endsection--}}
{{--@section('content')--}}

{{--    <div class="card">--}}
{{--        <div class="card-header">--}}
{{--            <div class="d-flex justify-content-between">--}}
{{--                <h3 class="card-title text-wrap">{{__('create_news')}}</h3>--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
{{--                <div class="row overflow-auto">--}}
{{--                    <form method="POST" action="{{ route('news.store') }}" enctype="multipart/form-data"--}}
{{--                    >--}}
{{--                        @csrf--}}
{{--                        @method('POST')--}}
{{--                        <div class="row mb-3">--}}
{{--                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">--}}
{{--                                <label>  {{__("title_fr")}} </label>--}}
{{--                                <input class="form-control" name="title_fr" type="text" value="{{old('title_fr')}}"/>--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>  {{__("description_fr")}} </label>--}}
{{--                                    <textarea name="description_fr" id="descriptionFrInput" class="form-control">{{ old('description_fr') }}</textarea>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row mb-3">--}}
{{--                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">--}}
{{--                                <label>  {{__("title_en")}} </label>--}}
{{--                                <input class="form-control" name="title_en" type="text" value="{{old('title_en')}}"/>--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>  {{__("description_en")}} </label>--}}
{{--                                    <textarea name="description_en" id="descriptionEnInput" class="form-control">{{ old('description_en') }}</textarea>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row mb-3">--}}
{{--                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">--}}
{{--                                <label>  {{__("title_ar")}} </label>--}}
{{--                                <input class="form-control" name="title_ar" type="text" value="{{old('title_ar')}}"/>--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>  {{__("description_ar")}} </label>--}}
{{--                                    <div id="descriptionAr" class="descriptionAr"></div>--}}
{{--                                    <input name="description_ar" id="descriptionArInput" type="hidden"--}}
{{--                                           class="form-control"/>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row mb-3">--}}
{{--                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">--}}
{{--                                <label>{{__("Picture")}}</label>--}}
{{--                                <input class="form-control" name="image" type="file"/>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="button-row d-flex mt-4">--}}
{{--                            <button class="btn btn-success ms-auto mb-0" id="form-submit-btn" type="submit"--}}
{{--                                    title="Enregistrer">{{__("save")}}</button>--}}
{{--                        </div>--}}
{{--                    </form>--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        @endsection--}}
{{--        @push('js')--}}
{{--            <script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>--}}

{{--            <script>--}}
{{--                ClassicEditor--}}
{{--                    .create(document.querySelector('#descriptionFrInput'))--}}
{{--                    .then(editor => {--}}
{{--                        // Optional: You can customize CKEditor here if needed.--}}
{{--                        console.log('CKEditor initialized.');--}}
{{--                    })--}}
{{--                    .catch(error => {--}}
{{--                        console.error(error);--}}
{{--                    });--}}

{{--            </script>--}}
{{--            <script>--}}

{{--                ClassicEditor--}}
{{--                    .create(document.querySelector('#descriptionArInput'))--}}
{{--                    .then(editor => {--}}
{{--                        // Optional: You can customize CKEditor here if needed.--}}
{{--                        console.log('CKEditor initialized.');--}}
{{--                    })--}}
{{--                    .catch(error => {--}}
{{--                        console.error(error);--}}
{{--                    });--}}

{{--            </script>--}}

{{--            <script>--}}

{{--                ClassicEditor--}}
{{--                    .create(document.querySelector('#descriptionEnInput'))--}}
{{--                    .then(editor => {--}}
{{--                        // Optional: You can customize CKEditor here if needed.--}}
{{--                        console.log('CKEditor initialized.');--}}
{{--                    })--}}
{{--                    .catch(error => {--}}
{{--                        console.error(error);--}}
{{--                    });--}}

{{--            </script>--}}

{{--    @endpush--}}



