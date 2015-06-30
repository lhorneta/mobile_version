<?php

class ModelArticle extends Model {

    public $url;
    public $query;

    /*
     * @return sql query result
     * @type array
     */
    public $db_result = array();

    public function action_index() {}

    public function getArticleContentById($id) {

        $q = DB::q("
            SELECT 
            `" . DB_PREFIX . "articles_description`.`articles_name`,
            `" . DB_PREFIX . "articles_description`.`articles_description`
            FROM `" . DB_PREFIX . "articles_description`
            WHERE `" . DB_PREFIX . "articles_description`.`articles_id` = " . $id . "
        ");

        if (DB::nr($q) <> 0) {
            while ($row = DB::fassoc($q)) {
                $db_result[] = $row;
            }
            return $db_result;
        } else {
            return null;
        }
    }
        		
    public function getArticleTDKbyId($id){
		
         $q = DB::q("
            SELECT 
            `" . DB_PREFIX . "articles_description`.`articles_head_title_tag`,
            `" . DB_PREFIX . "articles_description`.`articles_head_desc_tag`,
            `" . DB_PREFIX . "articles_description`.`articles_head_keywords_tag`
            FROM `" . DB_PREFIX . "articles_description`
            WHERE `" . DB_PREFIX . "articles_description`.`articles_id` = " . $id . "
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