<?php


namespace App\Services;


interface AccountableInterface
{
    /**
     * @return mixed
     */
    public function getAccountId();

    /**
     * @return mixed
     */
    public function getAccountName();

    /**
     * @return mixed
     */
    public function getAccountType();
}
