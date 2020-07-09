<?php

namespace polares552\ActivityLogger\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityLoggerModel extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'userType',
        'userId',
        'route',
        'ipAddress',
        'userAgent',
        'locale',
        'referer',
        'methodType',
    ];

    /**
     * Create a new instance to set the table and connection.
     *
     * @return void
     */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('activity-logger.table.name');
        $this->connection = config('activity-logger.activityLoggerDatabaseConnection');
    }

    /**
     * Get the database connection.
     */
    public function getConnectionName()
    {
        return $this->connection;
    }

    /**
     * Get the database connection.
     */
    public function getTableName()
    {
        return $this->table;
    }

    /**
     * An activity has a user.
     *
     * @var array
     */
    public function user()
    {
        return $this->hasOne(config('activity-logger.defaultUserModel'));
    }

    /**
     * Get a validator for an incoming Request.
     *
     * @param array $merge (rules to optionally merge)
     *
     * @return array
     */
    public static function rules($merge = [])
    {
        return array_merge(
            [
                'description'   => 'required|string',
                'userType'      => 'required|string',
                'userId'        => 'nullable|integer',
                'route'         => 'nullable|url',
                'ipAddress'     => 'nullable|ip',
                'userAgent'     => 'nullable|string',
                'locale'        => 'nullable|string',
                'referer'       => 'nullable|string',
                'methodType'    => 'nullable|string',
            ],
            $merge
        );
    }

    /**
     * User Agent Parsing Helper.
     *
     * @return string
     */
    public function getUserAgentDetailsAttribute()
    {
        return \polares552\ActivityLogger\App\Http\Traits\UserAgentDetails::details($this->userAgent);
    }

}
