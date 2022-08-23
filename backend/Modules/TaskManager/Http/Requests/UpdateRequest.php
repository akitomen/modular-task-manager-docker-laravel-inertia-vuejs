<?php


namespace Modules\TaskManager\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [ 'start_date' => ['required', 'date_format:Y-m-d'] ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [ 'start_date' => 'Start Date' ];
    }
}
