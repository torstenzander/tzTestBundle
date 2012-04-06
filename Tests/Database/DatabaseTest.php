<?php
/*
 * This file is part of the TzTestBundle package.
 *
 * ©2012 Torsten Zander <info@tzander.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tz\TestBundle\Test\Database;

use Tz\TestBundle\Database\PDO as Database;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

class DatabaseTest extends BaseWebTestCase
{
    /**
     * @var Tz\FixtureBundle\Model\Database
     */
    private $database;

    public function setUp()
    {
        $this->createClient();
        $this->database =  $pdo = static::$kernel->getContainer()->get('tz_test.database');
    }

    public function tearDown()
    {
        $this->database = null;
    }

    /**
     * @test
     */
    public function getPdoConnection()
    {
        $pdo = $this->database->getConnection();
        $this->assertInstanceOf('PDO', $pdo);
    }

    /**
     * @test
     * @expectedException PDOException
     */
    public function failPdoConnection()
    {
        $database = new Database('mysql', 'localhost', 'mysql', 'nouser', '');
        $pdo = $database->getConnection();
        $this->assertNull($pdo);
    }

    /**
     * @test
     */
    public function getDatabaseName()
    {
        $this->assertEquals('myinvoiz', $this->database->getDatabaseName());
    }
}
