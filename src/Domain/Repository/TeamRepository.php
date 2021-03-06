<?php
/**
 * Namespace for all Repositories of Clanify.
 * @since 1.0.0
 */
namespace Clanify\Domain\Repository;

use Clanify\Domain\DataMapper\TeamMapper;
use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\User;

/**
 * Class TeamRepository to select Team Entities.
 *
 * @author Sebastian Brosch <support@clanify.rocks>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Repository
 * @version 1.0.0
 */
class TeamRepository extends Repository
{
    /**
     * Method to build a new object of TeamRepository.
     * @return TeamRepository The created object of TeamRepository.
     * @since 1.0.0
     * @uses TeamMapper::build() to get the connection to the database.
     */
    public static function build()
    {
        return new self(TeamMapper::build());
    }

    /**
     * Method to find all Team Entities.
     * @return array An array with all found Team Entities.
     * @since 1.0.0
     */
    public function findAll()
    {
        //check if a TeamMapper is available.
        if (!($this->dataMapper instanceof TeamMapper)) {
            return [];
        } else {
            return $this->findAllEntities(get_class($this->dataMapper));
        }
    }

    /**
     * Method to find Team Entities by Clan Entity.
     * @param Clan $clan The Clan Entity to find the Team Entities.
     * @return array An array with all found Team Entities.
     * @since 1.0.0
     */
    public function findByClan(Clan $clan)
    {
        //check if a TeamMapper is available.
        if (!($this->dataMapper instanceof TeamMapper)) {
            return [];
        }

        //create the condition and return the result.
        $condition = 'id IN (SELECT team_id FROM clan_team WHERE clan_id = '.$clan->id.')';
        return $this->dataMapper->find($condition);
    }

    /**
     * Method to find Team Entities by ID.
     * @param int $id The ID to find the Team Entities.
     * @return array An array with all found Team Entities.
     * @since 1.0.0
     */
    public function findByID($id)
    {
        //check if a TeamMapper is available.
        if (!($this->dataMapper instanceof TeamMapper)) {
            return [];
        } else {
            return $this->findEntityByID($id, get_class($this->dataMapper));
        }
    }

    /**
     * Method to find Team Entities by name.
     * @param string $name The name to find the Team Entities.
     * @return array An array with all found Team Entities.
     * @since 1.0.0
     */
    public function findByName($name)
    {
        //check if a TeamMapper is available.
        if (!($this->dataMapper instanceof TeamMapper)) {
            return [];
        }

        //check if the parameter is an array.
        if (is_array($name)) {
            $condition = "name IN ('".implode("', '", $name)."')";
        } else {
            $condition = "name = '".$name."'";
        }

        //return the result of the TeamMapper.
        return $this->dataMapper->find($condition);
    }

    /**
     * Method to find Team Entities by tag.
     * @param string $tag The tag to find the Team Entities.
     * @return array An array with all found Team Entities.
     * @since 1.0.0
     */
    public function findByTag($tag)
    {
        //check if a TeamMapper is available.
        if (!($this->dataMapper instanceof TeamMapper)) {
            return [];
        }

        //check if the parameter is an array.
        if (is_array($tag)) {
            $condition = "tag IN ('".implode("', '", $tag)."')";
        } else {
            $condition = "tag = '".$tag."'";
        }

        //return the result of the TeamMapper.
        return $this->dataMapper->find($condition);
    }

    /**
     * Method to find Team Entities by website.
     * @param string $website The website to find the Team Entities.
     * @return array An array with all found Team Entities.
     * @since 1.0.0
     */
    public function findByWebsite($website)
    {
        //check if a TeamMapper is available.
        if (!($this->dataMapper instanceof TeamMapper)) {
            return [];
        }

        //check if the parameter is an array.
        if (is_array($website)) {
            $condition = "website IN ('".implode("', '", $website)."')";
        } else {
            $condition = "website = '".$website."'";
        }

        //return the result of the TeamMapper.
        return $this->dataMapper->find($condition);
    }

    /**
     * Method to find a Team Entity by unique parameters.
     * @param string $tag The tag to find the Team Entity.
     * @param string $name The name to find the Team Entity.
     * @return array An array with all found Team Entities.
     * @since 1.0.0
     */
    public function findUnique($tag, $name)
    {
        //check if a TeamMapper is available.
        if (!($this->dataMapper instanceof TeamMapper)) {
            return [];
        }

        //create the condition and return the result.
        $condition = "tag = '".$tag."' AND name = '".$name."'";
        return $this->dataMapper->find($condition);
    }

    /**
     * Method to find Team Entities by a User Entity.
     * @param User $user The User Entity to find the Team Entities.
     * @return array An array with all found Team Entities.
     * @since 1.0.0
     */
    public function findByUser(User $user)
    {
        //check whether a TeamMapper is available.
        if (!($this->dataMapper instanceof  TeamMapper)) {
            return [];
        }

        //create the condition and return the result.
        $condition = "id IN (SELECT team_id FROM team_user WHERE user_id = ".$user->id.")";
        return $this->dataMapper->find($condition);
    }
}
