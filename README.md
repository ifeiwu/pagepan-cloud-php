# Pagepan Cloud SDK PHP

## 快速安装
```
composer require ifeiwu/pagepan-cloud-php
```

## 开始使用

```php
require_once 'vendor/autoload.php';

$client = new PagepanCloud\WebsiteClient(ACCESS_TOKEN);
```

### 添加网站基本信息
```php
// 更多例子：example/website.php
$res = $client->addInfo('https://test.example.com');
```
