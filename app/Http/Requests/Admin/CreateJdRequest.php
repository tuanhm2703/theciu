<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateJdRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        if (!isset(request()->general_requirement['salary']['negotiable'])) {
            return [
                'name' => 'required',
                'group' => 'required',
                'from_date' => 'required',
                'to_date' => 'required',
                'short_description' => 'required',
                'job_type' => 'required',
                'general_requirement.level' => 'required',
                'general_requirement.experience' => 'required',
                'general_requirement.work_from.from_day' => 'required',
                'general_requirement.work_from.to_day' => 'required',
                'general_requirement.work_from.from_hour' => 'required',
                'general_requirement.work_from.to_hour' => 'required',
                'general_requirement.gender' => 'required',
                'general_requirement.required_skills' => 'required',
                'description' => 'required',
                'requirement' => 'required',
                'benefit' => 'required',
                'position' => 'required',
                'quantity' => 'required|numeric'
            ];
        }
        return [
            'name' => 'required',
            'group' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'short_description' => 'required',
            'job_type' => 'required',
            'general_requirement.level' => 'required',
            'general_requirement.experience' => 'required',
            'general_requirement.salary.min' => 'required|numeric',
            'general_requirement.salary.max' => 'required|numeric',
            'general_requirement.work_from.from_day' => 'required',
            'general_requirement.work_from.to_day' => 'required',
            'general_requirement.work_from.from_hour' => 'required',
            'general_requirement.work_from.to_hour' => 'required',
            'general_requirement.gender' => 'required',
            'general_requirement.required_skills' => 'required',
            'description' => 'required',
            'requirement' => 'required',
            'benefit' => 'required',
            'position' => 'required',
            'quantity' => 'required|numeric'
        ];
    }

    public function attributes() {
        return [
            'general_requirement.level' => 'cấp bậc',
            'general_requirement.experience' => 'kinh nghiêmk',
            'general_requirement.salary.min' => 'mức lương thấp nhất',
            'general_requirement.salary.max' => 'mức lương cao nhất',
            'general_requirement.work_from.from_day' => 'từ ngày',
            'general_requirement.work_from.to_day' => 'đến ngày',
            'general_requirement.work_from.from_hour' => 'khung giờ',
            'general_requirement.work_from.to_hour' => 'khung giờ',
            'general_requirement.gender' => 'giới tính',
            'general_requirement.required_skills' => 'kĩ năng cần có',
            'short_description' => 'mô tả ngắn',
            'requirement' => 'yêu cầu công việc',
            'benefit' => 'phúc lợi',
            'from_date' => 'ngày bắt đầu',
            'to_date' => 'ngày kết thúc',
            'position' => 'vị trí tuyển dụng',
            'quantity' => 'số lượng tuyển dụng'
        ];
    }
}
