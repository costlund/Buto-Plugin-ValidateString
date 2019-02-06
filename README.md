# Buto-Plugin-ValidateString

Form validators.

```
items:
  name:
    type: varchar
    label: Name
    mandatory: true
    validator:
      -
        plugin: validate/string
        method: validate_length
        data:
          length: 50
```



```
items:
  name:
    type: varchar
    label: Name
    mandatory: true
    validator:
      -
        plugin: validate/string
        method: validate_characters
        data:
          characters: abc
```


```
items:
  name:
    type: varchar
    label: Name
    mandatory: true
    validator:
      -
        plugin: validate/string
        method: validate_length_minmax
        data:
          min: 3
          max: 33
```
