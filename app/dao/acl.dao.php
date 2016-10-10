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

    public function matrix() {
        $routes = $this->routes();
        foreach ($routes as $route):
            $route->groups = $this->getGroupsAndPermissions($route->id);
        endforeach;
        return $routes;
    }

    public function groups() {
        $query = "SELECT `id`, `name` FROM `acl_groups` ";
        return $this->dbh->query($query)->fetchAll('obj');
    }

    public function routes() {
        $query = "SELECT `id`, `name`, `request`, `url`, `controller`, `method` FROM `acl_routes` ORDER BY `name`";
        return $this->dbh->query($query)->fetchAll('obj');
    }

    public function access($routeid, $groupid) {
        $results = $this->dbh->query(""
                        . "SELECT `groupid` FROM `acl_permissions` "
                        . "WHERE `routeid` = :routeid AND `groupid` = :groupid LIMIT 1"
                )
                ->bind(':routeid', $routeid)
                ->bind(':groupid', $groupid)
                ->fetch('obj');
        return (bool) $this->dbh->affected();
    }

    public function allowGroup($routeid, $groupid) {
        $data = array(
            'groupid' => $groupid,
            'routeid' => $routeid
        );
        $this->dbh->table('acl_permissions')->insert($data)->execute();
    }

    public function denyGroup($routeid, $groupid) {
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

    private function getGroupsAndPermissions($routeid) {
        $groups = $this->groups();
        foreach ($groups as $group):
            $group->access = $this->access($routeid, $group->id);
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

    public function removePermissionsByRoute($routeid) {
        $this->dbh->table('acl_permissions')
                ->delete('routeid = :routeid')
                ->bind(':routeid', $routeid)
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
