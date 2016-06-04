<?php
/**
 * Created by PhpStorm.
 * User: kito
 * Date: 03.06.16
 * Time: 23:49
 */

class Searcher extends Model
{
    public function getCategories()
    {
        $sql = "SELECT `id`,`category_name` FROM categories";
        return $this->db->query($sql);
    }

    public function getTags()
    {
        $sql = "SELECT * FROM tags";
        return $this->db->query($sql);
    }

    public function getNewsBySearch()
    {
        if($_GET['start_date'] !='' AND $_GET['end_date'] !='' AND $_GET['category'] == '' AND $_GET['tag'] ==''){
            $search_content = "date BETWEEN '{$_GET['start_date']}' AND '{$_GET['end_date']}'";
            } elseif($_GET['start_date'] !='' AND $_GET['end_date'] !='' AND $_GET['category'] != '' AND $_GET['tag'] ==''){
            $search_content = "date BETWEEN '{$_GET['start_date']}' AND '{$_GET['end_date']}' AND category_id = '{$_GET['category']}'";
        } elseif($_GET['start_date'] !='' AND $_GET['end_date'] !='' AND $_GET['category'] != '' AND $_GET['tag'] !=''){
            $search_content = "date BETWEEN '{$_GET['start_date']}' AND '{$_GET['end_date']}' AND category_id = '{$_GET['category']}'
            AND (tag1_id = '{$_GET['tag']}' OR tag2_id = '{$_GET['tag']}' OR tag3_id = '{$_GET['tag']}'  OR tag4_id = '{$_GET['tag']}')";
        } elseif($_GET['start_date'] =='' AND $_GET['end_date'] =='' AND $_GET['category'] == '' AND $_GET['tag'] !='') {
            $search_content = "tag1_id = '{$_GET['tag']}' OR tag2_id = '{$_GET['tag']}' OR tag3_id = '{$_GET['tag']}'  OR tag4_id = '{$_GET['tag']}'";
        } elseif($_GET['start_date'] =='' AND $_GET['end_date'] =='' AND $_GET['category'] != '' AND $_GET['tag'] ==''){
            $search_content = "category_id = '{$_GET['category']}'";
        } elseif($_GET['start_date'] !='' AND $_GET['end_date'] !='' AND $_GET['category'] == '' AND $_GET['tag'] !=''){
            $search_content = "date BETWEEN '{$_GET['start_date']}' AND '{$_GET['end_date']}'
            AND (tag1_id = '{$_GET['tag']}' OR tag2_id = '{$_GET['tag']}' OR tag3_id = '{$_GET['tag']}'  OR tag4_id = '{$_GET['tag']}')";
        } elseif($_GET['start_date'] =='' AND $_GET['end_date'] =='' AND $_GET['category'] != '' AND $_GET['tag'] !=''){
            $search_content = "category_id = '{$_GET['category']}'
            AND (tag1_id = '{$_GET['tag']}' OR tag2_id = '{$_GET['tag']}' OR tag3_id = '{$_GET['tag']}'  OR tag4_id = '{$_GET['tag']}')";
        } else {
            return false;
        }

        $sql = "SELECT * FROM `news` WHERE {$search_content} ORDER BY date DESC";
        return $this->db->query($sql);
    }
}