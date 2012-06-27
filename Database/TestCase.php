<?php
/*
 * This file is part of the TzTestBundle package.
 *
 * ©2012 Torsten Zander <info@tzander.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tz\TestBundle\Database;

use Tz\TestBundle\Model\Application;

class TestCase extends \PHPUnit_Extensions_Database_TestCase
{

    /**
     * @var \AppKernel
     */
    static protected $kernel;

    /**
     * @var string
     */
    protected $fixtureFile;

    /**
     * @var  Symfony\Bundle\FrameworkBundle\Client
     */
    protected static $client;

    /**
     * @param array  $server  An array of server parameters
     *
     * @return Client A Client instance
     */
    static protected function createClient(array $options = array(), array $server = array())
    {
        static::$kernel = new \Kernel(Application::getEnviroment(), true);
        static::$kernel->boot();
        $client = static::$kernel->getContainer()->get('test.client');
        $client->setServerParameters($server);
        return $client;
    }

    /**
     * @return void
     */
    public function setUp()
    {
        $serviceContainer = self::$kernel->getContainer();
        $this->router = $serviceContainer->get('router');
        parent::setUp();
    }

    /**
     * @return void
     */
    public static function setUpBeforeClass()
    {
        static::$client = self::createClient(array(), array());
        $application = static::$kernel->getContainer()->get('tz_model.application');
        $application->setUpSchema(static::$kernel);
    }

    /**
     * @return \PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection
     */
    protected function getConnection()
    {
        $pdo = static::$kernel->getContainer()->get('tz_test.database');
        return $this->createDefaultDBConnection($pdo->getConnection(), static::$kernel->getContainer()->getParameter('database_name'));
    }

    /**
     * @return \PHPUnit_Extensions_Database_DataSet_FlatXmlDataSet
     */
    protected function getDataSet()
    {
        return $this->createFlatXMLDataSet($this->fixtureDirectory . '/../DataFixtures/' . $this->fixtureFile);
    }

    /**
     * @param string $fixtureFile
     */
    protected function setFixtureFile($fixtureFile)
    {
        $this->fixtureFile = $fixtureFile;
    }

    /**
     * @param string $fixtureDirectory
     * @return void
     */
    protected function setFixtureDirectory($fixtureDirectory)
    {
        $this->fixtureDirectory = $fixtureDirectory;
    }
}
