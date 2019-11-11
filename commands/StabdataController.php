<?php

namespace app\commands;

use app\models\Courier;
use app\models\Location;
use app\models\Task;
use yii\console\Controller;
use yii\console\ExitCode;

class StabdataController extends Controller
{
    public function actionIndex()
    {
        $faker=\Faker\Factory::create('ru_RU');

        echo "\nFill address table...\n";
        $data=[];
        for($i=0; $i<100; $i++){
            $data[]=[
                $faker->city,
                $faker->streetName,
                $faker->numberBetween(1,500)
            ];
        }
        \Yii::$app->db->createCommand()->batchInsert('address', [
            'town','street','house'
        ], $data)->execute();

        echo "\nFill location table...\n";
        $data=[];
        for($i=1; $i<99; $i++){
            $data[]=[
                $faker->company,
                $faker->numberBetween(1,99)
            ];
        }
        \Yii::$app->db->createCommand()->batchInsert('location', [
            'title',
            'address_id'
        ], $data)->execute();

        echo "\nFill client table...\n";
        $data=[];
        for($i=0; $i<100; $i++){
            $data[]=[
                $faker->firstNameFemale,
                $faker->lastName
            ];
        }
        \Yii::$app->db->createCommand()->batchInsert('client', [
            'name',
            'surname'
        ], $data)->execute();

        echo "\nFill order table...\n";
        $data=[];
        for($i=1; $i<99; $i++){
            $data[]=[
                $faker->numberBetween(1,50)
            ];
        }
        \Yii::$app->db->createCommand()->batchInsert('order', [
            'client_id'
        ], $data)->execute();

        echo "\nFill courier table...\n";
        $data=[];
        for($i=1; $i<99; $i++){
            $data[]=[
                $faker->firstNameMale,
                $faker->lastName
            ];
        }
        \Yii::$app->db->createCommand()->batchInsert('courier', [
            'name',
            'surname'
        ], $data)->execute();

        echo "\nFill shipment table...\n";
        $data=[];
        for($i=1; $i<99; $i++){
            $data[]=[
                $faker->numberBetween(1,30),
                $faker->text(20),
                $faker->numberBetween(1200,10000),
                $faker->numberBetween(1,50),
                $faker->numberBetween(51,97)
            ];
        }
        \Yii::$app->db->createCommand()->batchInsert('shipment', [
            'order_id',
            'title',
            'price',
            'location_id1',
            'location_id2'
        ], $data)->execute();


        //Ставим таски для нескольких пользователей
        $task=new Task();
        $task->link('courier',Courier::findOne(1));
        $task->link('location',Location::findOne(1));
        $task->save();

        $task=new Task();
        $task->link('courier',Courier::findOne(2));
        $task->link('location',Location::findOne(2));
        $task->save();

        $task=new Task();
        $task->link('courier',Courier::findOne(3));
        $task->link('location',Location::findOne(3));
        $task->save();

        //На location=4 ставим несколько курьеров: один загрузится, остальные разгрузятся

        $task=new Task();
        $task->link('courier',Courier::findOne(1));
        $task->link('location',Location::findOne(4));
        $task->save();

        $task=new Task();
        $task->link('courier',Courier::findOne(2));
        $task->link('location',Location::findOne(4));
        $task->save();


        $task=new Task();
        $task->link('courier',Courier::findOne(3));
        $task->link('location',Location::findOne(4));
        $task->save();
    }
}
