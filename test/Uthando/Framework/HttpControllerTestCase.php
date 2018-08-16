<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoTest\Framework
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoTest\Framework;

use Uthando\User\Entity\DTO\Login;
use Uthando\User\Service\AuthenticationManager;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class HttpControllerTestCase extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    protected function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../config/application.config.php'
        );
        parent::setUp();
    }

    protected function login()
    {
        /** @var AuthenticationManager $auth */
        $auth           = $this->getApplicationServiceLocator()->get(AuthenticationManager::class);
        $dto            = new Login();
        $dto->email     = 'admin@example.com';
        $dto->password  = 'password';
        $result         = $auth->doAuthentication($dto);

        return $result;
    }
}