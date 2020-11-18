<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * Class Job
 * @package App\Models
 *
 * @property integer id
 * @property string url
 * @property string status
 * @property integer http_code
 * @property string|Carbon created_at
 * @property string|Carbon updated_at
 * @property string|Carbon deleted_at
 */
class Job extends BaseModel
{
    const NEW_STATUS = 'NEW';
    const PROCESSING_STATUS = 'PROCESSING';
    const DONE_STATUS = 'DONE';
    const ERROR_STATUS = 'ERROR';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'url',
        'status',
        'http_code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'url' => 'string',
        'status' => 'string',
        'http_code' => 'integer'
    ];
}
