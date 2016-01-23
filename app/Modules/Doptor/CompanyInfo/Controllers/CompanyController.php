<?php namespace Modules\Doptor\CompanyInfo\Controllers;
/*
=================================================
Module Name     :   Company Info
Module Version  :   v1.0
Compatible CMS  :   v1.2
Site            :   http://doptor.net
Description     :
===================================================
*/
use DB;
use Input;
use Redirect;
use Str;
use View;

use Backend\AdminController as BaseController;
use Services\Validation\ValidationException as ValidationException;

class CompanyController extends CompanyBaseController {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $router = app()->make('router');
        $route = $router->currentRouteName() ?: $router->current()->getPath();

        // Enable tabbed view for company_info only
        $tabbed_view = (ends_with($route, 'company_info'));

        $vendor = Str::lower($this->module_vendor);

        $company_model = $this->module_namespace . 'Models\\Company';
        $company_branch_model = $this->module_namespace . 'Models\\CompanyBranch';

        $companies = $company_model::with('country')->get();

        $company_branches = $company_branch_model::with('country');

        if (current_user_companies()) {
            $company_branches = $company_branches->where('company_id', current_user_companies());
        }

        $company_branches = $company_branches->get();

        $title = 'All Companies and Company Branches';

        $this->layout->title = $title;
        $this->layout->content = View::make("{$this->module_alias}::companies.{$this->type}.index")
            ->with('title', $title)
            ->with('companies', $companies)
            ->with('company_branches', $company_branches)
            ->with('tabbed_view', $tabbed_view);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $form_id
     */
    public function create()
    {
        $country_model = $this->module_namespace . 'Models\\Country';
        $countries = $country_model::names();

        $title = "Add New Company";

        $this->layout->title = $title;
        $this->layout->content = View::make("{$this->module_alias}::companies.{$this->type}.create_edit")
            ->with('title', $title)
            ->with('countries', $countries)
            ->with('incharge_count', 1);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store()
    {
        $input = Input::all();

        $incharges = $this->fixInchargeData($input['incharge']);

        if (isset($input['form_close'])) {
            return Redirect::to("{$this->link}modules/{$this->module_link}");
        }

        if (isset($input['form_save'])) {
            $redirect = "{$this->link}modules/{$this->module_link}";
        } else {
            $redirect = "{$this->link}modules/{$this->module_link}/companies/create";
        }

        if ($this->module_vendor) {
            $company_model = "Modules\\{$this->module_vendor}\\{$this->module_alias}\\Models\\Company";
        } else {
            $company_model = "Modules\\{$this->module_alias}\\Models\\Company";
        }

        try {
            $company = $company_model::create($input);
            foreach ($incharges as $incharge) {
                $company->incharges()->create($incharge);
            }
        } catch (ValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }

        if ($company) {
            return Redirect::to($redirect)
                ->with('success_message', trans('success_messages.company_create'));
        } else {
            return Redirect::back()
                ->with('error_message', trans('error_messages.company_create'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param $form_id
     */
    public function show($id)
    {
        $company_model = $this->module_namespace . "Models\\Company";
        $company = $company_model::findOrFail($id);

        $title = "Showing Company: {$company->name}";

        $this->layout->title = $title;
        $this->layout->content = View::make("{$this->module_alias}::companies.{$this->type}.show")
            ->with('title', $title)
            ->with('company', $company);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param $form_id
     */
    public function edit($id)
    {
        if (!can_user_access_company($id)) {
            abort(501);
        }
        if ($this->module_vendor) {
            $company_model = "Modules\\{$this->module_vendor}\\{$this->module_alias}\\Models\\Company";
        } else {
            $company_model = "Modules\\{$this->module_alias}\\Models\\Company";
        }
        $country_model = $this->module_namespace . 'Models\\Country';
        $countries = $country_model::names();

        $company = $company_model::with('incharges')->findOrFail($id);
        $incharge_count = ($company->incharges->count() ? : 1);

        $title = "Edit Company";

        $this->layout->title = $title;

        $this->layout->content = View::make("{$this->module_alias}::companies.{$this->type}.create_edit")
            ->with('title', $title)
            ->with('company', $company)
            ->with('incharge_count', $incharge_count)
            ->with('countries', $countries);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        if (!can_user_access_company($id)) {
            abort(501);
        }
        $input = Input::all();

        $incharges = $this->fixInchargeData($input['incharge']);

        if (isset($input['form_close'])) {
            return Redirect::to("{$this->link}modules/{$this->module_link}");
        }

        if (isset($input['form_save'])) {
            $redirect = "{$this->link}modules/{$this->module_link}";
        } else {
            $redirect = "{$this->link}modules/{$this->module_link}/companies/create";
        }

        $company_model = $this->module_namespace . "Models\\Company";
        $country_model = $this->module_namespace . 'Models\\Country';

        try {
            $company = $company_model::find($id);
            $company->update($input);
            foreach ($incharges as $incharge) {
                if ($incharge['id']) {
                    // Edit existing incharge
                    $this_incharge = $company->incharges()->find($incharge['id']);
                    $this_incharge->update($incharge);
                } else {
                    // Create new incharge
                    $company->incharges()->create($incharge);
                }
            }
        } catch (ValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }

        if ($company) {
            return Redirect::to($redirect)
                ->with('success_message', trans('success_messages.company_delete'));
        } else {
            return Redirect::back()
                ->with('error_message', trans('error_messages.company_delete'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id = null)
    {
        // If multiple ids are specified
        if ($id == 'multiple') {
            $selected_ids = trim(Input::get('selected_ids'));
            if ($selected_ids == '') {
                return Redirect::back()
                    ->with('error_message', trans('error_messages.nothing_selected_delete'));
            }
            $selected_ids = explode(' ', $selected_ids);
        } else {
            $selected_ids = array($id);
        }

        $company_model = $this->module_namespace . "Models\\Company";

        foreach ($selected_ids as $id) {
            if (can_user_access_company($id)) {
                $company = $company_model::findOrFail($id);

                $company->delete();
            }
        }

        if (count($selected_ids) > 1) {
            $message = trans('success_messages.companies_delete');
        } else {
            $message = trans('success_messages.company_delete');
        }

        return Redirect::back()
            ->with('success_message', $message);
    }
}
