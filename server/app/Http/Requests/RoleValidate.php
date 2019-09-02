<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleValidate extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->input('id');
        $rules = [
           'name'  => ['required', 'max:255'],
           'input_pmts'  => ['required'],
       ];

       //there are edit mode to ignore  itself’s name
       $name_unique = Rule::unique('roles');
       if( $id>0 ){
           $name_unique = $name_unique->ignore($id);
       }
       $rules['name'][] = $name_unique;
        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => '分组名称',
            'input_pmts' => '分组权限',
        ];
    }
    /**
     * 自定义错误消息
     *
     * @return void
     */
    public function messages()
    {
        return [
            'name.unique' => '分组名称不能重复',
        ];
    }

}
