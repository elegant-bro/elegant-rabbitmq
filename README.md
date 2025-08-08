## Example of simple exchange and queue declaration

Let's say we have some abstract pizza order flow

```php

use ElegantBro\RabbitMQ\BindPair;
use ElegantBro\RabbitMQ\Declaration;

$config = Declaration::new()
    ->withExchange('app.pizza_exchange', 'direct')
    ->withQueue('app.pizza_order_queue')
    ->bindToQueue(
        'app.pizza_order_queue',
        [
            new BindPair('app.pizza_exchange', 'ordered'),
            new BindPair('app.pizza_exchange', 'cooking'),
            new BindPair('app.pizza_exchange', 'courier_has_left'),
            new BindPair('app.pizza_exchange', 'delivered'),
        ],
    )
    ->finish()
```

and then in some command which runs at your CI/CD pipeline 
```php

use PhpAmqpLib\Connection\AbstractConnection;
use ElegantBro\RabbitMQ\Config;

class DoRabbitDeclarationCommand
{
    private AbstractConnection $rabbitConn;
    
    private Config $config
       
    public function __construct(
        AbstractConnection $rabbitConn,
        Config $config,
    ) {
        $this->rabbitConn = $rabbitConn;
        $this->config = $config;
    }
    
    public function __invoke(): void {
        $ch = $this->rabbitConn->channel();
        foreach ($this->config->exchanges() as $exchange) {
            $exchange->declare($ch);
        }
        foreach ($this->config->queues() as $queue) {
            $queue->declare($ch);
        }
        foreach ($this->config->bindings() as $binding) {
            $binding->bind($ch);
        }
        foreach ($this->config->unbindings() as $unbinding) {
            $unbinding->unbind($ch);
        }
        foreach ($this->config->deletingQueues() as $queueToDelete) {
            $queueToDelete->delete($ch);
        }
        foreach ($this->config->deletingExchanges() as $exchangeToDelete) {
            $exchangeToDelete->delete($ch);
        }
    }
}
```

Once defined you could leave this code as it is. If you run this command once again it did not throw any exceptions and will not create any new rabbit entities

## Example of exchanges or queues manipulation after it is created

Let's say we would like to unbind `cooking` pair from queue. Of course, you could simple login to Rabbit management page and stuff there, but...

```php

use ElegantBro\RabbitMQ\BindPair;
use ElegantBro\RabbitMQ\Declaration;

$config = Declaration::new()
    ->withExchange('app.pizza_exchange', 'direct')
    ->withQueue('app.pizza_order_queue')
    ->bindToQueue(
        'app.pizza_order_queue',
        [
            new BindPair('app.pizza_exchange', 'ordered'),
            new BindPair('app.pizza_exchange', 'courier_has_left'),
            new BindPair('app.pizza_exchange', 'delivered'),
        ],
    )
    ->unbindFromQueue(
        'app.pizza_order_queue',
        [
            new BindPair('app.pizza_exchange', 'cooking'),
        ],
    )    
    ->finish()
```

and after deployment `cooking` will unbind. Before your next release, if you want, you could remove `unbindFromQueue` call. It is okay if you do not remove it, you will not get any side effects.

Next, once upon a time your PM will tell you we are now switching from pizza delivery to sushi delivery. We do not need pizza queue and exchange anymore

```php

use ElegantBro\RabbitMQ\Declaration;

$config = Declaration::new()
    ->withoutQueue('app.pizza_order_queue',)
    ->withoutExchange('app.pizza_exchange')    
    ->finish()
```