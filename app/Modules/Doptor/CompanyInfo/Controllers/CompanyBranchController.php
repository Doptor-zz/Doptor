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

class CompanyBranchController extends CompanyBaseController {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index($company_id=null)
    {
        $vendor = Str::lower($this->module_vendor);

        $company_branch_model = $this->module_namespace . 'Models\\CompanyBranch';

        if (!$company_id) {
            $company_branches = $company_branch_model::with('country')->get();
            $title = "All Company Branches";
        } else {
            $company_model = $this->module_namespace . 'Models\\Company';

            $company = $company_model::find($company_id);

            $company_branches = $company_branch_model::with('country')
                                        ->where('company_id', $company_id)
                                        ->get();
            $title = "All Branches of {$company->name}";
        }

        $this->layout->title = $title;
        $this->layout->content = View::make("{$this->module_alias}::branches.{$this->type}.index")
            ->with('title', $title)
            ->with('company_branches', $company_branches);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $form_id
     */
    public function create()
    {
        $country_model = $this->module_namespace . 'Models\\Country';
        $company_model = $this->module_namespace . 'Models\\Company';

        $countries = $country_model::names();

        $current_user_companies = current_user_companies();
        
        if ($current_user_companies) {
            $companies = $company_model::where('id', $current_user_companies)->lists('name', 'id');
        } else {
            $companies = $company_model::names();
        }

        $this->layout->title = "Add New Entry in {$this->module_name}";
        $this->layout->content = View::make("{$this->module_alias}::branches.{$this->type}.create_edit")
            ->with('title', "Add New Entry in {$this->module_name}")
            ->with('companies', $companies)
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
            $redirect = "{$this->link}modules/{$this->module_link}/branches/create";
        }

        if ($this->module_vendor) {
            $company_branch_model = "Modules\\{$this->module_vendor}\\{$this->module_alias}\\Models\\CompanyBranch";
        } else {
            $company_branch_model = "Modules\\{$this->module_alias}\\Models\\CompanyBranch";
        }

        try {
            $company_branch = $company_branch_model::create($input);
            foreach ($incharges as $incharge) {
                $company_branch->incharges()->create($incharge);
            }
        } catch (ValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }

        if ($company_branch) {
            return Redirect::to($redirect)
                ->with('success_message', trans('success_messages.company_branch_create'));
        } else {
            return Redirect::back()
                ->with('error_message', trans('error_messages.company_branch_create'));
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
        $company_branch_model = $this->module_namespace . "Models\\CompanyBranch";
        $company_branch = $company_branch_model::findOrFail($id);

        $this->layout->title = "Showing Entry in {$this->module_name}";;
        $this->layout->content = View::make("{$this->module_alias}::branches.{$this->type}.show")
            ->with('title', "Showing Entry in {$this->module_name}")
            ->with('company', $company_branch);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param $form_id
     */
    public function edit($id)
    {
        if ($this->module_vendor) {
            $company_branch_model = "Modules\\{$this->module_vendor}\\{$this->module_alias}\\Models\\CompanyBranch";
        } else {
            $company_branch_model = "Modules\\{$this->module_alias}\\Models\\CompanyBranch";
        }

        $country_model = $this->module_namespace . 'Models\\Country';
        $company_model = $this->module_namespace . 'Models\\Company';

        $countries = $country_model::names();
        $companies = $company_model::names();

        $company_branch = $company_branch_model::with('incharges')->findOrFail($id);

        if (!can_user_access_company($company_branch->company_id)) {
            abort(501);
        }
        $incharge_count = ($company_branch->incharges->count() ? : 1);

        $this->layout->title = "Edit Entry in {$this->module_name}";;

        $this->layout->content = View::make("{$this->module_alias}::branches.{$this->type}.create_edit")
            ->with('title', "Edit Entry in module {$this->module_name}")
            ->with('company_branch', $company_branch)
            ->with('countries', $countries)
            ->with('companies', $companies)
            ->with('incharge_count', $incharge_count);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $input = Input::all();

        $incharges = $this->fixInchargeData($input['incharge']);

        if (isset($input['form_close'])) {
            return Redirect::to("{$this->link}modules/{$this->module_link}");
        }

        if (isset($input['form_save'])) {
            $redirect = "{$this->link}modules/{$this->module_link}";
        } else {
            $redirect = "{$this->link}modules/{$this->module_link}/branches/create";
        }

        $company_branch_model = $this->module_namespace . "Models\\CompanyBranch";
        $country_model = $this->module_namespace . 'Models\\Country';

        try {
            $company_branch = $company_branch_model::find($id);
            $company_branch->update($input);
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

        if ($company_branch) {
            return Redirect::to($redirect)
                ->with('success_message', trans('success_messages.company_branch_update'));
        } else {
            return Redirect::back()
                ->with('error_message', trans('error_messages.company_branch_update'));
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

        $company_branch_model = $this->module_namespace . "Models\\CompanyBranch";

        foreach ($selected_ids as $id) {
            $company_branch = $company_branch_model::findOrFail($id);

            $company_branch->delete();
        }

        if (count($selected_ids) > 1) {
            $message = trans('success_messages.company_branches_delete');
        } else {
            $message = trans('success_messages.company_branch_delete');
        }

        return Redirect::back()
            ->with('success_message', $message);
    }
}
