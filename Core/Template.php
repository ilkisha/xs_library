<?php

namespace Core;


class Template implements TemplateInterface
{
    public const TEMPLATE_FOLDER = 'App/Template/';
    public const TEMPLATE_EXTENSION = '.php';

    public function render(string $templateName, $data = null, array $errors = []) : void
    {
        require_once self::TEMPLATE_FOLDER
            . $templateName
            . self::TEMPLATE_EXTENSION;
    }
}