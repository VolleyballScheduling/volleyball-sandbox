#Volleyball
##Summer Camp Scheduling System

Online course management system primarily aimed at easing the logistics of scheduling multiple attendees, groups across a multitude of facilities.

###1. Installation

1) Composer
```js
"volleyball/sandbox": "@dev"
```

```bash
$ php composer.phar update "volleyball/volleyball-sandbox"
```

###2. Configuration
If you wish to use any of the geolocation features than you will need to supply a valid key and secret to access the geopoint api.  See the `paramters.yml` file.


###3. Usage
With the `FixturesBundle` is all the initial/ testing data one would need.

Without that, you will need to create an administrator account and continue from there.

###4. Features
- Multiportaled user interface
- report generation system
- centralized online advancement tracking
- fully encompassing scheduling system

###5. Plugins
Organization specific plugins (bundles) to extend the core functionality.
- Boy Scouts
    - custom passel types and positions
    - course entity extensions
    - requirement entity extensions
    - custom reports
    - class balancing
