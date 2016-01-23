<?php namespace Backend;
/*
=================================================
CMS Name  :  DOPTOR
CMS Version :  v1.2
Available at :  www.doptor.org
Copyright : Copyright (coffee) 2011 - 2015 Doptor. All rights reserved.
License : GNU/GPL, visit LICENSE.txt
Description :  Doptor is Opensource CMS.
===================================================
*/
class MenuPositionsController extends AdminController {

    /**
     * Display a listing of the menu positions.
     *
     * @return Response
     */
    public function index()
    {
        $menu_positions = \MenuPosition::latest()->get();

        $this->layout->title = 'All Menu Positions';
        $this->layout->content = \View::make($this->link_type.'.'.$this->current_theme.'.menu_positions.index')
                                        ->with('menu_positions', $menu_positions);
    }

    /**
     * Show the menu for creating a new menu positions.
     *
     * @return Response
     */
    public function create()
    {
        $this->layout->title = 'Create New Menu Position';
        $this->layout->content = \View::make($this->link_type.'.'.$this->current_theme.'.menu_positions.create_edit');
    }

    /**
     * Store a newly created menu positions in storage.
     *
     * @return Response
     */
    public function store()
    {
        try {
            $input = \Input::all();

            $validator = \MenuPosition::validate($input);

            if ($validator->passes()) {
                $menu_position = \MenuPosition::create($input);

                if ($menu_position) {
                    return \Redirect::to('backend/menu-positions')
                                        ->with('success_message', trans('success_messages.menu_position_create'));
                } else {
                    return \Redirect::to('backend/menu-positions')
                                        ->with('error_message', trans('error_messages.menu_position_create'));
                }
            } else {
                // Menu validation failed
                return \Redirect::back()
                                    ->withInput()
                                    ->withErrors($validator);
            }
        } catch (\Exception $e) {
            return \Redirect::to('backend/menu-positions')
                                ->with('error_message', trans('error_messages.menu_position_create') . ' ' . $e->getMessage());
        }
    }

    /**
     * Display the specified menu positions.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $menu_position = MenuPosition::findOrFail($id);
        $this->layout->title = $menu_position->title;
        $this->layout->content = \View::make($this->link_type.'.'.$this->current_theme.'.menu_positions.show')
                                        ->with('menu_position', $menu_position);
    }

    /**
     * Show the menu for editing the specified menu positions.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $menu_position = \MenuPosition::findOrFail($id);
        $this->layout->title = $menu_position->name;
        $this->layout->content = \View::make($this->link_type.'.'.$this->current_theme.'.menu_positions.create_edit')
                                        ->with('menu_position', $menu_position);
    }

    /**
     * Update the specified menu positions in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        try {
            $input = \Input::all();

            $validator = \MenuPosition::validate($input, $id);
            unset($input['id']);

            if ($validator->passes()) {
                $menu_position = \MenuPosition::findOrFail($id);

                if ($menu_position->update($input)) {
                    return \Redirect::to('backend/menu-positions')
                                        ->with('success_message', trans('success_messages.menu_position_update'));
                } else {
                    return \Redirect::to('backend/menu-positions')
                                        ->with('error_message', trans('error_messages.menu_position_update'));
                }
            } else {
                // Menu validation failed
                return \Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
        } catch (\Exception $e) {
            return \Redirect::to('backend/menu-positions')
                                ->with('error_message', trans('error_messages.menu_position_update'));
        }
    }

    /**
     * Remove the specified menu positions from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $menu_position = \MenuPosition::findOrFail($id);

        if ($menu_position && $menu_position->delete()) {
            if (\Request::ajax()) {
                return \Response::json(trans('success_messages.menu_position_delete'), 200);
            }
            return \Redirect::to('backend/menu-positions')
                                ->with('success_message', trans('success_messages.menu_position_delete'));
        } else {
            if (\Request::ajax()) {
                return \Response::json(trans('error_messages.menu_position_delete'), 400);
            }
            return \Redirect::to('backend/menu-positions')
                                ->with('error_message', trans('error_messages.menu_position_delete'));
        }
    }

}
