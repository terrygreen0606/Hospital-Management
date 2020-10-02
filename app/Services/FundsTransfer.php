<?php


namespace App\Services;


use App\Models\Account;
use App\Payment;

class FundsTransfer
{
    protected function process_payment(Payment $payment)
    {
        $ft = new self();
        $ft->make_payment_from_user_wallet_to_system_account($payment);
    }

    public function make_payment_from_user_wallet_to_system_account(Payment $payment)
    {
        $gl = Account::get_general_ledger_account();
        $recipient = $payment->user->account;
        $accounts = [
            'credit' => $gl,
            'debit' => $recipient
        ];
        Account::transfer($accounts, $payment->amount, $payment->transaction_id, 'Payment');
    }
}
