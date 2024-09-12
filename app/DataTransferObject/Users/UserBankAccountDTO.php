<?php

namespace App\DataTransferObject\Users;

use App\Enum\RoleEnum;

class UserBankAccountDTO
{
    private ?string $user_id;
    private ?string $bank;
    private ?string $agency = null;
    private ?string $nickname = null;
    private ?string $number = null;
    private ?bool $main_account = null;

    public function __construct(
       ?string $user_id = null,
       ?string $bank = null,
       ?string $agency = null,
       ?string $nickname = null,
       ?string $number = null,
       ?bool $main_account = null
    )
    {
        $this->user_id = $user_id;
        $this->bank = $bank;
        $this->agency = $agency;
        $this->nickname = $nickname;
        $this->number = $number;
        $this->main_account = $main_account;
    }
     // Getters and Setters

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function setUserId(string $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getBank(): ?string
    {
        return $this->bank;
    }

    public function setBank(?string $bank): void
    {
        $this->bank = $bank;
    }

    public function getAgency(): ?string
    {
        return $this->agency;
    }
    public function setAgency(?string $agency): void
    {
        $this->agency = $agency;
    }
    public function getNickname(): ?string
    {
        return $this->nickname;
    }
    public function setNickname(?string $nickname): void
    {
        $this->nickname = $nickname;
    }
    public function getNumber(): ?string
    {
        return $this->number;
    }
    public function setNumber(?string $number): void
    {
        $this->number = $number;
    }
    public function getMainAccount():?bool
    {
        return $this->main_account;
    }
    public function setMainAccount(?bool $main_account): void
    {
        $this->main_account = $main_account;
    }

}
