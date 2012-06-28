<?php
/*
 * This file is part of the TzTestBundle package.
 *
 * ©2012 Torsten Zander <info@tzander.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tz\TestBundle\Web;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\BrowserKit\Cookie;
use Tz\TestBundle\Model\Application;

abstract class TestCase extends BaseWebTestCase
{
    /**
     * @var string
     */
    protected $fixtureDirectory;

    /**
     * @var Symfony\Component\Routing\Router
     */
    protected $router;

    /**
     * @var  Symfony\Bundle\FrameworkBundle\Client
     */
    protected static $client;

    /**
     * @todo abstract or not maybe in AuthWebTestCase with createClientWithAuthentication
     */
    protected function getCurrentUser()
    {

    }

    /**
     * return void
     */
    public function setUp()
    {
        $serviceContainer = self::$kernel->getContainer();
        $this->router = $serviceContainer->get('router');
        parent::setUp();
    }

    /**
     * @static
     * @return void
     */
    public static function setUpBeforeClass()
    {
        self::$kernel = new \Kernel(Application::getEnviroment(), true);
        self::$kernel->boot();
        static::$client = self::createClient(array(), array());
        $application = static::$kernel->getContainer()->get('tz_model.application');
        $application->setUpSchema(self::$kernel);
    }

    /**
     * @param string $firewallName
     * @param array $options
     * @param array $server
     * @return Symfony\Component\BrowserKit\Client
     */
    protected function createClientWithAuthentication($firewallName, array $options = array(), array $server = array())
    {
        /* @var $client Symfony\Component\BrowserKit\Client */
        $client = $this->createClient($options, $server);
        $serviceContainer = self::$kernel->getContainer();
        $this->router = $serviceContainer->get('router');
        $client->getCookieJar()->set(new Cookie(session_name(), true));
        $user = $this->getCurrentUser();

        $token = new UsernamePasswordToken($user, null, $firewallName, array('ROLE_SUPER_ADMIN'));
        self::$kernel->getContainer()->get('session')->set('_security_' . $firewallName, serialize($token));

        return $client;
    }

    /**
     * @param string $fixtureDirectory
     * @return void
     */
    public function setFixtureDirectory($fixtureDirectory)
    {
        $this->fixtureDirectory = $fixtureDirectory;
    }
}
