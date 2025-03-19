<?php

namespace App\Http\Requests;

use App\Rules\PostValidationRules;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @class PostRequest
 * @package App\Http\Requests
 * @property integer $id
 * @property string $title
 * @property string $link
 * @property string $description
 * @property string $pub_date
 * @property string $search
 * @property string $sort_by
 * @property string $sort_order
 * @property integer $per_page
 * @property integer $page
 */
class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return match ($this->route()->getName()) {
            'posts.store', 'posts.update' => PostValidationRules::storeRules(),
            'posts.index' => PostValidationRules::listRules(),
            default => [],
        };
    }
}
