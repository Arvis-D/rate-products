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
        $context["htmlPropertyName"] = twig_replace_filter(twig_lower_filter($this->env, ($context["name"] ?? null)), [" " => "-"]);
        // line 2
        if ((0 !== twig_compare(($context["type"] ?? null), "password"))) {
            // line 3
            echo "    ";
            $context["old"] = (($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4 = ($context["old"] ?? null)) && is_array($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4) || $__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4 instanceof ArrayAccess ? ($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4[($context["name"] ?? null)] ?? null) : null);
        }
        // line 5
        echo "

<div class=\"form-group mb-3\">
  <label for=\"";
        // line 8
        echo twig_escape_filter($this->env, ("form-" . ($context["htmlPropertyName"] ?? null)), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, (twig_capitalize_string_filter($this->env, ($context["name"] ?? null)) . ":"), "html", null, true);
        echo "</label>
  <input 
    type=\"";
        // line 10
        (((array_key_exists("type", $context) &&  !(null === ($context["type"] ?? null)))) ? (print (twig_escape_filter($this->env, ($context["type"] ?? null), "html", null, true))) : (print ("text")));
        echo "\" 
    class=\"form-control ";
        // line 11
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), ($context["name"] ?? null), [], "array", true, true, false, 11)) {
            echo " border border-danger ";
        }
        echo "\"
    ";
        // line 13
        echo "    aria-label=\"";
        echo twig_escape_filter($this->env, twig_capitalize_string_filter($this->env, ($context["name"] ?? null)), "html", null, true);
        echo "\" 
    name=\"";
        // line 14
        echo twig_escape_filter($this->env, ($context["htmlPropertyName"] ?? null), "html", null, true);
        echo "\"
    id=\"";
        // line 15
        echo twig_escape_filter($this->env, ("form-" . ($context["htmlPropertyName"] ?? null)), "html", null, true);
        echo "\"
    ";
        // line 16
        if (array_key_exists("old", $context)) {
            // line 17
            echo "    value=\"";
            echo twig_escape_filter($this->env, ($context["old"] ?? null), "html", null, true);
            echo "\"
    ";
        }
        // line 19
        echo "  >
</div>

";
        // line 22
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), ($context["name"] ?? null), [], "array", true, true, false, 22)) {
            // line 23
            echo "    <div class=\"mb-3\">
      <strong class=\"text-danger\">";
            // line 24
            echo twig_escape_filter($this->env, (($__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144 = ($context["errors"] ?? null)) && is_array($__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144) || $__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144 instanceof ArrayAccess ? ($__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144[($context["name"] ?? null)] ?? null) : null), "html", null, true);
            echo "</strong>
    </div>
";
        }
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
        return array (  98 => 24,  95 => 23,  93 => 22,  88 => 19,  82 => 17,  80 => 16,  76 => 15,  72 => 14,  67 => 13,  61 => 11,  57 => 10,  50 => 8,  45 => 5,  41 => 3,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "elements/formTextElement.twig", "/var/www/products-custom/src/templates/elements/formTextElement.twig");
    }
}
