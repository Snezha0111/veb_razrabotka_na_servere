<?php
namespace MyProject\View;

class View
{
    private $templatesPath;

    public function __construct(string $templatesPath)
    {
        $this->templatesPath = $templatesPath;
    }
    
    public function renderHtml(string $templateName, array $vars = [], ?string $title = null)
    {
        // title в переменные для шаблона
        $vars['pageTitle'] = $title ?? 'Мой блог';
        
        extract($vars);
        include $this->templatesPath . '/' . $templateName;
    }
}