
<div class="d-flex justify-content-center">
    <a href="javascript:;" class="nav-link p-0 text-body" id="dropdownMenuButton"
       data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-ellipsis-h text-secondary"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end px- py-3 me-sm-n4 border" aria-labelledby="dropdownMenuButton">
        <li class="mb-2">
            <a class="dropdown-item border-radius-md" href="{{ route('cancelled-demands.show', $id) }}">
                <span class="text-sm">{{ __('show') }}</span>
            </a>
        </li>
    </ul>
</div>
