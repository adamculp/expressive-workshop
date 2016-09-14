<?php
namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template;

class PageAction
{
    private $template;

    public function __construct(Template\TemplateRendererInterface $template = null)
    {
        $this->template = $template;
    }

    public function __invoke(ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null)
    {
        $view = 'app::page-index';
        $action = $request->getAttribute('action');
        
        if ($action && $action != 'index') {
            $view = 'app::page-'.$action;
        }
        
        return new HtmlResponse($this->template->render($view));
    }
}
