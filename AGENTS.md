# Instructions for Silverstripe Project

## Project Overview
This is an opinionated Silverstripe CMS project that provides a ready-to-run, build & deploy CMS instance. It uses:
- **Silverstripe CMS** with Elemental blocks
- **DDEV** for local development environment
- **VSCode devcontainer** (recommended) - runs inside DDEV's web container with all extensions
- **VITE** frontend builds with laravel-vite-plugin
- **PHP Deployer** for deployment automation
- **VSCode** tasks for common operations (work inside devcontainer)

## Project Structure
```
/
├── .ddev/                     # DDEV configuration
├── .devcontainer/             # Devcontainer configuration
├── .vscode/                   # VSCode settings and tasks
├── app/                       # Silverstripe application code
│   ├── _config/               # YAML configuration
│   ├── src/                   # PHP classes
│   └── templates/             # App templates
├── deploy/                    # Deployment configuration
├── public/                    # Web root
│   ├── assets/                # Uploaded files
│   └── index.php              # Entry point
├── themes/default/            # Theme files
│   ├── src/                   # Source files for build
│   ├── dist/                  # Built assets
│   ├── templates/             # Theme templates
│   ├── package.json           # NPM packages
│   └── vite.config.js         # Build configuration
└── vendor/                    # Composer dependencies
```

## Development Environment

### Devcontainer Setup (Recommended)
This project uses a devcontainer that runs inside DDEV's web container:
- Open workspace in VSCode → Command Palette → "Dev Containers: Reopen in Container"
- Devcontainer automatically starts DDEV and installs npm packages
- All extensions (PHP Intelephense, Biome, Log Viewer, Xdebug, etc.) run inside the container
- Commands run directly without `ddev` prefix (e.g., `composer install`, `sake dev/build`)
- VSCode tasks work seamlessly inside the container

### DDEV CLI (Without Devcontainer)
- Prefix all commands with `ddev` (e.g., `ddev composer install`, `ddev sake dev/build`)

### DDEV Configuration
- DDEV project name matches folder name by default
- Default URLs:
  - Main site: https://{projectname}.ddev.site
  - Admin: https://{projectname}.ddev.site/admin (admin/password)
  - phpMyAdmin: https://{projectname}.ddev.site:8037
  - Mailpit: https://{projectname}.ddev.site:8026

### Common Tasks (via VSCode tasks or command line)

#### DDEV Management (magenta tasks)
- `ddev log web` - View web container logs
- `ddev xdebug on/off` - Enable/disable Xdebug

#### Silverstripe Development (blue tasks)
- `dev/build` - Rebuild database schema (runs `php ./vendor/bin/sake dev/build` in devcontainer, `ddev sake dev/build` from host)
- `ssshell` - Interactive Silverstripe REPL running on Psy Shell for debugging and data manipulation
- `composer install` - Install PHP dependencies
- `composer update` - Update PHP dependencies
- `composer vendor-expose` - Expose vendor assets

#### Frontend Development (green tasks)
- `npm install & update update-browserslist-db` - Install npm packages
- `npm watch` - Start Vite watcher
- `npm prod` - Production build

#### Deployment (cyan tasks)
- `deploy test/live` - Deploy to test/live environment
- `ssh test/live` - SSH into remote servers
- `download database from live` - Sync database from live
- `download assets from live` - Sync assets from live
- `dep releases test/live` - Show deployment history
- `deploy:unlock test/live` - Unlock stuck deployments

### Environment Variables
- Local development uses environment variables from `.ddev/config.yaml`
- Sensitive variables should be added to `.env` (not in git)
- Required for full functionality:
  - `APP_GOOGLE_MAPS_KEY` - Google Maps API key
  - `SS_NOCAPTCHA_SITE_KEY` - reCAPTCHA site key
  - `SS_NOCAPTCHA_SECRET_KEY` - reCAPTCHA secret key

## Code Organization

### Silverstripe Specifics
- Default locale: `de_CH` (set in `app/_config.php`)
- Logging to `silverstripe.log`
- Block-based page building with Elemental

### Internationalization (i18n) Guidelines
- **Always use `_t()` in PHP and `<%t ... %>` in templates** for user-facing strings, never hardcode text
- **English as default**: Write default strings in English within `_t()` functions
- **Minimal translations**: Only add translations to `app/lang/de_CH.yml`
- **Naming convention**: Use descriptive keys `self::class . '.NameDescription'` or `self::class . '.FIELDNAME'` (uppercase for fields)
- **Example**: `_t(self::class . '.HowTitle', 'What is shown?')` - only translate if "What is shown?" is different in German, if it's a comon aglizism don't

### PHP Requirements
- **PHP Version**: As specified in composer.json (compatible with Silverstripe version specified in composer.json)
- **Silverstripe**: Version as specified in composer.json like ^6 (latest stable)
- **Framework**: Uses `silverstripe/recipe-core` and `silverstripe/recipe-plugin`
- **Autoloading**: PSR-4 with `App\` namespace mapping to `app/src/`

### Composer Configuration
- **Minimum Stability**: dev (with prefer-stable: true)
- **Exposed Assets**: Automatically exposes theme dist files, vendor icons, and app assets (`ddev composer vendor-expose`)
- **Project Type**: `silverstripe-recipe` for recipe-based installation

### Frontend Build Process
- **Vite** configuration in `themes/default/vite.config.js`
- Source files in `themes/default/src/`
- Built files output to `themes/default/dist/`
- PostCSS processing (`themes/default/postcss.config.js`), JavaScript bundling, asset optimization

### CSS Architecture & Patterns
- **Modern CSS approach**: Uses CSS custom properties (variables), custom media queries, and PostCSS mixins
- **Color system**: OKLCH color format for better perceptual uniformity and alpha support
- **Responsive design**: Custom media queries defined in `custom-media.css` (e.g., `--cm-l-plus`, `--cm-xl-neg`)
- **Typography**: Modular scale using `--lh` (line-height) units for consistent vertical rhythm
- **CSS Reset**: Custom reset based on Andy Bell's modern CSS reset (`uni-sani-reset.css`)
- **Accessibility**: Focus-visible outlines, prefers-reduced-motion support, visually-hidden utility class
- **PostCSS mixins**: Reusable patterns for buttons, dropdowns, sliders, and arrow decorations in `mixins.css`

### CSS Best Practices
- Use `var(--variable-name)` for colors, spacing, and typography
- Follow OKLCH color format: `oklch(lightness chroma hue)` for better color manipulation
- Use custom media queries: `@media (--cm-l-plus)` instead of raw pixel values
- Maintain consistent spacing with `calc(var(--lh) * N * 1em)` pattern or `clamp()` for horyzontal spacing see --spacing in `themes/default/src/css/variables.css`
- Leverage `color-mix()` and `oklch(from ...)` for dynamic color variations
- Use semantic CSS custom properties (e.g., `--link-color`, `--text-color`) over direct color values

## File Conventions

### PHP Files
- Follow PSR-12 coding standards
- Namespace: `App\` for application code
- Controllers in `app/src/Controller/`
- Models in `app/src/Models/`
- Extensions in `app/src/Extensions/`
- Elements in `app/src/Elements/`
- Tasks in `app/src/Tasks/`

### Templates
- Silverstripe `.ss` template format
- App templates in `app/templates/`
- Theme templates in `themes/default/templates/`
- Follow Silverstripe template hierarchy with namespace

### Environments
- **dev**: Local DDEV environment
- **test**: Staging server
- **live**: Production server

## Common Patterns

### Code Changes:
- Follow Silverstripe conventions and PSR-12 standards
- Use `App\` namespace for application code
- Include proper error handling and validation
- Always run `dev/build` after schema changes
- Use SSShell for testing ORM queries

### Frontend Changes:
- Use Vite for builds: `npm --prefix themes/default run build`
- Follow OKLCH color format and existing CSS patterns
- Maintain responsive breakpoints from `custom-media.css`
- Preserve vertical rhythm with `--lh` based spacing
- Test with `prefers-reduced-motion` and `prefers-contrast`

### New Elements:
- Extend `BaseElement` in `app/src/Elements/`
- Create template in `themes/default/templates/App/Elements`
- Follow existing element patterns

## Debugging
- Xdebug available via VSCode task "DDEV: Enable Xdebug" (works in both devcontainer and host)
- Log files in `silverstripe.log`
- Use VSCode PHP Debug extension with provided launch configuration
- Dev tools accessible in dev environment only
- Mailpit catches all emails in development at https://{projectname}.ddev.site:8026
- **SSShell** for interactive debugging:
  - In devcontainer: `php ./vendor/bin/ssshell` or VSCode task "SilverStripe Shell"
  - From host: `ddev php ./vendor/bin/ssshell`
  - Query and manipulate DataObjects directly
  - Test ORM queries and relationships
  - Debug template variables and methods
  - Prototype code snippets before implementation

## Extensions and Modules

### Core CMS Extensions
- **Elemental** (`dnadesign/silverstripe-elemental`) - Block-based page building
- **UserForms** (`silverstripe/userforms`) - Form builder with Elemental integration
- **Blog** (`silverstripe/blog`) - Blog functionality with Elemental support
- **LinkField** (`silverstripe/linkfield`) - Modern link field for internal/external links
- **Asset Admin** (`silverstripe/asset-admin`) - Enhanced asset management

### Content & SEO
- **Google Sitemaps** (`wilr/silverstripe-googlesitemaps`) - XML sitemap generation
- **Meta Title** (`kinglozzer/metatitle`) - Enhanced meta title management
- **Canonical URLs** (`dorsetdigital/silverstripe-canonical`) - Canonical URL management
- **Redirected URLs** (`silverstripe/redirectedurls`) - 301 redirect management
- **Robots.txt** (`tractorcow/silverstripe-robots`) - Dynamic robots.txt generation
- **Share Care** (`jonom/silverstripe-share-care`) - Social sharing optimization

### Security & Forms
- **NoCaptcha** (`undefinedoffset/silverstripe-nocaptcha`) - reCAPTCHA integration
- **Klaro Cookie Consent** (`lerni/klaro-cookie-consent`) - GDPR-compliant cookie consent
- **Email Obfuscator** (`axllent/silverstripe-email-obfuscator`) - Email address protection

### Media & Assets
- **FocusPoint** (`jonom/focuspoint`) - Smart image cropping
- **HTML Editor Srcset** (`bigfork/htmleditorsrcset`) - Responsive images in TinyMCE
- **SortableFile** (`bummzack/sortablefile`) - Drag & drop file sorting
- **Select Upload** (`silverstripe/selectupload`) - Enhanced file selection

### Developer Tools
- **Better Navigator** (`jonom/silverstripe-betternavigator`) - Dev toolbar
- **Fail Whale** (`bigfork/silverstripe-fail-whale`) - Better error pages
- **GridField Extensions** (`symbiote/silverstripe-gridfieldextensions`) - Enhanced GridField functionality
- **Text Target Length** (`jonom/silverstripe-text-target-length`) - Content length indicators
- **SomeConfig** (`jonom/silverstripe-someconfig`) - Runtime configuration

### Custom Integrations
- **Tracking** (`lerni/silverstripe-tracking`) - Analytics integration (Google Analytics, Tag Manager)
- **Web Manifest** (`lerni/silverstripe-webmanifest`) - PWA manifest generation
- **Google Maps Field** (`innoweb/silverstripe-googlemapfield`) - Google Maps integration
- **Phone Link** (`firebrandhq/silverstripe-phonelink`) - Phone number formatting
- **Color Palette** (`heyday/silverstripe-colorpalette`) - Color picker fields
- **Embed Field** (`nathancox/embedfield`) - Media embedding with custom attributes

### Utilities
- **Schema.org** (`spatie/schema-org`) - Structured data generation
- **QR Code** (`endroid/qr-code`) - QR code generation
- **vCard** (`jeroendesloovere/vcard`) - Contact card generation
- **iCal** (`eluceo/ical`) - Calendar event generation
- **CommonMark** (`league/commonmark`) - Markdown processing
- **LibPhoneNumber** (`giggsey/libphonenumber-for-php`) - Phone number validation
- **Simple Icons** (`simple-icons/simple-icons`) - Brand icon library

### Development Dependencies
- **Deployer** (`deployer/deployer`) - Deployment automation
- **Populate** (`dnadesign/silverstripe-populate`) - Database seeding and sample content creation
- **SSShell** (`pstaender/ssshell`) - Interactive Silverstripe command line shell for debugging, data manipulation, and rapid prototyping
- **PHPUnit** (`phpunit/phpunit`) - Testing framework

## VSCode Integration
- **Devcontainer** (`.devcontainer/devcontainer.json`) provides complete development environment inside DDEV container
- `.vscode/extensions.json` suggests only `ms-vscode-remote.remote-containers` extension for local installation
- All other extensions (PHP Intelephense, Biome, Log Viewer, Xdebug, etc.) configured in devcontainer `customizations` and install automatically
- Tasks are color-coded by function (magenta=DDEV, blue=Silverstripe, green=npm, cyan=deployment)
- Tasks run inside devcontainer without `ddev` prefix; from host, use equivalent `ddev` commands
- Debug configuration available for PHP debugging (`.vscode/launch.json`)
- Log viewer integration for `silverstripe.log`

When helping with this project, prioritize Silverstripe best practices, DDEV workflow efficiency, and established code patterns. Always use proper i18n translation for user-facing strings.

## Code Quality & Testing
- Follow PSR-12 coding standards for PHP
- **EditorConfig** (`.editorconfig`) enforces consistent coding styles across editors:
  - UTF-8 encoding, LF line endings
  - 4 spaces for PHP, tabs for templates/CSS/SCSS
  - 2 spaces for YAML/JSON/JS
  - Trailing whitespace removal, final newline insertion
- Use PHPUnit for testing (configured in `phpunit.xml.dist`)
- PHPCS configuration available in `phpcs.xml.dist`)
- Never ever consider using deployment scripts or push & pull data to environments managed by deployer
- Use Better Navigator dev toolbar for debugging in development

## Performance Considerations
- Images use FocusPoint for smart cropping and responsive srcsets
- Assets in themes/default are optimized through Vites build process
- Optimize database queries, especially for Elemental blocks

## Security Best Practices
- Use reCAPTCHA for forms requiring verification
- Email addresses are automatically obfuscated

## Content Management
- Always use i18n (`_t()` in PHP, `<%t %>` in templates) for user-facing strings
- English as default, only add translations to `app/lang/de_CH.yml` when needed
