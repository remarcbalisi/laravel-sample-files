<?php

namespace App;

use App\Traits\UseUUID;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use Notifiable;
    use HasRoles;
    use UseUUID;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'address', 'phone_number',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function branches()
    {
        return $this->belongsToMany(Branch::class);
    }

    public function setPasswordAttribute($pass)
    {
        $this->attributes['password'] = Hash::make($pass);
    }

    public function favoriteBranches()
    {
        return $this->belongsToMany(
            Branch::class,
            'favorites',
            'user_id',
            'model_id'
        );
    }

    public function messages()
    {
        return $this->belongsToMany(
            Message::class,
            'message_recipients',
            'recipient_id',
            'message_id'
        );
    }

    public function message_recipients()
    {
        return $this->hasMany(MessageRecipient::class, 'recipient_id', 'id');
    }
}
