<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 24/5/2014
 * Time: 9:35 μμ
 */

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package User\Entity
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", length=5, name="user_id")
     */
    private $userId;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime", name="create_time", nullable=true)
     */
    private $createTime;

    /**
     * Check if the user's password is the same as the provided one.
     *
     * @param User $user
     * @param string $password
     * @return bool
     */
    public static function verifyPassword($user, $password)
    {
        return password_verify($password, $user->getPassword());
    }

    /**
     * Get the bcrypt hash of the provided password.
     *
     * @param string $password
     * @return string
     */
    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT, array('cost' => 11));
    }

    /**
     * @param mixed $createTime
     */
    public function setCreateTime($createTime)
    {
        if(!$createTime instanceof \DateTime){
            $createTime = new \DateTime($createTime);
        }
        $this->createTime = $createTime;
    }

    /**
     * @return mixed
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }


} 