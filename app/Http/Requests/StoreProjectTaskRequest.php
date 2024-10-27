<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class StoreProjectTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $project = $this->route('project');
        return $this->user()->can('create', [\App\Models\ProjectTask::class, $project]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after_or_equal:today',
            'priority' => 'required|in:low,medium,high',
            'label_id' => 'nullable|exists:labels,id',
            'notes' => 'nullable|string',
            'reminder' => 'nullable|boolean',
            'attachments' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'user_id' => 'nullable|exists:users,id',
        ];
    }
}
