<?php

class ModelProduct extends Model {

    public $id;
    public $query;

    /*
     * @return sql query result
     * @type array
     */
    public $db_result = array();

    public function action_index() {}

    public function getProductById($id) {

        $q = DB::q("
            SELECT 
            `" . DB_PREFIX . "products`.`products_id`,
            `" . DB_PREFIX . "products`.`products_price`,
            `" . DB_PREFIX . "products`.`products_image_lrg`,
            `" . DB_PREFIX . "products`.`products_image_sm_1`,
            `" . DB_PREFIX . "products`.`products_image_sm_2`,
            `" . DB_PREFIX . "products`.`products_image_sm_3`,
            `" . DB_PREFIX . "products`.`products_image_sm_4`,
            `" . DB_PREFIX . "products`.`products_image_sm_5`,
            `" . DB_PREFIX . "products`.`products_image_sm_6`,
            `" . DB_PREFIX . "products_description`.`products_description`,
            `" . DB_PREFIX . "products_description`.`products_img_title`,
            `" . DB_PREFIX . "products_description`.`products_img_alt`,
            `" . DB_PREFIX . "products_description`.`add_title_sm_1`,
            `" . DB_PREFIX . "products_description`.`add_title_sm_2`,
            `" . DB_PREFIX . "products_description`.`add_title_sm_3`,
            `" . DB_PREFIX . "products_description`.`add_title_sm_4`,
            `" . DB_PREFIX . "products_description`.`add_title_sm_5`,
            `" . DB_PREFIX . "products_description`.`add_title_sm_6`,
            `" . DB_PREFIX . "products_description`.`add_alt_sm_1`,
            `" . DB_PREFIX . "products_description`.`add_alt_sm_2`,
            `" . DB_PREFIX . "products_description`.`add_alt_sm_3`,
            `" . DB_PREFIX . "products_description`.`add_alt_sm_4`,
            `" . DB_PREFIX . "products_description`.`add_alt_sm_5`,
            `" . DB_PREFIX . "products_description`.`add_alt_sm_6`,
            `" . DB_PREFIX . "products_description`.`products_name`
            FROM `" . DB_PREFIX . "products`
            LEFT JOIN `" . DB_PREFIX . "products_description`
            ON `" . DB_PREFIX . "products_description`.`products_id` = `" . DB_PREFIX . "products`.`products_id` 
            WHERE `" . DB_PREFIX . "products`.`products_id` = '" . $id . "'
            AND `" . DB_PREFIX . "products`.`products_status` = 1
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

    public function getProductTDKbyId($id) {

        $q = DB::q("
            SELECT 
            `" . DB_PREFIX . "products_description`.`products_head_title_tag`,
            `" . DB_PREFIX . "products_description`.`products_head_desc_tag`,
            `" . DB_PREFIX . "products_description`.`products_head_keywords_tag`
            FROM `" . DB_PREFIX . "products_description`
            WHERE `" . DB_PREFIX . "products_description`.`products_id` = '" . $id . "'
        ");
        if (DB::nr($q) <> 0) {
            $row = DB::fr($q);
            $db_result = $row;
            return $db_result;
        } else {
            return null;
        }
    }

    public function getProductOptionsPrice($id) {

        $q = DB::q("
                SELECT 
                `" . DB_PREFIX . "products_options`.`products_options_name`,
                `" . DB_PREFIX . "products_options_values`.`products_options_values_name`,
                `" . DB_PREFIX . "products_options_values`.`products_options_description`,
                `" . DB_PREFIX . "products_attributes`.`products_attributes_id`,
                `" . DB_PREFIX . "products_attributes`.`products_id`, 
                `" . DB_PREFIX . "products_attributes`.`options_id`,
                `" . DB_PREFIX . "products_attributes`.`options_values_id`,
                `" . DB_PREFIX . "products_attributes`.`options_values_price`,
                `" . DB_PREFIX . "products_attributes`.`price_prefix`,
                `" . DB_PREFIX . "products_attributes`.`products_options_sort_order`,
                `" . DB_PREFIX . "products_attributes`.`product_attributes_one_time`,
                `" . DB_PREFIX . "products_attributes`.`products_attributes_weight`,
                `" . DB_PREFIX . "products_attributes`.`products_attributes_weight_prefix`,
                `" . DB_PREFIX . "products_attributes`.`products_attributes_units`,
                `" . DB_PREFIX . "products_attributes`.`products_attributes_units_price` 
                FROM `" . DB_PREFIX . "products_attributes` 
                LEFT JOIN `" . DB_PREFIX . "products_options_values` 
                ON `" . DB_PREFIX . "products_options_values`.`products_options_values_id` = `" . DB_PREFIX . "products_attributes`.`options_values_id`
                LEFT JOIN `" . DB_PREFIX . "products_options` 
                ON `" . DB_PREFIX . "products_options`.`products_options_id` = `" . DB_PREFIX . "products_attributes`.`options_id` 
                WHERE `" . DB_PREFIX . "products_attributes`.`products_id` = '" . $id . "'
                ORDER BY `" . DB_PREFIX . "products_attributes`.`products_options_sort_order` ASC
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

    public function getVideoReview($id) {

        $q = DB::q("
            SELECT 
            `" . DB_PREFIX . "products`.`products_image_3d`
            FROM `" . DB_PREFIX . "products`
            WHERE `" . DB_PREFIX . "products`.`products_id` = '" . $id . "'
        ");
        if (DB::nr($q) <> 0) {
            $row = DB::fr($q);
            $db_result = $row;
            return $db_result;
        } else {
            return null;
        }
        
    }

    public function getProductCharacteristicById($id) {

        $q = DB::q("
            SELECT 
            `" . DB_PREFIX . "products_description`.`m_foto_id_characteristic1`,
            `" . DB_PREFIX . "products_description`.`m_foto_id_characteristic2`,
            `" . DB_PREFIX . "products_description`.`m_foto_id_characteristic3`,
            `" . DB_PREFIX . "products_description`.`m_foto_id_characteristic4`,
            `" . DB_PREFIX . "products_description`.`m_foto_id_characteristic5`,
            `" . DB_PREFIX . "products_description`.`m_foto_id_characteristic6`,
            `" . DB_PREFIX . "products_description`.`m_characteristic1`,
            `" . DB_PREFIX . "products_description`.`m_characteristic2`,
            `" . DB_PREFIX . "products_description`.`m_characteristic3`,
            `" . DB_PREFIX . "products_description`.`m_characteristic4`,
            `" . DB_PREFIX . "products_description`.`m_characteristic5`,
            `" . DB_PREFIX . "products_description`.`m_characteristic6`
            FROM `" . DB_PREFIX . "products_description`
            WHERE `" . DB_PREFIX . "products_description`.`products_id` = '" . $id . "'
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

    public function getCommentsByLink($link) {

        $q = DB::q("
            SELECT 
            `" . DB_PREFIX . "comments`.`id`,
            `" . DB_PREFIX . "comments`.`comment`,
            `" . DB_PREFIX . "comments`.`name`,
            DATE_FORMAT(`" . DB_PREFIX . "comments`.`date_add`, '%d %M %Y') as date_add
            FROM `" . DB_PREFIX . "comments`
            WHERE `" . DB_PREFIX . "comments`.`url` LIKE '%" . $link . "%'
            AND `" . DB_PREFIX . "comments`.`status` = '1'
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

}