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
class FormBuilderController extends AdminController {

    /**
     * Display a listing of the form.
     * @return Response
     */
    public function index()
    {
        $forms = \BuiltForm::with('cat')->latest()->get();
        $this->layout->title = 'All Built Forms';
        $this->layout->content = \View::make($this->link_type.'.'.$this->current_theme.'.formbuilders.index')
                                        ->with('forms', $forms);
    }

    /**
     * Show the form for creating a new form.
     * @return Response
     */
    public function create()
    {
        $this->layout->title = 'Create New Form';
        $this->layout->content = \View::make($this->link_type.'.'.$this->current_theme.'.formbuilders.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     * @return Response
     */
    public function store()
    {
        try {
            $input = \Input::all();
            $input['show_captcha'] = isset($input['show_captcha']);

            $validator = \BuiltForm::validate($input);

            if ($validator->passes()) {
                $form = \BuiltForm::create (array(
                    'name'         => $input['name'],
                    'hash'         => uniqid('form_'),
                    'category'     => $input['category'],
                    'description'  => $input['description'],
                    'show_captcha' => $input['show_captcha'],
                    'data'         => $input['data'],
                    'redirect_to'  => $input['redirect_to'],
                    'extra_code'   => base64_decode($input['extra_code']),
                    'email'        => $input['email'],
                    'rendered'     => base64_decode($input['rendered'])
                ));

                if ($form) {
                    return \Redirect::to('backend/form-builder')
                                        ->with('success_message', 'The form was created.');
                } else {
                    return \Redirect::to('backend/form-builder')
                                        ->with('error_message', 'The form was\'t created.');
                }
            } else {
                // Form validation failed
                return \Redirect::back()
                                    ->withInput()
                                    ->withErrors($validator);
            }
        } catch (\Exception $e) {
            return \Redirect::back()
                                ->with('error_message', 'The form wasn\'t created.');
        }
    }

    /**
     * Display the specified form.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $form = \BuiltForm::findOrFail($id);
        $this->layout->title = $form->name;
        $this->layout->content = \View::make($this->link_type.'.'.$this->current_theme.'.formbuilders.show')
                                        ->with('form', $form);
    }

    /**
     * Show the form for editing the specified form.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $form = \BuiltForm::findOrFail($id);
        $this->layout->title = 'Edit Form';
        $this->layout->content = \View::make($this->link_type.'.'.$this->current_theme.'.formbuilders.create_edit')
                                        ->with('form', $form);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        try {
            $input = \Input::all();
            $input['show_captcha'] = isset($input['show_captcha']);

            $validator = \BuiltForm::validate($input, $id);

            if ($validator->passes()) {
                $form = \BuiltForm::findOrFail($id);

                $form->name         = $input['name'];
                if ($form->hash == '') {
                    $form->hash = uniqid('form_');
                }
                $form->category     = $input['category'];
                $form->show_captcha = $input['show_captcha'];
                $form->description  = $input['description'];
                $form->data         = $input['data'];
                $form->redirect_to  = $input['redirect_to'];
                $form->extra_code   = base64_decode($input['extra_code']);
                $form->email        = $input['email'];
                $form->rendered     = base64_decode($input['rendered']);

                if ($form->save()) {
                    return \Redirect::to('backend/form-builder')
                                        ->with('success_message', 'Form was updated.');
                } else {
                    return \Redirect::to('backend/form-builder')
                                        ->with('error_message', 'Form wasn\'t updated.');
                }
            } else {
                // Form validation failed
                return \Redirect::back()
                                    ->withInput()
                                    ->withErrors($validator);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            return \Redirect::back()
                                ->with('error_message', 'The form wasn\'t updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $form = \BuiltForm::findOrFail($id);

        if (\BuiltModule::where('form_id', '=', $id)->first()) {
            return \Redirect::back()
                            ->with('error_message', 'The form can\'t be deleted because a built module is using this form. <br> Either change the form in that built module or delete the module first to delete this form.');
        }
        if ($form->delete()) {
            return \Redirect::to('backend/form-builder')
                                ->with('success_message', 'Form was deleted.');
        } else {
            return \Redirect::to('backend/form-builder')
                                ->with('error_message', 'Form wasn\'t deleted.');
        }
    }

}
