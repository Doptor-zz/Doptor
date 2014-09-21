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

use App, Exception, Input, Redirect, View;
use Sentry;

use Services\UserManager;
use Services\UserGroupManager;
use User;

class UserController extends AdminController {

    protected $user_manager;
    protected $usergroup_manager;

    public function __construct(UserManager $user_manager, UserGroupManager $usergroup_manager)
    {
        $this->user_manager = $user_manager;
        $this->usergroup_manager = $usergroup_manager;

        parent::__construct();
    }

    /**
     * Display a listing of the users.
     * @return Response
     */
    public function index()
    {
        $users = $this->user_manager->findAllUsers();
        // dd($users);
        $this->layout->title = 'All Users';
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.users.index')
                                    ->with('users', $users);
    }

    /**
     * Show the form for creating a new user.
     * @return Response
     */
    public function create()
    {
        $this->layout->title = 'Create New User';
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.users.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     * @return Response
     */
    public function store()
    {
        try {
            $input = Input::all();

            $validator = User::validate_registration($input);

            if ($validator->passes()) {
                // Create user and add to selected user group
                $user = $this->user_manager->createUser($input);

                if ($input['status'] == 1) {
                    $this->user_manager->activateUser($user->id);
                } else {
                    $this->user_manager->deactivateUser($user->id);
                }

                return Redirect::back()
                                ->with('success_message', "The user {$input['username']} was created.");
            } else {
                // Form validation failed
                return Redirect::back()
                                    ->withInput()
                                    ->withErrors($validator);
            }
        } catch (Exception $e) {
            return Redirect::back()
                                ->with('error_message', "The user {$input['username']} wasn't created. {$e->getMessage()}");
        }
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = Sentry::findUserById($id);

        $this->layout->title = 'User Information';
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.users.show')
                                        ->with('user', $user);
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->user_manager->findUserById($id);
        $this->layout->title = 'Edit User';
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.users.create_edit')
                                        ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        if (!($this->user->hasAccess('users.edit') || Sentry::getUser()->id == $id)) App::abort('401');

        try {
            if (current_user()->id != $id ) {
                $redirect_to = $this->link_type . '/users';
            } else {
                // Redirect users without user editing privilege to their profile
                $redirect_to = $this->link_type . '/profile';
            }
            $input = Input::all();

            $validator = User::validate_change($input, $id);
            if ($validator->passes()) {
                // Update the current user
                $this->user_manager->updateUser($id, $input);

                if (isset($input['status'])) {
                    // Don not change the user status during profile update
                    if ($input['status'] == 1) {
                        $this->user_manager->activateUser($id);
                    } else {
                        $this->user_manager->deactivateUser($id);
                    }
                }

                return Redirect::to($redirect_to)
                    ->with('success_message', "The user {$input['username']} was updated.");

            } else {
                // Form validation failed
                return Redirect::back()
                                    ->withInput()
                                    ->withErrors($validator);
            }
        } catch (Exception $e) {
            return Redirect::to($redirect_to)
                                ->with('error_message', "User information was not updated. {$e->getMessage()}");
        }
    }

    public function getChangePassword()
    {
        $this->layout->title = 'Change User Password';
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.users.change_pw');
    }

    public function putChangePassword()
    {
        $input = Input::all();

        $validator = User::validate_pw_change($input);
        if ($validator->passes()) {
            $user = current_user();
            $user->password = $input['password'];
            $user->last_pw_changed = date('Y-m-d h:i:s');
            $user->save();

            return Redirect::to($this->link_type)
                ->with('success_message', "The user password was updated.");

        } else {
            // Form validation failed
            return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
        }
    }
    /**
     * Remove the specified user.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id=null)
    {
        try {
            $message = $this->user_manager->deleteUser($id);

            return Redirect::to("{$this->link_type}/users")
                ->with('success_message', $message);
        } catch (Exception $e) {
            return Redirect::back()->withInput()->with('error_message', $e->getMessage());
        }
    }

    /**
     * Activate the specified user
     *
     * @param  int $id User ID
     * @return Redirect
     */
    public function activate($id)
    {
        try {
            $this->user_manager->activateUser($id);

            return Redirect::to("{$this->link_type}/users")
                ->with('success_message', "User was activated.");
        } catch (Exception $e) {
            return Redirect::back()->withInput()->with('error_message', $e->getMessage());
        }
    }

    /**
     * Deactivate the specified user
     *
     * @param  int $id User ID
     * @return Redirect
     */
    public function deactivate($id)
    {
        try {
            $this->user_manager->deactivateUser($id);

            return Redirect::to("{$this->link_type}/users")
                ->with('success_message', "User was deactivated.");
        } catch (Exception $e) {
            return Redirect::back()->withInput()->with('error_message', $e->getMessage());
        }
    }
}
