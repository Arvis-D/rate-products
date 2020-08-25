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

/* elements/navbar.twig */
class __TwigTemplate_ea5d82240cffe1c1b5855900f856dd5f1aed914f6f3481e3f4e7355be4ccfae9 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<nav>
    ";
        // line 2
        $this->loadTemplate("elements/navElement.twig", "elements/navbar.twig", 2)->display(twig_array_merge($context, ["name" => "Home", "path" => "/"]));
        // line 3
        echo "    ";
        $this->loadTemplate("elements/navElement.twig", "elements/navbar.twig", 3)->display(twig_array_merge($context, ["name" => "Signup", "path" => "/signup"]));
        // line 4
        echo "    ";
        $this->loadTemplate("elements/navElement.twig", "elements/navbar.twig", 4)->display(twig_array_merge($context, ["name" => "Login", "path" => "/login"]));
        // line 5
        echo "</nav>
<hr>";
    }

    public function getTemplateName()
    {
        return "elements/navbar.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  48 => 5,  45 => 4,  42 => 3,  40 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "elements/navbar.twig", "/var/www/products-custom/src/templates/elements/navbar.twig");
    }
}
