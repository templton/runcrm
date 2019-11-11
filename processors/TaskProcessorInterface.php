<?php

/**
 * Интерфейс (или один из интерфейсов) для всех возможных Task, которые могут быть назначены пользователю
 * setCourier и setTask скорее всего будут присуствовать во всех возможных реализациях процессора, поэтому ставим эти
 * методы в общий интерфейс; если будет иначе, то, возможно, необходимо будет вынести их в отдельных интейрфейс
 */

namespace app\processors;

interface TaskProcessorInterface
{
    /**
     * Курьер, выполняющий задачу
     * @param \app\models\Courier $courier
     * @return mixed
     */
    public function setCourier(\app\models\Courier $courier);

    /**
     * Сама задача, которую необходимо выполнить
     * @param \app\models\Task $task
     * @return mixed
     */
    public function setTask(\app\models\TaskInterface $task);

    /**
     * Реализация логики выполнения задачи
     * @return mixed
     */
    public function execute();
}
