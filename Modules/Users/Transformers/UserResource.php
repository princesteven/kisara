<?php

namespace Modules\Users\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Services\Transformers\AttachmentResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'user_id' => $this->user_id,
            'username' => $this->username,
            'image' => new AttachmentResource($this->latestImage),
            'is_active' => $this->is_active,
            'should_update_password' => $this->should_update_password,
            'created_at' => $this->created_at,
            'roles' => RoleResource::collection($this->roles()->get()),
        ];
    }
}
