<?php
/**
 * Namespace for all Controller of Clanify.
 * @package Clanify\Controller
 * @since 0.0.1-dev
 */
namespace Clanify\Controller;

use Clanify\Core\API\ProjectHoneypot;
use Clanify\Core\Controller;
use Clanify\Core\View;
use Clanify\Domain\Entity\User;
use Clanify\Application\Service\AuthenticationService;
use Clanify\Domain\Specification\User\IsValidPassword;
use Clanify\Domain\Specification\User\IsValidUsername;
use Clanify\Core\Log\LogLevel;

/**
 * Class LoginController
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2016 Clanify <http://clanify.rocks>
 * @license GNU General Public License, version 3
 * @package Clanify\Controller
 * @version 0.0.1-dev
 */
class LoginController extends Controller
{
    /**
     * The index (default) action of the Login.
     * @since 0.0.1-dev
     */
    public function index()
    {
        $view = new View('Login');
        $view->load();
    }

    /**
     * The login action of the Login.
     * @since 0.0.1-dev
     */
    public function login()
    {
        //get the user from the login form.
        $user = new User();
        $user->loadFromPOST('login_');

        //check if the username is valid.
        if ((new IsValidUsername())->isSatisfiedBy($user) === false) {
            $this->jsonOutput('The username is not valid!', 'login_username', LogLevel::ERROR);
            return false;
        }

        //check if the password is valid.
        if ((new IsValidPassword())->isSatisfiedBy($user) === false) {
            $this->jsonOutput('The password is not valid!', 'login_password', LogLevel::ERROR);
            return false;
        }

        //check if the ID is trusted.
        if (PROJECT_HONEYPOT_KEY !== '') {
            if (filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                if ((new ProjectHoneypot(PROJECT_HONEYPOT_KEY))->check($_SERVER['REMOTE_ADDR'])) {
                    $this->jsonOutput('The IP you are using is not trusted!', '', LogLevel::ERROR);
                    return false;
                }
            }
        }

        //try to login the User.
        if ((new AuthenticationService())->login($user)) {
            $this->jsonOutput('The User could be logged in!', '', LogLevel::INFO, URL.'dashboard');
            return true;
        } else {
            $this->jsonOutput('The User could not be logged in!', '', LogLevel::ERROR);
            return false;
        }
    }
}
