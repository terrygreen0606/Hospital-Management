<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Account extends Model
{
    use SoftDeletes;

    const AC_SUSPENSE = 'SUSPENSE';
    const AC_USER = 'USER';
    const AC_APP = 'SYSTEM';
    const AC_GROUP = 'GROUP';
    const SYSTEM_ACCOUNT_NAME = "Transaction Fees Account";
    const GENERAL_SUSPENSE_ACCOUNT = "General Suspense Account";
    const TRANSACTION_ACCOUNT = "Transaction Account";

    protected $table = 'accounts';

    /**
     * Updated balance manually
     *
     * @var bool
     */
    public $update_balance = false;

    protected $fillable = [
        'owner_id', 'owner_type', 'name', 'main', 'sambaza', 'bonus', 'balance'
    ];

    public static $suspense_account_id = 1;

    /**
     * Create account from an AccountableInterface
     *
     * @param $accountable
     *
     * @return Account
     */
    public static function getOrCreate($accountable)
    {
        $ac = Account::whereOwnerId($accountable->getAccountId())
            ->whereOwnerType($accountable->getAccountType())->first();

        if (!$ac) {
            $ac = new Account([
                'owner_id' => $accountable->getAccountId(),
                'owner_type' => $accountable->getAccountType(),
                'name' => $accountable->getAccountName(),
            ]);

            $ac->save();

        }

        return $ac;
    }

    /**
     * Get withdrawal  suspense account
     *
     * @return Model|null|static
     */
    public static function get_withdrawal_suspense_account()
    {
        return self::query()->where([
            'name' => "Withdrawal Suspense Account",
            'owner_type' => 'Suspense'
        ])->first();
    }

    /**
     * Use the owner id and owner type to get account
     * @param $owner_id
     * @param $owner_type
     * @return Model|static
     */
    public static function getAccount($owner_id, $owner_type)
    {
        return Account::query()->where([ 'owner_id' => $owner_id,  'owner_type' => $owner_type])->firstOrFail();
    }

    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Get all ledger entries related to particular account
     */
    public function ledgers()
    {
        return $this->hasMany(Ledger::class, 'account_id', 'id');
    }

    /**
     * Make a credit transaction into an account
     * If transaction went through return true
     *
     * @param $owner_id
     * @param $owner_type
     * @param $account_type
     * @param $amount
     * @param $document_ref
     * @param $notes
     * @return void $result
     * @throws \Exception
     */
    public static function credit($owner_id, $owner_type, $account_type, $amount, $document_ref, $notes)
    {
        /* Get account and credit with the amount */

        $account = self::getAccount($owner_id, $owner_type);

        if ($account) {
            $account->{$account_type} += $amount;
            $account->update_balance();
            $account->save();

            /* Insert ledger entry */
            DB::table("ledgers")->insert([
                "txn_date" => Carbon::now()->format('YmdHis'),
                "account_id" => $account->id,
                "credit" => $amount,
                "debit" => 0,
                "balance" => $account->balance + $amount,
                "notes" => $notes,
                'ref' => $document_ref,
                'type' => $account_type,
                'created_at' => Carbon::now()
            ]);
        } else {
            Log::info("No account to debit found");
            throw  new \Exception("No account to debit has been found");
        }
    }

    /**
     * Make a debit transaction into an account
     * If transaction went through return true
     *
     * @param $owner_id
     * @param $owner_type
     * @param $account_type
     * @param $amount
     * @param $document_ref
     * @param $notes
     * @return void $result
     * @throws \Exception
     */
    public static function debit($owner_id, $owner_type, $account_type, $amount, $document_ref, $notes)
    {


        /* Get account and credit with the amount */
        $account = self::getAccount($owner_id, $owner_type);
        if ($account) {
            $account->{$account_type} -= $amount;
            $account->update_balance();
            $account->save();


            /* Insert ledger entry */
            DB::table("ledgers")->insert([
                "txn_date" => Carbon::now()->format('YmdHis'),
                "account_id" => $account->id,
                "credit" => 0,
                "debit" => $amount,
                "balance" => $account->balance - $amount,
                "notes" => $notes,
                'ref' => $document_ref,
                'type' => $account_type,
                'created_at' => Carbon::now()
            ]);
        } else {
            Log::info("No account to debit found");
            throw  new \Exception("No account to debit has been found");
        }
    }

    /**
     * Transfer funds between two accounts
     *
     * @param array $accounts
     * @param $amount
     * @param $document_ref
     * @param $notes
     * @throws \Exception
     */
    public static function transfer(array $accounts, $amount, $document_ref, $notes)
    {
        // If one part of the transfer fails the whole transaction fails

        DB::transaction(function () use ($accounts, $amount, $notes, $document_ref) {

            $credit = $accounts['credit'];
            $debit = $accounts['debit'];

            self::debit($debit['owner_id'], $debit['owner_type'], array_get($debit, 'account_type', 'main'), $amount, $document_ref, $notes);
            self::credit($credit['owner_id'], $credit['owner_type'], array_get($credit, 'account_type', 'main'), $amount, $document_ref, $notes);
        });

        // TODO:: if the transaction fails then queue it to be performed later. Explore other critical functions that need to be queued if it fails
    }

    /**
     * @return self
     */
    public static function get_system_account()
    {
        return self::query()->whereName(self::SYSTEM_ACCOUNT_NAME)->firstOrFail();
    }

    /**
     * @return mixed
     */
    public static function get_general_transaction_account()
    {
        return self::query()->whereName(self::TRANSACTION_ACCOUNT)->firstOrFail();
    }

    /**
     * @return mixed
     */
    public static function get_general_ledger_account()
    {
        return self::query()->whereName(self::GENERAL_SUSPENSE_ACCOUNT)->firstOrFail();
    }

    /**
     *
     */
    public function update_balance()
    {
        if ($this->update_balance)
            $this->balance = ($this->main + $this->bonus);
    }

    public function user()
    {
        return $this->belongsTo(User::class, "owner_id");
    }
}
