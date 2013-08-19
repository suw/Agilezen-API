# AgilezenAPI - Composer enabled package
This is a fork of [leftnode/Agilezen-API](https://github.com/leftnode/Agilezen-API)
that enables the class to be installed via Composer. You can see the original README
in the original repo.

## Usage
Since this package is not in packagist, you will need to add the following
to your composer.json:

    "repositories": [
        {
            "type": "vcs",
                "url": "https://github.com/suw/Agilezen-API"
        }
    ],
    "require": {
        "suw/Agilezen-API": "dev-master"
    }
