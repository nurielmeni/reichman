<?php

require_once 'NlsService.php';
require_once 'NlsHelper.php';

/**
 * Description of NlsSearch
 *
 * @author nurielmeni
 */
class NlsSearch extends NlsService
{
    /**
     * 
     * @param type $config the $auth and $settings
     */
    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->init();
    }

    /**
     * Override init to set the service URL
     */
    public function init()
    {
        $this->url = get_option(NlsHunterFbf_Admin::SEARCH_WSDL_URL);
        parent::init();
    }


    public function JobHuntersGetForUser()
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = array(
                "transactionCode" => $transactionCode,
                // "status" => $status
            );

            $res = $this->client->JobHuntersGetForUser($params);

            return $res;
        } catch (SoapFault $ex) {
            //var_dump($ex);
            throw new Exception('Error: JobHuntersGetForUser: SOAP Error: Check the log for more details.');
        } catch (Exception $ex) {
            $ex->transactionCode = $transactionCode;
            throw new Exception('Error: JobHuntersGetForUser: Niloos services are not availiable, try later.');
        }
    }

    public function JobHunterCreateOrUpdate($name = null, $hunterId = null, $filter = [], $hunterStatus = null)
    {
        $transactionCode = NlsHelper::newGuid();
        $hunterId = $hunterId ? $hunterId : NlsHelper::newGuid();
        try {
            $params = array(
                "transactionCode" => $transactionCode,
                "hunterId" => $hunterId,
                "hunterStatus" => $hunterStatus,
                "name" => $name,
                "jobId" => null,
                "externalId" => null,
                "userDefined1" => null,
                "userDefined2" => null,
                "filter" => $filter
            );

            $res = $this->client->JobHunterCreateOrUpdate($params);

            return $res;
        } catch (SoapFault $ex) {
            //var_dump($ex);
            throw new Exception('Error: SOAP Error: Check the log for more details.');
        } catch (Exception $ex) {
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    public function jobHunterExecuteByHunterId2($hunter_id, $from = 0, $ofset = 1000, $sinceLastQuery = true)
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = array(
                "transactionCode" => $transactionCode,
                "HunterId" => $hunter_id,
                "queryConfig" => array("ResultRowLimit" => $ofset, "ResultRowOffset" => $from),
                "sinceLastQuery" => $sinceLastQuery
            );
            $res = $this->client->JobHunterExecuteByHunterId2($params);
            return $res;
        } catch (SoapFault $ex) {
            //var_dump($ex);
            throw new Exception('Error: SOAP Error: Check the log for more details.');
        } catch (Exception $ex) {
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }


    public function applicantHunterExecuteNewQuery2($hunter_id, $from, $ofset, $filter)
    {
        $transactionCode = NlsHelper::newGuid();
        $hunter_id = NlsHelper::newGuid();
        try {
            $params = array(
                "transactionCode" => $transactionCode,
                "HunterId" => $hunter_id,
                "queryConfig" => array("ResultRowLimit" => $from, "ResultRowOffset" => $ofset),
                "oQueryInfo" => $filter
            );
            $res = $this->client->ApplicantHunterExecuteNewQuery2($params)->ApplicantHunterExecuteNewQuery2Result; //->Results;
            return $res;
        } catch (SoapFault $ex) {
            //var_dump($ex);
            throw new Exception('Error: SOAP Error: Check the log for more details.');
        } catch (Exception $ex) {
            /**
             * var_dump($ex);
             * echo "Request " . $this->client->__getLastRequest();
             * echo "Response " . $this->client->__getLastResponse();
             * die;
             **/
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    public function JobHunterExecuteNewQuery2($hunter_id, $resultRowOffset, $resultRowLimit, $filter)
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = [
                "transactionCode" => $transactionCode,
                "HunterId" => $hunter_id,
                "queryConfig" => ["ResultRowLimit" => $resultRowLimit, "ResultRowOffset" => $resultRowOffset],
                "oQueryInfo" => $filter
            ];
            $res = $this->client->JobHunterExecuteNewQuery2($params);
            $res = property_exists($res, 'JobHunterExecuteNewQuery2Result') ? $res->JobHunterExecuteNewQuery2Result : []; //->Results;
            return $res;
        } catch (SoapFault $ex) {
            //var_dump($ex);
            throw new Exception('Error: SOAP Error: Check the log for more details.');
        } catch (Exception $ex) {
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }


    public function JobHunterGetInfo($hunterId)
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = [
                "hunterId" => $hunterId,
                "transactionCode" => $transactionCode,
            ];

            $res = $this->client->JobHunterGetInfo($params);

            return $res;
        } catch (SoapFault $ex) {
            throw new Exception('Error: Niloos services are not availiable, try later.');
        } catch (Exception $ex) {
            $ex->transactionCode = $transactionCode;
            throw $ex;
        }
    }

    public function JobHunterDelete($hunterId)
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = [
                "hunterId" => $hunterId,
                "transactionCode" => $transactionCode,
            ];

            $res = $this->client->JobHunterDelete($params);

            return $res;
        } catch (SoapFault $ex) {
            throw new Exception('Error: Niloos services are not availiable, try later.');
        } catch (Exception $ex) {
            $ex->transactionCode = $transactionCode;
            throw $ex;
        }
    }

    public function AutomaticHunterConfirmReset($hunter_id)
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = array(
                "transactionCode" => $transactionCode,
                "HunterId" => $hunter_id
            );
            $this->client->AutomaticHunterConfirmReset($params);
        } catch (SoapFault $ex) {
            //var_dump($ex);
            throw new Exception('Error: SOAP Error: Check the log for more details.');
        } catch (Exception $ex) {
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    public function SearchApplicantsByName($applicantName)
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = array(
                "transactionCode" => $transactionCode,
                "partialName" => $applicantName
            );
            $this->client->SearchApplicantsByName($params);
        } catch (SoapFault $ex) {
            //var_dump($ex);
            throw new Exception('Error: SOAP Error: Check the log for more details.');
        } catch (Exception $ex) {
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }
}
