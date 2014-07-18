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
use App;
use Exception;
use Input;
use Redirect;
use View;

use Sentry;

use Group;
use Services\UserGroupManager;
use UserGroup;

class UserGroupsController extends AdminController {

    protected $usergroup_manager;

    public function __construct(UserGroupManager $usergroup_manager)
    {
        $this->usergroup_manager = $usergroup_manager;

        parent::__construct();
    }

    /**
     * Display a listing of the user groups.
     *
     * @return Response
     */
    public function index()
    {
        $this->layout->title = 'All User Groups';
        $user_groups = $this->usergroup_manager->findAllGroups();

        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.user_groups.index')
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
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.user_groups.create_edit')
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
            $input = Input::all();

            $validator = Group::validate($input);

            if ($validator->passes()) {
                $group = $this->usergroup_manager->createUserGroup($input);

                return Redirect::to('backend/user-groups')
                                    ->with('success_message', "The user group {$input['name']} was created.");
            } else {
                // Form validation failed
                return Redirect::back()
                                    ->withInput()
                                    ->withErrors($validator);
            }
        } catch (Exception $e) {
            return Redirect::back()
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
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.user_groups.show');
    }

    /**
     * Show the form for editing the specified user groups.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user_group = $this->usergroup_manager->findGroupById($id);

        if ($user_group->hasAccess('superuser') && !current_user()->hasAccess('superuser')) {
            return App::abort(401);
        }
        $this->layout->title = 'Edit User Group';
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.user_groups.create_edit')
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
            $input = Input::all();

            $validator = Group::validate($input, $id);

            if ($validator->passes()) {
                $group = $this->usergroup_manager->updateUserGroup($id, $input);

                return Redirect::to('backend/user-groups')
                                ->with('success_message', "The user group {$input['name']} was updated.");

            } else {
                // Form validation failed
                return Redirect::back()
                                    ->withInput()
                                    ->withErrors($validator);
            }
        } catch (Exception $e) {
            return Redirect::back()
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
            $message = $this->usergroup_manager->deleteUserGroup($id);

            return Redirect::to("{$this->link_type}/user-groups")
                ->with('success_message', $message);
        } catch (Exception $e) {
            return Redirect::to("{$this->link_type}/user-groups")
                ->with('error_message', $e->getMessage());
        }
    }
}
