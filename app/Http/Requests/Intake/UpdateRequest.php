<?php

namespace App\Http\Requests\Intake;

use Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Lang;

use App\Models\Intake;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		$access_name = 'intake_edit';
        abort_if(Gate::denies($access_name), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		return [
            'case_type' => ['required'],
            'status' => ['required'],
            'assignee' => ['required'],
            'marketing_source' => ['required']
        ];
    }
}
