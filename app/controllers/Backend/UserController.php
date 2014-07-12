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
use User;

class UserController extends AdminController {

    /**
     * Display a listing of the users.
     * @return Response
     */
    public function index()
    {
        $users = Sentry::findAllUsers();
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
            // dd($input);

            $validator = User::validate_registration($input);

            if ($validator->passes()) {
                $photo = User::upload_photo($input['photo']);
                $user = Sentry::createUser(array(
                        'username'   => $input['username'],
                        'email'      => $input['email'],
                        'password'   => $input['password'],
                        'photo'      => $photo,
                        'first_name' => $input['first_name'],
                        'last_name'  => $input['last_name'],
                        'activated'  => 1,
                ));

                // Assign user groups
                $userGroup = Sentry::findGroupById($input['user-group']);
                $user->addGroup($userGroup);

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
                                ->with('error_message', "The user {$input['username']} wasn't created.");
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
        $user = Sentry::findUserById($id);
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
            // dd($input);

            $validator = User::validate_change($input, $id);
            if ($validator->passes()) {
                // Find the user using the user id
                $user = Sentry::findUserById($id);

                $photo = User::upload_photo($input['photo'], $id);
                // Update the user details
                $user->username = $input['username'];
                $user->email    = $input['email'];
                if ($input['password'] != '') {
                    $user->password   = $input['password'];
                }
                $user->photo      = $photo;
                $user->first_name = $input['first_name'];
                $user->last_name  = $input['last_name'];

                // Update the user
                if ($user->save()) {
                    // Only if user-group selection is present or profile is not being edited
                    if (isset($input['user-group']) && !\Str::contains(\URL::previous(), '/profiles/')) {
                        // Remove previous groups
                        foreach (Sentry::findAllGroups() as $group) {
                            $user->removeGroup($group);
                        }
                        // Assign user groups
                        $userGroup = Sentry::findGroupById($input['user-group']);
                        $user->addGroup($userGroup);
                    }

                    return Redirect::to($redirect_to)
                                        ->with('success_message', "User information was updated.");
                } else {
                    return Redirect::to($redirect_to)
                                        ->with('error_message', "User information was not updated.");
                }

            } else {
                // Form validation failed
                return Redirect::back()
                                    ->withInput()
                                    ->withErrors($validator);
            }
        } catch (Exception $e) {
            return Redirect::to($redirect_to)
                                ->with('error_message', "User information was not updated.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id=null)
    {
        try {
            // If multiple ids are specified
            if ($id == 'multiple') {
                $selected_ids = trim(Input::get('selected_ids'));
                if ($selected_ids == '') {
                    return Redirect::back()
                                    ->with('error_message', "Nothing was selected to delete");
                }
                $selected_ids = explode(' ', $selected_ids);
            } else {
                $selected_ids = array($id);
            }

            foreach ($selected_ids as $id) {
                // Find the user using the user id
                $user = Sentry::findUserById($id);
                if ($id == current_user()->id) {
                    return Redirect::to($this->link_type . '/users')
                                    ->with('error_message', 'You can not delete yourself.');
                }
                $user->delete();
            }

            $wasOrWere = (count($selected_ids) > 1) ? 's were' : ' was';
            $message = 'The user' . $wasOrWere . ' deleted.';

            return Redirect::to($this->link_type . '/users')
                                ->with('success_message', $message);

        } catch (\CartalystSentryUsersUserNotFoundException $e)
        {
            return Redirect::to($this->link_type . '/users')
                                ->with('error_message', 'User was not found.');
        }
    }

    public function activate($id)
    {
        try {
            // Find the user using the user id
            $throttle = Sentry::findThrottlerByUserId($id);

            // UnBan the user
            $throttle->UnBan();

            return Redirect::to($this->link_type . '/users')
                                    ->with('success_message', "User was activated.");
        } catch (CartalystSentryUsersUserNotFoundException $e) {
            return Redirect::to($this->link_type . '/users')
                                ->with('error_message', 'User was not found.');
        }
    }

    public function deactivate($id)
    {
        if ($id == current_user()->id) {
            return Redirect::to($this->link_type . '/users')
                            ->with('error_message', 'You can not deactivate yourself.');
        }
        try {
            // Find the user using the user id
            $throttle = Sentry::findThrottlerByUserId($id);

            // Ban the user
            $throttle->ban();

            return Redirect::to($this->link_type . '/users')
                                    ->with('success_message', "User was deactivated.");
        } catch (CartalystSentryUsersUserNotFoundException $e) {
            return Redirect::to($this->link_type . '/users')
                                ->with('error_message', 'User was not found.');
        }
    }
}
