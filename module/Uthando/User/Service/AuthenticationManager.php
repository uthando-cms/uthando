<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\User\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace Uthando\User\Service;


use Doctrine\ORM\EntityManager;
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
    protected $filter;

    /**
     * AuthenticationManager constructor.
     * @param AuthenticationService $authService
     * @param SessionManager $sessionManager
     * @param array $filter
     */
    public function __construct(AuthenticationService $authService, SessionManager $sessionManager, array $filter)
    {
        $this->authService      = $authService;
        $this->sessionManager   = $sessionManager;
        $this->filter           = $filter;
    }

    /**
     * @param Login $login
     * @return Result
     * @throws \Exception
     */
    public function doAuthentication(Login $login): Result
    {
        /** @var ObjectRepository $adapter */
        $adapter = $this->authService->getAdapter();
        $adapter->setIdentity($login->email);
        $adapter->setCredential($login->password);
        $authResult = $this->authService->authenticate();

        if ($authResult->isValid()) {
            /** @var UserEntity $user */
            $user = $authResult->getIdentity();

            if ($user->checkPasswordHash($login->password)) {
                /** @var EntityManager $manager */
                $manager = $adapter->getOptions()->getObjectManager();
                $manager->flush();
                $manager->clear();
                $cacheDriver = $manager->getConfiguration()->getResultCacheImpl();
                $cacheDriver->delete('user-tags');
            }

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
        // Remove identity from session.
        $this->authService->clearIdentity();
        @$this->sessionManager->forgetMe();
        @$this->sessionManager->destroy();
    }

    /**
     * The 'access_filter' key is used by the User module to restrict or permit
     * access to certain controller actions for unauthenticated visitors.
     * Deny access is default, you must explicitly allow users.
     *
     * * allow all users
     * @ allow only authenticated users
     *
     * @param $controllerName
     * @param $actionName
     * @return bool
     * @throws \Exception
     */
    public function filterAccess($controllerName, $actionName)
    {
        $items = $this->filter[$controllerName] ?? [];
    
        foreach ($items as $item) {
    
            $actionList = $item['actions'] ?? [];
            $allow      = $item['allow'] ?? '';
    
            if (in_array($actionName, $actionList)) {
                
                // Anyone is allowed to see the page.
                if ('*' === $allow) {
                    return true;
                }
                
                // Only authenticated user is allowed to see the page.
                if ('@' === $allow && $this->authService->hasIdentity()) {
                    return true;
                }
            }
        }

        return false;
    }
}