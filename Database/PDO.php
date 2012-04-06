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

class PDO
{
    /**
     * @var string
     */
    private $database;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $databaseName;

    /**
     * @var string
     */
    private $databaseUser;

    /**
     * @var string
     */
    private $password;

    /**
     * @param string $database
     * @param string $host
     * @param string $databaseName
     * @param string $databaseUser
     * @param string $password
     */
    public function __construct($database, $host, $databaseName, $databaseUser, $password)
    {
        $this->database = $database;
        $this->host = $host;
        $this->databaseName = $databaseName;
        $this->databaseUser = $databaseUser;
        $this->password = $password;
    }

    /**
     * @return PDO
     */
    public function getConnection()
    {
        $pdo = new \PDO($this->database . ':host=' . $this->host . '.;dbname=' . $this->databaseName, $this->databaseUser, $this->password);
        return $pdo;
    }

    /**
     * @return string
     */
    public function getDatabaseName()
    {
        return $this->databaseName;
    }
}
