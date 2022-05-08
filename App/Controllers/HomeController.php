<?php

namespace App\Controllers ;

use System\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // echo $this->db->data([
        //      'users_group_id'=>0,
        //      'first_name'=>'ahmed',
        //      'last_name'=>'hamouda',
        //      'password'=>'123456',
        //      'image'=>'test.jpg',
        //      'gender'=>'male',
        //      'birthday'=>'12312312',
        //      'email' => 'ahmed',
        //      'status' =>'disable',
        //      'created'=> '1231231231',
        //      'ip'=>'192.168.1.115',
        //  ])->table('users')->insert()->lastId();
        //     $this->db->data('ip','192.168.1.111')
        //     ->where('id = ? ',1)
        //  ->update('users');
    }
}
