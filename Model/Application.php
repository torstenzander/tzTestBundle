<?php
/*
 * This file is part of the TzTestBundle package.
 *
 * ©2012 Torsten Zander <info@tzander.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tz\TestBundle\Model;
use Tz\TestBundle\Model\Enviroment;

class Application
{
    /**
     * @param string $command
     * @param array $options
     * @return int
     */
    private function runConsole($command, Array $options = array())
    {
        $options["-e"] = self::getEnviroment();
        $options["-q"] = null;
        $options = array_merge($options, array('command' => $command));
        return $this->application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
    }

    /**
     * @return void
     */
    public function setUpSchema(\AppKernel $kernel)
    {
        $this->application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
        $this->application->setAutoExit(false);
        $this->runConsole("doctrine:schema:drop", array('--force' => true));
        $this->runConsole("doctrine:schema:create");
        return $this->runConsole("cache:warmup");
    }

    /**
     * @static
     * @return string
     */
    public static function getEnviroment()
    {
        if (getenv('APPLICATION_ENV')) {
            return getenv('APPLICATION_ENV');
        } else {
            return 'test';
        }
    }
}