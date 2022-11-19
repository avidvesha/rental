<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FrontUser;
use App\Models\Admin;

class DefaultData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data['name'] = 'Avidvesha Daivadianta';
        $data['password'] = bcrypt(123456);
        $data['email'] = 'apit.scorpio10@gmail.com';
        $data['phone'] = '081226785784';

        Admin::create($data);
        
        $cdata['name'] = 'Krisna Irawan';
        $cdata['password'] = bcrypt(123456);
        $cdata['email'] = 'krisnazen@gmail.com';
        
        FrontUser::create($cdata);
    }
}
