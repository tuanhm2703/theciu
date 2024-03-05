<div class="card mx-3">
    <div class="card-header pb-0">
        <h6 class="text-uppercase">Thông tin chung</h6>
    </div>
    <div class="card-body pt-0">
        <div class="row">
            <div class="col-md-6">
                {!! Form::label('name', trans('labels.name') . ': ', ['class' => 'custom-control-label']) !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào']) !!}
                @error('name')
                    <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-3">
                {!! Form::label('position', 'Vị trí tuyển dụng: ', ['class' => 'custom-control-label']) !!}
                {!! Form::select('position', [
                    'Chuyên viên kinh doanh' => 'Chuyên viên kinh doanh',
                    'Tư vấn bán hàng' => 'Tư vấn bán hàng',
                    'Nhân viên marketing' => 'Nhân viên marketing',
                    'Trưởng phòng nhân sự' => 'Trưởng phòng nhân sự'
                ], isset($jd) ? [$jd->position] : null, ['class' => 'form-control select2-taggable']) !!}
                @error('group')
                    <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-3">
                {!! Form::label('group', trans('labels.department_group') . ': ', ['class' => 'custom-control-label']) !!}
                {!! Form::select('group', $groups, isset($jd) ? [$jd->group] : null, ['class' => 'form-control']) !!}
                @error('group')
                    <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                {!! Form::label('from_date', trans('labels.from_date') . ': ', ['class' => 'custom-control-label']) !!}
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon2"><i class="ni ni-calendar-grid-58"></i></span>
                    {!! Form::text('from_date', null, [
                        'class' => 'form-control datetimepicker',
                        'placeholder' => 'Nhập vào',
                    ]) !!}
                </div>
                @error('from_date')
                    <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-6">
                {!! Form::label('to_date', trans('labels.to_date') . ': ', ['class' => 'custom-control-label']) !!}
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon2"><i class="ni ni-calendar-grid-58"></i></span>
                    {!! Form::text('to_date', null, [
                        'class' => 'form-control datetimepicker',
                        'placeholder' => 'Nhập vào',
                    ]) !!}
                </div>
                @error('to_date')
                    <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                {!! Form::label('short_description', trans('labels.short_description') . ': ', [
                    'class' => 'custom-control-label',
                ]) !!}
                {!! Form::textarea('short_description', null, [
                    'class' => 'form-control summernote',
                    'placeholder' => 'Nhập vào',
                    'rows' => '5',
                ]) !!}
                @error('short_description')
                    <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>
<div class="card mx-3 mt-3">
    <div class="card-header pb-0">
        <h6 class="text-uppercase">Yêu cầu chung</h6>
    </div>
    <div class="card-body pt-0">
        <div class="row">
            <div class="col-md-6">
                {!! Form::label('job_type', trans('labels.job_type') . ': ', ['class' => 'custom-control-label']) !!}
                {!! Form::select('job_type', $job_types, isset($jd) ? [$jd->job_type] : null, ['class' => 'form-control']) !!}
                @error('job_type')
                    <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-6">
                {!! Form::label('general_requirement[level]', 'Cấp bậc: ', ['class' => 'custom-control-label']) !!}
                {!! Form::select(
                    'general_requirement[level]',
                    [
                        'Nhân viên' => 'Nhân viên',
                        'Trưởng nhóm' => 'Trưởng nhóm',
                        'Quản lý/Giám sát' => 'Quản lý/Giám sát',
                        'Trưởng chi nhánh' => 'Trưởng chi nhánh',
                        'Phó giám đốc' => 'Phó giám đốc',
                        'Giám đốc' => 'Giám đốc',
                        'Thực tập sinh' => 'Thực tập sinh',
                    ],
                    isset($jd->general_requirement['level']) ? [$jd->general_requirement['level']] : null,
                    ['class' => 'form-control select2-taggable'],
                ) !!}
                @error('general_requirement[level]')
                    <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                {!! Form::label('general_requirement[experience]', 'Kinh nghiệm: ', ['class' => 'custom-control-label']) !!}
                {!! Form::select(
                    'general_requirement[experience]',
                    [
                        'Chưa có kinh nghiệm' => 'Chưa có kinh nghiệm',
                        'Dưới 1 năm kinh nghiệm' => 'Dưới 1 năm kinh nghiệm',
                        '2 năm kinh nghiệm' => '2 năm kinh nghiệm',
                        '3 năm kinh nghiệm' => '3 năm kinh nghiệm',
                        '4 năm kinh nghiệm' => '4 năm kinh nghiệm',
                        '5 năm kinh nghiệm' => '5 năm kinh nghiệm',
                        'Trên 5 năm kinh nghiệm' => 'Trên 5 năm kinh nghiệm',
                    ],
                    isset($jd->general_requirement['experience']) ? [$jd->general_requirement['experience']] : null,
                    ['class' => 'form-control select2'],
                ) !!}
                @error('general_requirement[experience]')
                    <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between">
                    {!! Form::label('featured', 'Mức lương: ', ['class' => 'custom-control-label']) !!}
                    <div class="form-check">
                        {!! Form::checkbox('general_requirement[salary][negotiable]', true, false, [
                            'class' => 'form-check-input',
                            'id' => 'salaryNegotiable',
                        ]) !!}
                        <label class="custom-control-label" for="customCheckDisabled">Thoả thuận</label>
                    </div>
                </div>
                <div class="row" id="salary-wrapper">
                    <div class="col-md-6">
                        {!! Form::number('general_requirement[salary][min]', null, [
                            'class' => 'form-control',
                            'placeholder' => 'Thấp nhất',
                        ]) !!}
                        @error('general_requirement.salary.min')
                            <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        {!! Form::number('general_requirement[salary][max]', null, [
                            'class' => 'form-control',
                            'placeholder' => 'Cao nhất',
                        ]) !!}
                        @error('general_requirement.salary.max')
                            <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    {!! Form::label('general_requirement[work_from]', 'Thời gian làm việc:', ['class' => 'custom-control-label']) !!}
                    <div class="col-md-4">
                        {!! Form::select(
                            'general_requirement[work_from][from_day]',
                            [
                                'Thứ 2' => 'Thứ 2',
                                'Thứ 3' => 'Thứ 3',
                                'Thứ 4' => 'Thứ 4',
                                'Thứ 5' => 'Thứ 5',
                                'Thứ 6' => 'Thứ 6',
                                'Thứ 7' => 'Thứ 7',
                                'Chủ nhật' => 'Chủ nhật',
                            ],
                            isset($jd->general_requirement['work_from']['from_day']) ? $jd->general_requirement['work_from']['from_day'] : null,
                            ['class' => 'select2'],
                        ) !!}
                        @error('general_requirement[work_from][from_day]')
                            <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        {!! Form::select(
                            'general_requirement[work_from][to_day]',
                            [
                                'Thứ 2' => 'Thứ 2',
                                'Thứ 3' => 'Thứ 3',
                                'Thứ 4' => 'Thứ 4',
                                'Thứ 5' => 'Thứ 5',
                                'Thứ 6' => 'Thứ 6',
                                'Thứ 7' => 'Thứ 7',
                                'Chủ nhật' => 'Chủ nhật',
                            ],
                            isset($jd->general_requirement['work_from']['to_day']) ? $jd->general_requirement['work_from']['to_day'] : null,
                            ['class' => 'select2'],
                        ) !!}
                        @error('general_requirement.work_from.to_day')
                            <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        {{-- <i class="far fa-clock"></i> --}}
                        {!! Form::text('general_requirement[work_from][from_hour]', null, [
                            'class' => 'form-control hourPicker',
                            'placeholder' => '08:00',
                        ]) !!}
                        @error('general_requirement.work_from.from_hour')
                            <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        {!! Form::text('general_requirement[work_from][to_hour]', null, [
                            'class' => 'form-control hourPicker',
                            'placeholder' => '17:00',
                        ]) !!}
                        @error('general_requirement.work_from.to_hour')
                            <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                {!! Form::label('general_requirement[gender]', 'Giới tính:', ['class' => 'custom-control-label']) !!}
                {!! Form::select(
                    'general_requirement[gender]',
                    [
                        'Nam' => 'Nam',
                        'Nữ' => 'Nữ',
                        'Không yêu cầu' => 'Không yêu cầu',
                    ],
                    isset($jd->general_requirement->gender) ? [$jd->general_requirement->gender] : [],
                    ['class' => 'select2'],
                ) !!}
                @error('general_requirement.gender')
                    <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! Form::label('general_requirement[required_skills]', 'Kĩ năng cần có:', ['class' => 'custom-control-label']) !!}
                {!! Form::select(
                    'general_requirement[required_skills]',
                    [
                        'Photoshop' => 'Photoshop',
                        'Microsoft Word' => 'Microsoft Word',
                        'Microsoft Excel' => 'Microsoft Excel',
                    ],
                    isset($jd->general_requirement['required_skills']) ? $jd->general_requirement['required_skills'] : [],
                    ['class' => 'select2-taggable', 'multiple'],
                ) !!}
                @error('general_requirement.required_skills')
                    <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-6">
                {!! Form::label('general_requirement[optional_skills]', 'Kĩ năng nên có:', ['class' => 'custom-control-label']) !!}
                {!! Form::select(
                    'general_requirement[optional_skills]',
                    [
                        'Photoshop' => 'Photoshop',
                        'Microsoft Word' => 'Microsoft Word',
                        'Microsoft Excel' => 'Microsoft Excel',
                    ],
                    isset($jd->general_requirement['optional_skills']) ? $jd->general_requirement['optional_skills'] : [],
                    ['class' => 'select2-taggable', 'multiple'],
                ) !!}
                @error('general_requirement.optional_skills')
                    <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>
<div class="card mx-3 mt-3">
    <div class="card-header pb-0">
        <h6 class="text-uppercase">Thông tin chi tiết</h6>
    </div>
    <div class="card-body pt-0">
        <div class="row mt-3">
            <div class="col-md-12">
                {!! Form::label('description', trans('labels.description') . ': ', ['class' => 'custom-control-label']) !!}
                {!! Form::textarea('description', null, [
                    'class' => 'form-control summernote',
                    'placeholder' => 'Nhập vào',
                    'rows' => '5',
                ]) !!}
                @error('description')
                    <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                {!! Form::label('requirement', trans('labels.job_requirement') . ': ', ['class' => 'custom-control-label']) !!}
                {!! Form::textarea('requirement', null, [
                    'class' => 'form-control summernote',
                    'placeholder' => 'Nhập vào',
                    'rows' => '5',
                ]) !!}
                @error('requirement')
                    <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                {!! Form::label('benefit', trans('labels.benefit') . ': ', ['class' => 'custom-control-label']) !!}
                {!! Form::textarea('benefit', null, [
                    'class' => 'form-control summernote',
                    'placeholder' => 'Nhập vào',
                    'rows' => '5',
                ]) !!}
                @error('benefit')
                    <p class="text-danger text-xs pt-1"> {{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                {!! Form::label('featured', trans('labels.hot_job') . ': ', ['class' => 'custom-control-label']) !!}
                <div class="form-check form-switch">
                    {!! Form::checkbox('featured', null, null, ['class' => 'form-check-input']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $(document).ready(function() {
            $('select[name=group]').select2({
                tags: true
            })
            $('select[name=job_type]').select2({
                tags: true
            })
            $('#salaryNegotiable').change(e => {
                $('#salary-wrapper input').attr('disabled', $(e.target).is(':checked'))
            })
        })
    </script>
@endpush
