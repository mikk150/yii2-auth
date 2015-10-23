<?php
namespace mikk150\auth;

use yii\filters\auth\AuthMethod;

/**
*
*/
class HeaderParamAuth extends AuthMethod
{
    /**
     * @var string the header parameter name for passing the access token
     */
    public $tokenParam = 'x-token';

    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        $accessToken = $request->headers->get($this->tokenParam);
        if (is_string($accessToken)) {
            $identity = $user->loginByAccessToken($accessToken, get_class($this));
            if ($identity !== null) {
                return $identity;
            }
        }
        if ($accessToken !== null) {
            $this->handleFailure($response);
        }
        return null;
    }
}
