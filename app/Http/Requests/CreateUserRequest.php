<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            // 'FIELD名' => 'ルール',
            'USER_ID' => 'required|regex:/^[a-zA-Z0-9]+$/|min:5|unique:users,USER_ID', // 英文と数字だけ可、 最小5字
            'name' => 'required|min:2|max:5', // 最大5字
            'KAISYA_CODE' => 'required|max:20', // 最大 20字
            'SOSHIKI_CODE' => 'required|max:20', // 最大 20字
        ];
    }

     //エラー発生時のメッセージ
     public function messages(){

        return [
        // USER_ID
        'USER_ID.required' => '社員IDは必須項目です。入力してください。',
        'USER_ID.min' =>'社員IDはmin:文字以内にしてください。',
        'USER_ID.regex' => '入力された社員ＩＤの形式は正しくありません。',
        'USER_ID.unique' => '入力されたIDは既に存在します。',
        // name
        'name.required' => 'この氏名の形式は正しくありません。',
        'name.min' => '氏名は:min文字以上で入力してください。',
        'name.max' => '氏名は:max文字以内で入力してください。',
        // KAISYA_CODE
        'KAISYA_CODE.required' => 'この会社名の形式は正しくありません。',
        'KAISYA_CODE.max' => '会社名は:max文字以内で入力してください。',
        // SOSHIKI_CODE
        'SOHSIKI_CODE.required' => 'この組織名の形式は正しくありません。',
        'SOSHIKI_CODE.max' => '組織名は:max文字以内で入力してください。',

        ];
    }
}
