<?php

/**
 * Любая реализация Task-а в системе должна следовать данному интерфейсу
 */

namespace app\models;

interface TaskInterface
{
    public function setTaskInProcess();

    public function setTaskComplete();

    public function getTaskProcessor();

    public function getCourier();

    public function getLocation();
}