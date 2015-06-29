<?php

class ModelInformationPage extends Model {

    public $link;
    public $query;

    /*
     * @return sql query result
     * @type array
     */
    public $db_result = array();

    public function action_index() {
        
    }

    public function getInformationPageIdByLink($link) {

        $q = DB::q("
                SELECT 
                `" . DB_PREFIX . "pages_description`.`pages_id`
                FROM `" . DB_PREFIX . "pages_description`
                LEFT JOIN `" . DB_PREFIX . "my_structure`
                ON `" . DB_PREFIX . "my_structure`.`idt` = `" . DB_PREFIX . "pages_description`.`pages_id`
                LEFT JOIN `" . DB_PREFIX . "pages`
                ON `" . DB_PREFIX . "pages`.`pages_id` = `" . DB_PREFIX . "pages_description`.`pages_id`
                WHERE `" . DB_PREFIX . "my_structure`.`link` = '" . $link . "'
                AND `" . DB_PREFIX . "pages`.`pages_status` = 1
        ");

        if (DB::nr($q) <> 0) {
            $row = DB::fr($q);
            $db_result = $row;
            return $db_result;
        } else {
            return null;
        }
    }

    public function getInformationPageById($id) {

        $q = DB::q("
                SELECT 
                `" . DB_PREFIX . "pages_description`.`pages_name`,
                `" . DB_PREFIX . "pages_description`.`pages_description`
                FROM `" . DB_PREFIX . "pages_description`
                WHERE `" . DB_PREFIX . "pages_description`.`pages_id` = '" . $id . "'
        ");

        if (DB::nr($q) <> 0) {
            while ($row = DB::fa($q)) {
                $db_result[] = $row;
            }
            return $db_result;
        } else {
            return null;
        }
    }

    public function getInformationPageTDKbyId($id) {

        $q = DB::q("
            SELECT 
            `" . DB_PREFIX . "pages_description`.`pages_title`,
            `" . DB_PREFIX . "pages_description`.`pages_desc`,
            `" . DB_PREFIX . "pages_description`.`pages_keywords`
            FROM `" . DB_PREFIX . "pages_description`
            WHERE 
            `" . DB_PREFIX . "pages_description`.`pages_id`='" . $id . "'
        ");

        if (DB::nr($q) <> 0) {
            $row = DB::fr($q);
            $db_result = $row;
            return $db_result;
        } else {
            return null;
        }
    }
}