# Author

Display authors. This package is an extension to the TYPO3 system.

## Requirements

* TYPO3 13.4
* `cpsit/cps-utility` ^3.2

## Installation

This package is (not yet) available on packagist.org. Add the repository URL
to your root `composer.json` first:

```
composer config repositories.cps-author vcs \
    git@github.com:CPS-IT/cps-author.git
composer require cpsit/cps-author
```

## Plugins

The plugins are registered as content types (`CType`):

| CType              | Description                   | Selectable |
|--------------------|-------------------------------|------------|
| `cpsauthor_app`    | Author app (search, filter)   | yes        |
| `cpsauthor_show`   | Single author view            | yes        |
| `cpsauthor_list`   | List of authors               | yes        |
| `cpsauthor_filter` | Filter placeholder, use app   | no         |

`cpsauthor_filter` stays registered so that migrated records keep a valid
type. It is hidden from the New Content Element wizard.

### Upgrade from `list_type` plugins

Records created before 4.0.0 use `CType = list` with a `list_type`. Run the
upgrade wizard `cpsAuthor_listTypeToCType`. It migrates the content records
and the backend group permissions. Run the core wizard
`backendGroupsExplicitAllowDenyMigration` before it:

```
vendor/bin/typo3 upgrade:run backendGroupsExplicitAllowDenyMigration
vendor/bin/typo3 upgrade:run cpsAuthor_listTypeToCType
```

## Actions / Views

### List Authors

Displays a list of Authors items in frontend sorted by sorting. Editors are
able to filter the results by alphabet. Editors have the possibility to enable
or disable the search form in front end.

**Important**: _Search and filters have to be done with Ajax_.

**Action**: listAction

**Cache**: Cacheable

## Code quality

Install the dev dependencies as described under Tests, then run (prefix
with `ddev` in the DDEV project):

```
composer lint   # composer.json, EditorConfig, PHP-CS-Fixer, TypoScript
composer fix    # fix the findings that can be fixed automatically
composer sca    # PHPStan, level 6
```

## Tests

Tests and code quality tools run in the package's own DDEV project
(`.ddev/config.yaml`: PHP 8.4, MariaDB 10.11). The functional tests use the
database named in the `typo3Database*` variables of the DDEV config. The
private repository `cpsit/cps-utility` needs your SSH key in the container:
run `ddev auth ssh` once.

```
ddev auth ssh
ddev start
ddev composer install
```

### Unit Tests

```
ddev composer test:unit
```

### Functional Tests

```
ddev composer test:functional
```
