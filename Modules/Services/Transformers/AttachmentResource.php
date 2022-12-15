<?php

namespace Modules\Services\Transformers;

use App\Services\MongoDB\DocumentService;
use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'document_id' => $this->document_id,
            'file' => optional((new DocumentService())->retrieve($this->document_id))->file
        ];
    }
}
