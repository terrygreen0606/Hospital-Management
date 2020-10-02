<?php


namespace App\Services;


use App\Models\Account;

trait AccountableTrait
{
    /**
     * ID column of the model that has account trait
     *
     * @var string
     */
    protected $id_column  = 'id';



    /**
     * Binds creating/saving events to create UUIDs (and also prevent them from being overwritten).
     *
     * @return void
     */
    public static function bootAccountableTrait()
    {
        static::created(function ($model) {
            if($model->role == 'patient') Account::getOrCreate($model);
        });
    }

    /**
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->{$this->id_column};
    }

    /**
     *
     */
    public function getAccountType()
    {
        return $this->account_type;
    }

    /**
     * Get the account
     *
     * @return HasOne
     */
    public function account()
    {
        return $this->hasOne(Account::class,'owner_id',$this->id_column)
            ->where('owner_type',$this->getAccountType());
    }

    /**
     * @return Account
     */
    public function getAccount()
    {
        return $this->account ? : new Account();
    }

}
