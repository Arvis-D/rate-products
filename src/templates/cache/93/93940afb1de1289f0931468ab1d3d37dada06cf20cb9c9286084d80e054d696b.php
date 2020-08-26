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

/* elements/formTextElement.twig */
class __TwigTemplate_1e5d1a2dd6febe239ecb24db2a17c50aa06a171871412fd6f390722443f25120 extends Template
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
        echo "<div class=\"input-group mb-3\">
    <input 
    type=\"";
        // line 3
        (((array_key_exists("type", $context) &&  !(null === ($context["type"] ?? null)))) ? (print (twig_escape_filter($this->env, ($context["type"] ?? null), "html", null, true))) : (print ("text")));
        echo "\" 
    class=\"form-control\" 
    placeholder=\"";
        // line 5
        echo twig_escape_filter($this->env, twig_capitalize_string_filter($this->env, ($context["name"] ?? null)), "html", null, true);
        echo "\" 
    aria-label=\"";
        // line 6
        echo twig_escape_filter($this->env, twig_capitalize_string_filter($this->env, ($context["name"] ?? null)), "html", null, true);
        echo "\" 
    name=\"";
        // line 7
        echo twig_escape_filter($this->env, twig_replace_filter(twig_lower_filter($this->env, ($context["name"] ?? null)), [" " => "-"]), "html", null, true);
        echo "\"
    >
</div>";
    }

    public function getTemplateName()
    {
        return "elements/formTextElement.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  54 => 7,  50 => 6,  46 => 5,  41 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "elements/formTextElement.twig", "/var/www/products-custom/src/templates/elements/formTextElement.twig");
    }
}
