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

/* pages/login.twig */
class __TwigTemplate_66ad9bf70258f7548ce5747bf7e4dd133f58b771f23fe13de84b0633cb415e33 extends Template
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
        $this->parent = $this->loadTemplate("master.twig", "pages/login.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "    ";
        $this->loadTemplate("elements/navbar.twig", "pages/login.twig", 4)->display(twig_array_merge($context, ["currentPath" => "/auth/login"]));
        // line 5
        echo "
    <div class=\"container mt-6\">
        <form action=\"/auth/login\" method=\"post\">
            ";
        // line 8
        $this->loadTemplate("elements/formTextElement.twig", "pages/login.twig", 8)->display(twig_array_merge($context, ["name" => "username"]));
        // line 9
        echo "            ";
        $this->loadTemplate("elements/formTextElement.twig", "pages/login.twig", 9)->display(twig_array_merge($context, ["name" => "password", "type" => "password"]));
        // line 10
        echo "            <button class=\"btn btn-primary\">login</button>
        </form>
    </div>
";
    }

    public function getTemplateName()
    {
        return "pages/login.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  63 => 10,  60 => 9,  58 => 8,  53 => 5,  50 => 4,  46 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "pages/login.twig", "/var/www/products-custom/src/templates/pages/login.twig");
    }
}
