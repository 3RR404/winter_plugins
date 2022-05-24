<?php

namespace Err404\Shoping\Classes;

use Err404\User\Models\User;
use Lovata\Ordersshopaholic\Models\UserAddress;
use Lovata\Toolbox\Traits\Helpers\TraitValidationHelper;

class UserAddressCreator
{
    use TraitValidationHelper;

    /** @var User */
    protected $obUser;

    public function __construct( $obUser )
    {
        $this->obUser = $obUser;
    }

    /**
     * Add user address data
     * @param string $sType
     * @param array  $arAddressData
     * @return array
     */
    public function addOrderAddress($sType, $arAddressData) : array
    {
        if (empty($arAddressData) || empty($sType) || empty($this->obUser)) {
            return $this->prepareAddressData($sType, $arAddressData);
        }

        $arResult = $this->findAddressByID($sType, $arAddressData);

        if (empty($arResult)) {
            $obAddress = UserAddress::findAddressByData($arAddressData, $this->obUser->id);
            if (!empty($obAddress)) {
                $arResult = $this->getAddressData($obAddress);
            }
        }

        if (empty($arResult)) {
            $arResult = $this->createUserAddress($sType, $arAddressData);
        }

        return $this->prepareAddressData($sType, $arResult);
    }

    /**
     * Prepare address array to save in Order properties
     * @param string $sType
     * @param array  $arAddressData
     * @return array
     */
    protected function prepareAddressData($sType, $arAddressData) : array
    {
        if (empty($arAddressData)) {
            return [];
        }

        $arResult = [];
        foreach ($arAddressData as $sKey => $sValue) {
            $arResult[$sType.'_'.$sKey] = $sValue;
        }

        return $arResult;
    }

    /**
     * Find Address object by ID, type and user_id
     * @param string $sType
     * @param array  $arAddressData
     * @return array
     */
    protected function findAddressByID($sType, $arAddressData) : array
    {
        $iAddressID = array_get($arAddressData, 'id');
        if (empty($iAddressID)) {
            return [];
        }

        $obAddress = UserAddress::getByUser($this->obUser->id)->getByType($sType)->find($iAddressID);
        if (empty($obAddress)) {
            return [];
        }

        return $this->getAddressData($obAddress);
    }

    /**
     * @param string $sType
     * @param array  $arAddressData
     * @return array
     */
    protected function createUserAddress($sType, $arAddressData) : array
    {
        if (empty($arAddressData)) {
            return [];
        }

        $arAddressData['type'] = $sType;
        $arAddressData['user_id'] = $this->obUser->id;

        try {
            //Create new address for user
            $obAddress = UserAddress::create($arAddressData);
        } catch (\October\Rain\Database\ModelException $obException) {
            $this->processValidationError($obException);
            return [];
        }

        return $this->getAddressData($obAddress);
    }

    /**
     * Get address data from object
     * @param UserAddress $obAddress
     * @return array
     */
    protected function getAddressData($obAddress) : array
    {
        if (empty($obAddress)) {
            return [];
        }

        $arResult = $obAddress->toArray();
        array_forget($arResult, ['id', 'type']);

        return $arResult;
    }

    public function addCompany( $arCompanyData )
    {
        if (empty($arCompanyData) || empty($this->obUser) )
            return $this->prepareCompanyData($arCompanyData);

        try {
            $this->obUser->update($arCompanyData);
        } catch (\October\Rain\Database\ModelException $obException) {
            $this->processValidationError($obException);
            return [];
        }

        return $this->prepareCompanyData($arCompanyData);
    }

    protected function prepareCompanyData($arCompanyData): array
    {
        if (empty($arCompanyData)) {
            return [];
        }

        $arResult = [];
        foreach ($arCompanyData as $sKey => $sValue) {
            $arResult['company_'.$sKey] = $sValue;
        }

        return $arResult;
    }
}
