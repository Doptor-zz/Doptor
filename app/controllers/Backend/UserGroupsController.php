<?php namespace Backend;
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
use UserGroup;

class UserGroupsController extends AdminController {

    /**
     * Display a listing of the user groups.
     *
     * @return Response
     */
    public function index()
    {

        $this->layout->title = 'All User Groups';
        $user_groups = \Sentry::findAllGroups();
        // dd($user_groups);
        $this->layout->content = \View::make('backend.'.$this->current_theme.'.user_groups.index')
                                    ->with('user_groups', $user_groups);
    }

    /**
     * Show the form for creating a new user groups.
     *
     * @return Response
     */
    public function create()
    {

        $this->layout->title = 'Create New User Group';
        $this->layout->content = \View::make('backend.'.$this->current_theme.'.user_groups.create_edit')
                                        ->with('access_areas', UserGroup::access_areas());
    }

    /**
     * Store a newly created user groups in storage.
     *
     * @return Response
     */
    public function store()
    {

        try {
            $input = \Input::all();

            $validator = \Group::validate($input);

            if ($validator->passes()) {
                $permissions = UserGroup::set_permissions();

                $group = \Sentry::createGroup(array(
                    'name'        => $input['name'],
                    'permissions' => $permissions,
                ));

                return \Redirect::to('backend/user-groups')
                                    ->with('success_message', "The user group {$input['name']} was created.");
            } else {
                // Form validation failed
                return \Redirect::back()
                                    ->withInput()
                                    ->withErrors($validator);
            }
        } catch (\Exception $e) {
            return \Redirect::back()
                                ->with('error_message', "The user group {$input['name']} wasn't created.");
        }
    }

    /**
     * Display the specified user groups.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {

        $this->layout->title = 'All User Groups';
        $this->layout->content = \View::make('backend.'.$this->current_theme.'.user_groups.show');
    }

    /**
     * Show the form for editing the specified user groups.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user_group = \Sentry::findGroupById($id);

        if ($user_group->hasAccess('superuser') && !current_user()->hasAccess('superuser')) {
            return \App::abort(401);
        }
        $this->layout->title = 'Edit User Group';
        $this->layout->content = \View::make('backend.'.$this->current_theme.'.user_groups.create_edit')
                                        ->with('access_areas', UserGroup::access_areas())
                                        ->with('user_group', $user_group);
    }

    /**
     * Update the specified user groups in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {

        try {
            $input = \Input::all();

            $validator = \Group::validate($input, $id);

            if ($validator->passes()) {
                $group = \Sentry::findGroupById($id);

                $permissions = UserGroup::set_permissions();
                // dd($permissions);
                $group->name = $input['name'];
                $group->permissions = $permissions;

                // Update the group
                if ($group->save()) {
                    return \Redirect::to('backend/user-groups')
                                    ->with('success_message', "The user group {$input['name']} was updated.");
                } else {
                    return \Redirect::to('backend/user-groups')
                                    ->with('error_message', "The user group {$input['name']} wasn't updated.");
                }

            } else {
                // Form validation failed
                return \Redirect::back()
                                    ->withInput()
                                    ->withErrors($validator);
            }
        } catch (\Exception $e) {
            return \Redirect::back()
                                ->with('error_message', "The user group {$input['name']} wasn't updated.");
        }
    }

    /**
     * Remove the specified user groups from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {


        try {
            // Find the group using the group id
            $group = \Sentry::findGroupById($id);

            $users = \Sentry::findAllUsersInGroup($group);

            if ($users->count() > 0) {
                return \Redirect::to('backend/user-groups')
                                ->with('error_message', "Some users are associated with the selected user group. <br> First change the user group of those users or delete those users.");
            }

            // Delete the group
            if ($group->delete()) {
                return \Redirect::to('backend/user-groups')
                                ->with('success_message', "The user group was deleted.");
            } else {
                return \Redirect::to('backend/user-groups')
                                ->with('error_message', "The user group couldn't be deleted.");
            }
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            return \Redirect::back()
                                ->with('error_message', 'Group was not found.');
        }
    }
}
