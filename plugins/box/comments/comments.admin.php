<?php

    // Admin Navigation: add new item
    Navigation::add(__('Comments', 'comments'), 'content', 'comments', 5);
   

    
class CommentsAdmin extends Backend
{


    private static $page = array();
    private static $pagesList = array();
    private static $records = array();
    private static $comments = null;
    private static $pages = null;
    private static $available = false;

    private static function getData()
    {
        CommentsAdmin::$pages = new Table('pages');
        CommentsAdmin::$comments = new Table('comments');
        CommentsAdmin::$pagesList = CommentsAdmin::$pages->select('[slug!="error404" and (template="post" or template="index")]', 'all', null, null, 'parent', 'DESC');
        if (Request::get("page") == "") {
            CommentsAdmin::$page = array("slug"=>"", "no_comments"=> false);
            CommentsAdmin::$records = CommentsAdmin::$comments->select(null, 'all', null, null, 'date', 'DESC');
        } else {
            CommentsAdmin::$page = CommentsAdmin::$pages->select('[slug="'.Request::get("page").'"]', 'all')[0];
            CommentsAdmin::$records = CommentsAdmin::$comments->select('[page="'.Request::get("page").'"]', 'all', null, null, 'date', 'DESC');
        }
        
        CommentsAdmin::$available = in_array(CommentsAdmin::$page["slug"],array_map(function($o){return $o["slug"];},CommentsAdmin::$pagesList));
        
    }

    private static function actionsHandler()
    {
        // Get comments table
        if (Security::check(Request::get('token'))) {
            if (Request::get('action') &&  Request::get('action') == 'delete_record' && Request::get('record_id')) {
                CommentsAdmin::$comments->delete((int)Request::get('record_id'));
                Request::redirect("index.php?id=comments&page=".CommentsAdmin::$page["slug"]);
            }

            if (Request::get('action') &&  Request::get('action') == 'enable_comments' && Request::get('page')) {
                CommentsAdmin::$pages->update(CommentsAdmin::$page["id"], array("no_comments"=>false));
                Notification::set('success', __("Comments Enabled", "comments"));
            }

            if (Request::get('action') &&  Request::get('action') == 'disable_comments' && Request::get('page')) {
                CommentsAdmin::$pages->update(CommentsAdmin::$page['id'], array("no_comments"=>true));
                Notification::set('success', __("Comments Disabled", "comments"));
            }
        }
    }


    private static function generateView()
    {
        
        View::factory('box/comments/views/backend/index')
        ->assign('records', CommentsAdmin::$records)
        ->assign('pages', CommentsAdmin::$pagesList)
        ->assign('current', CommentsAdmin::$page)
        ->display();
    }


    public static function main()
    {
        CommentsAdmin::getData();
        CommentsAdmin::actionsHandler();
        CommentsAdmin::getData();
        CommentsAdmin::generateView();
    }
}
