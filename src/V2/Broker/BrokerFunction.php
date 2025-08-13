<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2\Broker;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Exception\AMQPExceptionInterface;

interface BrokerFunction
{
    /**
     * @throws AMQPExceptionInterface
     */
    public function call(AMQPChannel $ch): void;
}
