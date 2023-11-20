<div class="dropdown text-center">
    <button class="btn dropdown-toggle m-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
        style="box-shadow: none" aria-expanded="false">
        <i class="fas fa-ellipsis-v"></i>
    </button>
    <ul class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
        <li>
            <a href="{{ route('admin.recruitment.resume.pdf', $resume->id) }}" class="dropdown-item"><span
                    class="badge badge-warning d-block text-warning"><i
                        class="far fa-edit p-1"></i>{{ trans('labels.view_cv') }}</span></a>
        </li>
    </ul>
</div>

