# DaiDP Application Insights
Application Insight for Larvel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/phuocdaivl/app-insights?style=flat-square)](https://packagist.org/packages/phuocdaivl/app-insights)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/phuocdaivl/app-insights/master.svg?style=flat-square)](https://travis-ci.org/phuocdaivl/app-insights)
[![Total Downloads](https://img.shields.io/packagist/dt/phuocdaivl/app-insights.svg?style=flat-square)](https://packagist.org/packages/phuocdaivl/app-insights)

This library uses the [official Application Insights PHP API](https://packagist.org/packages/microsoft/application-insights). To get started, you should have a basic knowledge of how Application Insights works (Tracking Event, Tracking Error, Tracking PageView, Tracking Request, ...).

## Download & Install
```bash
composer require phuocdaivl/app-insights
```

## Add service provider
Add the service provider to the providers array in the <span style='color:red'>`config/app.php`</span> config file as follows:

```bash
'providers' => [

    ...

    DaiDP\AppInsights\Providers\AzureAppInsightsProvider::class,
]
```

Well done.

### Handle Error
Open file <span style='color:red'>`app/Exceptions/Handler.php`</span> and add following code:
```bash
public function render($request, Exception $exception)
{
    $telemetry = app()->get(\DaiDP\AppInsights\TelemetryClient::class);
    $telemetry->trackException($exception);
    $telemetry->flush();
    
    ...
}
```

### Log customize error
- Add log from try catch
```bash
try {
  // To do something
  ...
} catch(\Exception $ex) {
    $telemetry = app()->get(\DaiDP\AppInsights\TelemetryClient::class);
    $telemetry->trackException($ex);
    $telemetry->flush();
}
```

- Add any customize log
```bash
$ex = new Exception('Some message');

$telemetry = app()->get(\DaiDP\AppInsights\TelemetryClient::class);
$telemetry->trackException($ex);
$telemetry->flush();
```
