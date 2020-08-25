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

/* elements/navElement.twig */
class __TwigTemplate_f3b882acaf53adb486935490bb695cb153b514c619f99b6415c9e390f7bd9298 extends Template
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
        echo "<a href=\"";
        echo twig_escape_filter($this->env, ($context["path"] ?? null), "html", null, true);
        echo "\" class=\"";
        if ((0 === twig_compare(($context["path"] ?? null), ($context["currentPath"] ?? null)))) {
            echo "active";
        }
        echo "\">";
        echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
        echo "</a>
";
    }

    public function getTemplateName()
    {
        return "elements/navElement.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "elements/navElement.twig", "/var/www/products-custom/src/templates/elements/navElement.twig");
    }
}
