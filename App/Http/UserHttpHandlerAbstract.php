<?php

namespace App\Http;

use Core\DataBinderInterface;
use Core\TemplateInterface;

abstract class UserHttpHandlerAbstract
{
    /**
     * @var TemplateInterface
     */
    private $template;

    /**
     * @var DataBinderInterface
     */
    protected $dataBinder;

    public function __construct(TemplateInterface $template,
        DataBinderInterface $dataBinder)
    {
        $this->template = $template;
        $this->dataBinder = $dataBinder;
    }

    /**
     * @param string $templateName
     * @param null $data
     * @param array $errors
     */
    public function render(string $templateName, $data = null, $errors = []) : void
    {
        $this->template->render($templateName, $data, $errors);
    }

    /**
     * @param string $url
     */
    public function redirect(string $url) : void
    {
        header("Location: $url");
    }
}