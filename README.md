# Buto-Plugin-ValidateString
Form validators.
## Length
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
## Characters
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
## Length min max
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
