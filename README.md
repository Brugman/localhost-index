# Localhost Index

> Localhost Index is a replacement "index.php" for Laragon / WampServer / XAMPP users.

![screenshot](/screenshot.png)

## What's up with these URLs?

Blog post coming some day. Rough draft:

You want to build multiple websites. There is only 1 "localhost". So you need to use subdirectories or subdomains.

If you use subdirectories for websites you cannot use "/" to link to the site root. If a website is done, you usually give it its own domain, like example.com. Therefore it is easier to work locally with domains or subdomains, and avoid having to deal with subdir problems.

`.dev` aka dot-dev *used to be* a popular TLD for local development that was not real. Then Google bought it and it became real. https://timbr.dev is real and https://web.dev is real. This created 2 problems for using it for local development. 1. You run the chance of overriding a real website. 2. Google requires SSL on dot-dev, and getting SSL on your localhost is tricky. For now, just remember that a lot of people want to use `project.dev`, but we cannot anymore. Unless the URL does not end in `.dev`...

If you create a lot of new websites, creating new (sub)domains for each new project will get annoying. We can avoid this with a wildcard setup in Apache's vhosts: We can make `project-a.dev` map to `/webdev/project-a/public_html/` 

`public_html` may be an Apache classic, but Laravel uses `public`, and some other frameworks like `web` and `www`. Instead of forcing `public_html` on everything, we can make multiple wildcard vhosts. We link the `.dev` to `public_html`, but `.lar` to `public`. Etcetera.

If you work in an office and want to show your co-workers your local website, they can't access `project-a.dev`, that requires mapping on their OS. What does work is your LAN IP, like `192.168.0.56`, or `10.10.10.56`, if you open up your Apache to LAN visitors. You only have 1 IP, and many sites though, so we need a way to pass along that you want to visit `project-a`.

Enter Wildcard DNS services [nip](https://nip.io/) and [sslip](https://sslip.io/). They do the same. If you visit `10.10.10.56.nip.io`, they make you load `10.10.10.56`. But if visit `project-a.dev.10.10.10.56.nip.io`, they make you load `10.10.10.56`, but your Apache on the receiving end, can detect that the URL is `project-a.dev.10.10.10.56.nip.io`. From there your vhost can extract the `project-a.dev` part, and load the website in `/webdev/project-a/public_html/`

Yes, your local websites now have crazy long weird URLs.

But you also:
- Never again have to edit your OS domain mapping file.
- Never again have to edit your Apache vhosts file.
- Have access to all your sites at the same time.
- Have every site on a subdomain.
- Can visit your local sites from anywhere on your LAN.
- Can visit your co-workers sites from anywhere on the office LAN.

![fuck yeah](https://i.imgur.com/Xb8yDSd.jpg)

## Installation

1. Get `projectname.dev.[IP].nip.io` working.
1. Map `localhost-index.dev.[IP].nip.io` to the project dir.
1. Visit `localhost-index.dev.[IP].nip.io`.
1. Are things broken? Try editing `app/config.php`.
1. Redirect your `localhost` and `[IP].nip.io` to the mapped URL.
1. Bookmark your new localhost index or set it as your homepage.

## Branches

The `develop` branch is built for local development with URLs that look like `project-name.test`.

The `nip.io` branch is built for local development with URLs that look like `project-name.dev.10.10.10.56.nip.io`.

## Contributing

Found a bug? Anything you would like to ask, add or change? Please open an issue so we can talk about it.

Pull requests are welcome. Please try to match the current code formatting.

### Development installation

1. `npm i`

### Build tools

1. `npx gulp --env=prod` (repeat)

## Author

[Tim Brugman](https://github.com/Brugman)
