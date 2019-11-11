<?php

/**
 * Одна из конкретных реализаций логики обработки Task-а
 * В данной реализации первый курьер, прибывший на адресс, забирает все свободные доставки
 */

namespace app\processors;

use app\models\Shipment;
use app\processors\TaskProcessorInterface;
use app\models\Task;
use yii\db\Exception;

class ShipmentTaskProcessor implements TaskProcessorInterface
{
    /**
     * @var app\models\Task Задача, которую нужно обработать
     */
    private $_task;

    /**
     * @var app\models\Courier Курьер, которому поставлено в работу обрабатываемое задание
     */
    private $_courier;

    public function setCourier(\app\models\Courier $courier){
        $this->_courier=$courier;
    }

    public function setTask(\app\models\TaskInterface $task){
        $this->_task=$task;
    }

    /**
     * Выполняется обработка конкретного задания для конкретного курьера
     * Необходимо обеспечить, чтобы в один момент времени выполнялась только один процесс обработки
     * для связки курьер/задание
     * @return mixed|void
     */
    public function execute()
    {
        if (!$this->_task->setTaskInProcess())
            throw new \Exception("Task {$this->_task->id} is already in process");

        echo "Курьер ID = {$this->_courier->id}, current task ID = ".$this->_task->id."<br>";

        $this->setFreeShipmentsToCourier();

        $this->pushDeliveredShipments();

        $this->_task->setTaskComplete();
    }

    /**
     * Поставить все свободные доставки на курьера
     */
    private function setFreeShipmentsToCourier(){

        echo "    Ставим на курьера все свободные доставки на данном адресе: ";

        $countUpdateItems=Shipment::updateAll(
                [
                    'status'=>Shipment::STATUS_ACTIVE,
                    'courier_id'=>$this->_courier->id
                ],
                [
                    'and',
                    ['=','status',Shipment::STATUS_NEW],
                    ['=','location_id1',$this->_task->location->id],
                    ['is','courier_id',null]
                ]
            );

        echo "Поставлено $countUpdateItems записей<br>";

    }

    /**
     * Забрать у курьера доставки для текущего адреса
     * За каждую доставку курьеру начислить оплату, указанную в доставке
     */
    private function pushDeliveredShipments(){
        echo "    Выдать все доставки для данного адреса, которые стоят на пользователе<br>";

        $data=Shipment::find()
            ->where('location_id2='.$this->_task->location->id)
            ->andWhere('status='.Task::PROCESS_IN_WORK)
            ->andWhere('courier_id='.$this->_courier->id)
            ->all();

        //Перебираем все доставки пользователя для данного адреса, которые нужно выдать
        foreach ($data as $shipment){
            echo "Выдается shipment ID=".$shipment->id.", стоимость = {$shipment->price}<br>";
        }

    }
}