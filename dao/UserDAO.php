<?php

require_once '../entities/UserEntity.php';
/**
 * Interface for retrieving and saving user information
 * 
 */
interface UserDAO
{
    /**
     * @param string $namelike
     * @return an array of UserEntities whose display name is such and such
     */
    function getUsersByNameLike(string $namelike);

    /**
     * Saves user in the database
     * @param UserEntity $user
     * @return the UserEntity with the correct id? null if the save fails.
     */
    function saveUser(UserEntity $user, string $hashedPwd);

    /**
     * @param int $id
     * @return the user with that id or null if it doesn't exist
     */
    function getUserById(int $id);

    /**
     * @param string $email
     * @return the user and password map. keys: ['user', 'hashed_pwd']
     */
    function getUserByEmail(string $email);

    /**
     * @param UserEntity $user needs to have the id of the user to update
     * @return mixed
     */
    function updateUser(UserEntity $user);

    /**
     * @param UserEntity $user
     * @param string $new_hasehd_pwd
     * @return mixed
     */
    function updatePassword(UserEntity $user, string $new_hasehd_pwd);

    /**
     * @param int $id
     * @return deletes the user from the database.
     */
    function deleteUser(int $id);
}