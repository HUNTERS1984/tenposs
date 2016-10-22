<?php

use Illuminate\Database\Seeder;

class FaqTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\FaqType::class,4)->create()
        	->each(function($faqtype){
        		$faqtype->faqs()->saveMany(factory(App\Models\Faq::class,4)->make());
        	});
    }
}
