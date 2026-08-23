<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ProcessPhotosRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'files' => ['required', 'array', 'max:10'],
            'files.*' => ['image', 'max:10240'], // 10MB

            'source' => ['nullable', 'string', 'in:batch,optimizer,converter,thumbnails'],
            'includeOriginal' => ['nullable', 'boolean'],

            'format' => ['nullable', 'string', 'in:original,jpeg,png,webp'],

            'originalFileName' => ['boolean'],

            'compression' => ['boolean'],

            'resolution.width' => ['nullable', 'integer', 'min:1'],
            'resolution.height' => ['nullable', 'integer', 'min:1'],

            'thumbnails' => ['nullable', 'array', 'max:5'],
            'thumbnails.*.width' => ['nullable', 'integer', 'min:1'],
            'thumbnails.*.height' => ['nullable', 'integer', 'min:1'],

            'watermark.enabled' => ['boolean'],
            'watermark.type' => ['in:text,image'],
            'watermark.text' => ['nullable', 'string', 'max:255'],
            'watermark.opacity' => ['integer', 'between:0,100'],

            'watermark.image' => ['nullable', 'image', 'max:5120'],
            'watermark.x' => ['nullable', 'numeric'],
            'watermark.y' => ['nullable', 'numeric'],
            'watermark.scale' => ['nullable', 'numeric'],
        ];
    }

    /**
     * Дополнительная проверка размеров миниатюр.
     *
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [function (Validator $validator): void {
            $thumbnails = $this->input('thumbnails', []);

            if ($this->input('source') === 'thumbnails' && empty($thumbnails)) {
                $validator->errors()->add('thumbnails', 'Добавьте хотя бы один размер миниатюры.');
            }

            foreach ($thumbnails as $index => $thumbnail) {
                if (empty($thumbnail['width']) && empty($thumbnail['height'])) {
                    $validator->errors()->add(
                        "thumbnails.$index.width",
                        'Укажите ширину или высоту миниатюры.',
                    );
                }
            }
        }];
    }
}
