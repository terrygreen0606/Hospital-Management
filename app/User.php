<?php

namespace App;

use App\Models\Account;
use App\Services\AccountableInterface;
use App\Services\AccountableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;
use QCod\ImageUp\HasImageUploads;
use App\Prescriber;

class User extends Authenticatable implements AccountableInterface
{
    use Notifiable;
    use HasApiTokens;
    use HasImageUploads;
    use Billable;
    use AccountableTrait;

    protected $accountType = Account::AC_USER;

    protected static $imageFields = [
        'avatar' => [
            'width'       => 300,
            'height'      => 300,
            'crop'        => true,
            'disk'        => 'public',
            'path'        => 'avatars',
            'placeholder' => 'https://api.adorable.io/avatars/285/',
            'rules'       => 'image|max:2000',
        ],
    ];

    // override cover file name
    protected function coverUploadFilePath($file)
    {
        return asset("storage/{$file->getClientOriginalName()}");
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'avatar', 'email', 'phone', 'role', 'lang', 'dob', 'otp','uuid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'otp', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at'        => 'datetime:m/d/Y',
        'dob'               => 'string',
        'email_verified_at' => 'datetime',
        'meta'              => 'array',
    ];

    public function getPaymentCountAttribute()
    {
        return array(
            "success" => [
                'completed', Payment::where('user_id', $this->id)->where('status', 'completed')->count()
            ],
            "info"    => [
                'processing', Payment::where('user_id', $this->id)->where('status', 'processing')->count()
            ],
            "light"   => [
                'pending', Payment::where('user_id', $this->id)->where('status', 'pending')->count()
            ],
            "warning" => [
                'cancelled', Payment::where('user_id', $this->id)->where('status', 'cancelled')->count()
            ],
            "danger"  => [
                'failed', Payment::where('user_id', $this->id)->where('status', 'failed')->count()
            ],
        );
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function routeNotificationForTwilio()
    {
        return (substr($this->phone, 0, 1) == "0")
            ? "+" . preg_replace("/^0/", "254", $this->phone)
            : "+1{$this->phone}";
    }

    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array|string
     */
    public function routeNotificationForMail($notification)
    {
        // Return name and email address...
        return [$this->email => $this->name];
    }

    public function requests()
    {
        return $this->hasMany(LoginRequest::class, 'user_id', 'id');
    }

    public function generateAUserToken()
    {
        return md5(uniqid($this->id, true));
    }

    public function findForPassport($username)
    {
        $customUsername = 'phone';
        return $this->where($customUsername, $username)->first();
    }

    public function validateForPassportPasswordGrant($password)
    {
        return Hash::check($password, $this->password);
    }

    public function getAccountName()
    {
        return $this->phone;
    }

    public function getAccountId()
    {
        return $this->id;
    }

    public function getAccountType()
    {
        return $this->accountType;
    }
    
    public function prescriber()
    {
        return $this->hasOne(Prescriber::class);
    }
}
