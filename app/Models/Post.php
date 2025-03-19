<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Post",
 *     type="object",
 *     required={"guid", "title", "link", "description", "pub_date"},
 *     @OA\Property(property="id", type="integer", description="ID of the post"),
 *     @OA\Property(property="guid", type="string", description="Unique identifier for the post"),
 *     @OA\Property(property="title", type="string", description="Title of the post"),
 *     @OA\Property(property="link", type="string", description="URL of the post"),
 *     @OA\Property(property="description", type="string", description="Short description of the post"),
 *     @OA\Property(property="pub_date", type="string", format="date-time", description="Publication date of the post"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Date and time when the post was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Date and time when the post was last updated"),
 * )
 */
class Post extends Model
{
    protected $fillable = [
        'guid',
        'title',
        'link',
        'description',
        'pub_date',
    ];

    protected $dates = ['pub_date'];
}
