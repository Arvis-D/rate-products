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
        echo "  ";
        $this->loadTemplate("elements/navbar.twig", "pages/home.twig", 4)->display(twig_array_merge($context, ["currentPath" => "/"]));
        // line 5
        echo "
  <div class=\"container-fluid\">
    <div class=\"row justify-content-start\">
      <div class=\"col-sm-6 col-md-5 col-lg-4 col-xl-3 side-filter\">
        <div class=\"\">
          <div class=\"p-5 m-1 bg-primary\"></div>
          <div class=\"p-5 m-1 bg-primary\"></div>
        </div>
      </div>
    </div>
    <div class=\"row justify-content-end\">
      <div class=\"col-sm-6 col-md-7 col-lg-8 col-xl-9\">
        <div class=\"container-fluid\">
          <div class=\"row\">
            
            ";
        // line 20
        ob_start(function () { return ''; });
        // line 21
        echo "              ";
        $this->loadTemplate("elements/product.twig", "pages/home.twig", 21)->display($context);
        // line 22
        echo "            ";
        $context["product"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 23
        echo "
            ";
        // line 24
        echo twig_escape_filter($this->env, ($context["product"] ?? null), "html", null, true);
        echo "
            ";
        // line 25
        echo twig_escape_filter($this->env, ($context["product"] ?? null), "html", null, true);
        echo "
            ";
        // line 26
        echo twig_escape_filter($this->env, ($context["product"] ?? null), "html", null, true);
        echo "
            ";
        // line 27
        echo twig_escape_filter($this->env, ($context["product"] ?? null), "html", null, true);
        echo "
            ";
        // line 28
        echo twig_escape_filter($this->env, ($context["product"] ?? null), "html", null, true);
        echo "
            ";
        // line 29
        echo twig_escape_filter($this->env, ($context["product"] ?? null), "html", null, true);
        echo "
            ";
        // line 30
        echo twig_escape_filter($this->env, ($context["product"] ?? null), "html", null, true);
        echo "
            ";
        // line 31
        echo twig_escape_filter($this->env, ($context["product"] ?? null), "html", null, true);
        echo "
            ";
        // line 32
        echo twig_escape_filter($this->env, ($context["product"] ?? null), "html", null, true);
        echo "
          </div>
        </div>
      </div>
    </div>
  </div>

";
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
        return array (  113 => 32,  109 => 31,  105 => 30,  101 => 29,  97 => 28,  93 => 27,  89 => 26,  85 => 25,  81 => 24,  78 => 23,  75 => 22,  72 => 21,  70 => 20,  53 => 5,  50 => 4,  46 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "pages/home.twig", "/var/www/products-custom/src/templates/pages/home.twig");
    }
}
