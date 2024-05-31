<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePublishsApiRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ];
    }

    /**
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Название обязательно к заполнению.',
            'image.required' => 'Изображение обязательно к загрузке.',
            'image.image' => 'Файл должен быть изображением.',
            'image.mimes' => 'Изображение должно быть формата jpeg, png, jpg или svg.',
            'image.max' => 'Изображение не должно превышать размер в 2 МБ.'
        ];
    }
}
