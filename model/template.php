<?php

class ModelTemplate extends Model {

    public $id;

    /*
     * @return sql query result
     * @type array
     */
    public $db_result = array();

    public function getListArticlesById($id) {

        $sql = ("
            SELECT 
            `" . DB_PREFIX . "articles_description`.`articles_name`,
            `" . DB_PREFIX . "my_structure`.`link` 
            FROM `" . DB_PREFIX . "articles_to_topics` 
            LEFT JOIN `" . DB_PREFIX . "articles_description` 
            ON `" . DB_PREFIX . "articles_description`.`articles_id` = `" . DB_PREFIX . "articles_to_topics`.`articles_id`
            LEFT JOIN `" . DB_PREFIX . "articles`
            ON `" . DB_PREFIX . "articles`.`articles_id` = `" . DB_PREFIX . "articles_description`.`articles_id`
            LEFT JOIN `" . DB_PREFIX . "my_structure`
            ON `" . DB_PREFIX . "my_structure`.`idt` = `" . DB_PREFIX . "articles_description`.`articles_id`
            WHERE `" . DB_PREFIX . "articles_to_topics`.`topics_id` = '".$id."' 
            AND `" . DB_PREFIX . "articles_description`.`articles_name` IS NOT NULL
            AND `" . DB_PREFIX . "articles_description`.`articles_name` != ''
            AND `" . DB_PREFIX . "my_structure`.`link` LIKE '%-a-%'
                    AND `" . DB_PREFIX . "my_structure`.`link` NOT LIKE '%nachalo-mesyaca-a-interneta.html%'
            AND `" . DB_PREFIX . "articles`.`articles_status` = 1
            ORDER BY `" . DB_PREFIX . "articles_description`.`articles_id` DESC
        ");

        $q = DB::q($sql);
        
        if (DB::nr($q) <> 0) {
            while ($row = DB::fassoc($q)) {
                $db_result[] = $row;
            }
            return $db_result;
        } else {
            return null;
        }
    }
}   