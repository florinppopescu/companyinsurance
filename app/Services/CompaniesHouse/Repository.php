<?php
/**
 * Created by PhpStorm.
 * User: florin
 */

namespace App\Services\CompaniesHouse;

use App\Services\CompaniesHouse\Client as CompaniesHouseClient;


class Repository
{
    /**
     * @var $httpClient
     */
    protected $httpClient;
    protected $baseApiUrl;

    public function __construct()
    {
        $this->client = new CompaniesHouseClient();
    }

    /**
     * Checks if Insurance is available for the data provided
     *
     * @param $requestData
     *
     * @return array
     */
    public function checkIfInsuranceIsAvailable($requestData){
        $data = [];

        $companyNumber = $requestData['company_number'];

        // we first check if the company exists. we could have done it by checking directly the officers,
        // as it would first check to see if the company exists, to ensure stability over time it's better
        // to check if the company exists, by using it's own dedicated endpoint.

        if($this->client->getCompany($companyNumber)->code == 200){
            // we check to see if the name provided in the form is one of the company officers

            if($this->belongsToOfficers($requestData)){
                // if the user's name is one of the company officers we check
                // to see if the the company can benefit from insurance
                if($this->canHaveInsurance($companyNumber)){
                    $data['result'] = 'Company is eligible for insurance';
                } else {
                    $data['result'] = 'Company is not eligible for insurance';
                }
            } else {
                $data['result'] = 'Company member not found';
            }
        } else {
            $data['result'] = 'Company not found';
        }


        return $data;
    }

    /**
     * @param $firstName
     * @param $lastName
     * @param $officers
     *
     * @return bool
     */
    protected function belongsToOfficers($data){
        $companyOfficers = $this->client->getCompanyOfficers($data['company_number']);
        if($companyOfficers->message->total_results){
            foreach($companyOfficers->message->items as $officer){
                $names = explode(',', $officer->name);
                // we check to see if name format from the response
                // corresponds to what was observed in the documentation
                if(count($names) != 2)
                    return false;

                if(strtoupper($data['last_name']) == $names[0] && $data['first_name'] == ltrim($names[1], ' '))
                    return true;
            }
        }

        return false;
    }

    /**
     * Retrieves the company for insolvency history and based on that
     * it calculates if the company is valid or not to get insurance
     *
     * For the sake of the exercise, we will give insurance to the company
     * if there are no records of insolvency
     *
     * @param $companyNumber
     * @return bool
     */
    protected function canHaveInsurance($companyNumber){
        $response = $this->client->getCompanyInsolvency($companyNumber);

        if($response->code == 200){
            if($response->message == null){
                return true;
            }
        }

        return false;
    }
}