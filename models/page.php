<?php
/**
 * Created by PhpStorm.
 * User: kito
 * Date: 22.05.16
 * Time: 21:09
 */

class Page extends  Model
{

    public function getCategories()
    {
        $sql = "SELECT `id`,`category_name` FROM categories";
        return $this->db->query($sql);
    }

    public function getLastFiveNewsEachCategory()
    {
        $sql = "SELECT `id`,`category_name` FROM categories";
       $categories = $this->db->query($sql);
        foreach ($categories as $category){
            $sql = "SELECT `id`, `news_name`, `category_id` FROM news WHERE category_id = '{$category['id']}' ORDER BY `date` DESC LIMIT 5";
            $lastFiveNewsEachCategory [] =  $this->db->query($sql);
        }

        return $lastFiveNewsEachCategory;
    }

    public function getLastNews()
    {
        $sql = "SELECT id, news_name, img_link, category_id FROM news ORDER BY `date` DESC LIMIT 5";
        return $this->db->query($sql);
    }

    public function getCategoryById($id)
    {
        $id = $this->db->escape($id);
        $sql = "SELECT * FROM categories WHERE id = '{$id}'";
        return $this->db->query($sql);
    }

    public function getNewsByCategoryId($id)
    {
        $id = $this->db->escape($id);
        $sql = "SELECT * FROM news WHERE category_id = '{$id}' ORDER BY `date` DESC";
        return $this->db->query($sql);
    }

    public function getPaginationNewsByTag($page,$tag)
    {
        if($page<1 ){
            $page = 1;
        }
        $limit = $page * 5;
        $start = $limit - 5;

        $sql = "SELECT * FROM news WHERE tag1_id = '{$tag}' OR tag2_id = '{$tag}' OR
        tag3_id = '{$tag}' OR tag4_id = '{$tag}' ORDER BY `date` DESC LIMIT {$start},5";
        return $this->db->query($sql);
    }

    public function getPaginationCommentsByUser($page,$id)
    {
        if($page<1 ){
            $page = 1;
        }
        $limit = $page * 5;
        $start = $limit - 5;

        $sql = "SELECT * FROM comments WHERE user_id = '{$id}' ORDER BY `likes` DESC LIMIT {$start},5";
        return $this->db->query($sql);
    }





    public function getNumberOfPagesTags($tag)
    {
        $sql = "SELECT COUNT(*) as cnt FROM news WHERE tag1_id = '{$tag}' OR tag2_id = '{$tag}' OR
        tag3_id = '{$tag}' OR tag4_id = '{$tag}'";
        return $this->db->query($sql);

    }

    public function getNumberOfPagesComments($id)
    {
        $sql = "SELECT COUNT(*) as cnt FROM comments WHERE user_id = '{$id}'";
        return $this->db->query($sql);

    }

    public function getNewsById($id)
    {
        $id = $this->db->escape($id);
        $sql = "SELECT id, news_name, content,img_link, numb_readers, DATE_FORMAT(date,'%d.%m.%Y') AS date,is_analytics, tag1_id, tag2_id, tag3_id, tag4_id,
  category_id FROM news WHERE id = '{$id}'";
        return $this->db->query($sql);
    }

    public function getNumberOfPages($category)
    {
        $sql = "SELECT COUNT(*) as cnt FROM news WHERE category_id = '{$category}'";
        return $this->db->query($sql);

    }

    public function getPaginationNews($page, $category)
    {
        if($page<1 ){
            $page = 1;
        }
        $limit = $page * 5;
        $start = $limit - 5;
        $sql = "SELECT * FROM news WHERE category_id = '{$category}' ORDER BY `date` DESC LIMIT {$start},5";
        return $this->db->query($sql);
    }

    public function updateReaders($id,$readers)
    {
        $readers = $readers+1;
        $sql = "UPDATE news SET numb_readers = '{$readers}' WHERE id = '{$id}'";
        return $this->db->query($sql);
    }

    public function getTags($id)
    {
        $sql = "SELECT * FROM tags WHERE id IN('{$id[0]}','{$id[1]}','{$id[2]}','{$id[3]}')";
        return $this->db->query($sql);
    }

    public function getTagById($id)
    {
        $sql = "SELECT * FROM tags WHERE id = '{$id}'";
        return $this->db->query($sql);
    }

    public function getLastAnalytics()
    {
        $sql = "SELECT * FROM news WHERE is_analytics = 1 ORDER BY `date`DESC LIMIT 5";
        return $this->db->query($sql);
    }

    public function getCommentsByNewsId($id)
    {
        $sql = "SELECT id, com_id, user_id, comment, firstName, likes, lastName, DATE_FORMAT(com_date,'%d.%m.%Y') AS date, likes, unlikes
              FROM news_all_info WHERE id = '{$id}' ORDER BY likes DESC ";
        return $this->db->query($sql);
    }

    public function getUserById($id){
        $sql = "SELECT * FROM users WHERE id = '{$id}'";
        return $this->db->query($sql);

    }
    public function addLike($comment_id,$likes)
    {
        $likes = $likes + 1;
        $sql = "UPDATE comments SET likes = '{$likes}' WHERE id = '{$comment_id}'";
        return $this->db->query($sql);
    }
    public function reduceLike($comment_id,$likes)
    {
        $likes = $likes + 1;
        $sql = "UPDATE comments SET unlikes = '{$likes}' WHERE id = '{$comment_id}'";
        return $this->db->query($sql);
    }

    public function getUserByLogin($login){
        $sql = "SELECT * FROM users WHERE login = '{$login}'";
        return $this->db->query($sql);
    }
    public function saveComment($news_id,$data)
    {

        $is_visible = 1;
        $login = $this->db->escape($data['login']);
        $comment = $this->db->escape($data['comment']);
        $date = date("Y-m-d");
        $sql = "INSERT INTO comments
            set comment = '{$comment}',
                user_id = '{$login}',
                news_id = '{$news_id}',
                date = '{$date}',
                is_visible = '{$is_visible}'";
        return $this->db->query($sql);
    }

    public function countComments($user_id){
        $sql = "SELECT COUNT(id) as cnt, user_id FROM comments WHERE user_id = '{$user_id}'";
        return $this->db->query($sql);
    }

    public function getAllUsers(){
        $sql = "SELECT * FROM users";
        return $this->db->query($sql);
    }

    public function getList1()
    {
        $sql = "SELECT * FROM news ORDER BY date DESC";
        return $this->db->query($sql);
    }

    public function getCategories1()
    {
        $sql = "SELECT `id`,`category_name` FROM categories";
        return $this->db->query($sql);
    }

    public function getTags1()
    {
        $sql = "SELECT * FROM tags";
        return $this->db->query($sql);
    }

    public function getById($id)
    {
        $id = (int)$id;
        $sql = "SELECT * FROM news where id = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function save($data, $id = null)
    {
        if (!isset($data['img_link']) || !isset($data['news_name'])  || !isset($data['content'])) {
            return false;
        }
        $id = (int)$id;
        $link = $this->db->escape($data['img_link']);
        $title  = $this->db->escape($data['news_name']);
        $content = $this->db->escape($data['content']);
        $category = $this->db->escape($data['category']);
        $tag = $this->db->escape($data['tag']);
        $date = date('Y-m-d');

        if ( !$id ) { // Add new record
            $sql = "
                    INSERT INTO news
                    set news_name = '{$title}',
                        content = '{$content }',
                         img_link = '{$link}',
                        category_id = '{$category}',
                        tag1_id = '{$tag}',
                        date = '{$date}'

            ";
        } else {// Update existing record
            $sql = "
                    UPDATE news
                    set news_name = '{$title}',
                        content = '{$content }',
                         img_link = '{$link}',
                        category_id = '{$category}',
                        tag1_id = '{$tag}'
                    WHERE id = '{$id}'
            ";
        }

        return $this->db->query($sql);
    }

    public function delete($id)
    {
        $id = (int)$id;
        $sql = "DELETE FROM news WHERE id = '{$id}'";
        return $this->db->query($sql);
    }

}