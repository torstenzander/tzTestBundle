<?php
/*
 * This file is part of the TzTestBundle package.
 *
 * ©2012 Torsten Zander <info@tzander.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tzander\TestBundle\Test\Database;

use Tzander\TestBundle\Database\PDO as Database;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

class DatabaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Tzander\FixtureBundle\Model\Database
     */
    private $database;

    public function setUp()
    {
        $this->database =  $pdo = new Database('sqlite', 'localhost', 'myinvoiz', 'root', 'root');
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
        $this->markTestSkipped();
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
