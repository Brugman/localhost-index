# Localhost Index

> Localhost Index is a replacement "index.php" for Laragon / WampServer / XAMPP users.

![screenshot](/screenshot.png)

## Installation

Make sure the `project-name.test -> /webdev/project-name/public_html/` local dev format is working first.

1. Map `localhost-index.test` to the project `public_html` dir.
1. Redirect `localhost` to `localhost-index.test`. ([example code](/redirect-example.php)).

## Configuration

Your settings can be found in `app/config.php`.

- You can set a different TLD than `test`.
- You can exclude folders from the project list.
- You can enable SSL/HTTPS for your project links.

## Contributing

Found a bug? Anything you would like to ask, add or change? Please open an issue so we can talk about it.

Pull requests are welcome. Please try to match the current code formatting.

### Development installation

1. `npm i`

### Build tools

1. `npx gulp --env=prod` (repeat)

## Author

[Tim Brugman](https://github.com/Brugman)

