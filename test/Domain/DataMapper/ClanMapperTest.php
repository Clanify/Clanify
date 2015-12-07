<?php
/**
 * Namespace to test the DataMappers of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Test\Domain\DataMapper;

use Clanify\Domain\Entity\Clan;
use Clanify\Domain\DataMapper\ClanMapper;

/**
 * Class ClanMapperTest
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Test\Domain\DataMapper
 * @version 0.0.1-dev
 */
class ClanMapperTest extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * The database connection with PDO.
     * @since 0.0.1-dev
     * @var null|\PDO
     */
    private $pdo = null;

    /**
     * Method to get the database connection for test.
     * @return \PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection
     * @since 0.0.1-dev
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function getConnection()
    {
        $this->pdo = new \PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);
        return $this->createDefaultDBConnection($this->pdo, $GLOBALS['DB_DBNAME']);
    }

    /**
     * Method to get the initial state of the database for test.
     * @return \PHPUnit_Extensions_Database_DataSet_XmlDataSet
     * @since 0.0.1-dev
     */
    public function getDataset()
    {
        return $this->createXMLDataSet(__DIR__.'/DataSets/Clan/clan.xml');
    }

    /**
     * Method to test if the method delete() works.
     * @since 0.0.1-dev
     * @test
     */
    public function testDelete()
    {
        //The Clan which will be deleted on database.
        $clan = new Clan();
        $clan->id = 2;

        //The ClanMapper to delete the Clan on database.
        $clanMapper = new ClanMapper($this->pdo);
        $clanMapper->delete($clan);

        //Get the actual and expected table.
        $queryTable = $this->getConnection()->createQueryTable('clan', 'SELECT * FROM clan');
        $expectedDataSet = __DIR__.'/DataSets/Clan/clan-delete.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataSet)->getTable('clan');

        //Check if the tables are equal.
        $this->assertTablesEqual($expectedTable, $queryTable);
    }

    /**
     * Method to test if the method create() works.
     * @since 0.0.1-dev
     * @test
     */
    public function testSaveCreate()
    {
        //The Clan which will be created on database.
        $clan = new Clan();
        $clan->name = 'Killerbees eSport';
        $clan->tag = 'KBE';
        $clan->website = 'http://example.com/';

        //The ClanMapper to create the Clan on database.
        $clanMapper = new ClanMapper($this->pdo);
        $clanMapper->save($clan);

        //Get the actual and expected table.
        $queryTable = $this->getConnection()->createQueryTable('clan', 'SELECT * FROM clan');
        $expectedDataSet = __DIR__.'/DataSets/Clan/clan-save-create.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataSet)->getTable('clan');

        //Check if the tables are equal.
        $this->assertTablesEqual($expectedTable, $queryTable);
    }

    /**
     * Method to test if the method update() works.
     * @since 0.0.1-dev
     * @test
     */
    public function testSaveUpdate()
    {
        //The Clan which will be updated on database.
        $clan = new Clan();
        $clan->id = 2;
        $clan->name = 'Clanify eSport';
        $clan->tag = 'CeS';
        $clan->website = 'http://clanify.rocks/esport';

        //The ClanMapper to update the Clan on database.
        $clanMapper = new ClanMapper($this->pdo);
        $clanMapper->save($clan);

        //Get the actual and expected table.
        $queryTable = $this->getConnection()->createQueryTable('clan', 'SELECT * FROM clan');
        $expectedDataSet = __DIR__.'/DataSets/Clan/clan-save-update.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataSet)->getTable('clan');

        //Check if the tables are equal.
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
}