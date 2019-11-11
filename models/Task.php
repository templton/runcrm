<?php

/**
 * Некий Task, который можно поставить курьеру в работу
 */

namespace app\models;

use yii\db\ActiveRecord;
use app\models\TaskInterface;
use app\processors\ShipmentTaskProcessor;

class Task extends ActiveRecord implements TaskInterface
{
    const PROCESS_FREE=0;
    const PROCESS_IN_WORK=1;
    const PROCESS_COMPLETE=2;

    /**
     * @var string Класс по умочланию для обработки задания
     */
    private $_defaultTaskProcessorClass='app\processors\ShipmentTaskProcessor';

    /**
     * @var string Данный интерфейс должны реализовывать все процессоры, которые используются для обработки задания
     */
    private $_requiredTaskProcessorInterfase='app\processors\TaskProcessorInterface';

    /**
     * Возвращает объект курьера, которому принадлежит данное задание
     * @return \yii\db\ActiveQuery
     */
    public function getCourier(){
        return $this->hasOne(Courier::className(), ['id'=>'courier_id']);
    }

    /**
     * Возвращает объект локации, на которую заведено данное задание
     * @return \yii\db\ActiveQuery
     */
    public function getLocation(){
        return $this->hasOne(Location::className(), ['id'=>'location_id']);
    }

    /**
     * Каждое задание может быть обработано по-разному. Например, по умолчанию используется такой обработчик, при котором
     * курьер прибывает на адрес и забирает ВСЕ СВОБОДНЫЕ доставки. Но в каком-то случае будет использоваться другая
     * логика. В этом месте можно подменить релизацию интерфейса TaskProcessInterfase каким-то другим конкретным классом.
     *
     * Например, можно вообще создать отдельную таблицу типов задач (task-ов) и каждому типа поставить разные классы,
     * по своему реализующие интерфейс работы с задачей
     */
    public function getTaskProcessor(){
        //Данное название класса может приходить из БД или может быть задано параметром. Пока что берем дефолтное
        $classNameProcessor=$this->_defaultTaskProcessorClass;

        $processor=new $classNameProcessor;

        //TODO Не только исключение, но и логгировать с указанием короткого контекста: какая задача, при каких условиях
        if (!($processor instanceof $this->_requiredTaskProcessorInterfase))
            throw new \Exception("Error in getting class name processor. $classNameProcessor is not an instance of {$this->_requiredTaskProcessorInterfase}");

        $processor->setCourier($this->courier);

        $processor->setTask($this);

        return $processor;
    }

    /**
     * Освободить task - поставить флаг, что task в данный момент не обрабатывается
     */
    public function setTaskComplete(){
        $this->in_process=self::PROCESS_COMPLETE;
        $this->save();
    }

    /**
     * Поставить задачу в работу.
     * То есть фактически проверить, что другой процесс не взял данную задачу в обработку
     * @return bool true - если задача поставлена в работу, false - задача уже находилась в работе
     */
    public function setTaskInProcess(){

        $blocked=self::findForUpdate($this->id);

        if ($blocked->in_process==self::PROCESS_IN_WORK || $blocked->in_process==self::PROCESS_COMPLETE)
            return false;

        $blocked->in_process=self::PROCESS_IN_WORK;
        $blocked->save();

        $this->in_process=self::PROCESS_IN_WORK;

        return true;
    }

    /**
     * Выбрать задачу из базы в режиме эксклюзивной блокировки
     * @param int $id
     * @return array|ActiveRecord|null
     */
    private static function findForUpdate(int $id)
    {
        $sql = self::find()
            ->where(['id' => $id])
            ->createCommand()
            ->getRawSql();

        return self::findBySql($sql . ' FOR UPDATE')->one();
    }

}