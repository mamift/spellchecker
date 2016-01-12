<?php 

/**
 * Verifies an APIKey
 * @return true or false [boolean indicating whether the APIkey is valid]
 */
R::ext('isAPIKeyValid', function($apikey) {
    $boolDoesApiKeyExist = (($apiKeyBean = R::findOne(TBL_APIKEYS, ' apikey = ? ', array($apikey))) !== NULL);
    $boolDoesApiKeyMatch = $boolDoesApiKeyExist ? (strcmp($apikey, $apiKeyBean->apikey) == 0) : false;

    return ($boolDoesApiKeyExist && $boolDoesApiKeyMatch);
});