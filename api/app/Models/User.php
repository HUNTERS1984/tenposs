<?php

namespace App\Models;
use Carbon\Carbon;
use Hash;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    const STATUS_TEMPORARY = 0;
    const STATUS_VALID = 1;
    const STATUS_INVALID = 9;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'fullname', 'status', 'temporary_hash', 'sex', 'birthday', 'locale', 'company', 'address', 'tel'
    ];
    protected $table = 'users';

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'email' => 'required|email'
        //...
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function contacts(){
        return $this->hasMany(Contact::class);

    }
    public static function createAsTemporary(array $data)
    {
        $data['temporary_hash'] = self::createTemporaryHash($data);
        $data['status'] = self::STATUS_TEMPORARY;

        return self::create($data);
    }
    public static function createTemporaryHash(array $data)
    {
        $hash = Hash::make(
            $data['name'] . $data['password'] . Carbon::now()->timestamp
        );

        return $hash;
    }

    /**
     * Find by temporary hash
     *
     * @var string $hash temporary_hash
     * @return User
     */
    public static function findByTemporaryHash($hash)
    {
        return self::where('temporary_hash', $hash)->first();
    }

    // Users has many apps
    public function apps(){
        return $this->hasMany(App::class);
    }


}
