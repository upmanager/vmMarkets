<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Install;
use Auth;

class InstallController extends Controller
{
    public static function update()
    {
        if (!Schema::hasTable('settings')) {
            Install::init();
            DB::table('settings')->insert(['param' => 'install', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
            Install::update0();
        }

        if (!Schema::hasColumn('foods', 'images'))
            DB::statement("ALTER TABLE foods ADD COLUMN images VARCHAR(255)");
        if (!Schema::hasColumn('restaurants', 'perkm'))
            DB::statement("ALTER TABLE restaurants ADD COLUMN perkm tinyint(1) default 0");
        if (!Schema::hasColumn('orders', 'perkm'))
            DB::statement("ALTER TABLE orders ADD COLUMN perkm tinyint(1) default 0 ");
        if (!Schema::hasColumn('users', 'lat'))
            DB::statement("ALTER TABLE users ADD COLUMN lat VARCHAR(255) default ''");
        if (!Schema::hasColumn('users', 'lng'))
            DB::statement("ALTER TABLE users ADD COLUMN lng VARCHAR(255) default ''");
        if (!Schema::hasColumn('users', 'speed'))
            DB::statement("ALTER TABLE users ADD COLUMN speed VARCHAR(255) default ''");

        // skins
        if (count(DB::table('settings')->where("param", 'skin')->get()) == 0)
            DB::table('settings')->insert(['param' => 'skin', 'value' => 'basic', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        // seller registration
        if (count(DB::table('settings')->where("param", 'sellerText1')->get()) == 0)
            DB::table('settings')->insert(['param' => 'sellerText1',
                'value' => 'Our ambition
                        To revolutionize the world of e-commerce by offering each and every one of our clients a unique experience in terms of technology, functionalities and
                        business acumen and ensuring that their marketplace earns them a market-leading position.', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        if (count(DB::table('settings')->where("param", 'sellerText11')->get()) == 0)
            DB::table('settings')->insert(['param' => 'sellerText11',
                'value' => '01. Free Opening of You Store', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        if (count(DB::table('settings')->where("param", 'sellerText12')->get()) == 0)
            DB::table('settings')->insert(['param' => 'sellerText12',
                'value' => '02. Commissions Lower then the Average', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        if (count(DB::table('settings')->where("param", 'sellerText13')->get()) == 0)
            DB::table('settings')->insert(['param' => 'sellerText13',
                'value' => '03. Fast and Stable Payments System', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        if (count(DB::table('settings')->where("param", 'sellerText14')->get()) == 0)
            DB::table('settings')->insert(['param' => 'sellerText14',
                'value' => '04. Millions of shoppers are waiting to visit your store', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);

        if (count(DB::table('settings')->where("param", 'sellerText20')->get()) == 0)
            DB::table('settings')->insert(['param' => 'sellerText20',
                'value' => 'Be a part of a new digital economy!', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);

        if (count(DB::table('settings')->where("param", 'sellerImage1')->get()) == 0){
            DB::table('image_uploads')->insert(['filename' => 'seller1.jpg', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
            DB::table('settings')->insert(['param' => 'sellerImage1', 'value' => DB::getPdo()->lastInsertId(), 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
            DB::table('image_uploads')->insert(['filename' => 'seller2.jpg', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
            DB::table('settings')->insert(['param' => 'sellerImage2', 'value' => DB::getPdo()->lastInsertId(), 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
            DB::table('image_uploads')->insert(['filename' => 'seller3.jpg', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
            DB::table('settings')->insert(['param' => 'sellerImage3', 'value' => DB::getPdo()->lastInsertId(), 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
            DB::table('image_uploads')->insert(['filename' => 'seller4.jpg', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
            DB::table('settings')->insert(['param' => 'sellerImage4', 'value' => DB::getPdo()->lastInsertId(), 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        }

        if (!Schema::hasTable('sellersregs')) {
            Schema::create('sellersregs', function ($table) {
                $table->id();
                $table->timestamps();
                $table->string('name');
                $table->string('email');
                $table->string('password');
            });
        }


        //
        //
        // set Time Zone
        //
        $timezone = DB::table('settings')->where('param', '=', "timezone")->get()->first()->value;
        date_default_timezone_set($timezone);

        DB::table('settings')->where("param", 'version')->update(['value' => '1.8.5', 'updated_at' => new \DateTime(),]);

//        $text = "remote: " . $_SERVER['REMOTE_ADDR'] . " method: " . $_SERVER['REQUEST_METHOD'] . " addr: " . $_SERVER['REQUEST_URI'];
        // logging
//        DB::table('logging')->insert([
//            'data' => "$text",
//            'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        // clear log (more then 30 days)
        $now = new \DateTime();
        $datetime = $now->modify('-30 day');
        DB::table('logging')->where('updated_at', '<', $datetime)->delete();
    }
}
