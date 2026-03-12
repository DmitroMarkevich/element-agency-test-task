<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    protected function prepareForValidation(): void
    {
        if ($this->screenshots && is_string($this->screenshots)) {
            $this->merge([
                'screenshots' => json_decode($this->screenshots, true) ?? [],
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'active' => ['nullable', 'boolean'],
            'title_uk' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],

            'description_uk' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],

            'release_year' => ['nullable', 'integer', 'min:1888', 'max:2100'],
            'youtube_trailer_id' => ['nullable', 'string', 'max:255'],
            'poster' => ['nullable', 'string', 'max:2048'],

            'screenshots' => ['nullable', 'array'],
            'screenshots.*' => ['nullable', 'string', 'max:2048'],

            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', 'exists:tags,id'],

            'view_start_at' => ['nullable', 'date'],
            'view_end_at' => ['nullable', 'date', 'after_or_equal:view_start_at'],
        ];
    }
}
