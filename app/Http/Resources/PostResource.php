<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

/**
 * @class PostResource
 * @package App\Http\Resources
 * @property integer $id
 * @property string $guid
 * @property string $title
 * @property string $link
 * @property string $description
 * @property Carbon $pub_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @OA\Schema (
 *     schema="PostResource",
 *     title="Post",
 *     description="Post resource",
 *     @OA\Property (
 *         property="id",
 *         type="integer",
 *         description="Post ID"
 *     ),
 *     @OA\Property (
 *         property="title",
 *         type="string",
 *         description="Post title"
 *     ),
 *     @OA\Property (
 *         property="link",
 *         type="string",
 *         description="Link to the original article"
 *     ),
 *     @OA\Property (
 *         property="description",
 *         type="string",
 *         description="Short description of the post"
 *     ),
 *     @OA\Property (
 *         property="pub_date",
 *         type="string",
 *         format="date-time",
 *         description="Publication date of the post"
 *     ),
 *     @OA\Property (
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date when the post was created"
 *     ),
 *     @OA\Property (
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date when the post was last updated"
 *     )
 * )
 */
class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'guid' => $this->guid,
            'title' => $this->title,
            'link' => $this->link,
            'description' => $this->description,
            'pub_date' => $this->pub_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
