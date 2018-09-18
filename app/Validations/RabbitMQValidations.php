<?php

namespace App\Validations;

abstract class RabbitMQValidations 
{
  const paramsByFunction = [
    'createExchange' => ['exchange_name', 'type', 'auto_delete', 'durable', 'internal', 'arguments'],
    'deleteExchange' => ['exchange_name', 'type', 'arguments'],
    'createBinding' => ['exchange_name', 'queue_name', 'routing_key', 'arguments'],
    'createQueue' => ['queue_name', 'auto_delete', 'durable', 'internal', 'arguments'],
    'deleteQueue' => ['queue_name', 'arguments'],
    'clearContent' => ['queue_name'],
  ];
  
  const rulesByFunction = [
    'createExchange' => [
      'exchange_name' => 'required|string|min:6|max:255',
      'type' => 'required|string|in:direct,fanout,topic,headers',
      'auto_delete' => 'required|boolean',
      'durable' => 'required|boolean',
      'internal' => 'required|boolean',
      'arguments' => 'nullable'
    ],
    'deleteExchange' => [
      'exchange_name' => 'required|string|min:6|max:255',
      'type' => 'required|string|in:direct,fanout,topic,headers',
      'arguments' => 'nullable'
    ],
    'createBinding' => [
      'exchange_name' => 'required|string|min:6|max:255',
      'queue_name' => 'required|string|min:6|max:255',
      'routing_key' => 'required|string|min:3|max:100',
      'arguments' => 'nullable'
    ],
    'createQueue' => [
      'queue_name' => 'required|string|min:6|max:255',
      'auto_delete' => 'required|boolean',
      'durable' => 'required|boolean',
      'internal' => 'required|boolean',
      'arguments' => 'nullable'
    ],
    'deleteQueue' => [
      'queue_name' => 'required|string|min:6|max:255',
      'arguments' => 'nullable'
    ],
    'clearContent' => [
      'queue_name' => 'required|string|min:6|max:255'
    ],
  ];
}