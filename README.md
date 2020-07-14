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

## Possible variables

| Variable: | Description: |
| --- | --- |
| `{$vendor}` | Vendor name of the package. |
| `{$name}` | Package name (after vendor name). |
