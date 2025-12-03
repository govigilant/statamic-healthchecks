<a href="https://github.com/govigilant/vigilant" title="Vigilant">
    <img src="./art/banner.png" alt="Banner">
</a>

# Vigilant Statamic Healthchecks

<p>
    <a href="https://github.com/govigilant/statamic-healthchecks"><img src="https://img.shields.io/github/actions/workflow/status/govigilant/statamic-healthchecks/tests.yml?label=tests&style=flat-square" alt="Tests"></a>
    <a href="https://github.com/govigilant/statamic-healthchecks"><img src="https://img.shields.io/github/actions/workflow/status/govigilant/statamic-healthchecks/analyse.yml?label=analysis&style=flat-square" alt="Analysis"></a>
    <a href="https://github.com/govigilant/statamic-healthchecks"><img src="https://img.shields.io/github/actions/workflow/status/govigilant/statamic-healthchecks/style.yml?label=style&style=flat-square" alt="Style"></a>
    <a href="https://packagist.org/packages/govigilant/statamic-healthchecks"><img src="https://img.shields.io/packagist/dt/govigilant/statamic-healthchecks?color=blue&style=flat-square" alt="Total downloads"></a>
</p>

An addon that adds healthchecks to any Statamic application and integrates seamlessly with [Vigilant](https://github.com/govigilant/vigilant).
It extends the [Vigilant Laravel Healthchecks](https://github.com/govigilant/laravel-healthchecks) package and adds Statamic specific checks.

## Features

This package providers an API endpoint to check the health of your Statamic application. It returns two types of checks, health checks and metrics.
Healthchecks are checks that indicate whether a specific part of your application is functioning correctly, while metrics provide numeric values that give insights on health over time. [Vigilant](https://github.com/govigilant/vigilant) can use these metrics to notify you of spikes or quickly increasing metrics.

## Installation

Install the package via Composer:

```bash
composer require govigilant/statamic-healthchecks
```

## Configuration

Set the API token in your `.env` file:

```env
VIGILANT_HEALTHCHECK_TOKEN=your-vigilant-api-key-here
```

> **Note:** The token is required to access the health endpoint.

Optionally publish the configuration if ou want to adjust default behavior:

```bash
php artisan vendor:publish --provider="Vigilant\LaravelHealthchecks\ServiceProvider"
```

This creates `config/vigilant-healthchecks.php`.

### Scheduler

This package automatically schedules a command and a job to verify if your sheduler and queue workers are running.
If you do not want or want to customize this behavior, you can disable the automatic scheduling in the config file by setting `schedule` to `false`.

Ensure to schedule the `php artisan vigilant:scheduler-heartbeat` yourself if you disable automatic scheduling.


## Usage and customization

Please refer to the [Vigilant Laravel Healthchecks Readme](https://github.com/govigilant/laravel-healthchecks) for usage and customization instructions.


## Available checks

All Laravel checks in [Vigilant Laravel Healthchecks](https://github.com/govigilant/laravel-healthchecks) are available, plus the following Statamic specific checks:

| Check | Description |
|-------|-------------|
| **StacheCheck** | Verifies that the stache is built |

## Development Environment

A ready-to-use Docker-based development environment lives in `devenv/`.
Ensure Docker is running, then start the stack: `docker compose -f devenv/docker-compose.yml up --build`.

This will create a Statamic application and link this package for development. The bearer token is set to `testing` and can be used to access the health endpoint:
```shell
curl -X POST "http://localhost:8000/api/vigilant/health" \
  -H "Authorization: Bearer testing" \
  -H "Content-Type: application/json"
```

You may use the following credentials to log in to the Statamic control panel at `http://localhost:8000/cp`:
- Email: `admin@govigilant.io`
- Password: `admin`

## Quality

Run the quality checks:

```bash
composer quality
```

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Vincent Boon](https://github.com/VincentBean)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
