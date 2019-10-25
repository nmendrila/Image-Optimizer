# Image Optimizer

A wrapper for the TinyJPG/TinyPNG PHP client

### Prerequisites

This project needs an API key from TinyJPG. You can obtain it [here](https://tinyjpg.com/developers).

### Installing

Download or clone the project, then use 
```
composer install
```
to install the dependencies.

Then, in the config/config.php file, replace "###" with the the api key obtained from TinyJPG. 

Place the original images into the default directory "/images/", then either run the script through the browser (by visiting, for example, http://localhost/imageoptimizer/) or run it through the CLI with
```
php index.php
```

The optimized images will be saved to the "/images/" folder as well, and they will by default have the suffix "-opt" in their name. The script will not process images that have already been processed.

## Authors

* **Neven Mendrila**

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).

## Image Credits

Test image by [Diego Delso](https://en.wikipedia.org/wiki/Landscape_genetics#/media/File:Parque_Eagle_River,_Anchorage,_Alaska,_Estados_Unidos,_2017-09-01,_DD_02.jpg)