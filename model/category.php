<?php

class ModelCategory extends Model {

    public $id;
    public $query;

    /*
     * @return sql query result
     * @type array
     */
    public $db_result = array();

    public function action_index() {}

    public function getAllCategories() {
        $q = DB::q("
            SELECT
            `" . DB_PREFIX . "categories`.`categories_id`,
            `" . DB_PREFIX . "categories_description`.`categories_heading_title`,
            `" . DB_PREFIX . "my_structure`.`link`
            FROM `" . DB_PREFIX . "categories`
            LEFT JOIN `" . DB_PREFIX . "categories_description`
            ON `" . DB_PREFIX . "categories`.`categories_id` = `" . DB_PREFIX . "categories_description`.`categories_id`
            LEFT JOIN `" . DB_PREFIX . "my_structure`
            ON `" . DB_PREFIX . "my_structure`.`idt` = `" . DB_PREFIX . "categories`.`categories_id`
            WHERE `" . DB_PREFIX . "my_structure`.`link` LIKE '%-c-%'
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

    public function getCategoryById($id) {

        $q = DB::q("
            SELECT 
            `" . DB_PREFIX . "categories`.`categories_id`,
            `" . DB_PREFIX . "categories_description`.`categories_heading_title`,
            `" . DB_PREFIX . "my_structure`.`link`
            FROM `" . DB_PREFIX . "categories`
            LEFT JOIN `" . DB_PREFIX . "categories_description`
            ON `" . DB_PREFIX . "categories`.`categories_id` = `" . DB_PREFIX . "categories_description`.`categories_id`
            LEFT JOIN `" . DB_PREFIX . "my_structure`
            ON `" . DB_PREFIX . "my_structure`.`idt` = `" . DB_PREFIX . "categories`.`categories_id`
            WHERE `" . DB_PREFIX . "my_structure`.`link` LIKE '%" . $id . "%'
	    AND `" . DB_PREFIX . "my_structure`.`type` = 1
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

    public function getProductsNumber($id) {

	$q = DB::q("
            SELECT
            `" . DB_PREFIX . "products_to_categories`.`products_id`
            FROM `" . DB_PREFIX . "products`
            LEFT JOIN `" . DB_PREFIX . "products_to_categories`
            ON `" . DB_PREFIX . "products_to_categories`.`products_id` = `" . DB_PREFIX . "products`.`products_id` 
            LEFT JOIN `" . DB_PREFIX . "my_structure`
            ON `" . DB_PREFIX . "my_structure`.`idt` = `" . DB_PREFIX . "products`.`products_id`
            LEFT JOIN `" . DB_PREFIX . "products_description`
            ON `" . DB_PREFIX . "products_description`.`products_id` = `" . DB_PREFIX . "products`.`products_id` 
            WHERE `" . DB_PREFIX . "products_to_categories`.`categories_id` = '" . $id . "'
            AND `" . DB_PREFIX . "products`.`products_status` = 1
            AND `" . DB_PREFIX . "products_description`.`products_name` IS NOT NULL
            AND `" . DB_PREFIX . "my_structure`.`link` LIKE '%-p-%'
            ORDER BY `" . DB_PREFIX . "products`.`products_sort_order`
        ");

        if (DB::nr($q) <> 0) {
            $db_result = DB::nr($q);
            return $db_result;
        } else {
            return null;
        }
    }
	
    public function getProductsByCategory($id,$limit_start,$limit_end) {

        if($limit_start !=='' && $limit_end !==''){
            $limit = "LIMIT ".$limit_start.",".$limit_end;
        }else{$limit = '';}
       
        $query = "
            SELECT
            `" . DB_PREFIX . "my_structure`.`link`,
            `" . DB_PREFIX . "products`.`products_price`,
            `" . DB_PREFIX . "products`.`products_sort_order`,
            `" . DB_PREFIX . "products`.`products_image`,
            `" . DB_PREFIX . "products_to_categories`.`products_id`,
            `" . DB_PREFIX . "products_description`.`products_name`,
            `" . DB_PREFIX . "products_description`.`products_img_title`,
            `" . DB_PREFIX . "products_description`.`products_img_alt`
            FROM `" . DB_PREFIX . "products`
            LEFT JOIN `" . DB_PREFIX . "products_to_categories`
            ON `" . DB_PREFIX . "products_to_categories`.`products_id` = `" . DB_PREFIX . "products`.`products_id` 
            LEFT JOIN `" . DB_PREFIX . "my_structure`
            ON `" . DB_PREFIX . "my_structure`.`idt` = `" . DB_PREFIX . "products`.`products_id`
            LEFT JOIN `" . DB_PREFIX . "products_description`
            ON `" . DB_PREFIX . "products_description`.`products_id` = `" . DB_PREFIX . "products`.`products_id` 
            WHERE `" . DB_PREFIX . "products_to_categories`.`categories_id` = '" . $id . "'
            AND `" . DB_PREFIX . "products`.`products_status` = 1
            AND `" . DB_PREFIX . "products_description`.`products_name` IS NOT NULL
            AND `" . DB_PREFIX . "my_structure`.`link` LIKE '%-p-%'
            GROUP BY `" . DB_PREFIX . "my_structure`.`link`
            ORDER BY `" . DB_PREFIX . "products`.`products_sort_order`
        ";
        
        $sql = $query.$limit;
       // echo $sql;
        $q = DB::q($sql);
        
        if (DB::nr($q) <> 0) {
            while ($row = DB::fa($q)) {
                $db_result[] = $row;
            }
            return $db_result;
        } else {
            return null;
        }
    }

    public function getCategoryTDKbyId($id) {

        $q = DB::q("
            SELECT 
            `" . DB_PREFIX . "categories_description`.`categories_meta_title`,
            `" . DB_PREFIX . "categories_description`.`categories_meta_description`,
            `" . DB_PREFIX . "categories_description`.`categories_meta_keywords`
            FROM `" . DB_PREFIX . "categories_description`
            WHERE 
            `" . DB_PREFIX . "categories_description`.`categories_id`='" . $id . "'
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
