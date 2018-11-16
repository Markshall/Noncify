# Noncify
Generate and verify previously generated nonces for use in web forms

---

## Usage
```php
<?php
require_once('Noncify.php');

define('NONCE_SALT', 'f7H4gx88ZaqwM3'); // you'd probably store this in a config file or in a database

$nonce = Noncify::generate(NONCE_SALT, 3); // generates a nonce salt that expires after 3 minutes

// the verify() method must be provided the same nonce salt that you passed through to generate()
if (Noncify::verify($nonce, NONCE_SALT)) {
  echo 'Verified!';
} else {
  echo 'Wrong salt key supplied, or nonce has expired.';
}
```
