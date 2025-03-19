<?php

namespace App\Rules;

class PostValidationRules
{
    /**
     * Validation rules for creating a new post.
     *
     * @return array
     */
    public static function storeRules(): array
    {
        return [
            'guid' => 'required|string|unique:posts,guid',
            'title' => 'required|string',
            'link' => 'required|url',
            'description' => 'required|string',
            'pub_date' => 'required|date',
        ];
    }

    /**
     * Validation rules for listing posts.
     *
     * @return array
     */
    public static function listRules(): array
    {
        return [
            'search' => 'nullable|string',
            'sort_by' => 'nullable|string',
            'sort_order' => 'nullable|string',
            'per_page' => 'required|numeric',
            'page' => 'nullable|numeric',
        ];
    }
}
