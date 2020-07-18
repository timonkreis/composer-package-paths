# ReadMe
Composer plugin to configure paths for composer package types.

To set package paths, add configuration of package types and paths to your _composer.json_:

```json
...
"extra": {
    "package-paths": {
        "[package-type]": "custom/path/{$vendor}/{$name}"
    }
}
...
```

The `[package-type]` has to match the [type of the composer package](https://getcomposer.org/doc/04-schema.md#type).

Alternatively, you can add paths for vendor namespaces or even single packages:

```json
...
"extra": {
    "package-paths": {
        "my-vendor/*": "vendor/path/{$vendor}/{$name}",
        "my-vendor/my-package": "vendor/path/{$vendor}/{$name}"
    }
}
...
```

The priority is as follows:
1. Check if the package is referenced directly by package name (`[vendor]/[name]`).
1. Check if the package namespace is referenced (`[vendor]/*`).
1. Check if the package type is referenced (`[package-type]`).

## Possible variables

| Variable: | Description: |
| --- | --- |
| `{$vendor}` | Vendor name of the package. |
| `{$name}` | Package name (after vendor name). |
