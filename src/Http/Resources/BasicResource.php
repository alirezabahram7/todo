<?php

namespace Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

/**
 * @OA\Schema(
 *     title="ProjectResource",
 *     description="Project resource",
 *     @OA\Xml(
 *         name="ProjectResource"
 *     )
 * )
 */
class BasicResource extends JsonResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )u
     *
     * @var \User
     */
    protected $data;
    protected $message;
    protected $error_message;
    protected $errors;
    protected $count;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->data = $this['data'] ?? new stdClass();
        $this->count = $this['count'] ?? null;
        $this->message = $this['message'] ?? null;
        $this->error_message = $this['error_message'] ?? null;
        $this->errors = $this['errors'] ?? null;
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->data,
            'message' => $this->message,
            'error' => [
                'message' => $this->error_message,
                'errors' => $this->errors,
            ],
        ];
    }
}
