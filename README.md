# subscriptions-manager

## Database
```Database name: subscriptions_manager```

```port: 3306```

```host: localhost```

Import db_structure.sql & db_data.sql if initial data is needed.

You can configure DB routing by modifying ```app/config/site.ini```

## Build
Run ```composer install```

## Run
Run ```./start_php_dev_server.sh```

## API
Import Postman workspace from ```360VUZ.postman_collection```

Routes can be found in ```app/config/routings.ini```

## Instructions
You can generate dummy merchants by calling ```POST /merchants/createDummyMerchant```

A merchant can subscribe to a partner's subscription by calling ```POST POST /subscribe``` while providing subscription type and the partner.

