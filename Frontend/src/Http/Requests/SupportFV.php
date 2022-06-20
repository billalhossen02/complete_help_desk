<?php

namespace Cinebaz\SupportTicket\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupportFV extends FormRequest
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
        $data = [];
        if(!$this->message){
            $data['attachment'] = 'required';
        }else{
            $data['message'] = 'required';
        }
        
        

        return $data;
    }
}
