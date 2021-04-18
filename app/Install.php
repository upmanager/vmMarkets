<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Artisan;
use Illuminate\Support\Facades\Schema;

class Install
{
    public static function init(){
        Artisan::call('key:generate');
        echo Artisan::output();
        echo "<br>";

        Artisan::call('migrate');
        echo Artisan::output();
        echo "<br>";

        //Install passport migration
        Artisan::call('migrate', ['--path' => 'vendor/laravel/passport/database/migrations']);
        echo Artisan::output();
        echo "<br>";
        Artisan::call('passport:install');  //or  echo shell_exec('php ../artisan passport:install');
        echo Artisan::output();
        echo "<br>";

        /*
         * ERROR:
         * The command "passport:install" does not exist.
         *
         * add to file app/Console/Kernel.php
              protected $commands = [
                \Laravel\Passport\Console\InstallCommand::class,
                \Laravel\Passport\Console\KeysCommand::class,
                \Laravel\Passport\Console\ClientCommand::class,
               ];
         */

        Artisan::call('db:seed');
        echo Artisan::output();
        echo "<br>";


        //
        User::create(            [
            'name'=>'Owner',
            'email'=>'owner@abg-studio.com',
            'password'=> bcrypt('123456'),
            'role' => '1',
        ]);

        //
        DB::table('settings')->insert(['param' => 'version', 'value' => '1.0.0', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        //
        // settings
        //
        DB::table('settings')->insert(['param' => 'default_tax', 'value' => '10', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'demo_mode', 'value' => 'false', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'notify_image', 'value' => '100', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('image_uploads')->insert(['id' => 100, 'filename' => 'notify.png', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);

        //
        // payments
        //
        DB::table('settings')->insert(['param' => 'StripeEnable', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'stripeKey', 'value' => '', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'stripeSecretKey', 'value' => '', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'razEnable', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'razKey', 'value' => '', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'razName', 'value' => 'My Company Name', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'cashEnable', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);

        Schema::create('currencies', function ($table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('symbol');
            $table->string('code');
            $table->integer('digits');
        });

        //
        // Currencies
        //
        DB::table('settings')->insert(['param' => 'default_currencies', 'value' => '$', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'default_currencyCode', 'value' => 'USD', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'rightSymbol', 'value' => 'false', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        //
        DB::table('currencies')->insert(['name' => 'US Dollar', 'symbol' => '$', 'code' => 'USD', 'digits' => 2, 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('currencies')->insert(['name' => 'Euro', 'symbol' => '€', 'code' => 'EUR', 'digits' => 2, 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);

        // firebase
        DB::table('settings')->insert(['param' => 'firebase_key', 'value' => '', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);

        // ui customer app
        DB::table('settings')->insert(['param' => 'radius', 'value' => '3', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'shadow', 'value' => '10', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'row1', 'value' => 'search', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'row2', 'value' => 'topr', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'row3', 'value' => 'topf', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'row4', 'value' => 'cat', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'row5', 'value' => 'pop', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'row6', 'value' => 'nearyou', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'row7', 'value' => 'review', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'row1visible', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'row2visible', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'row3visible', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'row4visible', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'row5visible', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'row6visible', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'row7visible', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'mainColor', 'value' => '668798', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'iconColorWhiteMode', 'value' => '000000', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'iconColorDarkMode', 'value' => '', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'restaurantCardWidth', 'value' => '60', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'restaurantCardHeight', 'value' => '40', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'restaurantBackgroundColor', 'value' => 'FFFFFF', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'restaurantCardTextSize', 'value' => '16', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'restaurantCardTextColor', 'value' => '', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'restaurantTitleColor', 'value' => 'FFFFFF', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'dishesTitleColor', 'value' => 'FFFFFF', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'dishesBackgroundColor', 'value' => 'FFFFFF', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'dishesCardHeight', 'value' => '', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'oneInLine', 'value' => 'false', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'categoriesTitleColor', 'value' => 'FFFFFF', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'categoriesBackgroundColor', 'value' => 'FFFFFF', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'categoryCardWidth', 'value' => '25', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'categoryCardHeight', 'value' => '25', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'searchBackgroundColor', 'value' => 'FFFFFF', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'reviewTitleColor', 'value' => 'FFFFFF', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'reviewBackgroundColor', 'value' => 'FFFFFF', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'categoryCardCircle', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'darkMode', 'value' => 'false', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'topRestaurantCardHeight', 'value' => '', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'bottomBarType', 'value' => 'type1', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'bottomBarColor', 'value' => 'FFFFFF', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'titleBarColor', 'value' => 'FFFFFF', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'mapapikey', 'value' => '', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'typeFoods', 'value' => 'type2', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);

        DB::table('settings')->insert(['param' => 'walletEnable', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        // 18.11.2020
        DB::table('settings')->insert(['param' => 'payPalEnable', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'payPalSandBox', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'payPalClientId', 'value' => '', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'payPalSecret', 'value' => '', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'payStackEnable', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'payStackKey', 'value' => '', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'distanceUnit', 'value' => 'km', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'appLanguage', 'value' => '1', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);

        Schema::create('orders', function ($table) {
            $table->id();
            $table->timestamps();
            $table->integer('user');
            $table->integer('driver');
            $table->integer('status');
            $table->string('pstatus');
            $table->integer('tax');
            $table->longText('hint');
            $table->boolean('active');
            $table->integer('restaurant');
            $table->string('method');
            $table->decimal('total', 15, 2);
            $table->decimal('fee', 15, 2);
            $table->boolean('send');
            $table->string('address');
            $table->string('phone');
            $table->string('lat');
            $table->string('lng');
            $table->boolean('percent');
            $table->string('curbsidePickup')->nullable();
            $table->string('arrived')->nullable();
            $table->string('couponName')->nullable();
            $table->integer('vendor')->default(0);
        });

        Schema::create('restaurants', function ($table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->boolean('published');
            $table->boolean('delivered');
            $table->string('phone');
            $table->string('mobilephone');
            $table->string('address');
            $table->string('lat');
            $table->string('lng');
            $table->integer('imageid');
            $table->longText('desc');
            $table->decimal('fee', 15, 2);
            $table->boolean('percent');
            $table->string('openTimeMonday')->nullable();
            $table->string('closeTimeMonday')->nullable();
            $table->string('openTimeTuesday')->nullable();
            $table->string('closeTimeTuesday')->nullable();
            $table->string('openTimeWednesday')->nullable();
            $table->string('closeTimeWednesday')->nullable();
            $table->string('openTimeThursday')->nullable();
            $table->string('closeTimeThursday')->nullable();
            $table->string('openTimeFriday')->nullable();
            $table->string('closeTimeFriday')->nullable();
            $table->string('openTimeSaturday')->nullable();
            $table->string('closeTimeSaturday')->nullable();
            $table->string('openTimeSunday')->nullable();
            $table->string('closeTimeSunday')->nullable();
            $table->integer('area')->nullable();
            $table->decimal('minAmount', 15, 2);
            $table->integer('commission')->default(0);
            $table->integer('tax')->default(0);
        });

        Schema::create('orderstatuses', function ($table) {
            $table->id();
            $table->timestamps();
            $table->string('status');
        });

        DB::table('orderstatuses')->insert([
            'status' => "Order Received",
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
        DB::table('orderstatuses')->insert([
            'status' => "Preparing",
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
        DB::table('orderstatuses')->insert([
            'status' => "Ready",
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
        DB::table('orderstatuses')->insert([
            'status' => "On the Way",
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
        DB::table('orderstatuses')->insert([
            'status' => "Delivered",
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
        DB::table('orderstatuses')->insert([
            'status' => "Canceled",
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);

        Schema::create('roles', function ($table) {
            $table->id();
            $table->timestamps();
            $table->string('role');
        });
        DB::table('roles')->insert([
            'role' => "Owner",
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
        DB::table('roles')->insert([
            'role' => "Vendor",
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
        DB::table('roles')->insert([
            'role' => "Driver",
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
        DB::table('roles')->insert([
            'role' => "User",
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);

        Schema::create('docs', function ($table) {
            $table->id();
            $table->timestamps();
            $table->string('param');
            $table->longText('value');
        });
        DB::table('docs')->insert(['param' => 'copyright', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'copyright_text', 'value' => '2021 Markets. All Rights Reserved', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'about', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'about_text', 'value' => 'About us', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'delivery', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'delivery_text', 'value' => 'Delivery info', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'privacy', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'privacy_text', 'value' => 'Privacy Policy', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'terms', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'terms_text', 'value' => 'Terms and Condition', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'refund', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'refund_text', 'value' => 'Refund Text', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'refund_text_name', 'value' => 'Refund Policy', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'about_text_name', 'value' => 'About Us', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'delivery_text_name', 'value' => 'Delivery info', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'privacy_text_name', 'value' => 'Privacy Policy', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'terms_text_name', 'value' => 'Terms and Condition', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'about_ca', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'delivery_ca', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'privacy_ca', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'terms_ca', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'refund_ca', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->insert(['param' => 'copyright_ca', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);

        Schema::create('notifications', function ($table) {
            $table->id();
            $table->timestamps();
            $table->integer('user');
            $table->string('title');
            $table->longText('text');
            $table->string('image');
            $table->integer('show');
            $table->integer('read');
            $table->string('uid');
            $table->string('delete');
        });

        Schema::create('foods', function ($table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->integer('imageid');
            $table->decimal('price', 15, 2);
            $table->decimal('discountprice', 15, 2);
            $table->longText('desc');
            $table->integer('restaurant');
            $table->integer('category');
            $table->longText('ingredients');
            $table->string('unit');
            $table->integer('packageCount');
            $table->integer('weight');
            $table->boolean('canDelivery');
            $table->integer('stars');
            $table->boolean('published');
            $table->integer('extras');
            $table->integer('nutritions');
            $table->integer('vendor')->default(0);
        });

        Schema::create('banners', function ($table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->integer('imageid');
            $table->string('type');
            $table->longText('details');
            $table->boolean('visible');
            $table->string('position');
            $table->integer('vendor')->default(0);
        });

        Schema::create('categories', function ($table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->integer('imageid');
            $table->longText('desc');
            $table->boolean('visible');
            $table->integer('vendor')->default(0);
        });

        Schema::create('ordersdetails', function ($table) {
            $table->id();
            $table->timestamps();
            $table->integer('order');
            $table->string('food');
            $table->integer('count');
            $table->decimal('foodprice', 15, 2);
            $table->string('extras');
            $table->integer('extrascount');
            $table->decimal('extrasprice', 15, 2);
            $table->integer('foodid');
            $table->integer('extrasid');
            $table->string('image');
        });

        Schema::create('faq', function ($table) {
            $table->id();
            $table->timestamps();
            $table->longText('question');
            $table->longText('answer');
            $table->boolean('published');
        });

        Schema::create('chat', function ($table) {
            $table->id();
            $table->timestamps();
            $table->integer('from_user');
            $table->integer('to_user');
            $table->string('text');
            $table->string('delivered');
            $table->string('read');
        });

        DB::table('settings')->insert(['param' => 'medialib_type', 'value' => 'medium', 'vendor' => '0', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        // time zone - default UTC
        DB::table('settings')->insert(['param' => 'timezone', 'value' => 'UTC', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        // yandex kassa
        DB::table('settings')->insert(['param' => 'yandexKassaEnable', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'yandexKassaShopId', 'value' => '', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'yandexKassaClientAppKey', 'value' => '', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'yandexKassaSecretKey', 'value' => '', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        // instamojo
        DB::table('settings')->insert(['param' => 'instamojoEnable', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'instamojoSandBoxMode', 'value' => '', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'instamojoApiKey', 'value' => '', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'instamojoPrivateToken', 'value' => '', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);

        DB::table('settings')->insert(['param' => 'faq_ca', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'row10', 'value' => 'categoryDetails', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'row10visible', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'row11', 'value' => 'copyright', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'row11visible', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        //
        DB::table('settings')->insert(['param' => 'googleLogin_ca', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'facebookLogin_ca', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        //
        DB::table('settings')->insert(['param' => 'defaultLat', 'value' => '51.511680332118786', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'defaultLng', 'value' => '-0.12748138132489592', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
    }

    public static function update0(){

        if (!Schema::hasTable('topfoods')) {
            Schema::create('topfoods', function ($table) {
                $table->id();
                $table->timestamps();
                $table->integer('food');
            });
        }
        if (!Schema::hasTable('toprestaurants')) {
            Schema::create('toprestaurants', function ($table) {
                $table->id();
                $table->timestamps();
                $table->integer('restaurant');
            });
        }
        if (!Schema::hasTable('restaurantsreviews')) {
            Schema::create('restaurantsreviews', function ($table) {
                $table->id();
                $table->timestamps();
                $table->longText('desc');
                $table->integer('user');
                $table->string('rate');
                $table->integer('restaurant');
            });
        }

        if (!Schema::hasTable('coupons')) {
            Schema::create('coupons', function ($table) {
                $table->id();
                $table->timestamps();
                $table->string('name');
                $table->dateTime('dateStart');
                $table->dateTime('dateEnd');
                $table->decimal('discount', 15, 2);
                $table->boolean('published');
                $table->boolean('inpercents');
                $table->decimal('amount', 15, 2);
                $table->string('desc');
                $table->boolean('allRestaurants');
                $table->boolean('allCategory');
                $table->boolean('allFoods');
                $table->longText('restaurantsList');
                $table->longText('categoryList');
                $table->longText('foodsList');
                $table->integer('vendor')->default(0);
            });
        }

        if (count(DB::table('settings')->where("param", 'otp')->get()) == 0)
            DB::table('settings')->insert(['param' => 'otp', 'value' => 'false', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        if (count(DB::table('settings')->where("param", 'curbsidePickup')->get()) == 0)
            DB::table('settings')->insert(['param' => 'curbsidePickup', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        if (count(DB::table('settings')->where("param", 'delivering')->get()) == 0)
            DB::table('settings')->insert(['param' => 'delivering', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        if (count(DB::table('settings')->where("param", 'coupon')->get()) == 0)
            DB::table('settings')->insert(['param' => 'coupon', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        if (count(DB::table('settings')->where("param", 'deliveringTime')->get()) == 0)
            DB::table('settings')->insert(['param' => 'deliveringTime', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        if (count(DB::table('settings')->where("param", 'banner1CardHeight')->get()) == 0)
            DB::table('settings')->insert(['param' => 'banner1CardHeight', 'value' => '40', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        if (count(DB::table('settings')->where("param", 'banner2CardHeight')->get()) == 0)
            DB::table('settings')->insert(['param' => 'banner2CardHeight', 'value' => '40', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        if (count(DB::table('settings')->where("param", 'row8')->get()) == 0)
            DB::table('settings')->insert(['param' => 'row8', 'value' => 'banner1', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        if (count(DB::table('settings')->where("param", 'row9')->get()) == 0)
            DB::table('settings')->insert(['param' => 'row9', 'value' => 'banner2', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        if (count(DB::table('settings')->where("param", 'row8visible')->get()) == 0)
            DB::table('settings')->insert(['param' => 'row8visible', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        if (count(DB::table('settings')->where("param", 'row9visible')->get()) == 0)
            DB::table('settings')->insert(['param' => 'row9visible', 'value' => 'true', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);


        if (!Schema::hasTable('variants')) {
            Schema::create('variants', function ($table) {
                $table->id();
                $table->timestamps();
                $table->integer('food');
                $table->string('name');
                $table->integer('imageid')->default(0);
                $table->decimal('price', 15, 2);
                $table->decimal('dprice', 15, 2)->default(0);
            });
        }

        if (!Schema::hasTable('rproducts')) {
            Schema::create('rproducts', function ($table) {
                $table->id();
                $table->timestamps();
                $table->integer('food');
                $table->integer('rp');
            });
        }

        if (!Schema::hasTable('foodsreviews')) {
            Schema::create('foodsreviews', function ($table) {
                $table->id();
                $table->timestamps();
                $table->longText('desc');
                $table->integer('user');
                $table->string('rate');
                $table->integer('food');
            });
        }

        if (!Schema::hasTable('favorites')) {
            Schema::create('favorites', function ($table) {
                $table->id();
                $table->timestamps();
                $table->integer('user');
                $table->integer('food');
            });
        }

        if (!Schema::hasTable('address')) {
            Schema::create('address', function ($table) {
                $table->id();
                $table->timestamps();
                $table->integer('user');
                $table->longText('text');
                $table->string('lat');
                $table->string('lng');
                $table->string('type');
                $table->string('default');
            });
        }

        if (!Schema::hasTable('ordertimes')) {
            Schema::create('ordertimes', function ($table) {
                $table->id();
                $table->timestamps();
                $table->integer('order_id');
                $table->integer('status');
                $table->integer('driver');
                $table->string('comment');
            });
        }

        if (!Schema::hasTable('wallet')) {
            Schema::create('wallet', function ($table) {
                $table->id();
                $table->timestamps();
                $table->integer('user');
                $table->decimal('balans', 15, 2);
            });
        }

        if (!Schema::hasTable('walletlog')) {
            Schema::create('walletlog', function ($table) {
                $table->id();
                $table->timestamps();
                $table->integer('user');
                $table->decimal('amount', 15, 2);
                $table->decimal('total', 15, 2);
                $table->boolean('arrival');
                $table->string('comment');
            });
        }

        if (!Schema::hasTable('logging')) {
            Schema::create('logging', function ($table) {
                $table->id();
                $table->timestamps();
                $table->longText('data');
            });
        }

        //
        //
        //
        //
        //
        //
        if (!Schema::hasColumn('orders', 'view'))
            DB::statement("ALTER TABLE orders ADD COLUMN view VARCHAR(255) DEFAULT 'false'");
        // subcategories
        if (!Schema::hasColumn('categories', 'parent'))
            DB::statement("ALTER TABLE categories ADD COLUMN parent int(11) DEFAULT 0");
        // social network sign in ("google", "email")
        if (!Schema::hasColumn('users', 'typeReg'))
            DB::statement("ALTER TABLE users ADD COLUMN typeReg VARCHAR(255) DEFAULT 'email'");

        //
        DB::table('settings')->insert(['param' => 'web_mainColor', 'value' => '0089a8', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'web_mainColorHover', 'value' => '00b9e3', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'web_radius', 'value' => '6', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->insert(['param' => 'web_logo', 'value' => '99', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        DB::table('image_uploads')->insert(['id' => 99, 'filename' => 'weblogo.png', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);

    }
}
