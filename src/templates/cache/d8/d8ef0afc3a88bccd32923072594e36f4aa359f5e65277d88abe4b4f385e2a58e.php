<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* pages/home.twig */
class __TwigTemplate_36c52ff15bf5142b8208ade3874f3abfbce5784a820c7288e73fb1373733c500 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "master.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("master.twig", "pages/home.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "    ";
        $this->loadTemplate("elements/navbar.twig", "pages/home.twig", 4)->display(twig_array_merge($context, ["currentPath" => "/"]));
        // line 5
        echo "
    ";
        // line 6
        if (($context["authenticated"] ?? null)) {
            // line 7
            echo "        <h1>You are authenticated!</h1>
    ";
        } else {
            // line 9
            echo "        <h1>Login to see more!</h1>
    ";
        }
    }

    public function getTemplateName()
    {
        return "pages/home.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  62 => 9,  58 => 7,  56 => 6,  53 => 5,  50 => 4,  46 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "pages/home.twig", "/var/www/products-custom/src/templates/pages/home.twig");
    }
}
