CompoWebsiteDemo
===========

Website demo based on CompoSymfonyCms.

[![Try the demo](https://img.shields.io/badge/try-demo-green.svg)](http://website.compo-symfony-cms.ru)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)

Branch | Travis | Buddy | Site |
------ | ------ | ----- | ---- |
develop| [![Build Status](https://travis-ci.com/comporu/compo-website-demo.svg?token=Wm83L8fq2&branch=develop)](https://travis-ci.com/comporu/compo-website-demo) | [![buddy pipeline](https://app.buddy.works/comporu/compo-website-demo/pipelines/pipeline/137500/badge.svg?token=fc1497672c816787d99074f21845ccc61876 "buddy pipeline")](https://app.buddy.works/comporu/compo-website-demo/pipelines/pipeline/13700) | http://website.compo-symfony-cms.ru/ |

## Installation

### Docker

Create .env

```bash
cp .env.dist .env
```

Docker up

```bash
docker-compose up --build -d
```

Install or update composer dependency

```bash
docker-compose exec php composer install
# or
docker-compose exec php composer update
```

Install databases

```bash
docker-compose exec php bin/console compo:core:install
```

Install demo data

```bash
docker-compose exec php bin/console compo:webiste-demo:install
```

Assetic dump

```bash
docker-compose exec php bin/console assetic:dump --env=prod
```

Restart services

```bash
docker-compose restart php
docker-compose restart nginx
```


Visit https://localhost/

Admin https://localhost/admin

Default login/password for dev environment: website/website

Default login/password for admin: admin/admin

PhpMyadmin

```bash
docker run --name phpmyadmin --net compowebsitedemo_default --link db:db -p 8080:80 phpmyadmin/phpmyadmin
```


## Documentation

Check out the documentation on the [http://docs.compo-symfony-cms.ru/en/latest/](http://docs.compo-symfony-cms.ru/en/latest/)

## Support

If you think you found a bug or you have a feature idea to propose, feel free to open an issue
**after looking** at the [contributing guide](CONTRIBUTING.md).

## License

This package is available under the [MIT license](LICENSE).
