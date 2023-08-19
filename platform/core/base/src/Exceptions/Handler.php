<?php

namespace Botble\Base\Exceptions;

use App\Exceptions\Handler as ExceptionHandler;
use Botble\Base\Facades\BaseHelper;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Facades\EmailHandler;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Cache;
use PhpOffice\PhpSpreadsheet\Exception as PhpSpreadsheetException;
use Botble\Media\Facades\RvMedia;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Botble\Theme\Facades\Theme;
use Throwable;

class Handler extends ExceptionHandler
{
    public function __construct(Container $container)
    {
        parent::__construct($container);

        $this->ignore(PhpSpreadsheetException::class);
        $this->ignore(DisabledInDemoModeException::class);
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof PostTooLargeException && count($request->allFiles())) {
            return RvMedia::responseError(trans('core/media::media.upload_failed', [
                'size' => BaseHelper::humanFilesize(RvMedia::getServerConfigMaxUploadFileSize()),
            ]));
        }

        if ($e instanceof ModelNotFoundException || $e instanceof MethodNotAllowedHttpException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        if ($e instanceof TokenMismatchException) {
            return (new BaseHttpResponse())
                ->setError()
                ->setCode($e->getCode())
                ->setMessage('CSRF token mismatch. Please try again!');
        }

        if ($e instanceof HttpExceptionInterface) {
            $code = $e->getStatusCode();

            if ($request->expectsJson()) {
                $response = new BaseHttpResponse();

                return match ($code) {
                    401 => $response
                        ->setError()
                        ->setMessage(trans('core/acl::permissions.access_denied_message'))
                        ->setCode($code)
                        ->toResponse($request),
                    403 => $response
                        ->setError()
                        ->setMessage(trans('core/acl::permissions.action_unauthorized'))
                        ->setCode($code)
                        ->toResponse($request),
                    404 => $response
                        ->setError()
                        ->setMessage(trans('core/base::errors.not_found'))
                        ->setCode(404)
                        ->toResponse($request),
                    default => $response
                        ->setError()
                        ->setMessage($e->getMessage())
                        ->setCode($code)
                        ->toResponse($request),
                };
            }

            if (! app()->isDownForMaintenance()) {
                do_action(BASE_ACTION_SITE_ERROR, $code);
            }
        }

        if ($e instanceof NotFoundHttpException && setting('redirect_404_to_homepage', 0) == 1) {
            return redirect(route('public.index'));
        }

        return parent::render($request, $e);
    }

    public function report(Throwable $e)
    {
        if ($this->shouldReport($e) && ! $this->isExceptionFromBot()) {
            $isSent = Cache::has('send_error_exception');
            if (! app()->isLocal() && ! app()->runningInConsole() && ! app()->isDownForMaintenance() && ! $isSent) {
                Cache::put('send_error_exception', 1, Carbon::now()->addMinutes(5));
                if (setting('enable_send_error_reporting_via_email', false) &&
                    setting('email_driver', config('mail.default')) &&
                    $e instanceof Exception
                ) {
                    EmailHandler::sendErrorException($e);
                }

                if (config('core.base.general.error_reporting.via_slack', false)) {
                    logger()->channel('slack')->critical(
                        $e->getMessage() . ($e->getPrevious() ? '(' . $e->getPrevious() . ')' : null),
                        [
                            'Request URL' => request()->fullUrl(),
                            'Request IP' => request()->ip(),
                            'Request Method' => request()->method(),
                            'Exception Type' => get_class($e),
                            'File Path' => ltrim(str_replace(base_path(), '', $e->getFile()), '/') . ':' . $e->getLine(),
                        ]
                    );
                }
            }
        }

        parent::report($e);
    }

    protected function isExceptionFromBot(): bool
    {
        $ignoredBots = config('core.base.general.error_reporting.ignored_bots', []);
        $agent = strtolower(request()->userAgent());

        if (empty($agent)) {
            return false;
        }

        foreach ($ignoredBots as $bot) {
            if (str_contains($agent, $bot)) {
                return true;
            }
        }

        return false;
    }

    protected function getHttpExceptionView(HttpExceptionInterface $e)
    {
        if (app()->runningInConsole() || request()->wantsJson() || request()->expectsJson()) {
            return parent::getHttpExceptionView($e);
        }

        $code = $e->getStatusCode();

        if (request()->is(BaseHelper::getAdminPrefix() . '/*') || request()->is(BaseHelper::getAdminPrefix())) {
            return 'core/base::errors.' . $code;
        }

        if (class_exists('Theme')) {
            $view = 'theme.' . Theme::getThemeName() . '::views.' . $code;

            if (view()->exists($view)) {
                return $view;
            }
        }

        return parent::getHttpExceptionView($e);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return (new BaseHttpResponse())
                ->setError()
                ->setMessage($exception->getMessage())
                ->setCode(401)
                ->toResponse($request);
        }

        return redirect()->guest(route('access.login'));
    }
}
