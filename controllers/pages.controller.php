<?php
/**
 * Created by PhpStorm.
 * User: kito
 * Date: 22.05.16
 * Time: 17:14
 */

 class PagesController extends Controller
 {

     public function __construct($data = array())
     {
         parent::__construct($data);
         $this->model = new Page();

     }

     public function index(){
         $this->data['categories'] = $this->model->getCategories();
         $this->data['lastFiveNews'] = $this->model->getLastFiveNewsEachCategory();
         $this->data['slide'] = $this->model->getLastNews();
         $this->data['lastFiveAnalytics'] = $this->model->getLastAnalytics();

         $users = $this->model->getAllUsers();
         foreach ($users as $user){
             $this->data['top_comments'][$user['id']] = $this->model->countComments($user['id']);
         }
         foreach ($this->data['top_comments'] as $value){
             foreach($value as $item){
                 $this->data['top'][] = $item;
             }
         }
         foreach($this->data['top'] as $value){
             $this->data['commentators'][$value['user_id']] = $value['cnt'];
         }
         arsort($this->data['commentators']);
         $this->data['commentators'] = array_flip($this->data['commentators']);

         foreach ($this->data['commentators'] as $commentator){
             $this->data['top_commentators'][] = $this->model->getUserById($commentator);
         }
     }




     public function view() {
         $params = App::getRouter()->getParams();
         if (isset($params[0])){
             $id = strtolower($params[0]);
             $this->data['category'] = $this->model->getCategoryById($id);
             $this->data['param_1'] = 1;
             $this->data['count']= $this->model->getNumberOfPages($id);
             $this->data['news'] = $this->model->getPaginationNews($_GET['page'],$id);


         }

         if (isset($params[1])){

             if(isset($_POST['like'])){
                 $this->model->addLike($_POST['comment_id'], $_POST['likes']);
             }
             if(isset($_POST['unlike'])){
                 $this->model->reduceLike($_POST['comment_id'], $_POST['unlikes']);
             }
             $id = strtolower($params[1]);
             $this->data['news_one'] = $this->model->getNewsById($id);
             $this->data['param_2'] = 2;
             $this->data['readers'] = $this->model->updateReaders($this->data['news_one'][0]['id'],$this->data['news_one'][0]['numb_readers']);
             $tags =[$this->data['news_one'][0]['tag1_id'],$this->data['news_one'][0]['tag2_id'],$this->data['news_one'][0]['tag3_id'],
                 $this->data['news_one'][0]['tag4_id']];
             $this->data['tags']= $this->model->getTags($tags);

             if(isset($_POST['comment']) && (mb_strlen($_POST['comment'])>5)){
                 $user_id = $this->model->getUserByLogin($_POST['login']);
                 $_POST['login'] = $user_id[0]['id'];

                 $this->model->saveComment($params[1], $_POST);
             }
             $this->data['comments'] = $this->model->getCommentsByNewsId($this->data['news_one'][0]['id']);
         }


     }
     public function tags()
     {
         $params = App::getRouter()->getParams();
         if (isset($params[0])){
             $id = strtolower($params[0]);
             $this->data['tag'] = $this->model->getTagById($id);
             $this->data['param_1'] = 1;
             $this->data['count']= $this->model->getNumberOfPagesTags($id);
             $this->data['news'] = $this->model->getPaginationNewsByTag($_GET['page'],$id);
             $this->data['category'] = $this->model->getCategoryById($this->data['news'][0]['category_id']);
         }
     }

     public function user()
     {
         $params = App::getRouter()->getParams();
         if(isset($params[0])){
             $id = strtolower($params[0]);
             $this->data['user'] = $this->model->getUserById($id);
             $this->data['count'] = $this->model->getNumberOfPagesComments($id);
             $this->data['news'] = $this->model->getPaginationCommentsByUser($_GET['page'],$id);
         }
     }








     public function admin_index()
     {
         $this->data['pages1'] = $this->model->getList1();
     }

     public function admin_add()
     {

         $this->data['categories'] = $this->model->getCategories1();
         $this->data['tags'] = $this->model->getTags1();

         if ($_POST) {
             $this->model->save($_POST);
             Router::redirect('/admin/pages/');
         }
     }

     public function admin_edit()
     {

         if ($_POST) {
             $id = $_POST['id'];
             $this->model->save($_POST, $id);

             Router::redirect('/admin/pages/');
         }

         $this->data['categories'] = $this->model->getCategories1();
         $this->data['tags'] = $this->model->getTags1();
         if(isset($this->params[0])) {
             $this->data['page'] = $this->model->getById($this->params[0]);
         } else {
             Session::setFlash('Wrong page id.');
             Router::redirect('/admin/pages/');
         }

     }

     public function admin_delete(){
         if (isset($this->params[0])) {
             $result = $this->model->delete($this->params[0]);
             if ($result) {
                 Session::setFlash('Page was saved');
             } else {
                 Session::setFlash('Error.');
             }
             Router::redirect('/admin/pages/');

         }
     }
 }