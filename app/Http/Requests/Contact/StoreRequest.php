<?php

namespace App\Http\Requests\Contact;

use Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Lang;

use App\Models\Contact;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		$access_name = 'contact_create';
        abort_if(Gate::denies($access_name), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return true;
    }

    public function rules()
    {
		return [
            'contact_nature' => ['required'],
            'contact_type' => ['required'],
            'contact_first_name' => ['required'],
            'contact_last_name' => ['required'],
            'contact_phone' => ['required'],
            'contact_email' => ['required']
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }
}
