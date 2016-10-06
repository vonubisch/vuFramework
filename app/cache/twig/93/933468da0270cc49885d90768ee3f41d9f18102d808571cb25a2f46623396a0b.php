<?php

/* acl.html */
class __TwigTemplate_303dd8662bd6bfa622cb4f17ceefbe7479f5224bea2cc3b687bcddc63f23da5c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"boxed\">
    <div id=\"content-container\">
        <div id=\"page-content\">
            <div class=\"panel\">
                <div class=\"panel-heading\">
                    <div class=\"panel-control\">
                        <a class=\"fa fa-question-circle fa-lg fa-fw unselectable add-tooltip\" href=\"#\" data-original-title=\"<h4 class='text-thin'>Information</h4><p style='width:150px'>This is an information bubble to help the user.</p>\" data-html=\"true\" title=\"\"></a>
                    </div>
                    <h3 class=\"panel-title\">
                        Access Control List
                    </h3>
                </div>

                <div class=\"panel-body\">

                    <form action=\"<?php echo \$app->router->generate('acl_sync'); ?>\" method=\"POST\" class=\"pull-left\">
                        <button type=\"submit\" class=\"btn btn-sm btn-success\">
                            <i class=\"fa fa-refresh fa-spin\"></i>
                            Synchronize routes with configuration INI file
                        </button>
                    </form>

                    <table class=\"table table-hover\">
                        <thead>
                            <tr>
                                <th>Route, URL, method, controller::function</th>
                                {for group in groups}
                                <th class=\"text-center\" style=\"width: 1px;\">{= group.name }</th>
                                {/for}
                            </tr>
                        </thead>
                        <tbody>
                            {for route in routes}
                            <tr>
                                <td>
                                    <strong class=\"text-primary\">
                                        {= route.name }
                                    </strong>
                                    &nbsp;
                                    <small class=\"text-muted\">
                                        <code>
                                            {= route.url }
                                        </code>

                                        &nbsp;
                                        <small class=\"label label-primary\">
                                            {= route.method }
                                        </small>
                                        &nbsp;
                                        <small>
                                            {= route.controller }::{= route.action }
                                        </small>
                                    </small>
                                    <form action=\"<?php echo \$app->router->generate('acl_route', array('type' => 'remove', 'routeid' => \$route->id)); ?>\" method=\"POST\" class=\"pull-left\">
                                        <button type=\"submit\" class=\"btn-link btn-xs\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Click to delete route '<?php echo \$route->name; ?>'\">
                                            <i class=\"text-muted fa fa-trash\"></i>
                                        </button>
                                    </form>
                                </td>
                                {for group in groups}
                                <td class=\"text-center\">
                                    <?php if (\$acl->access(\$route->id, \$group->id)): ?>
                                    <form action=\"<?php echo \$app->router->generate('acl_change', array('type' => 'deny', 'routeid' => \$route->id, 'groupid' => \$group->id)); ?>\" method=\"POST\">
                                        <button type=\"submit\" class=\"btn-link\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Click to deny access to group '<?php echo \$group->name; ?>'\">
                                            <i class=\"text-success fa fa-check-circle\"></i>
                                        </button>
                                    </form>
                                    <?php else: ?>
                                    <form action=\"<?php echo \$app->router->generate('acl_change', array('type' => 'allow', 'routeid' => \$route->id, 'groupid' => \$group->id)); ?>\" method=\"POST\">
                                        <button type=\"submit\" class=\"btn-link\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Click to allow access to group '<?php echo \$group->name; ?>'\">
                                            <i class=\"text-danger fa fa-minus-circle\"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </td>
                                {/for}
                            </tr>
                            {/for}
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                {for group in groups}
                                <th class=\"text-center\" style=\"width: 1px;\">{= group.name }</th>
                                {/for}
                            </tr>
                        </tfoot>
                    </table>

                    <div class=\"panel-group\" id=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">
                        {for group in groups}
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\" role=\"tab\" id=\"headingOne\">
                                <h4 class=\"panel-title\">
                                    <a class=\"accordion-toggle collapsed\" role=\"button\" data-toggle=\"collapse\" data-parent=\"\" href=\"#group-<?php echo \$group->name; ?>\" aria-expanded=\"true\" aria-controls=\"group-<?php echo \$group->name; ?>\">
                                        {= group.name }
                                    </a>
                                </h4>
                            </div>
                            <div id=\"group-<?php echo \$group->name; ?>\" class=\"panel-collapse collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne\">
                                <table class=\"table table-hover\">
                                    <thead>
                                        <tr>
                                            <th style=\"width: 80%;\">
                                                Name
                                            </th>
                                            <th style=\"width: 20%;\" class=\"text-center\">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (\$acl->getMembers(\$group->id) as \$user): ?>
                                        <tr>
                                            <td>
                                                <?php echo \$user->username; ?>
                                            </td>
                                            <td class=\"text-center\">
                                                <form action=\"<?php echo \$app->router->generate('acl_members', array('type' => 'remove', 'groupid' => \$group->id)); ?>\" method=\"POST\">
                                                    <input type=\"hidden\" name=\"userid\" value=\"<?php echo \$user->id; ?>\">
                                                    <button type=\"submit\" class=\"btn btn-default btn-xs\">
                                                        Remove
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan=\"2\" class=\"\">
                                                <form action=\"<?php echo \$app->router->generate('acl_members', array('type' => 'add', 'groupid' => \$group->id)); ?>\" method=\"POST\" class=\"\">
                                                    <div class=\"row\">
                                                        <div class=\"col-sm-11\">
                                                            <select name=\"userid\" class=\"form-control input-sm\">
                                                                <option disabled selected>
                                                                    < Add a user to <?php echo \$group->name; ?> >
                                                                </option>
                                                                <?php foreach (\$users as \$user): ?>
                                                                <option value=\"<?php echo \$user->id; ?>\">
                                                                    <?php echo \$user->username; ?>
                                                                </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class=\"col-sm-1\">
                                                            <button type=\"submit\" class=\"btn btn-default btn-sm\">
                                                                Add user
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        {/for}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "acl.html";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    public function getSource()
    {
        return "";
    }
}
