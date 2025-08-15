<?php

namespace App\Http\Requests\Intake;

use Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Lang;

use App\Models\Intake;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		$access_name = 'intake_create';
        abort_if(Gate::denies($access_name), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return true;
    }

    public function rules()
    {
		return [
            'case_type' => ['required'],
            'status' => ['required'],
            'assignee' => ['required'],
            'marketing_source' => ['required']
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }
}
