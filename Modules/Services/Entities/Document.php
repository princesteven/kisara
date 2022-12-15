<?php

namespace Modules\Services\Entities;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mongodb';

    protected $collection = 'documents';

    protected $fillable = ['file'];
}
