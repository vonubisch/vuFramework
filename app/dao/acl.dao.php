<?php

/**
 * Description of test
 *
 * @author bvubisch
 */
class ACLDao extends DAO {

    public function run() {
        $this->dbh = $this->database('mysql');
    }

    public function action($action, $userid) {
        $this->dbh->query(""
                        . "SELECT `acl_permissions`.`groupid` FROM `acl_actions` "
                        . "JOIN `acl_permissions` ON `acl_actions`.`id` = `acl_permissions`.`actionid` "
                        . "JOIN `acl_members` ON `acl_permissions`.`groupid` = `acl_members`.`groupid` "
                        . "WHERE `acl_actions`.`name` = :action AND `acl_members`.`userid` = :userid LIMIT 1"
                )
                ->bind(':action', $action)
                ->bind(':userid', $userid)
                ->fetch('obj');
        return (bool) $this->dbh->affected();
    }

    public function isAllowed($route, $userid) {
        $this->dbh->query(""
                        . "SELECT `acl_permissions`.`groupid` FROM `acl_routes` "
                        . "JOIN `acl_permissions` ON `acl_routes`.`id` = `acl_permissions`.`routeid` "
                        . "JOIN `acl_members` ON `acl_permissions`.`groupid` = `acl_members`.`groupid` "
                        . "WHERE `acl_routes`.`name` = :route AND `acl_members`.`userid` = :userid LIMIT 1"
                )
                ->bind(':route', $route)
                ->bind(':userid', $userid)
                ->fetch('obj');
        return (bool) $this->dbh->affected();
    }

    public function routesMatrix() {
        $routes = $this->routes();
        foreach ($routes as $route):
            $route->groups = $this->getRouteGroupsAndPermissions($route->id);
        endforeach;
        return $routes;
    }

    public function actionsMatrix() {
        $actions = $this->actions();
        foreach ($actions as $action):
            $action->groups = $this->getActionGroupsAndPermissions($action->id);
        endforeach;
        return $actions;
    }

    public function groups() {
        $query = "SELECT `id`, `name` FROM `acl_groups` ";
        return $this->dbh->query($query)->fetchAll('obj');
    }

    public function routes() {
        $query = "SELECT `id`, `name`, `request`, `url`, `controller`, `method` FROM `acl_routes` ORDER BY `name`";
        return $this->dbh->query($query)->fetchAll('obj');
    }

    public function actions() {
        $query = "SELECT `id`, `name`, `description` FROM `acl_actions` ORDER BY `name`";
        return $this->dbh->query($query)->fetchAll('obj');
    }

    public function hasAccessToRoute($routeid, $groupid) {
        $results = $this->dbh->query(""
                        . "SELECT `groupid` FROM `acl_permissions` "
                        . "WHERE `routeid` = :routeid AND `groupid` = :groupid LIMIT 1"
                )
                ->bind(':routeid', $routeid)
                ->bind(':groupid', $groupid)
                ->fetch('obj');
        return (bool) $this->dbh->affected();
    }

    public function hasAccessToAction($actionid, $groupid) {
        $results = $this->dbh->query(""
                        . "SELECT `groupid` FROM `acl_permissions` "
                        . "WHERE `actionid` = :actionid AND `groupid` = :groupid LIMIT 1"
                )
                ->bind(':actionid', $actionid)
                ->bind(':groupid', $groupid)
                ->fetch('obj');
        return (bool) $this->dbh->affected();
    }

    public function allowActionGroup($actionid, $groupid) {
        $data = array(
            'groupid' => $groupid,
            'actionid' => $actionid
        );
        $this->dbh->table('acl_permissions')->insert($data)->execute();
    }

    public function denyActionGroup($actionid, $groupid) {
        $this->dbh->table('acl_permissions')
                ->delete('groupid = :groupid AND actionid = :actionid LIMIT 1')
                ->bind(':groupid', $groupid)
                ->bind(':actionid', $actionid)
                ->execute();
    }

    public function allowRouteGroup($routeid, $groupid) {
        $data = array(
            'groupid' => $groupid,
            'routeid' => $routeid
        );
        $this->dbh->table('acl_permissions')->insert($data)->execute();
    }

    public function denyRouteGroup($routeid, $groupid) {
        $this->dbh->table('acl_permissions')
                ->delete('groupid = :groupid AND routeid = :routeid LIMIT 1')
                ->bind(':groupid', $groupid)
                ->bind(':routeid', $routeid)
                ->execute();
    }

    public function sync($data, $update) {
        $this->dbh->table('acl_routes')->insert($data, $update)->execute();
    }

    public function members() {
        $groups = $this->groups();
        foreach ($groups as $group):
            $group->members = $this->getMembersByGroup($group->id);
        endforeach;
        return $groups;
    }

    private function getRouteGroupsAndPermissions($routeid) {
        $groups = $this->groups();
        foreach ($groups as $group):
            $group->access = $this->hasAccessToRoute($routeid, $group->id);
        endforeach;
        return $groups;
    }

    private function getActionGroupsAndPermissions($actionid) {
        $groups = $this->groups();
        foreach ($groups as $group):
            $group->access = $this->hasAccessToAction($actionid, $group->id);
        endforeach;
        return $groups;
    }

    private function getMembersByGroup($groupid) {
        return $this->dbh->query(""
                                . "SELECT `users_accounts`.`id`, `users_accounts`.`username` FROM `acl_members` "
                                . "JOIN `users_accounts` ON `users_accounts`.`id` = `acl_members`.`userid`"
                                . "WHERE `acl_members`.`groupid` = :groupid"
                        )
                        ->bind(':groupid', $groupid)
                        ->fetchAll('obj');
    }

    public function users() {
        return $this->dbh
                        ->query("SELECT `id`, `username` FROM `users_accounts` ")
                        ->fetchAll('obj');
    }

    public function removeRoute($routeid) {
        $this->removePermissionsByRoute($routeid);
        $this->dbh->table('acl_routes')
                ->delete('id = :routeid LIMIT 1')
                ->bind(':routeid', $routeid)
                ->execute();
    }

    public function removeAction($actionid) {
        $this->removePermissionsByAction($actionid);
        $this->dbh->table('acl_actions')
                ->delete('id = :actionid LIMIT 1')
                ->bind(':actionid', $actionid)
                ->execute();
    }

    public function removePermissionsByRoute($routeid) {
        $this->dbh->table('acl_permissions')
                ->delete('routeid = :routeid')
                ->bind(':routeid', $routeid)
                ->execute();
    }

    public function removePermissionsByAction($actionid) {
        $this->dbh->table('acl_permissions')
                ->delete('actionid = :actionid')
                ->bind(':actionid', $actionid)
                ->execute();
    }

    public function addMember($data) {
        $this->dbh->table('acl_members')->insert($data)->execute();
    }

    public function removeMember($data) {
        $this->dbh->table('acl_members')
                ->delete('userid = :userid AND groupid = :groupid LIMIT 1')
                ->bind(':userid', $data['userid'])
                ->bind(':groupid', $data['groupid'])
                ->execute();
    }

}
