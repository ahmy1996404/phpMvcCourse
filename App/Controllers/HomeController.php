<?php

namespace App\Controllers ;

use System\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $data['my_name'] = 'Ahmed Hamouda';
       return $this->view->render('home' , $data);
    }
}
