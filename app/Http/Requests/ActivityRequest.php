<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return match ($this->method()) {
            'GET' => $this->getRules(),
            'POST' => $this->postRules(),
            'PUT', 'PATCH' => $this->putPatchRules(),
            default => [],
        };
    }

    protected function getRules(): array
    {
        return [
            'type' => 'sometimes|string|in:task_created,comment_added',
            'actor' => 'sometimes|string|max:255',
            'from' => 'sometimes|date',
            'to' => 'sometimes|date|after_or_equal:from',
        ];
    }

    protected function postRules(): array
    {
        return [
            'type' => 'required|string|in:task_created,comment_added',
            'actor' => 'required|string|max:255',
            'target' => 'required|string|max:255',
            'timestamp' => 'required|date',
            'metadata' => 'nullable|array',
        ];
    }

    protected function putPatchRules(): array
    {
        return [
            'type' => 'sometimes|string|in:task_created,comment_added',
            'actor' => 'sometimes|string|max:255',
            'target' => 'sometimes|string|max:255',
            'timestamp' => 'sometimes|date',
            'metadata' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'نوع فعالیت الزامی است.',
            'type.in' => 'نوع فعالیت معتبر نیست.',
            'actor.required' => 'نام انجام‌دهنده الزامی است.',
            'target.required' => 'هدف فعالیت الزامی است.',
            'timestamp.required' => 'زمان فعالیت الزامی است.',
            'timestamp.date' => 'فرمت زمان معتبر نیست.',
            'metadata.array' => 'اطلاعات تکمیلی باید یک آرایه معتبر باشد.',
        ];
    }

    public function attributes(): array
    {
        return [
            'type' => 'نوع فعالیت',
            'actor' => 'انجام‌دهنده',
            'target' => 'هدف فعالیت',
            'timestamp' => 'زمان',
            'metadata' => 'اطلاعات تکمیلی',
            'from' => 'شروع بازه زمانی',
            'to' => 'پایان بازه زمانی',
        ];
    }
}
