<?php

namespace App\DataTransferObject\Users;

use App\Enum\RoleEnum;

class ClientDTO
{
    private ?string $name = null;
    private ?string $email = null;
    private ?string $person = null;
    private ?string $birthday = null;
    private ?string $notifications = null;
    private ?string $type_of_investor = null;
    private ?string $telephone = null;
    private ?string $phone = null;
    private ?string $genre = null;
    private ?string $address_street = "";
    private ?string $address_state = "";
    private ?string $address_number = "";
    private ?string $address_district = "";
    private ?string $address_zip_code = "";
    private ?string $address_city = "";
    private ?string $address_country = "";
    private ?string $current_balance = "0.00";
    private ?string $last_month = "0.00";

    public function __construct(
        ?string $name = null,
        ?string $email = null,
        ?string $person = null,
        ?string $birthday = null,
        ?string $notifications = null,
        ?string $type_of_investor = null,
        ?string $telephone = null,
        ?string $phone = null,
        ?string $genre = null,
        ?string $address_street = "",
        ?string $address_state = "",
        ?string $address_number = "",
        ?string $address_district = "",
        ?string $address_zip_code = "",
        ?string $address_city = "",
        ?string $address_country = "",
        ?string $current_balance = "0.00",
        ?string $last_month = "0.00",

    ) {
        $this->name = $name;
        $this->email = $email;
        $this->person = $person;
        $this->birthday = $birthday;
        $this->notifications = $notifications;
        $this->type_of_investor = $type_of_investor;

        $this->telephone = $telephone;
        $this->phone = $phone;
        $this->genre = $genre;
        $this->address_street = $address_street;
        $this->address_state = $address_state;
        $this->address_number = $address_number;
        $this->address_district = $address_district;
        $this->address_zip_code = $address_zip_code;
        $this->address_city = $address_city;
        $this->address_country = $address_country;
        $this->current_balance = $current_balance;
        $this->last_month = $last_month;
    }

    // Getters and Setters

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPerson(): ?string
    {
        return $this->person;
    }

    public function setPerson(?string $person): void
    {
        $this->person = $person;
    }

    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    public function setBirthday(?string $birthday): void
    {
        $this->birthday = $birthday;
    }

    public function getNotifications(): ?string
    {
        return $this->notifications;
    }

    public function setNotifications(?string $notifications): void
    {
        $this->notifications = $notifications;
    }

    public function getTypeOfInvestor(): ?string
    {
        return $this->type_of_investor;
    }

    public function setTypeOfInvestor(?string $type_of_investor): void
    {
        $this->type_of_investor = $type_of_investor ?? 'Investidor Obsidian';
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): void
    {
        $this->genre = $genre;
    }

    public function getAddressStreet(): ?string
    {
        return $this->address_street;
    }

    public function setAddressStreet(?string $address_street): void
    {
        $this->address_street = $address_street;
    }

    public function getAddressState(): ?string
    {
        return $this->address_state;
    }

    public function setAddressState(?string $address_state): void
    {
        $this->address_state = $address_state;
    }

    public function getAddressNumber(): ?int
    {
        return $this->address_number;
    }

    public function setAddressNumber(?string $address_number): void
    {
        $this->address_number = (int)$address_number;
    }

    public function getAddressDistrict(): ?string
    {
        return $this->address_district;
    }

    public function setAddressDistrict(?string $address_district): void
    {
        $this->address_district = $address_district;
    }

    public function getAddressZipCode(): ?string
    {
        return $this->address_zip_code;
    }

    public function setAddressZipCode(?string $address_zip_code): void
    {
        $this->address_zip_code = $address_zip_code;
    }

    public function getAddressCity(): ?string
    {
        return $this->address_city;
    }

    public function setAddressCity(?string $address_city): void
    {
        $this->address_city = $address_city;
    }

    public function getAddressCountry(): ?string
    {
        return $this->address_country;
    }

    public function setAddressCountry(?string $address_country): void
    {
        $this->address_country = $address_country;
    }
    public function getCurrentBalance(): ?float
    {
       return  $this->current_balance;
    }
    public function setCurrentBalance(?float $current_balance): void
    {
        $this->current_balance = (float)$current_balance;
    }
    public function getLastMonth(): ?float
    {
       return  $this->last_month;
    }
    public function setLastMonth(?float $last_month): void
    {
        $this->last_month =(float) $last_month;
    }
    public function getRole():RoleEnum
    {
        return RoleEnum::Client;
    }
}
