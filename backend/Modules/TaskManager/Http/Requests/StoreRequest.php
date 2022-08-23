<?php


namespace Modules\TaskManager\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Modules\TaskManager\Restrictions\Shortcuts;

class StoreRequest extends FormRequest
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
        return [
            'title' => ['required', 'string'],
            'description' => ['string', 'nullable'],
            'start_date' => ['required', 'date_format:Y-m-d', 'after:yesterday'],
            'time' => ['required', 'string'],
            'end_date' =>  ['nullable','date_format:Y-m-d', 'after:start_date'],
            'repeat_type' =>  [
                'nullable', 'required_with:end_date', 'string',
                'in:'.collect(Shortcuts::getRepeatTypes())->keys()->implode(',')
            ],
            'repeat_period' => [
                'nullable', 'required_with:repeat_type', 'array',
                $this->repeat_type
                    ? 'in:'.collect(Shortcuts::getRepeatsProperties()[$this->repeat_type])->pluck('value')->implode(',')
                    : ''
            ]
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'title' => 'Title',
            'description' => 'Description',
            'time' => 'Time',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'repeat_type' => 'Repeat Type',
            'repeat_period' => 'Repeat Period',
        ];
    }
}
