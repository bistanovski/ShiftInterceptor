<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Request;
use App\Validations\RabbitMQValidations;
use GuzzleHttp\Exception\GuzzleException;

class RabbitMQController extends Controller
{

  /**
   * Get new instance of ShiftRay version of GuzzleClient
   */
  private static function getGuzzleClient()
  {
    return new GuzzleClient(['base_uri' => env('RABBITMQ_HOST') . '/api/',
      'auth' => [env('RABBITMQ_USER'), env('RABBITMQ_PASSWORD')],
      'headers' => [ 'Content-Type' => 'application/json' ]
    ]);
  }

  /**
   * Get RabbitMQ Status
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getStatus(Request $request)
  {
    $client = RabbitMQController::getGuzzleClient();
    
    $res = $client->request('GET', 'overview');
    $body = $res->getBody();
    return response()->webApi($body->getContents(), 200);
  }

  /**
   * Get RabbitMQ Exchanges
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getExchanges(Request $request)
  {
    $client = RabbitMQController::getGuzzleClient();
    
    $res = $client->request('GET', 'exchanges');
    echo $res->getBody();
    return response()->webApi($res->getBody()->getContents(), 200);
  }

  /**
   * Create RabbitMQ Exchange
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
   */
  public function createExchange(Request $request)
  {
    $params = $request->only(RabbitMQValidations::paramsByFunction[__FUNCTION__]);
    $validateStatus = $this->_validateUserParams($params, RabbitMQValidations::rulesByFunction[__FUNCTION__]);
    if(true !== $validateStatus)
    {
      return response()->webApi(['error' => $validateStatus], 401);
    }

    $client = RabbitMQController::getGuzzleClient();
    $res = $client->request('PUT', 'exchanges/' . env('RABBITMQ_ACTIVE_VHOST') . '/' . $params['exchange_name'], 
      [
      'json' => ['type' => $params['type'],
                 'auto_delete' => $params['auto_delete'],
                 'durable' => $params['durable'],
                 'internal' => $params['internal'],
                 'arguments' => $params['arguments']
      ]
    ]);

    return response()->webApi('', $res->getStatusCode());
  }

  /**
   * Delete RabbitMQ Exchange
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
   */
  public function deleteExchange(Request $request)
  {
    $params = $request->only(RabbitMQValidations::paramsByFunction[__FUNCTION__]);
    $validateStatus = $this->_validateUserParams($params, RabbitMQValidations::rulesByFunction[__FUNCTION__]);
    if(true !== $validateStatus)
    {
      return response()->webApi(['error' => $validateStatus], 401);
    }

    $client = RabbitMQController::getGuzzleClient();
    $res = $client->request('DELETE', 'exchanges/' . env('RABBITMQ_ACTIVE_VHOST') . '/' . $params['exchange_name'], 
      [
      'json' => ['type' => $params['type'],
                 'arguments' => $params['arguments']
      ]
    ]);

    return response()->webApi('', $res->getStatusCode());
  }

  /**
   * Get RabbitMQ Bindings
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getBindings(Request $request)
  {
    $client = RabbitMQController::getGuzzleClient();
    
    $res = $client->request('GET', 'bindings/' . env('RABBITMQ_ACTIVE_VHOST'));
    echo $res->getBody();
    return response()->webApi($res->getBody()->getContents(), 200);
  }
  
  /**
   * Create RabbitMQ Binding
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
   */
  public function createBinding(Request $request)
  {
    $params = $request->only(RabbitMQValidations::paramsByFunction[__FUNCTION__]);
    $validateStatus = $this->_validateUserParams($params, RabbitMQValidations::rulesByFunction[__FUNCTION__]);
    if(true !== $validateStatus)
    {
      return response()->webApi(['error' => $validateStatus], 401);
    }

    $client = RabbitMQController::getGuzzleClient();
    $res = $client->request('POST', 'bindings/' . env('RABBITMQ_ACTIVE_VHOST') . '/e/' . $params['exchange_name'] . '/q/' . $params['queue_name'] , 
    [
      'json' => ['routing_key' => $params['routing_key'],
                 'arguments' => $params['arguments']
      ]
    ]);

    return response()->webApi('', $res->getStatusCode());
  }
  
  /**
   * Get RabbitMQ Queues
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getQueues(Request $request)
  {
    $client = RabbitMQController::getGuzzleClient();
    
    $res = $client->request('GET', 'queues/' . env('RABBITMQ_ACTIVE_VHOST'));
    echo $res->getBody();
    return response()->webApi($res->getBody()->getContents(), 200);
  }

  /**
   * Create RabbitMQ Queue
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
   */
  public function createQueue(Request $request)
  {
    $params = $request->only(RabbitMQValidations::paramsByFunction[__FUNCTION__]);
    $validateStatus = $this->_validateUserParams($params, RabbitMQValidations::rulesByFunction[__FUNCTION__]);
    if(true !== $validateStatus)
    {
      return response()->webApi(['error' => $validateStatus], 401);
    }

    $client = RabbitMQController::getGuzzleClient();
    $res = $client->request('PUT', 'queues/' . env('RABBITMQ_ACTIVE_VHOST') . '/' . $params['queue_name'], 
    [
      'json' => ['auto_delete' => $params['auto_delete'],
                 'durable' => $params['durable'],
                 'internal' => $params['internal'],
                 'arguments' => $params['arguments']
      ]
    ]);

    return response()->webApi('', $res->getStatusCode());
  }

  /**
   * Delete RabbitMQ Queue
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
   */
  public function deleteQueue(Request $request)
  {
    $params = $request->only(RabbitMQValidations::paramsByFunction[__FUNCTION__]);
    $validateStatus = $this->_validateUserParams($params, RabbitMQValidations::rulesByFunction[__FUNCTION__]);
    if(true !== $validateStatus)
    {
      return response()->webApi(['error' => $validateStatus], 401);
    }

    $client = RabbitMQController::getGuzzleClient();
    $res = $client->request('DELETE', 'queues/' . env('RABBITMQ_ACTIVE_VHOST') . '/' . $params['queue_name'], 
    [
      'json' => [
        'arguments' => $params['arguments']
        ]
    ]);

    return response()->webApi('', $res->getStatusCode());
  }

  /**
   * Clear RabbitMQ Queue content
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
   */
  public function clearContent(Request $request)
  {
    $params = $request->only(RabbitMQValidations::paramsByFunction[__FUNCTION__]);
    $validateStatus = $this->_validateUserParams($params, RabbitMQValidations::rulesByFunction[__FUNCTION__]);
    if(true !== $validateStatus)
    {
      return response()->webApi(['error' => $validateStatus], 401);
    }

    $client = RabbitMQController::getGuzzleClient();
    $res = $client->request('DELETE', 'queues/' . env('RABBITMQ_ACTIVE_VHOST') . '/' . $params['queue_name'] . '/contents');

    return response()->webApi('', $res->getStatusCode());
  }
}
 