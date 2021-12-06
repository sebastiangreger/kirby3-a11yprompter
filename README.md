# Kirby3 A11yprompter

> For a comprehensive overview of Sa11y and Editoria11y, how they can assist maintaining an accessible website by supporting content editors, and to read about the rationale behind this plugin, **check out the in-depth blog post** at https://sebastiangreger.net/2021/11/sa11y-editoria11y-and-a-kirby-plugin

## Overview

The A11yprompter (*a11y* as in accessibility, and *prompter* like the person assisting actors on stage) is a tiny wrapper to easily add a user-friendly automatic content accessibility checker to the frontend of a website built with [Kirby 3](https://getkirby.com/).

The plugin currently integrates both [Editoria11y](https://itmaybejj.github.io/editoria11y/) and [Sa11y](https://ryersondmp.github.io/sa11y/), and even allows to try them both at random. They are specifically developed to assist content editors to not break a site's accessibility as they create content; not full-fledged accessibility validators, but tools that nudge editors to follow a11y guidelines.

## Installation

Download and copy this repository to `/site/plugins/kirby3-a11yprompter`

Or use Composer:

```bash
composer require sgkirby/a11yprompter
```

Or install as Git submodule

```bash
git submodule add https://github.com/sebastiangreger/kirby3-a11yprompter.git site/plugins/kirby3-a11yprompter
```


## Setup

There is only one step needed to get started. Add the following to the template or snippet rendering the end of your HTML body (like `site/snippets/footer.php` in the Kirby Starterkit, for example), just before the closing `</body>` tag:

```php
<?= snippet('a11yprompter') ?>
```

This will render the required `<script>` and `<style>` tags to include the checker tool in the page; by default, one of the two tools is chosen at random – think of it as a kind of "tryout" mode (while pretty similar, both tools have different UI and feature sets, so this might be handy to find your preferred solution).

The tool is only displayed when loading a web page as a logged-in user – careful if Kirby's built-in page cache is in use; you may want to [disable page caching for logged-in users](https://getkirby.com/docs/cookbook/setup/selective-page-cache).

You should now be ready to go – make sure you are logged in to your Kirby website and open any page on the frontend that is rendered using the template/snippet with this code.

## Configuration

Additional configuration variables can be included in the snippet call to customize the setup. The `$data` variable is expected to be an associative array, as with any other [Kirby snippet](https://getkirby.com/docs/reference/templates/helpers/snippet):

```php
<?= snippet('a11yprompter', $data) ?>
```

### Checker engine selection

To turn off the randomized "tryout" mode and permanently settle for one engine, set the `engine` value accordingly:

| Value | Description |
|-------|-------------|
| `'engine' => 'sa11y'` | Uses [Sa11y](https://ryersondmp.github.io/sa11y/) |
| `'engine' => 'editoria11y'` | Uses [Editoria11y](https://itmaybejj.github.io/editoria11y/) |
| `'engine' => 'random'` or empty (default) | Randomly uses one of the two – either Sa11y or Editoria11y – for every page load |
| `'engine' => 'tota11y'` | Uses [Tota11y](https://khan.github.io/tota11y/); this "forebear" of the newer solutions, not updated since 2019, is only included here for reference purposes or very specific use cases, it is never shown when using the `random` option as its target audience is different from the others |

So, to only use Sa11y, set:

```php
<?= snippet('a11yprompter', ['engine' => 'sa11y']) ?>
```

*NB. Both engine names do not contain `L` letters, but numeric characters `1`.*

### Template limitation

By default, the checker tool is shown on every page that contains the template with this snippet. To limit, you may hand an array of template names to the snippet:

| Value | Description |
|-------|-------------|
| `templates` => array | An array of template IDs that will include the checker tool, e.g. `'templates' => ['article']` |

### Access control

By default, the checker tool is shown to every logged-in user. You can limit this further by setting one of the following arrays in the `$data` variable:

| Value | Description |
|-------|-------------|
| `'users' => ` array | An array of user IDs that will see the checker tool, e.g. `'users' => ['ascd1234', 'b2cy82t5']` |
| `'roles' => ` array | An array of user roles that will see the checker tool, e.g. `'roles' => ['admin']` |

For example, a complete setup with template and access limitations could look like this:

```php
<?= snippet('a11yprompter', [
    'engine'    => 'sa11y',
    'templates' => ['article', 'note'],
    'roles'     => ['admin', 'leadeditor'],
]) ?>
```

### Script settings

To override selected default settings of the checker scripts, overwrite them using an array named after the tools' name:

| Value | Description |
|-------|-------------|
| `sa11y` => array | An array of variables for the Sa11y tool; see the variables and their explanations in [sa11y-english.js](https://github.com/ryersondmp/sa11y/blob/master/src/sa11y-english.js) |
| `editoria11y` => array | An array of variables for the Editoria11y tool; see the variables and their explanations in [editoria11y-prefs.js](https://github.com/itmaybejj/editoria11y/blob/main/js/editoria11y-prefs.js) |

For example, to change the Editoria11y variable `ed11yAlertMode` from its default value of `polite` to `assertive`, use the following code:

```php
<?= snippet('a11yprompter', [
    'engine'      => 'editoria11y',
    'editoria11y' => [
        'ed11yAlertMode' => 'assertive',
    ],
]) ?>
```

This renders a line of script code setting `ed11yAlertMode = 'assertive';` and thereby overwriting the default. Take a look at the various config variables of both scripts – they each enable a great (but different) amount of customization, from including/excluding certain areas to other interface settings.

Probably the most important setting is the limitation of the tested area to a specific DOM element (e.g. to only target the area that can be edited by authors, not the rest of page, usually rendered from fixed templates); default is the entire `body`:

| Sa11y | Editoria11y |
|-------|-------------|
| `'sa11yCheckRoot' => '#content'` |`'ed11yCheckRoot' => '#content'` |

## Credits

This plugin is merely a little helper to easily embed the Editoria11y and Sa11y tools into websites built with Kirby 3. My original contribution is limited to making them available by use of a Kirby snippet in a template.

[Editoria11y](https://github.com/itmaybejj/editoria11y) is maintained by John Jameson and is provided to the community thanks to the Digital Accessibility initiatives at Princeton University's Office of Web Development Services. It started as a fork of [Sa11y](https://ryersondmp.github.io/sa11y/) created by Digital Media Projects, Computing and Communication Services (CCS) at Ryerson University in Toronto, Canada and lead and maintained by Adam Chaboryk, which has since evolved into version 2. Sa11y itself began as a fork of [Tota11y](https://github.com/Khan/tota11y) by Khan Academy, and uses FontAwesome icons and jQuery.

## License

Kirby3 A11yprompter is open-sourced software licensed under the [GPLv2 license](https://www.gnu.org/licenses/old-licenses/gpl-2.0.html), to comply with the original GPLv2 license of Editoria11y. Sa11y and Tota11y are licensed under the MIT license, which permits its inclusion in GPLv2-licensed software.

Copyright © 2021 [Sebastian Greger](https://sebastiangreger.net)

It is discouraged to use this plugin in any project that promotes the destruction of our planet, racism, sexism, homophobia, animal abuse, violence or any other form of hate speech.
