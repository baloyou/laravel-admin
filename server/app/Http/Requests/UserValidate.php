<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserValidate extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data = $this->validationData();

        $rules = [
            'name'  => ['required', 'max:255'],
            'login_name'  => ['required', 'max:255'],
            // 'password'  => ['required', 'max:255'], （只有新增情况才验证密码字段）
            'email'  => ['required', 'max:255'],
            'phone'  => ['required', 'max:255'],
            'input_roles'  => ['required'],
        ];
        
        //there are edit mode to ignore  itself’s name
        $login_name     = Rule::unique('users');
        $email          = Rule::unique('users');
        $phone          = Rule::unique('users');

        if( $data['id']>0 ){
            $login_name = $login_name->ignore($data['id']);
            $email      = $email->ignore($data['id']);
            $phone      = $phone->ignore($data['id']);
        }else{
            //只有新增数据时，密码表单为必填
            $rules['password'] = ['required', 'max:60'];
        }
        $rules['login_name'][]  = $login_name;
        $rules['email'][]       = $email;
        $rules['phone'][]       = $phone;
        return $rules;
    }

    /**
     * 自定义表单字段名
     *
     * @return void
     */
    public function attributes()
    {
        return [
            'name' => '昵称',
            'login_name' => '登陆名',
            'input_roles' => '分组',
        ];
    }

    // 在验证之前的回调函数
    // public function withValidator($validator)
    // {
    //     $validator->after(function ($validator) {
    //         $rules = $this->rules();
    //         dump($this->validationData(),$rules,$validator);exit;
    //     });
    // }
}
