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
class User extends Eloquent {

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     * @var array
     */
    protected $hidden = array('password');

    // Path in the public folder to upload image and its corresponding thumbnail
    public static $images_path = 'uploads/users/';

    /**
     * All the groups that the user lies in
     * @param  SentryUser $user
     * @return string
     */
    public static function user_groups($user)
    {
        $ret = '';
        foreach ($user->getGroups() as $user) {
            $ret .= $user->name;
        }
        return $ret;
    }

    public static function validator($input, $rules)
    {
        // Validate the inputs
        $validator = Validator::make($input, $rules);

        return $validator;
    }

    public static function validate_registration($input)
    {
        $rules = array(
            'username'              => 'alpha_spaces|required|min:4|unique:users,username',
            'email'                 => 'required|min:4|email|unique:users,email',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'first_name'            => 'required|min:3',
            'last_name'             => 'required|min:3'
        );

        return User::validator($input, $rules);
    }

    public static function validate_change($input, $id)
    {
        $rules = array(
            'username'              => 'alpha_spaces|required|min:4|unique:users,username,'.$id,
            'email'                 => 'required|min:4|email|unique:users,email,'.$id,
            'password'              => 'min:6|confirmed|confirmed',
            'password_confirmation' => 'min:6',
            'first_name'            => 'required|min:3',
            'last_name'             => 'required|min:3'
        );

        return User::validator($input, $rules);
    }

    public static function validate_reset($input)
    {
        $rules = array(
                    'email' => 'required|email|min:4'
            );

        return User::validator($input, $rules);
    }

    /**
     * Upload profile photo of user
     * @param  File $file Input file
     * @param  integer $id   User ID (if editing)
     * @return string       File Path
     */
    public static function upload_photo($file, $id=null)
    {
        // Only if a file is selected
        if ($file) {
            if (Input::hasFile('photo')) {
                File::exists(public_path() . '/uploads/') || File::makeDirectory(public_path() . '/uploads/');
                File::exists(public_path() . '/' . static::$images_path) || File::makeDirectory(public_path() . '/' . static::$images_path);

                $file_name = $file->getClientOriginalName();
                $image = Image::make($file->getRealPath());

                if ($id) {
                    // If user is being edited, delete old image
                    $old_image = Sentry::findUserById($id)->photo;
                    File::exists($old_image) && File::delete($old_image);
                }

                $image->fit(128, 128)
                        ->save(static::$images_path . $file_name);

            } else {
                $file_name = $file;
            }

            return $file_name;
        } else {
            if ($id) {
                return Sentry::findUserById($id)->photo;
            }
        }
    }

    /**
     * Get the user group that the user lies in
     * @return integer
     */
    public static function user_group($user)
    {
        $groups = $user->getGroups();

        return $groups[0]->id;
    }

    public static function isBanned($id)
    {
        $throttle = Sentry::findThrottlerByUserId($id);

        if($throttle->isBanned()) {
            // User is Banned
            return true;
        } else {
            // User is not Banned
            return false;
        }
    }

}
