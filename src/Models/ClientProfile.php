<?php

namespace MikeyDevelops\Econt\Models;

/**
 * Information about the client profile.
 *
 * @property  integer  $id  The client identifier.
 * @property  string  $name  The client name.
 * @property  string  $nameEn  The client name in latin alphabet (International name).
 * @property  string[]  $phones  Connected phone numbers. (digits, optional '+' in the beginning)
 * @property  string  $email  The client email.
 * @property  string[]  $skypeAccounts  The client skype account handles.
 * @property  string  $clientNumber  The client number.
 * @property  string  $clientNumberEn  The client number. (in english)
 * @property  boolean  $judicialEntity  True if client is company.
 * @property  string  $personalIDType  Type of personal identification number. (EGN, PIN, PK, PASSPORT)
 * @property  string  $personalIDNumber  Personal ID Number (EGN)
 * @property  string  $companyType  Company type (registration of company)
 * @property  string  $ein  Registration number.
 * @property  string  $ddsEinPrefix  VAT Registration prefix. (two-letter code)
 * @property  string  $ddsEin  VAT Registration.
 * @property  string  $registrationAddress  Company's registration address.
 * @property  string  $molName  Name of company's representative.
 * @property  string  $molEGN  Unique Citizenship Number (EGN) of the company's representative.
 * @property  string  $molIDNum  ID card of company's representative.
 *
 * @see https://ee.econt.com/services/Profile/#ClientProfile
 */
class ClientProfile extends Model
{
    /**
     * If client is a company.
     *
     * @return boolean
     */
    public function isCompany(): bool
    {
        return $this->judicialEntity;
    }

    /**
     * If client is an individual.
     *
     * @return boolean
     */
    public function isIndividual(): bool
    {
        return ! $this->judicialEntity;
    }
}
