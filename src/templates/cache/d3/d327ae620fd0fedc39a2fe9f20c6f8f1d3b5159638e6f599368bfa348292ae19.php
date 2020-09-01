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
        // line 2
        echo "<div class=\"dummy-navbar\"></div>

<nav class=\"navbar-custom\">
  <div class=\"nav-brand\">
    <h2>Rate products</h2>
  </div>

  <div class=\"nav-links\">
    ";
        // line 10
        $this->loadTemplate("elements/navLink.twig", "elements/navbar.twig", 10)->display(twig_array_merge($context, ["name" => "Products", "path" => "/add-product"]));
        // line 11
        echo "    ";
        $this->loadTemplate("elements/navLink.twig", "elements/navbar.twig", 11)->display(twig_array_merge($context, ["name" => "Shops", "path" => "/add-product"]));
        // line 12
        echo "    ";
        $this->loadTemplate("elements/navLink.twig", "elements/navbar.twig", 12)->display(twig_array_merge($context, ["name" => "Home", "path" => "/"]));
        // line 13
        echo "    ";
        $this->loadTemplate("elements/navLink.twig", "elements/navbar.twig", 13)->display(twig_array_merge($context, ["name" => "About", "path" => "/about"]));
        // line 14
        echo "  </div>

  ";
        // line 22
        echo "
  <div class=\"nav-search\">
    <input type=\"text\" placeholder=\"Search in products...\">
  </div>


  <div class=\"nav-auth-controls\">
    ";
        // line 29
        if (($context["authenticated"] ?? null)) {
            // line 30
            echo "      <div class=\"logout\">
        <button class=\"btn btn-danger\" form=\"logout-form\">Logout</button>
        <form method=\"post\" action=\"/auth/logout\" id=\"logout-form\">
          ";
            // line 33
            $this->loadTemplate("elements/csrfToken.twig", "elements/navbar.twig", 33)->display($context);
            // line 34
            echo "        </form>
      </div>
    ";
        } else {
            // line 37
            echo "      <a href=\"/login\" class=\"btn btn-primary\">Log In</a>
      <a href=\"/signup\" class=\"btn btn-outline-primary\">Sign Up</a>
    ";
        }
        // line 40
        echo "  </div>

</nav>";
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
        return array (  90 => 40,  85 => 37,  80 => 34,  78 => 33,  73 => 30,  71 => 29,  62 => 22,  58 => 14,  55 => 13,  52 => 12,  49 => 11,  47 => 10,  37 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("", "elements/navbar.twig", "/var/www/products-custom/src/templates/elements/navbar.twig");
    }
}
