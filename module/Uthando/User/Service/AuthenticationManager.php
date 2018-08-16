<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\User\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando\User\Service;


use DoctrineModule\Authentication\Adapter\ObjectRepository;
use Uthando\User\Entity\DTO\Login;
use Uthando\User\Entity\UserEntity;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Session\SessionManager;

class AuthenticationManager
{
    /**
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * @var SessionManager
     */
    protected $sessionManager;

    /**
     * @var array
     */
    protected $config;

    /**
     * @param UserEntity $user
     * @param string $inputPassword
     * @return bool
     */
    public static function verifyCredential(UserEntity $user, string $inputPassword): bool
    {
        $verified = password_verify($inputPassword, $user->password);

        return $verified;
    }

    public function __construct(AuthenticationService $authService, SessionManager $sessionManager, array $config)
    {
        $this->authService      = $authService;
        $this->sessionManager   = $sessionManager;
        $this->config           = $config;
    }

    /**
     * @param Login $login
     * @return Result
     * @throws \Exception
     */
    public function doAuthentication(Login $login): Result
    {
        if (null !== $this->authService->getIdentity()) {
            throw new \Exception('Already logged in');
        }

        /** @var ObjectRepository $adapter */
        $adapter = $this->authService->getAdapter();
        $adapter->setIdentity($login->email);
        $adapter->setCredential($login->password);
        $authResult = $this->authService->authenticate();

        if ($authResult->isValid()) {

            if (true === $login->rememberMe) {
                $this->sessionManager->rememberMe(60*60*24*30);
            }

            $this->authService->getStorage()
                ->write($authResult->getIdentity());
        }

        return $authResult;
    }

    /**
     * @throws \Exception
     */
    public function clear()
    {
        // Allow to log out only when user is logged in.
        if (null === $this->authService->getIdentity()) {
            throw new \Exception('The user is not logged in');
        }

        // Remove identity from session.
        $this->authService->clearIdentity();
        $this->sessionManager->forgetMe();
        $this->sessionManager->destroy();
    }

    /**
     * @param $controllerName
     * @param $actionName
     * @return bool
     * @throws \Exception
     */
    public function filterAccess($controllerName, $actionName)
    {
        // Determine mode - 'restrictive' (default) or 'permissive'. In restrictive
        // mode all controller actions must be explicitly listed under the 'access_filter'
        // config key, and access is denied to any not listed action for unauthenticated users.
        // In permissive mode, if an action is not listed under the 'access_filter' key,
        // access to it is permitted to anyone (even for not logged in users.
        // Restrictive mode is more secure and recommended to use.
        $mode = isset($this->config['options']['mode'])?$this->config['options']['mode']:'restrictive';

        if ('restrictive' !== $mode && 'permissive' !== $mode)
            throw new \Exception('Invalid access filter mode (expected either restrictive or permissive mode');

        if (isset($this->config['controllers'][$controllerName])) {

            $items = $this->config['controllers'][$controllerName];

            foreach ($items as $item) {

                $actionList = $item['actions'];
                $allow      = $item['allow'];

                if (is_array($actionList) && in_array($actionName, $actionList) ||  '*' === $actionList) {

                    if ('*' === $allow)
                        return true; // Anyone is allowed to see the page.
                    else if ('@' === $allow && $this->authService->hasIdentity()) {
                        return true; // Only authenticated user is allowed to see the page.
                    } else {
                        return false; // Access denied.
                    }
                }
            }
        }

        // In restrictive mode, we forbid access for authenticated users to any
        // action not listed under 'access_filter' key (for security reasons).
        if ('restrictive' === $mode && !$this->authService->hasIdentity())
            return false;

        // Permit access to this page.
        return true;
    }
}