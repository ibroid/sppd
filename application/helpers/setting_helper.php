<?php

use Illuminate\Database\Eloquent\Model;

if (!function_exists("pengaturan")) {

    class Pengaturan extends Model
    {
        // protected $connection = 'default';
        protected $table = 'pengaturan';
        protected $guarded = [];
    }

    function pengaturan()
    {
        return new class
        {
            function __construct()
            {
                $data = Pengaturan::get();
                foreach ($data as $key => $value) {
                    $sj = $value['name'];
                    $this->$sj =  $value['value'];
                }
            }

            public function update($key, $value): void
            {
                Pengaturan::where('name', $key)->update([
                    'value' => $value
                ]);
            }
        };
    }
}


if (!function_exists("prindie")) {
    function prindie(...$data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die;
    }
}
