<?php

    /**
     *  Comments plugin
     *
     *  @package Monstra
     *  @subpackage Plugins
     *  @author Romanenko Sergey / Awilum
     *  @copyright 2012 Romanenko Sergey / Awilum
     *  @version 1.2.0
     *
     */


    // Register plugin
    Plugin::register( __FILE__,
                    __('Comments', 'comments'),
                    __('Comments plugin for Monstra', 'comments'),
                    '1.2.0',
                    'Awilum',
                    'http://monstra.org/',
                    null,
                    'box');


    // Load comments Admin for Editor and Admin
    if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin', 'editor'))) {
        Plugin::admin('comments','box');
    }


 
    class Comments
    {

        private static $comments_records = '';
        private static $comments_form = '';
        private static $page = array();
        private static $comments = null;
        private static $records = array();
        private static $username = "";
        private static $email    = "";
        private static $message  = "";
        private static $available  = false;
        private static $errors  = array();
        private static $pagesList  = array();



        private static function getData()
        {
            if(Pages::$requested_page  != null){
            	Comments::$page = Pages::$pages->select('[slug="'.Pages::$requested_page.'"]', 'all')[0];
            	Comments::$comments = new Table('comments');
            	Comments::$records = Comments::$comments->select('[page="'.Pages::$requested_page.'"]', 'all', null,null , 'date', 'DESC');
                Comments::$pagesList = Pages::$pages->select('[slug!="error404" and (template="post" or template="index")]', 'all', null, null, 'parent', 'DESC');
                
                Comments::$available = (Comments::$page["no_comments"] != true) && in_array(Comments::$page["slug"],array_map(function($o){return $o["slug"];},Comments::$pagesList));

               }else{
                Comments::$available = false;
               }
        }


        private static function actionsHandler()
        {

            Comments::$username = Request::post('comments_username');
            Comments::$email    = Request::post('comments_email');
            Comments::$message  = Request::post('comments_message');

            Comments::$errors = array();
            
            // Add new record
            if (Request::post('comments_submit')) {
                if (Security::check(Request::post('csrf'))) {
                    if (Request::post('comments_username') == '' || Request::post('comments_email') == '' || Request::post('comments_message') == '') {
                        Comments::$errors['comments_empty_fields'] = __('Empty required fields!', 'comments');
                    }

                    if (!Valid::email(Request::post('comments_email'))) {
                        Comments::$errors['comments_email_not_valid'] = __('Email address is not valid!', 'comments');
                    }

                    if (Option::get('captcha_installed') == 'true' && ! CryptCaptcha::check(Request::post('answer'))) {
                        Comments::$errors['users_captcha_wrong'] = __('Captcha code is wrong', 'users');
                    }

                    if (count(Comments::$errors) == 0) {
                        Comments::$comments->insert(array('username' => Comments::$username, 'email' => Comments::$email, 'message' => Comments::$message, 'date' => time(),'page'=> Comments::$page["slug"]));
                        Comments::$username = "";
                        Comments::$email = "";
                        Comments::$message = "";
                        Comments::$errors = array();
                    }
                } else {
                    die('csrf detected!');
                }
            }
        }


        private static function generateView()
        {
        
            Comments::$comments_records = View::factory('box/comments/views/frontend/index')
                        ->assign('records', Comments::$records)
                        ->render();

            // Get form view
            Comments::$comments_form = View::factory('box/comments/views/frontend/form')
                        ->assign('username', Comments::$username)
                        ->assign('email', Comments::$email)
                        ->assign('message', Comments::$message)
                        ->assign('errors', Comments::$errors)
                        ->render();
        }

        
        private static function content()
        {
            return Comments::$comments_records.Comments::$comments_form;
        }


        public static function init()
        {
            Comments::getData();
            if (Comments::$available == true) {
                Comments::actionsHandler();
                Comments::getData();
                Comments::generateView();
                return Comments::content();
            }
        }
    }
