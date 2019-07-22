Uso
=====

Crear un Plan
-------------



    use Gerardojbaez\Laraplans\Models\Plan;
    use Gerardojbaez\Laraplans\Models\PlanFeature;

    $plan = Plan::create([
        'name' => 'Pro',
        'description' => 'Pro plan',
        'price' => 9.99,
        'interval' => 'month',
        'interval_count' => 1,
        'trial_period_days' => 15,
        'sort_order' => 1,
    ]);

    $plan->features()->saveMany([
        new PlanFeature(['code' => 'listings', 'value' => 50, 'sort_order' => 1]),
        new PlanFeature(['code' => 'pictures_per_listing', 'value' => 10, 'sort_order' => 5]),
        new PlanFeature(['code' => 'listing_duration_days', 'value' => 30, 'sort_order' => 10]),
        new PlanFeature(['code' => 'listing_title_bold', 'value' => 'Y', 'sort_order' => 15])
    ]);

Acceso a las características del plan
-----------------------

En algunos casos, necesita acceder a una función particular en un plan particular, puede lograr esto utilizando el método `` getFeatureByCode`` disponible en el modelo `` Plan``.

Ejemplo:



    $feature = $plan->getFeatureByCode('pictures_per_listing');
    $feature->value // Obtener el valor de la característica

Crear una Suscripción
---------------------

Primero, recupere una instancia de su modelo de suscriptor, que normalmente será su modelo de usuario y una instancia del plan al que se está suscribiendo. Una vez que haya recuperado la instancia del modelo, puede usar el método `` newSubscription`` (disponible en el rasgo `` PlanSubscriber``) para crear la suscripción del modelo.



    use Auth;
    use Gerardojbaez\Laraplans\Models\Plan;

    $user = Auth::user();
    $plan = Plan::find(1);

    $user->newSubscription('main', $plan)->create();

El primer argumento pasado al método `` newSubscription`` debe ser el nombre de la suscripción. Si su aplicación ofrece una suscripción única, puede llamar a este `` main`` o `` primary``. El nombre de la suscripción no es el nombre del Plan, es un identificador de suscripción * único *. El segundo argumento es la instancia de plan a la que se está suscribiendo el usuario.

Resolución de suscripciones
----------------------

Cuando utilice el método `` abono () `` (es decir, `` $ usuario-> abono ('principal') ``) en el modelo suscriptor para recuperar un abono, recibirá la última suscripción creada del abonado y El nombre de la suscripción. Por ejemplo, si se suscribe * Jane Doe * a * Free plan * y, posteriormente, a * Pro plan *, Laraplans devolverá la suscripción con el * Pro plan * porque es la suscripción más reciente disponible. Si tiene un requisito diferente, puede usar su propia resolución de suscripción vinculando una implementación de `` Gerardojbaez \ Laraplans \ Contracts \ SubscriptionResolverInterface`` al `service container`__; al igual que:

https://documentacion-laravel.com/container.html#introduction



    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SubscriptionResolverInterface::class, CustomSubscriptionResolver::class);
    }

Habilidad de la suscripción
----------------------

Hay varias formas de determinar el uso y la capacidad de una característica en particular en la suscripción del usuario, la más común es `` canUse``:

El método `` canUse`` devuelve `` true`` o `` false`` dependiendo de múltiples factores:

- La característica *is enabled*
- El valor de la característica no es ``0``.
- O la característica tiene usos restantes disponibles



    $user->subscription('main')->ability()->canUse('listings');

**Hay otras formas de determinar la capacidad de una suscripción:**

- ``enabled``: devuelve `` true`` cuando el valor de la característica es una *positive word* listada en el archivo de configuración.
- ``consumed``: devuelve la cantidad de veces que el usuario ha usado una característica en particular.
- ``remainings``: devuelve los usos disponibles para una característica en particular.
- ``value``: devuelve el valor de la característica.

Todos los métodos comparten la misma firma: ``$user->subscription('main')->ability()->consumed('listings');``.

Registro de uso de funciones
--------------------

Para utilizar de manera efectiva los métodos de habilidad, deberá realizar un seguimiento de cada uso de las funciones basadas en el uso. Puedes usar el método ``record`` disponible a través del método ``SubscribeUsage ()`` del usuario:



    $user->subscriptionUsage('main')->record('listings');

El método `` record`` acepta 3 parámetros: el primero es el código de la función, el segundo es la cantidad de usos para agregar (el valor predeterminado es ``1``), y el tercero indica si el uso debe incrementarse (``true``: comportamiento predeterminado) o sobrescrito (``false``).

Vea el siguiente ejemplo:



    // Incremento por 2
    $user->subscriptionUsage('main')->record('listings', 2);

    // Anular con 9
    $user->subscriptionUsage('main')->record('listings', 9, false);

Reducir el uso de características
--------------------

Reducir el uso de la función es *casi * lo mismo que aumentarla. En este caso solo * restamos * una cantidad dada (el valor predeterminado es ``1``) para el uso real:



    // Reducir en 1
    $user->subscriptionUsage('main')->reduce('listings');

    // Reducir en 2
    $user->subscriptionUsage('main')->reduce('listings', 2);


Borrar los datos de uso de la suscripción
---------------------------------

En algunos casos, tendrá que borrar todos los usos en una suscripción de usuario particular, puede lograr esto utilizando el método ``clear``:



    $user->subscriptionUsage('main')->clear();

Verificar el estado de la suscripción
-------------------------

Para que una suscripción se considere **active** la suscripción debe tener una versión de prueba activa o la suscripción ``ends_at`` está en el futuro.



    $user->subscribed('main');
    $user->subscribed('main', $planId); // Compruebe si la suscripción está activa Y utilizando un plan particular

Alternativamente, puede usar los siguientes métodos disponibles en el modelo de suscripción:



    $user->subscription('main')->isActive();
    $user->subscription('main')->isCanceled();
    $user->subscription('main')->isCanceledImmediately();
    $user->subscription('main')->isEnded();
    $user->subscription('main')->isOnTrial();

.. caution::
    **Suscripciones** canceladas **con** una prueba activa o ``ends_at`` en el futuro se consideran activas.

Renovar una suscripción
--------------------

Para renovar una suscripción, puede utilizar el método ``renew`` disponible en el modelo de suscripción. Esto establecerá una nueva fecha ``ends_at`` basada en el plan seleccionado y **borrará los datos de uso** de la suscripción.



    $user->subscription('main')->renew();

.. caution::
    Las suscripciones canceladas con un período finalizado no se pueden renovar.

El evento ``RafaelMorenoJS\Plans\Events\SubscriptionRenewed`` se activa cuando una suscripción se renueva con el método ``renew``.

Cancelar una suscripción
---------------------

Para cancelar una suscripción, simplemente use el método ``cancel`` en la suscripción del usuario:



    $user->subscription('main')->cancel();


De forma predeterminada, la suscripción permanecerá activa hasta que finalice el período. Pase ``true`` a *immediately* cancelar una suscripción.



    $user->subscription('main')->cancel(true);

