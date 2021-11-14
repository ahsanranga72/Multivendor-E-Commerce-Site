<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product_name = $this->faker->unique()->words($nb=4,$asText=true);
        $slug = Str::slug($product_name);
        return [
            'name'=> $product_name,
            'slug'=>$slug,
            'seller_id'=> '2',
            's_desc'=> $this->faker->text(200),
            'desc'=>$this->faker->text(500),
            're_price'=>$this->faker->numberBetween(100, 500),
            'sku'=>$this->faker->unique()->numberBetween(100, 500),
            'stock_status'=>'instock',
            'quantity'=>$this->faker->numberBetween(10, 50),
            'image'=>'digital_'.$this->faker->unique()->numberBetween(1,20).'jpg',
            'category_id'=>$this->faker->numberBetween(1,5),
        ];
    }
}
