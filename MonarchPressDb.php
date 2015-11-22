<?php

class MonarchPressDb {

    private $mysqli;

    public function __construct($url, $user, $pwd, $db) {
        $this->mysqli = new mysqli($url, $user, $pwd, $db);

        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
    }

    function __destruct() {
        $this->mysqli->close();
    }

    /*     * ******** Methods for monarch_user table ********* */

    public function insert_user($name, $pwd, $question, $answer, $email, $t_handle) {
        return $this->mysqli->query("insert into wordpress.monarch_user (username, password, secret_question, secret_answer, email, twitter_handle) values ('{$name}', '{$pwd}', '{$question}', '{$answer}', '{$email}', '{$t_handle}')");
    }

    public function update_user($id, $pwd, $question, $answer, $email, $t_handle) {
        return $this->mysqli->query("update wordpress.monarch_user set username='{$name}', password='{$pwd}', secret_question='{$question}', secret_answer='{$answer}', email='{$email}', twitter_handle='{$t_handle}' where id='{$id}'");
    }

    public function search_user_by_username($name) {
        return $this->mysqli->query("SELECT * FROM wordpress.monarch_user where username='{$name}'");
    }

    public function search_user_by_email($email) {
        return $this->mysqli->query("SELECT * FROM wordpress.monarch_user where email='{$email}'");
    }

    public function search_user_by_twitter_handle($t_handle) {
        return $this->mysqli->query("SELECT * FROM wordpress.monarch_user where twitter_handle='{$t_handle}'");
    }

    /*     * ******** Methods for monarch_role table ********* */

    public function insert_role($role) {
        return $this->mysqli->query("insert into wordpress.monarch_role (role) values ('{$role}')");
    }

    public function update_role($id, $role) {
        return $this->mysqli->query("update wordpress.monarch_role set role='{$role}' where id='{$id}'");
    }

    public function search_role_by_id($id) {
        return $this->mysqli->query("SELECT * FROM wordpress.monarch_role where id='{$id}'");
    }

    /*     * ******** Methods for monarch_user_role table ********* */

    public function insert_user_role($user_id, $role_id) {
        return $this->mysqli->query("insert into wordpress.monarch_role (role) values ('{$role}')");
    }

    public function update_user_role($id, $role) {
        return $this->mysqli->query("update wordpress.monarch_role set role='{$role}' where id={$id}");
    }

    public function search_user_role_by_id($id) {
        return $this->mysqli->query("SELECT * FROM wordpress.monarch_role where id='{$id}'");
    }

    public function search_user_role_by_userid($userid) {
        return $this->mysqli->query("SELECT * FROM wordpress.monarch_role where user_id='{$user_id}'");
    }

    /*     * ******** Methods for monarch_privilege table ********** */

    public function insert_privilege($name, $desc) {
        return $this->mysqli->query("insert into wordpress.monarch_privilege (name, desc) values ('{$name}', '{$desc}')");
    }

    public function update_privilege($id, $name, $desc) {
        return $this->mysqli->query("update wordpress.monarch_privilege set name='{$name}', desc='{$desc}' where id='{$id}'");
    }

    public function search_privilege_by_name($name) {
        return $this->mysqli->query("SELECT * FROM wordpress.monarch_privilege where id='{$name}'");
    }

    /*     * ******** Methods for monarch_role_privilege table ********** */

    public function insert_role_privilege($roleId, $privId) {
        return $this->mysqli->query("insert into wordpress.monarch_role_privilege (role_id, privilege_id) values ('{$roleId}', '{$privId}')");
    }

    public function update_role_privilege($id, $roleId, $privId) {
        return $this->mysqli->query("update wordpress.monarch_role_privilege set role_id='{$roleId}', privilege_id='{$privId}' where id='{$id}'");
    }

    public function search_privilege_by_roleid($roleId) {
        return $this->mysqli->query("SELECT * FROM wordpress.monarch_role_privilege where role_id='{$roleId}'");
    }

    public function search_privilege_by_privilegeid($privId) {
        return $this->mysqli->query("SELECT * FROM wordpress.monarch_role_privilege where id='{$privId}'");
    }

    /*     * ******** Methods for monarch_article ********** */
    public function insert_article($pubDate, $modDate, $content, $userId) {
        return $this->mysqli->query("insert into wordpress.monarch_article (published_date, modified_date, content, user_id) values ('{$pubDate}', '{$modDate}', '{$content}', '{$userId}')");
    }

    public function update_article_content($id, $modDate, $content) {
        return $this->mysqli->query("update wordpress.monarch_article set modified_date='{$modDate}', content='{$content}' where id='{$id}'");
    }

    public function search_article_by_userid($userId) {
        return $this->mysqli->query("SELECT * FROM wordpress.monarch_article where user_id='{$userId}'");
    }

    public function search_article_by_published_date($pubDate) {
        return $this->mysqli->query("SELECT * FROM wordpress.monarch_article where published_date='{$pubDate}'");
    }
    
    /*     * ******** Methods for monarch_template ********** */
    public function insert_template($fileName){
        return $this->mysqli->query("insert into wordpress.monarch_template (filename) values ('{$fileName}')");
    }
    
    public function update_template($id, $fileName) {
        return $this->mysqli->query("update wordpress.monarch_template set filename='{$fileName}' where id='{$id}'");
    }
    
    public function search_template_by_filename($filename){
        return $this->mysqli->query("SELECT * FROM wordpress.monarch_template where filename='{$filename}'");
    }
    
    /*     * ******** Methods for monarch_blog_post ********** */
    public function insert_blog_post($pubDate, $modDate, $content, $userId) {
        return $this->mysqli->query("insert into wordpress.monarch_blog_post (published_date, modified_date, content, user_id) values ('{$pubDate}', '{$modDate}', '{$content}', '{$userId}')");
    }
    
    public function update_blog_post_content($id, $modDate, $content) {
        return $this->mysqli->query("update wordpress.monarch_blog_post set modified_date='{$modDate}', content='{$content}' where id='{$id}'");
    }

    public function search_blog_post_by_userid($userId) {
        return $this->mysqli->query("SELECT * FROM wordpress.monarch_blog_post where user_id='{$userId}'");
    }

    public function search_blog_post_by_published_date($pubDate) {
        return $this->mysqli->query("SELECT * FROM wordpress.monarch_blog_post where published_date='{$pubDate}'");
    }
    
    /*     * ******** Methods for monarch_notification ********** */
    public function insert_notification($userId, $articleId, $hasBeenNotified, $wantsNotification){
        return $this->mysqli->query("insert into wordpress.monarch_notification (user_id, article_id, has_been_notified, wants_notification) values ('{$userId}', '{$articleId}', '{$hasBeenNotified}', '{$wantsNotification}')");
    }
    
    public function update_notification($id, $user_id, $article_id, $hasBeenNotified, $wantsNotification){
        return $this->mysqli->query("update wordpress.monarch_notification set user_id='{$user_id}', article_id='{$article_id}', has_been_notified='{$hasBeenNotified}', wants_notification='{$wantsNotification}' where id='{$id}'");
    }
    
    public function search_notification_by_article_id($articleId){
        return $this->mysqli->query("SELECT * FROM wordpress.monarch_notification where article_id='{$articleId}'");
    }
    
    public function search_notification_by_user_id($userId){
        return $this->mysqli->query("SELECT * FROM wordpress.monarch_notification where user_id='{$userId}'");
    }
    
    /*     * ******** Methods for monarch_whitelist_user ********** */
}
?>
