<h1 align="center">
	<img src="http://get-simple.info/data/uploads/getsimple-logo-2.png" style="height:48px" /><br />
	GetSimple Theme Extras
</h1>
<h6 align="center">Allows themes to provide extra functionality and configuration options</h6>

<!-- This is intentional to create blank space -->
<p>&nbsp;</p>

<p align="center">
	<img src="https://img.shields.io/github/v/release/johnstray/gs-plugin-ThemeExtras?label=latest%20release" alt="Latest release version" />
	<img src="https://img.shields.io/github/downloads/johnstray/gs-plugin-ThemeExtras/total" alt="Total GitHub release downloads" />
	<img src="https://img.shields.io/github/license/johnstray/gs-plugin-ThemeExtras" alt="License" />
	<img src="https://img.shields.io/github/issues-raw/johnstray/gs-plugin-ThemeExtras?logo=github" alt="GitHub open issues" />
	<img src="https://img.shields.io/github/last-commit/johnstray/gs-plugin-ThemeExtras?logo=github" alt="GitHub last commit" />
</p>

<p align="center">
	<a href="#about">About</a> &nbsp;&nbsp;&bull;&nbsp;&nbsp;
	<a href="#known-supported-themes">Supported Themes</a> &nbsp;&nbsp;&bull;&nbsp;&nbsp;
	<a href="#installation-and-usage">Installation and Usage</a> &nbsp;&nbsp;&bull;&nbsp;&nbsp;
	<a href="#contributing">Contributing</a> &nbsp;&nbsp;&bull;&nbsp;&nbsp;
	<a href="https://github.com/johnstray/gs-plugin-ThemeExtras/wiki">Documentation</a>
</p>

<!-- This is intentional to create blank space -->
<p>&nbsp;</p>

## About
A plugin for GetSimple CMS that provides supporting functionality for themes developed by me. Designed generically so that it will work with all GetSimple CMS themes developed by me.

Compatible with: _GetSimple CMS v3.3.16+, v3.4.0+_

#### Features Include
- __Custom fields__ addition to the page editor, allowing the theme to be dynamically customised on a per-page basis
- __Configuration__ settings support, enabling elements of the theme to be configured (eg.: colours, etc.)

## Known Supported Themes
- [__Yawen__](https://github.com/johnstray/gs-theme-yawen) - A theme designed to be simple yet elegant, focusing more on well constructed content than the website itself.

## Installation and Usage
You can install this plugin to your GetSimple CMS installation by following these simple instructions.

- Download the latest release ZIP file of the plugin from the Releases page
- Unzip it into the "plugins" folder of your GetSimple installation.
- Ensure your /Data and /Backups folder have write permissions.
- Log in to your GetSimple administration panel.
- Activate the plugin under the Plugins tab.
- Once installed, if a theme provides configuration options, there will be a new theme configuration sidebar menu option in the Themes tab.*
- If a theme provides custom fields support, the extra fields will automatically be added to your page editor in the metadata section*

. * _NOTE: Applies only when a supported theme is active._

### Adding Themes
To enable a theme to be supported by this plugin, it will need to have a `theme.xml` file in the base of the theme's derectory. For information on the layout and content of the XML file, <a href="https://github.com/johnstray/gs-plugin-ThemeExtras/wiki/">check out the Wiki</a>.

## Supported Languages
- English (US) - Default language, used when GS language is not supported

---

## Contributing
Everyone is welcome to make suggestions on how this plugin can be improved by either submitting an issue or a pull-request. If you would like to contribute to this project, please first have a read of the [Contributing Guidelines](.github/CONTRIBUTING.md).

## License
This project is licensed under the terms of the GNU Affero General Public Licence v3 (or later).

This program comes with ABSOLUTELY NO WARRANTY. This is free software, and you are welcome to redistrbute it and monify it under certain conditions. See [LICENCE](LICENCE) for details.
