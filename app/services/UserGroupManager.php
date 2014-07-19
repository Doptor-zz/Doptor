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
use Str;

use Cartalyst\Sentry\Groups\GroupNotFoundException;
use Sentry;

use UserGroup;

class UserGroupManager {

    /**
     * Find all user groups
     * @return mixed
     */
    public function findAllGroups()
    {
        return Sentry::findAllGroups();
    }

    /**
     * Find a user group by id
     * @param $id
     * @return mixed
     */
    public function findGroupById($id)
    {
        return Sentry::findGroupById($id);
    }

    /**
     * Get a list of all user groups
     * @param  string $value Value
     * @param  key $key Key
     * @return array
     */
    public function groupLists($value, $key = null)
    {
        $groups = array();
        foreach (Sentry::findAllGroups() as $group) {
            if ($key) {
                $groups[$group->{$key}] = $group->{$value};
            } else {
                $groups[] = $group->{$value};
            }
        }
        return $groups;
    }

    /**
     * Create a new user group
     * @param array $input
     * @return mixed
     */
    public function createUserGroup($input = array())
    {
        $permissions = $this->setPermissions($input);

        return Sentry::createGroup(array(
            'name'        => $input['name'],
            'permissions' => $permissions
        ));
    }

    /**
     * Update an existing user group
     * @param $id
     * @param array $input
     * @return mixed
     */
    public function updateUserGroup($id, $input = array())
    {
        $group = Sentry::findGroupById($id);

        $permissions = $this->setPermissions($input);

        $group->name = $input['name'];
        $group->permissions = $permissions;

        // Update the group
        return $group->save();
    }

    /**
     * Delete an existing user group
     * @param $id
     * @return mixed|void
     * @throws Exception
     */
    public function deleteUserGroup($id)
    {
        try {
            // Find the group using the group id
            $group = Sentry::findGroupById($id);

            $users = Sentry::findAllUsersInGroup($group);

            if ($users->count() > 0) {
                throw new Exception('Some users are associated with the selected user group.
                First change the user group of those users or delete those users.');
            }

            // Delete the group
            $group->delete();
        } catch (GroupNotFoundException $e) {
            throw new Exception('Group was not found.');

        }
    }

    /**
     * Set permissions on group
     * @param $input
     * @return array
     */
    public function setPermissions($input)
    {
        if (isset($input['superuser'])) {
            // If superuser permissions, then no need to assign any other permissions
            $permissions = array('superuser' => 1);
        } else {
            $permissions = array('superuser' => 0);
            $permissions['backend'] = (isset($input['backend'])) ? 1 : 0;
            $access_areas = UserGroup::access_areas();
            foreach ($access_areas['resourceful'] as $abbr => $full) {
                $permissions[$abbr . '.index'] = (isset($input["{$abbr}_index"])) ? 1 : 0;
                $permissions[$abbr . '.show'] = (isset($input["{$abbr}_show"])) ? 1 : 0;
                $permissions[$abbr . '.create'] = (isset($input["{$abbr}_create"])) ? 1 : 0;
                $permissions[$abbr . '.edit'] = (isset($input["{$abbr}_edit"])) ? 1 : 0;
                $permissions[$abbr . '.destroy'] = (isset($input["{$abbr}_destroy"])) ? 1 : 0;
            }

            foreach ($access_areas['others'] as $name => $all_permissions) {
                foreach ((array)$all_permissions as $permission => $desc) {
                    $permissions["{$name}.{$permission}"] = (isset($input["{$name}_{$permission}"])) ? 1 : 0;
                }
            }

            foreach ($access_areas['modules'] as $alias => $name) {
                $alias_lower = Str::lower($alias);
                $permissions["modules.{$alias_lower}.index"] = (isset($input["modules_{$alias}_index"])) ? 1 : 0;
                $permissions["modules.{$alias_lower}.show"] = (isset($input["modules_{$alias}_show"])) ? 1 : 0;
                $permissions["modules.{$alias_lower}.create"] = (isset($input["modules_{$alias}_create"])) ? 1 : 0;
                $permissions["modules.{$alias_lower}.edit"] = (isset($input["modules_{$alias}_edit"])) ? 1 : 0;
                $permissions["modules.{$alias_lower}.destroy"] = (isset($input["modules_{$alias}_destroy"])) ? 1 : 0;
            }
        }

        return $permissions;
    }
}
