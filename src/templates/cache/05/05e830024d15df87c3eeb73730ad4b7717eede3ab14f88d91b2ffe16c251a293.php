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
        echo "  ";
        $this->loadTemplate("elements/navbar.twig", "pages/login.twig", 4)->display(twig_array_merge($context, ["currentPath" => "/login"]));
        // line 5
        echo "
  <div class=\"container mt-5\">
    <div class=\"row justify-content-md-center\">
      <div class=\"col-md-6\">
        <div class=\"p-3\">

          <form action=\"/auth/login\" method=\"post\">
            ";
        // line 12
        $this->loadTemplate("elements/formTextElement.twig", "pages/login.twig", 12)->display(twig_array_merge($context, ["name" => "username"]));
        // line 13
        echo "            ";
        $this->loadTemplate("elements/formTextElement.twig", "pages/login.twig", 13)->display(twig_array_merge($context, ["name" => "password", "type" => "password"]));
        // line 14
        echo "            ";
        $this->loadTemplate("elements/csrfToken.twig", "pages/login.twig", 14)->display($context);
        // line 15
        echo "            ";
        $this->loadTemplate("elements/formCheckBox.twig", "pages/login.twig", 15)->display(twig_array_merge($context, ["name" => "Remember me"]));
        // line 16
        echo "            <button class=\"btn btn-primary w-100\">login</button>
          </form>
          

          ";
        // line 20
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "login", [], "any", true, true, false, 20)) {
            // line 21
            echo "            <div class=\"mt-3\">
              <strong class=\"text-danger\">";
            // line 22
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "login", [], "any", false, false, false, 22), "html", null, true);
            echo "</strong>
            </div>
          ";
        }
        // line 25
        echo "        </div>
      </div>
    </div>
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
        return array (  90 => 25,  84 => 22,  81 => 21,  79 => 20,  73 => 16,  70 => 15,  67 => 14,  64 => 13,  62 => 12,  53 => 5,  50 => 4,  46 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "pages/login.twig", "/var/www/products-custom/src/templates/pages/login.twig");
    }
}
