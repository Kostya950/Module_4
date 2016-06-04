<?php
/**
 * Created by PhpStorm.
 * User: kito
 * Date: 03.06.16
 * Time: 23:46
 */

class SearchController extends Controller
{
    public function __construct($data=array())
    {
        parent::__construct($data);
        $this->model = new Searcher();
    }

    public function index()
    {
        $this->data['categories'] = $this->model->getCategories();
        $this->data['tags'] = $this->model->getTags();

        if($_GET){
            $this->data['news'] = $this->model->getNewsBySearch();
        }
    }



}
