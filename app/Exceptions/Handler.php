<?php namespace App\Exceptions;

use App;
use View;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler {

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception && method_exists($exception, 'getStatusCode')) {
            $code = $exception->getStatusCode();
        } else {
            $code = 500;
        }

        if (App::environment() != 'local') {
            list($link_type, $link, $layout, $theme) = current_section();

            View::share('current_theme', $theme);
            $current_user = current_user();

            if ($exception instanceof Illuminate\Database\Eloquent\ModelNotFoundException) {
                return response(view("$link_type.$theme.404", array('title' => 'Page Not Found', 'current_user' => $current_user), array(404)));
            }

            switch ($code) {
                case 401:
                    return response(view("$link_type.$theme.401", array('title' => 'Unauthorized access', 'current_user' => $current_user), array(401)));
                    break;

                case 404:
                    return response(view("$link_type.$theme.404", array('title' => 'Page Not Found', 'current_user' => $current_user), array(404)));
                    break;

                case 503:
                    return response(view('503', array('title' => 'Site Offline', 'link_type' => $link_type, 'current_user' => $current_user), array(503)));
                    break;

                default:
                    return response(view("$link_type.$theme.500", array('title'=>'Error', 'current_user' => $current_user), array($code)));
                    break;
            }
        }
        return parent::render($request, $exception);
    }

}
