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


use PDO;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use PHPUnit\DbUnit\TestCaseTrait;
use Uthando\User\Entity\DTO\Login;
use Uthando\User\Service\AuthenticationManager;
use Zend\Dom\Document;
use Zend\Dom\Document\Query;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class HttpControllerTestCase extends AbstractHttpControllerTestCase
{
    use TestCaseTrait;

    protected $traceError = true;

    // only instantiate pdo once for test clean-up/fixture load
    static private $pdo = null;

    // only instantiate PHPUnit\DbUnit\Database\Connection once per test
    private $conn = null;

    protected function setUp()
    {
        $config  = include __DIR__ . '/../../config/application.config.php';

        $this->setApplicationConfig(
            $config
        );
        parent::setUp();

        copy(
            __DIR__ . '/../../assets/uthando-cms.sqlite.orig',
            __DIR__ . '/../../assets/uthando-cms.sqlite'
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    protected function getCsrfValue($url)
    {
        $this->dispatch($url);

        $response   = $this->getResponse();
        $document   = new Document($response->getContent());
        $query      = new Query();
        $csrf       = $query->execute('form input[name="csrf"]', $document, Query::TYPE_CSS)
            ->current()
            ->getAttribute('value');

        $this->reset(true);

        return $csrf;
    }

    protected function login()
    {
        /** @var AuthenticationManager $auth */
        $auth               = $this->getApplicationServiceLocator()->get(AuthenticationManager::class);
        $dto                = new Login();
        $dto->email         = 'admin@example.com';
        $dto->password      = 'password';
        if (phpversion() < 7.2) $dto->rememberMe    = true;
        $result             = $auth->doAuthentication($dto);

        return $result;
    }

    /**
     * Returns the test database connection.
     *
     * @return Connection
     */
    protected function getConnection()
    {
        if ($this->conn === null) {
            $schema = __DIR__ . '/../../assets/uthando-cms.sqlite';

            if (self::$pdo == null) {
                self::$pdo = new PDO('sqlite:' . $schema);
            }

            $this->conn = $this->createDefaultDBConnection(self::$pdo, $schema);
        }

        return $this->conn;
    }

    /**
     * Returns the test dataset.
     *
     * @return IDataSet
     */
    protected function getDataSet()
    {
        return $this->createArrayDataSet(include __DIR__ . '/../../assets/uthando-cms.php');
    }
}