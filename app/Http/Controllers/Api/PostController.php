<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\PostRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * @class PostController
 * @package App\Http\Controllers
 */
class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Get list of posts with filtering, sorting, and pagination",
     *     tags={"Posts"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search posts by title, description, link",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="Sort posts by a specific field (id, title, pub_date, etc.)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"id", "title", "link", "pub_date", "created_at", "updated_at"})
     *     ),
     *     @OA\Parameter(
     *         name="sort_order",
     *         in="query",
     *         description="Sort order (asc or desc)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"asc", "desc"})
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of posts",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Post")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     *
     * @param PostRequest $request
     * @param PostRepository $postRepository
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(
        PostRequest $request,
        PostRepository $postRepository
    ): AnonymousResourceCollection|JsonResponse {
        try {
            $validated = $request->validated();
            $posts = $postRepository->getPosts($validated);

            return PostResource::collection($posts);
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), ['exception' => $exception]);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/posts",
     *     summary="Create a new post",
     *     tags={"Posts"},
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              required={"guid", "title", "link", "description", "pub_date"},
     *              @OA\Property(property="guid", type="string", description="Unique identifier for the post"),
     *              @OA\Property(property="title", type="string", description="Title of the post"),
     *              @OA\Property(property="link", type="string", description="URL of the post"),
     *              @OA\Property(property="description", type="string", description="Short description of the post"),
     *              @OA\Property(property="pub_date", type="string", format="date-time", description="Publication date of the post")
     *          )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     *
     * @param PostRequest $request
     * @param PostRepository $postRepository
     * @return PostResource|JsonResponse
     */
    public function store(PostRequest $request, PostRepository $postRepository): PostResource|JsonResponse
    {
        try {
            $validated = $request->validated();
            $post = $postRepository->createPost($validated);

            return new PostResource($post);
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), ['exception' => $exception]);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Get a specific post by ID",
     *     tags={"Posts"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the post to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post found",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     *
     * @param Post $post
     * @return PostResource|JsonResponse
     */
    public function show(Post $post): PostResource|JsonResponse
    {
        try {
            return new PostResource($post);
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), ['exception' => $exception]);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/posts/{id}",
     *     summary="Update a specific post",
     *     tags={"Posts"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the post to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              required={"guid", "title", "link", "description", "pub_date"},
     *              @OA\Property(property="guid", type="string", description="Unique identifier for the post"),
     *              @OA\Property(property="title", type="string", description="Title of the post"),
     *              @OA\Property(property="link", type="string", description="URL of the post"),
     *              @OA\Property(property="description", type="string", description="Short description of the post"),
     *              @OA\Property(property="pub_date", type="string", format="date-time", description="Publication date of the post")
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     *
     * @param Post $post
     * @param PostRequest $request
     * @param PostRepository $postRepository
     * @return PostResource|JsonResponse
     */
    public function update(Post $post, PostRequest $request, PostRepository $postRepository): PostResource|JsonResponse
    {
        try {
            $validated = $request->validated();
            $postRepository->updatePost($post, $validated);

            return new PostResource($post);
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), ['exception' => $exception]);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     summary="Delete a specific post",
     *     tags={"Posts"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the post to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Post deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     *
     * @param Post $post
     * @param PostRepository $postRepository
     * @return JsonResponse
     */
    public function destroy(Post $post, PostRepository $postRepository): JsonResponse
    {
        try {
            $postRepository->deletePost($post);

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), ['exception' => $exception]);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
