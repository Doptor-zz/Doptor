<?php namespace Modules\Newsletter\Controllers\Backend;

use App;
use BaseController;
use Input;
use Redirect;
use Request;
use Str;
use View;

use Services\Validation\ValidationException as ValidationException;
use Modules\Newsletter\Models\NewsletterSubscriber;

class SubscriberController extends BaseController {

    public function __construct()
    {
        parent::__construct();

        // Add location hinting for views
        View::addNamespace('newsletter-subscribers', app_path() . "/Modules/Newsletter/Views/{$this->current_theme}/{$this->link_type}/newsletter-subscribers");
    }

    /**
     * Display a listing of the newsletters.
     * @return View
     */
    public function index()
    {
        $subscribers = NewsletterSubscriber::all();

        $this->layout->title = 'All Subscribers';

        $this->layout->content = View::make('newsletter-subscribers::index')
            ->with('subscribers', $subscribers);
    }

    public function create()
    {
        $this->layout->title = 'Add Subscriber';
        $this->layout->content = View::make('newsletter-subscribers::create_edit');
    }

    public function store()
    {
        $input = Input::all();

        if (isset($input['form_close'])) {
            return Redirect::to("$this->link_type/modules/newsletters/subscribers");
        }
        try {
            App::make('Modules\\Newsletter\\Validation\\SubscriberValidator')->validateForCreation($input);
        } catch (ValidationException $exception) {
            return Redirect::back()
                            ->withInput()
                            ->withErrors($exception->getErrors());
        }

        NewsletterSubscriber::create($input);

        $redirect = (isset($input['form_save'])) ? "$this->link_type/modules/newsletters/subscribers" : "$this->link_type/modules/newsletters/subscribers/create";

        return Redirect::to($redirect)
                        ->with('subscribe_success', trans('success_messages.subscriber_create'));
    }

    public function edit($id)
    {
        $subscriber = NewsletterSubscriber::findOrFail($id);

        $this->layout->title = 'Edit Subscriber';
        $this->layout->content = View::make('newsletter-subscribers::create_edit')
                                        ->with('subscriber', $subscriber);
    }

    public function update($id)
    {
        $input = Input::get();

        if (isset($input['form_close'])) {
            return Redirect::to("$this->link_type/modules/newsletters/subscribers");
        }

        try {
            $input['id'] = $id;
            App::make('Modules\\Newsletter\\Validation\\SubscriberValidator')->validateForUpdate($input);
        } catch (ValidationException $exception) {
            return Redirect::back()
                            ->withInput()
                            ->withErrors($exception->getErrors());
        }

        $subscriber = NewsletterSubscriber::findOrFail($id);
        $subscriber->email = $input['email'];
        $subscriber->save();

        $redirect = (isset($input['form_save'])) ? "$this->link_type/modules/newsletters/subscribers" : "$this->link_type/modules/newsletters/subscribers/create";

        return Redirect::to($redirect)
            ->with('success_message', trans('success_messages.subscriber_update'));
    }

    /**
     * Remove the specified subscriber from storage.
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
            $subscriber = NewsletterSubscriber::findOrFail($id);

            $subscriber->delete();
        }

        $wasOrWere = (count($selected_ids) > 1) ? 's were' : ' was';
        $message = 'The subscriber' . $wasOrWere . ' deleted.';

        if (count($selected_ids) > 1) {
            $message = trans('success_messages.subscribers_delete');
        } else {
            $message = trans('success_messages.subscriber_delete');
        }

        return Redirect::to("$this->link_type/modules/newsletters/subscribers")
            ->with('success_message', $message);
    }
}
