<?php
$dsn = "mysql:host=localhost; dbname=module_4_news";
$user = 'root';
$password = '111111';
try {
    $dbh = new PDO ($dsn, $user, $password);
} catch (PDOException $e) {
    echo $e->getMessage();
}
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // превращаем ошибки в исключения
$dbh->query("SET NAMES utf8");

    if($_POST['tag']) {
        $tag = $_POST['tag'];
        $sth = $dbh->query("SELECT * FROM tags WHERE `tag_name` LIKE '%{$tag}%'");
        $cat = $sth->fetchAll(PDO::FETCH_ASSOC);
        echo "<option class='text-muted'>Выберите тег:</option>
              <option></option>";

        foreach ($cat as $item) {

            echo "<option value='/pages/tags/{$item['id']}'>{$item['tag_name']}</option>";
        }
    }
