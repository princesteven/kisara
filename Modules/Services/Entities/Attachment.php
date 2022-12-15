<?php

namespace Modules\Services\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'documents';

    protected $hidden = ['pivot'];

    protected $fillable = [
        'documentable_id',
        'documentable_type',
        'document_id',
        'user_id',
    ];

    /**
     * Inverse  relationship of attachments
     *
     * @return MorphTo
     */
    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }

}
