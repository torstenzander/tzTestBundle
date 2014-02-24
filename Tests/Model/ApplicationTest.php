<?php
/*
 * This file is part of the TzTestBundle package.
 *
 * ©2012 Torsten Zander <info@tzander.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tzander\TestBundle\Test\Model;

use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Tzander\TestBundle\Model\Application;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Tzander\TestBundle\Model\Application
     */
    protected $application;

    protected function setUp()
    {
        $this->application = new Application;
    }

    /**
     * @test
     */
    public function setUpSchema()
    {
       // $integer = $this->application->setUpSchema(self::$kernel);
       // $this->assertInternalType('int', $integer);
    }

    /**
     * @test
     */
    public function getEnviroment()
    {
        $this->assertNotNull(Application::getEnviroment());
    }
}

