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
use App, Input, Redirect, Request, Response, Sentry, Str, View, File;
use Menu, MenuCategory;

class MenuManagerController extends AdminController {

    /**
     * Display a listing of the menu entries.
     * @return Response
     */
    public function index()
    {
        $menu_entries = Menu::with('cat')
                        ->latest()
                        ->orderBy('parent', 'ASC')
                        ->orderBy('order', 'ASC')
                        ->orderBy('title', 'ASC')
                        ->get();

        $this->layout->title = 'Menu Manager';
        $this->layout->content = \View::make($this->link_type.'.'.$this->current_theme.'.menumanagers.index')
                                        ->with('menu_entries', $menu_entries);
    }

    /**
     * Show the form for creating a new menu entry.
     * @return Response
     */
    public function create()
    {
        $this->layout->title = 'Create New Menu Entry';
        $this->layout->content = \View::make($this->link_type.'.'.$this->current_theme.'.menumanagers.create_edit');
    }

    /**
     * Store a newly created menu entry in storage.
     * @return Response
     */
    public function store()
    {
        try {
            $input = Input::all();

            $groups = Input::get('access_groups', array());
            $alias = $input['position'] . '-' . Str::slug($input['title'], '-');
            $input['alias'] = ($input['alias']=='') ? $alias : $input['alias'];

            $validator = Menu::validate($input);

            if ($validator->passes()) {
                $menu = new Menu($input);
                $menu->save();

                $menu->groups()->sync($groups);

                if ($menu) {
                    return Redirect::to('backend/menu-manager')
                                        ->with('success_message', 'The menu entry was created.');
                } else {
                    return Redirect::to('backend/menu-manager')
                                        ->with('error_message', 'The menu entry wasn\'t created.');
                }
            } else {
                // Form validation failed
                return Redirect::back()
                                    ->withInput()
                                    ->withErrors($validator);
            }
        } catch (Exception $e) {
            return Redirect::to('backend/menu-manager')
                                ->with('error_message', 'The menu entry wasn\'t created.');
        }
    }

    /**
     * Display the specified menu entry.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $this->layout->title = '';
        $this->layout->content = \View::make($this->link_type.'.'.$this->current_theme.'.menumanagers.show');
    }

    /**
     * Show the form for editing the specified menu entry.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);

        $this->layout->title = 'Edit Existing Menu Entry';
        $this->layout->content = \View::make($this->link_type.'.'.$this->current_theme.'.menumanagers.create_edit')
                                        ->with('menu', $menu);
    }

    /**
     * Update the specified menu entry in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        try {
            $input = Input::all();
            $alias = $input['position'] . '-' . Str::slug($input['title'], '-');
            $input['alias'] = ($input['alias']=='') ? $alias : $input['alias'];
            $groups = Input::get('access_groups', array());
            // $input['parent'] = 0;   // Just for validation

            $validator = Menu::validate($input, $id);
            // unset($input['parent']);

            if ($validator->passes()) {
                $menu = Menu::findOrFail($id);

                if ($menu->update($input)) {
                    $menu->groups()->sync($groups);
                    if (Request::ajax()) {
                        return Response::json('The menu entry was updated.', 200);
                    } else {
                        return Redirect::to('backend/menu-manager')
                                            ->with('success_message', 'The menu entry was updated.');
                    }
                } else {
                    if (Request::ajax()) {
                        return Response::json('The menu entry wasn\'t updated.', 400);
                    } else {
                        return Redirect::to('backend/menu-manager')
                                            ->with('error_message', 'The menu entry wasn\'t updated.');
                    }
                }
            } else {
                // Form validation failed

                if (Request::ajax()) {
                    $errors = '<ul>' . implode('', $validator->getMessageBag()->all('<li>:message</li>')) . '</ul>';
                    return Response::json($errors, 400);
                } else {
                    return Redirect::back()
                                        ->withInput()
                                        ->withErrors($validator);
                }
            }
        } catch (Exception $e) {
            if (Request::ajax()) {
                return Response::json('The menu entry wasn\'t updated.', 400);
            } else {
                return Redirect::to('backend/menu-manager')
                                    ->with('error_message', 'The menu entry wasn\'t created.');
            }
        }
    }

    /**
     * Remove the specified menu entry from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id=null)
    {
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
            $menu = Menu::findOrFail($id);

            File::delete($menu->icon);

            $menu->delete();
        }

        if (count($selected_ids) > 1) {
            $message = 'The menu entries were successfully deleted';
        } else {
            $message = 'The menu entry was successfully deleted';
        }

        return Redirect::to('backend/menu-manager')
                                ->with('success_message', $message);
    }

}
