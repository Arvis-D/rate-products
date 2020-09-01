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

/* pages/signup.twig */
class __TwigTemplate_d589da8e71e40183a7802b5e70dc6b47eda2e6e88d497e88f160003bdb2af75f extends Template
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
        $this->parent = $this->loadTemplate("master.twig", "pages/signup.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "    ";
        $this->loadTemplate("elements/navbar.twig", "pages/signup.twig", 4)->display(twig_array_merge($context, ["currentPath" => "/signup"]));
        // line 5
        echo "
  <div class=\"container mt-5\">
    <div class=\"row justify-content-md-center\">
      <div class=\"col-md-6\">
        <div class=\"p-3\">
          <form action=\"/auth/signup\" method=\"post\">
            ";
        // line 11
        $this->loadTemplate("elements/formTextElement.twig", "pages/signup.twig", 11)->display(twig_array_merge($context, ["name" => "username"]));
        // line 12
        echo "            ";
        $this->loadTemplate("elements/formTextElement.twig", "pages/signup.twig", 12)->display(twig_array_merge($context, ["name" => "email"]));
        // line 13
        echo "            ";
        $this->loadTemplate("elements/formTextElement.twig", "pages/signup.twig", 13)->display(twig_array_merge($context, ["name" => "password", "type" => "password"]));
        // line 14
        echo "            ";
        $this->loadTemplate("elements/formTextElement.twig", "pages/signup.twig", 14)->display(twig_array_merge($context, ["name" => "repeat password", "type" => "password"]));
        // line 15
        echo "            ";
        $this->loadTemplate("elements/formCheckBox.twig", "pages/signup.twig", 15)->display(twig_array_merge($context, ["name" => "Remember me"]));
        // line 16
        echo "            ";
        $this->loadTemplate("elements/csrfToken.twig", "pages/signup.twig", 16)->display($context);
        // line 17
        echo "            <button class=\"btn btn-primary w-100\">Sign Up</button>
          </form>
        </div>
      </div>
    </div>
  </div>


";
    }

    public function getTemplateName()
    {
        return "pages/signup.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 17,  75 => 16,  72 => 15,  69 => 14,  66 => 13,  63 => 12,  61 => 11,  53 => 5,  50 => 4,  46 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "pages/signup.twig", "/var/www/products-custom/src/templates/pages/signup.twig");
    }
}
