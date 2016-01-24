<?php namespace Modules\Newsletter\Controllers\Backend;

use Config;
use File;
use Input;
use Mail;
use Redirect;
use Request;
use Sentry;
use Str;
use View;

use Backend\AdminController as BaseController;
use Modules\Newsletter\Models\Newsletter;
use Modules\Newsletter\Models\NewsletterSubscriber;

class NewsletterController extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        // Add location hinting for views
        View::addNamespace('newsletters', app_path() . "/Modules/Newsletter/Views/{$this->current_theme}/{$this->link_type}/newsletters");
    }

    public function index()
    {
        // \Schema::drop('newsletters');
        // \Schema::drop('newsletter_subscribers');
        // die;
        $newsletters = Newsletter::latest()->get();

        $this->layout->title = 'All Newsletters';
        $this->layout->content = View::make('newsletters::index')
                                        ->with('newsletters', $newsletters);
    }

    /**
     * Show the form for creating a new newsletter.
     * @return View
     */
    public function create()
    {
        $this->layout->title = 'Send Newsletter';
        $this->layout->content = View::make('newsletters::create_edit');
    }

    /**
     * Send newsletters to all subscribers
     * @return View
     */
    public function store()
    {
        View::addNamespace('newsletter-email', app_path() . "/StrongCode/Newsletter/Views/{$this->current_theme}/public");

        $input = Input::all();

        if (isset($input['form_close'])) {
            return Redirect::to("$this->link_type/modules/newsletters");
        }

        $subscribers = NewsletterSubscriber::get()->fetch('email');

        Newsletter::create($input);

        try {
            foreach ($subscribers as $subscriber) {
                Mail::queue('newsletter-email::newsletter', $input, function($email_message) use($input, $subscriber) {
                    $email_message->from(Config::get('mail.username'));
                    $email_message->to($subscriber)
                            ->subject($input['subject']);
                });
            }
        } catch (Exception $e) {
            return Redirect::back()
                                ->withInput()
                                ->with('error_message', $e->getMessage());
        }

        $redirect = (isset($input['form_save'])) ? "$this->link_type/modules/newsletters" : "$this->link_type/modules/newsletters/create";

        return Redirect::to($redirect)
            ->with('success_message', 'The newsletter was sent.');
    }

    /**
     * Remove the specified newsletter from storage.
     *
     * @param  int $id
     * @return View
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

        foreach ($selected_ids as $id) {
            $newsletter = Newsletter::findOrFail($id);

            $newsletter->delete();
        }

        $wasOrWere = (count($selected_ids) > 1) ? 's were' : ' was';
        $message = 'The newsletter' . $wasOrWere . ' deleted.';

        return Redirect::to("$this->link_type/modules/newsletters")
            ->with('success_message', $message);
    }
}
