<?php namespace Services;
/*
=================================================
CMS Name  :  DOPTOR
CMS Version :  v1.2
Available at :  www.doptor.org
Copyright : Copyright (coffee) 2011 - 2014 Doptor. All rights reserved.
License : GNU/GPL, visit LICENSE.txt
Description :  Doptor is Opensource CMS.
===================================================
*/
use Exception;
use File;
use Image;
use Input;
use Sentry;
use Str;
use URL;

use Cartalyst\Sentry\Users\UserNotFoundException;
use User;


class UserManager {

    /**
     * Find all users
     * @return mixed
     */
    public function findAllUsers()
    {
        $users = Sentry::findAllUsers();
        foreach ($users as $user) {
            $user->user_groups = $this->getUserGroups($user, 'name');
            $user->is_banned = $this->isBanned($user->id);
        }

        return $users;
    }

    /**
     * Find a user by id
     * @param $id
     * @param string $group_field
     * @return mixed
     */
    public function findUserById($id, $group_field = 'id')
    {
        $user = Sentry::findUserById($id);
        $user->user_groups = $this->getUserGroups($user, $group_field);
        $user->is_banned = $this->isBanned($user->id);

        return $user;
    }

    /**
     * Create a new user
     * @param array $input
     * @return $user
     * @throws Exception
     */
    public function createUser($input = array())
    {
        $photo = (isset($input['photo']) && $input['photo']) ? $this->uploadImage($input['photo']) : '';

        $user = Sentry::createUser(array(
            'username'          => $input['username'],
            'email'             => $input['email'],
            'password'          => $input['password'],
            'photo'             => $photo,
            'first_name'        => $input['first_name'],
            'last_name'         => $input['last_name'],
            'security_question' => isset($input['security_question']) ? $input['security_question'] : '',
            'security_answer'   => isset($input['security_answer']) ? $input['security_answer'] : '',
            'auto_logout_time'  => $input['auto_logout_time'],
            'last_pw_changed'   => date('Y-m-d h:i:s'),
            'activated'         => 1,
        ));

        // Assign user groups
        $this->addUserToGroup($input['user-group'], $user);

        return $user;
    }

    /**
     * Update an existing user
     * @param $id
     * @param array $input
     * @return mixed|void
     * @throws Exception
     */
    public function updateUser($id, $input = array())
    {
        $input['id'] = $id;

        $user = Sentry::findUserById($id);

        $photo = (isset($input['photo']) && $input['photo']) ? $this->uploadImage($input['photo']) : $user->photo;
        // Update the user details
        $user->username = $input['username'];
        $user->email = $input['email'];
        if (isset($input['password']) && $input['password'] != '') {
            $user->password = $input['password'];
            $user->last_pw_changed = date('Y-m-d h:i:s');
        }
        $user->photo = $photo;
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        if (isset($input['security_question'])) {
            $user->security_question = $input['security_question'];
        }
        if (isset($input['security_answer'])) {
            $user->security_answer = $input['security_answer'];
        }
        $user->auto_logout_time = $input['auto_logout_time'];
        $user->save();

        if (isset($input['user-group']) && !Str::contains(URL::previous(), '/profiles/')) {
            // Remove previous groups
            foreach ($this->getUserGroups($user) as $group) {
                $user->removeGroup($group);
            }
            // Assign user groups
            $this->addUserToGroup($input['user-group'], $user);
        }
    }

    /**
     * Delete a user or multiple users
     * @param $id
     * @return mixed|void
     * @throws Exception
     */
    public function deleteUser($id)
    {
        try {
            // If multiple ids are specified
            if ($id == 'multiple') {
                $selected_ids = trim(Input::get('selected_ids'));
                if ($selected_ids == '') {
                    throw new Exception('Nothing was selected to delete.');
                }
                $selected_ids = explode(' ', $selected_ids);
            } else {
                $selected_ids = array($id);
            }

            if (in_array(current_user()->id, $selected_ids)) {
                throw new Exception('You can not delete yourself.');
            }

            foreach ($selected_ids as $id) {
                // Delete the user using the user id
                $user = Sentry::findUserById($id);
                $user->delete();
            }

            $wasOrWere = (count($selected_ids) > 1) ? 's were' : ' was';
            $message = 'The user' . $wasOrWere . ' deleted.';

            return $message;
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            throw new Exception('User was not found.');
        }
    }

    /**
     * Upload profile photo of user
     * @param  File $file Input file
     * @param  integer $id User ID (if editing)
     * @return string       File Path
     */
    public function uploadImage($file, $id = null)
    {
        if (gettype($file) === 'string') {
            return $file;
        }
        $images_path = User::$images_path;

        File::exists(public_path() . '/uploads/') || File::makeDirectory(public_path() . '/uploads/');
        File::exists(public_path() . '/' . $images_path) || File::makeDirectory(public_path() . '/' . $images_path);

        $file_name = $file->getClientOriginalName();

        $file_ext = File::extension($file_name);
        $only_fname = str_replace('.' . $file_ext, '', $file_name);

        // Add random characters to filename
        $file_name = $only_fname . '_' . str_random(8) . '.' . $file_ext;

        $image = Image::make($file->getRealPath());

        if ($id) {
            // If user is being edited, delete old image
            $old_image = Sentry::findUserById($id)->photo;
            File::exists($old_image) && File::delete($old_image);
        }

        $image->fit(128, 128)
            ->save($images_path . $file_name);

        return $images_path . '/' . $file_name;
    }

    /**
     * Get all the user groups that a user lies in
     * @param SentryUser $user The user
     * @param  string $value Value
     * @param  key $key Key
     * @return array
     */
    public function getUserGroups($user, $value = null, $key = null)
    {
        if (!$value) {
            // If no value is passed return Sentry Object
            return $user->getGroups();
        }
        $groups = array();
        foreach ($user->getGroups() as $group) {
            if ($key) {
                $groups[$group->{$key}] = $group->{$value};
            } else {
                $groups[] = $group->{$value};
            }
        }

        return $groups;
    }

    /**
     * Activate a user
     * @param $id User ID
     * @return mixed|void
     * @throws Exception
     */
    public function activateUser($id)
    {
        try {
            // Find the user using the user id
            $throttle = Sentry::findThrottlerByUserId($id);

            // UnBan the user
            $throttle->UnBan();
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            throw new Exception('User was not found.');
        }
    }

    /**
     * Deactivate a user
     * @param $id User ID
     * @return mixed|void
     * @throws Exception
     */
    public function deactivateUser($id)
    {
        if (current_user() && $id == current_user()->id) {
            throw new Exception('You can not deactivate yourself.');
        }
        try {
            // Find the user using the user id
            $throttle = Sentry::findThrottlerByUserId($id);

            // Ban the user
            $throttle->ban();
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            throw new Exception('User was not found.');
        }
    }

    /**
     * Check whether an user is banned or not
     * @param $id
     * @return bool
     */
    public function isBanned($id)
    {
        $throttle = Sentry::findThrottlerByUserId($id);

        if ($throttle->isBanned()) {
            // User is Banned
            return true;
        } else {
            // User is not Banned
            return false;
        }
    }

    /**
     * Add an user to an user group
     * @param $group_id
     * @param $user
     * @throws Exception
     */
    public function addUserToGroup($group_id, $user)
    {
        try {
            $userGroup = Sentry::findGroupById($group_id);
            $user->addGroup($userGroup);
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            throw new Exception('Group was not found.');
        }
    }
}
