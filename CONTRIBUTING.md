# Contributing

Bug reports and pull requests are welcome at <https://github.com/accredible/acms-php-api/issues>. Please include as much detail as you can.

## Local setup

```bash
make install   # composer install --no-interaction --dev
make test      # vendor/bin/phpunit tests
```

Note that the current test suite has no mocks — every test makes real HTTP calls against the staging API and creates/deletes real records, so it needs network access and a working staging API key.

## Releasing

Packagist builds from this repo's git tags, so a release is:

1. Merge to `master`.
2. Tag and push the version: `git tag v0.2.7 && git push origin v0.2.7`.

Left alone, Packagist only re-crawls periodically, so a new tag can take hours to appear. Two independent mechanisms notify it immediately — either one is sufficient, and having both is harmless, since a duplicate update request is a no-op.

### 1. The Packagist GitHub integration (preferred; set up once, no repo changes)

Follow <https://packagist.org/about#how-to-update-packages>: log into Packagist with GitHub and grant the Packagist app access to the `accredible` organization. To add the hook by hand instead, use **Settings → Webhooks → Add webhook**:

| Field | Value |
| --- | --- |
| Payload URL | `https://packagist.org/api/github?username=PACKAGIST_USERNAME` |
| Content type | `application/json` |
| Secret | the Packagist **safe** API token (Profile → Show Safe API Token) |
| Events | *Just the push event* |

### 2. The `Update Packagist` GitHub Action

[`.github/workflows/packagist-update.yml`](.github/workflows/packagist-update.yml) POSTs to Packagist's update API on every push to `master`, on every `v*` tag, and on manual dispatch. It needs two repository secrets (**Settings → Secrets and variables → Actions**):

| Secret | Value |
| --- | --- |
| `PACKAGIST_USERNAME` | the Packagist account that owns the package |
| `PACKAGIST_API_TOKEN` | that account's **safe** API token — Profile → **Show Safe API Token**. The safe token is scoped to package updates; do not use the main token, which can also create and delete packages. |

If the secrets are missing the job logs a warning and exits successfully, so forks and pull requests don't fail.
