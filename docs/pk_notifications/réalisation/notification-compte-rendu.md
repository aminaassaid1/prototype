---
layout: default
chapitre : true
package: pkg_competences
order:  630
---

### Création de la Composer View 

```shell
cd ../../prototype/app

mkdir app/View/Composers/pkg_notificationsTest

cd app/View/Composers/pkg_notificationsTest

type NotificationComposer.php
```

### Création de la ViewComposer Service Provider

```shell
php artisan make:provider pkg_notification/ViewComposerServiceProvider
```

### Ajouter ViewComposerServiceProvider à confing/app.php

```php
'providers' => [
    App\Providers\pkg_notifications\ViewComposerServiceProvider::class
]
```