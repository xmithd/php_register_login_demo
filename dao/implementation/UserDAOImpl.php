<?php

/**
 * Created by IntelliJ IDEA.
 * User: link
 * Date: 2016-05-17
 * Time: 9:02 PM
 */
class UserDAOImpl implements UserDAO
{

    private $conn;

    public function __construct(PDO $connection)
    {
        $this->conn = $connection;
    }

    /**
     * @param string $namelike
     * @return an array of UserEntities whose display name is such and such
     */
    function getUsersByNameLike(string $namelike)
    {
        $stmt = $this->conn->prepare('SELECT user_id, email, display_name 
        FROM USER_ACCOUNTS
        WHERE display_name LIKE :name');
        $param = '%'. $namelike .'%';
        $stmt->bindParam(':name', $param);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return array_map(function ($it) {
            $user = new UserEntity();
            $user->setId($it['user_id']);
            $user->setDisplayName($it['display_name']);
            $user->setEmail($it['email']);
            return $user;
        }, $results);
    }

    /**
     * Saves user in the database
     * @param UserEntity $user
     * @return the UserEntity with the correct id? null if the save fails.
     */
    function saveUser(UserEntity $user, string $hashedPwd)
    {
        // TODO validation?
        $stmt = $this->conn->prepare("INSERT INTO USER_ACCOUNTS (email, display_name, password)
        VALUES(:email,:display_name, :pwd)
        ");
        $stmt->bindParam(':email', $user->getEmail());
        $stmt->bindParam(':display_name', $user->getDisplayName() );
        $stmt->bindParam(':pwd', $hashedPwd );
        $stmt->execute();
        return true;
    }

    /**
     * @param int $id
     * @return the user with that id or null if it doesn't exist
     */
    function getUserById(int $id)
    {
        $stmt = $this->conn->prepare('SELECT * from USER_ACCOUNTS WHERE user_id = :id');
        $stmt->bindParam(':id', $id );
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row) {
            $user = new UserEntity();
            $user->setId($id);
            $user->setDisplayName($row['display_name']);
            $user->setEmail($row['email']);
            return $user;
        } else {
            return false;
        }
    }

    /**
     * @param string $email
     * @return the user and password map. keys: ['user', 'hashed_pwd']
     */
    function getUserByEmail(string $email)
    {
        $stmt = $this->conn->prepare('SELECT user_id, display_name, email, password from USER_ACCOUNTS WHERE email = :email');
        $stmt->bindParam(':email', $email );
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row) {
            $user = new UserEntity();
            $user->setId($id);
            $user->setDisplayName($row['display_name']);
            $user->setEmail($row['email']);
            return array(
                'user' => $user,
                'hashed_pwd' => $row['password']
            );
        } else {
            return false;
        } 
    }

    /**
     * @param UserEntity $user needs to have the id of the user to update
     * @return mixed
     */
    function updateUser(UserEntity $user)
    {
        $stmt = $this->conn->prepare('UPDATE USER_ACCOUNTS SET
        email = :email, display_name = :display_name 
        WHERE user_id = :user_id');
        $new_email = $user->getEmail();
        $new_display_name = $user->getDisplayName();
        $stmt->bindParam(':email', $new_email);
        $stmt->bindParam(':display_name', $new_display_name );
        $stmt->bindParam(':user_id', $user->getId());
        $stmt->execute();
        return true;
    }

    /**
     * @param UserEntity $user
     * @param string $new_hashed_pwd
     * @return mixed
     */
    function updatePassword(UserEntity $user, string $new_hashed_pwd) {
        $stmt = $this->conn->prepare('UPDATE USER_ACCOUNTS SET
        password = :password 
        WHERE user_id = :user_id');
        $stmt->bindParam(':password', $new_hashed_pwd);
        $stmt->bindParam(':user_id', $user->getId());
        $stmt->execute();
        return true;
    }

    /**
     * @param int $id
     * @return true if the user from the database.
     */
    function deleteUser(int $id)
    {
        $stmt = $this->conn->prepare('DELETE FROM USER_ACCOUNTS WHERE user_id = :user_id');
        $stmt->bindParam(':user_id', $id);
        $stmt->execute();
        return true;
    }
}