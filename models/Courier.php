<?php

namespace app\models;

use app\models\interfaces\AccountInterface;
use yii\db\ActiveRecord;
use app\models\interfaces\AccountGettingInterface;

class Courier extends ActiveRecord implements AccountGettingInterface
{
    /**
     * Получить все задачи курьера
     * @return \yii\db\ActiveQuery
     */
    public function getTasks(){
        return $this->hasMany(Task::className(),['courier_id'=>'id'])->inverseOf('courier');
    }

    /**
     * Выполнить все имеющиеся задания
     * Каждое задание имеет класс, реализующий интерфейс работы с таском - TaskProcessorInterface
     */
    public function executeTasks(){
        foreach ($this->getTasks()->andWhere('in_process="'.Task::PROCESS_FREE.'"')->all() as $task) {
            try{
                $task->getTaskProcessor()->execute();
            }catch (\Throwable $e){
                \Yii::error($e->getMessage().', File '.$e->getFile().', Line '.$e->getLine(), 'execute_task');
            }
        }
    }

    public function getAccount(): AccountInterface
    {
        return $this->hasOne(Account::className(), ['id'=>'account_id']);
    }
}