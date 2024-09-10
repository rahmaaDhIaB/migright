{{--<div class="d-flex justify-content-center">--}}
{{--    <a href="javascript:;" class="nav-link p-0 text-body" id="dropdownMenuButton"--}}
{{--       data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--        <i class="fa fa-ellipsis-h text-secondary"></i>--}}
{{--    </a>--}}
{{--    <ul class="dropdown-menu  dropdown-menu-end  px- py-3 me-sm-n4  border" aria-labelledby="dropdownMenuButton">--}}
{{--        <li class="mb-2">--}}
{{--            <a class="dropdown-item border-radius-md" href="{{route('news.show',$id)}}">--}}
{{--                <span class="text-sm">{{__('show')}}</span>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="mb-2">--}}
{{--            <a class="dropdown-item border-radius-md"  href="{{route('news.edit',$id)}}">--}}
{{--                <span class="text-sm">{{__('edit')}}</span>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="mb-2 cursor-pointer">--}}
{{--            <a type="button" class="dropdown-item border-radius-md text-danger" data-bs-toggle="modal"--}}
{{--               data-bs-target="#exampleModal-{{$id}}">--}}
{{--                {{__('delete')}}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--</div>--}}

{{--<div class="modal fade" id="exampleModal-{{$id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"--}}
{{--     aria-hidden="true">--}}
{{--    <div class="modal-dialog modal-dialog-centered" role="document">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h5 class="modal-title text-wrap" id="exampleModalLabel">{{__('delete_user_modal')}}</h5>--}}
{{--                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">--}}
{{--                    <span aria-hidden="true">&times;</span>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            <div class="modal-footer">--}}
{{--                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">{{__('close')}}</button>--}}
{{--                <form--}}
{{--                    method="post" action="{{route('news.destroy',$id)}}"--}}
{{--                >--}}
{{--                    @method('delete')--}}
{{--                    @csrf--}}
{{--                    <button type="submit" class="btn bg-gradient-primary">{{__('confirm')}}</button>--}}
{{--                </form>--}}

{{--            </div>--}}




{{--            <a href="{{ route('news.archive', $news) }}"--}}
{{--               class="btn btn-warning"--}}
{{--               onclick="event.preventDefault(); document.getElementById('archive-form-{{ $news->id }}').submit();">--}}
{{--                Archive--}}
{{--            </a>--}}

{{--            <form id="archive-form-{{ $news->id }}" action="{{ route('news.archive', $news) }}" method="POST" style="display: none;">--}}
{{--                @csrf--}}
{{--                @method('PATCH')--}}
{{--            </form>--}}

{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}



<div class="d-flex justify-content-center">
    <a href="javascript:;" class="nav-link p-0 text-body" id="dropdownMenuButton"
       data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-ellipsis-h text-secondary"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end px- py-3 me-sm-n4 border" aria-labelledby="dropdownMenuButton">
        <li class="mb-2">
            <a class="dropdown-item border-radius-md" href="{{ route('categories.show', $id) }}">
                <span class="text-sm">{{ __('show') }}</span>
            </a>
        </li>
        <li class="mb-2">
            <a class="dropdown-item border-radius-md" href="{{ route('categories.edit', $id) }}">
                <span class="text-sm">{{ __('edit') }}</span>
            </a>
        </li>
        <li class="mb-2">
            <a class="dropdown-item border-radius-md text-danger" data-bs-toggle="modal"
               data-bs-target="#exampleModal-{{ $id }}">
                {{ __('delete') }}
            </a>
        </li>

    </ul>
</div>
<div class="modal fade" id="exampleModal-{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-wrap" id="exampleModalLabel">{{ __('delete_user_modal') }}</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">{{ __('close') }}</button>
                <form method="post" action="{{ route('categories.destroy', $id) }}">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn bg-gradient-primary">{{ __('confirm') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
