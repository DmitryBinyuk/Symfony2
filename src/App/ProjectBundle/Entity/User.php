<?php //
namespace App\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Sonata\UserBundle\Entity\User as FosUser;

/**
 * User
 * @ORM\Entity
 * @ORM\Table(name="fos_user_user")
 */
class User extends FosUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    
    public function setFirstname($firstname) {
        parent::setFirstname($firstname);
    }
    
    public function setLastname($lastname) {
        parent::setLastname($lastname);
    }
}