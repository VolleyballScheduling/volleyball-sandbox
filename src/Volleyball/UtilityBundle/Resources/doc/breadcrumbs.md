### Volleyball
## Breadcrumbs

```php
# generte
$breadcrumbs = $this->get('volleyball_breadcrumbs');

# basic link item
$breadcrumbs->addItem('home', $this->get('router')->generate('homepage'));

# basic text item
$breadcrumbs->addItem('text item');

# parameter injection
$breadcrumbs->addItem($text, $url, array("%users%" => $user->getName()));
```
# Render
```html
{{ volleyball_breadcrumbs }}
```