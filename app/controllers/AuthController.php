<?php
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

use Services\UserManager;
use Services\UserGroupManager;

class AuthController extends BaseController {

    protected $user_manager;
    protected $usergroup_manager;

    public function __construct(UserManager $user_manager, UserGroupManager $usergroup_manager)
    {
        $this->user_manager = $user_manager;
        $this->usergroup_manager = $usergroup_manager;

        parent::__construct();
    }

    /**
     * View for the login page
     * @return View
     */
    public function getLogin($target='admin')
    {
        if (Sentry::check()) {
            return Redirect::to($target);
        }
        $this->layout = View::make($target . '.'.$this->current_theme.'._layouts._login');
        $this->layout->title = 'Login';
        $this->layout->content = View::make($target . '.'.$this->current_theme.'.login');
    }

    /**
     * Login action
     * @return Redirect
     */
    public function postLogin($target='admin')
    {
        $input = Input::all();

        $credentials = array(
            'username' => $input['username'],
            'password' => $input['password']
        );

        $remember = (isset($input['remember']) && $input['remember'] == 'checked') ? true : false;

        try {
            $user = Sentry::authenticate($credentials, $remember);

            if ($user) {
                if (isset($input['api'])) {
                    return Response::json(array(), 200);
                } else {
                    return Redirect::intended($target);
                }
            }
        } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            if (isset($input['api'])) {
                return Response::json(array(
                                        'error' => trans('cms.check_activation_email')
                                        ), 200);
            } else {
                return Redirect::back()
                                    ->withErrors(trans('cms.check_activation_email'));
            }
        } catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            if (isset($input['api'])) {
                return Response::json(array(
                                        'error' => trans('cms.account_suspended', array('minutes' => 10))
                                        ), 200);
            } else {
                return Redirect::back()
                                    ->withErrors(trans('cms.account_suspended', array('minutes' => 10)));
            }
        } catch(Exception $e) {
            if (isset($input['api'])) {
                return Response::json(array(
                                        'error' => trans('cms.invalid_username_pw')
                                        ), 200);
            } else {
                return Redirect::back()
                                    ->withErrors(trans('cms.invalid_username_pw'));
            }
        }
    }

    /**
     * Logout action
     * @return Redirect
     */
    public function getLogout()
    {
        Sentry::logout();

        return Redirect::to('/');
    }

    public function postForgotPassword()
    {
        $input = Input::all();

        $validator = User::validate_reset($input);

        if ($validator->passes()) {
            $user = User::whereEmail($input['email'])->first();

            if ($user) {
                $user = Sentry::findUserByLogin($user->username);

                $resetCode = $user->getResetPasswordCode();

                $data = array(
                            'user_id'   => $user->id,
                            'resetCode' => $resetCode
                        );

                Mail::queue('backend.'.$this->current_theme.'.reset_password_email', $data, function($message) use($input, $user) {
                    $message->from(get_setting('email_username'), Setting::value('website_name'))
                            ->to($input['email'], "{$user->first_name} {$user->last_name}")
                            ->subject('Password reset ');
                });

                return Redirect::back()
                                   ->with('success_message', 'Password reset code has been sent to the email address. Follow the instructions in the email to reset your password.');
            } else {
                return Redirect::back()
                                ->with('error_message', 'No user exists with the specified email address');
            }
        } else {
            return Redirect::back()
                            ->withInput()
                            ->with('error_message', implode('<br>', $validator->messages()->get('email')));
        }
    }

    public function getResetPassword($id, $token, $target='backend')
    {
        if (Sentry::check()) {
            return Redirect::to($target);
        }
        try {
            $user = Sentry::findUserById($id);

            $this->layout = View::make($target . '.'.$this->current_theme.'._layouts._login');
            $this->layout->title = 'Reset Password';

            if ($user->checkResetPasswordCode($token)) {
                $this->layout->content = View::make($target . '.'.$this->current_theme.'.reset_password')
                                                ->with('id', $id)
                                                ->with('token', $token)
                                                ->with('target', $target)
                                                ->with('user', $user);
            } else {
                $this->layout->content = View::make($target . '.'.$this->current_theme.'.reset_password')
                                                ->withErrors(array(
                                                        'invalid_reset_code'=>'The provided password reset code is invalid'
                                                    ));
            }
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $this->layout->content = View::make($target . '.'.$this->current_theme.'.reset_password')
                                            ->withErrors('The specified user doesn\'t exist');
        }
    }

    public function postResetPassword()
    {
        $input = Input::all();

        try {
            $user = Sentry::findUserById($input['id']);

            if ($input['username'] != $user->username
                || $input['security_answer'] != $user->security_answer
                ) {
                return Redirect::back()
                                    ->withInput()
                                    ->with('error_message', 'Either the username or security answer is incorrect');
            }

            if ($user->checkResetPasswordCode($input['token'])) {
                if ($user->attemptResetPassword($input['token'], $input['password'])) {

                    $data = array(
                            'user_id'      => $user->id,
                            'created_at' => strtotime($user->created_at) * 1000
                        );

                    Mail::queue('backend.'.$this->current_theme.'.reset_password_confirm_email', $data, function($message) use($input, $user) {
                        $message->from(get_setting('email_username'), Setting::value('website_name'))
                                ->to($user->email, "{$user->first_name} {$user->last_name}")
                                ->subject('Password Reset Confirmation');
                    });

                    $user->last_pw_changed = date('Y-m-d h:i:s');
                    $user->save();

                    return Redirect::to("login/${input['target']}")
                                        ->with('success_message', 'Password reset is successful. Now you can log in with your new password');
                } else {
                    return Redirect::back()
                                    ->with('error_message', 'Password reset failed');
                }
            } else {
                return Redirect::back()
                                    ->withErrors(array(
                                            'invalid_reset_code'=>'The provided password reset code is invalid'
                                        ));
            }
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return Redirect::back()
                                ->with('error_message', 'The specified user doesn\'t exist');
        }
    }

    public function suspendUser($user_id, $created_at)
    {
        $user = Sentry::findUserById($user_id);

        if (strtotime($user->created_at) * 1000 == $created_at) {
            $this->user_manager->deactivateUser($user_id);

            return Redirect::to('login/backend')
                                ->with('success_message', 'The user has been suspended.');
        } else {
            return Redirect::to('login/backend')
                                ->with('error_message', 'The user cannot be suspended.');
        }
    }
}
