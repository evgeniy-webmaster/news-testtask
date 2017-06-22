<?php
namespace app\fixtures;

use yii\test\ActiveFixture;

class NewsFixture extends ActiveFixture
{
    public $modelClass = 'app\models\News';

    protected function getData()
    {
        //echo __DIR__; die();
        $faker = \Faker\Factory::create();

        $out = [];
        for($i = 0; $i < 50; $i++) {
            $img = $faker->image('/tmp', 640, 480, 'cats');
            rename($img, \Yii::getAlias('@app/web/news-images/') . $i . '.jpg');
            //unlink($img);

            $out[$i]['authorId'] = rand(1, 2);
            $out[$i]['title'] = $faker->sentence();
            $out[$i]['shortText'] = $faker->paragraph();
            $out[$i]['text'] = $faker->text();
            $out[$i]['status'] = rand(0, 1);
            $out[$i]['updated_at'] = $faker->unixTime();
            $out[$i]['created_at'] = $faker->unixTime($out[$i]['updated_at']);
        }
        return $out;
    }

    public function unload()
    {
        parent::unload();
        $newsImgsDir = \Yii::getAlias('@app/web/news-images/');
        foreach(scandir($newsImgsDir) as $file) {
            if($file == '.' || $file == '..') continue;
            unlink($newsImgsDir . $file);
        }
    }
}
