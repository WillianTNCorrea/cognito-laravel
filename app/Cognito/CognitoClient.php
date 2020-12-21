<?php 


namespace App\Cognito;

use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException;

class CognitoClient
{
    protected $client;
    protected $clientId;
    protected $poolId;

    public function __construct(CognitoIdentityProviderClient $client, $clientId, $poolId) {

        $this->client   = $client;
        $this->clientId = $clientId;
        $this->poolId   = $poolId;
    }

    public function register($email, $password, array $attributes = [])
    {
        $attributes['email'] = $email;

        try {
            $response = $this->client->signUp([
                'ClientId' => $this->clientId,
                'Password' => $password,
                'UserAttributes' => $this->formatAttributes($attributes),
                'Username' => $email
            ]);

        } catch (CognitoIdentityProviderException $e) {
            throw $e;
        }

        return;
    }

    public function verify(string $email, string $code)
    {
        try {
            $response = $this->client->confirmSignUp([
                'ClientId' => $this->clientId,
                'Username' => $email,
                'ConfirmationCode' => $code,
            ]);

        } catch (CognitoIdentityProviderException $e) {
            throw $e;
        }

        return;
    }

    public function authenticate($email, $password)
    {
        try {
            $response = $this->client->adminInitiateAuth([
                'AuthFlow'       => 'ADMIN_NO_SRP_AUTH',
                'AuthParameters' => [
                    'USERNAME'   => $email,
                    'PASSWORD'   => $password,
                ],
                'ClientId'       => $this->clientId,
                'UserPoolId'     => $this->poolId
            ]);
            return  $result->get('AuthenticationResult')['AccessToken'];    
        } catch (CognitoIdentityProviderException $e) {
            return false;
        }

        return true;
    }

    protected function formatAttributes(array $attributes)
    {
        $userAttributes = [];

        foreach ($attributes as $key => $value) {
            $userAttributes[] = [
                'Name'  => $key,
                'Value' => $value,
            ];
        }

        return $userAttributes;
    }
}

?>