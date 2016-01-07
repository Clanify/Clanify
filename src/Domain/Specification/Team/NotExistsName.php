<?php
/**
 * Namespace for all Specifications of Team.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification\Team;

use Clanify\Core\Database;
use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Entity\Team;
use Clanify\Domain\Repository\TeamRepository;
use Clanify\Domain\Specification\ISpecification;

/**
 * Class NotExistsName
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\Team
 * @version 0.0.1-dev
 */
class NotExistsName implements ISpecification
{
    /**
     * Method to check if the Team satisfies the Specification.
     * @param IEntity $team The Team which will be checked.
     * @return bool The state if the Team satisfies the Specification.
     * @since 0.0.1-dev
     */
    public function isSatisfiedBy(IEntity $team)
    {
        //check if the Entity is a Team.
        if ($team instanceof Team) {
            $database = Database::getInstance();
            $teamRepository = new TeamRepository($database->getConnection());

            //find the teams by name.
            $teams = $teamRepository->findByName($team->name);

            //check if a user was found and return the state.
            return (count($teams) > 0) ? false : true;
        } else {
            return false;
        }
    }
}