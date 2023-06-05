# Author

Display authors. This package is an extension to the TYPO3 system.

### Installation

* This package is (not yet) available as composer package on packagist.org. Please add the repo url to your root composer json first.

```
composer config repositories.cps-author vcs git@github.com:CPS-IT/cps-author.git
```

```
composer require cps/cps-author 
```

## Actions / Views

### List Authors

Displays a list of Authors items in frontend sorted by sorting. Editors are able to filter the results by alphabet. 
Editors have the possibility to enable or disable the search form in front end. 

**Important**: _Search and filters have to be done with Ajax_.

**Action**: listSelectedAction

**Cache**: Cacheable

## Tests

### Setup Test Environment 

```
docker-composer -f Tests/Build/docker-compose.yml up -d
docker-compose -f Tests/Build/docker-compose.yml exec web bash -c "cd /app && composer test:functional:prepare"
```

### Unit Tests

```
docker-compose -f Tests/Build/docker-compose.yml exec web bash -c "cd /app && composer test:unit"
```

### Functional Tests

```
docker-compose -f Tests/Build/docker-compose.yml exec web bash -c "cd /app && composer test:functional:run"
```
