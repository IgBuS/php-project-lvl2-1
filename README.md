![PHP CI](https://github.com/demiankoAnton/php-project-lvl2/workflows/PHP%20CI/badge.svg)
[![Maintainability](https://api.codeclimate.com/v1/badges/6002444f791342bf21d9/maintainability)](https://codeclimate.com/github/demiankoAnton/php-project-lvl2/maintainability)
<a href="https://codeclimate.com/github/demiankoAnton/php-project-lvl2/test_coverage"><img src="https://api.codeclimate.com/v1/badges/6002444f791342bf21d9/test_coverage" /></a>

Diff Generator - program, that generate differences between two files.
You can choose between json, plane or pretty output style.<br>
Support Json and Yaml input formats and also generates differences in nested structures.<br>
You need too install Composer too use Diff Generator.

<h4>Instalation:</h4>

Type in command line:

```composer global require demianko.a/gendiff:dev-master```

[![asciicast](https://asciinema.org/a/320733.svg)](https://asciinema.org/a/320733)

By default Diff Generator using 'pretty' output format.
Too choose different format, just use ```--format``` flag with json, plain or pretty arguments.

<h4>How too use:</h4>

``gendiff --help`` to see help message:

[![asciicast](https://asciinema.org/a/331886.svg)](https://asciinema.org/a/331886)

``gendiff --format pretty <firstFilePath> <secondFilePath>`` or ``gendiff <firstFilePath> <secondFilePath>`` to generate differences in pretty style:

[![asciicast](https://asciinema.org/a/331897.svg)](https://asciinema.org/a/331897)

``gendiff --format json <firstFilePath> <secondFilePath>`` to generate differences in json format:

[![asciicast](https://asciinema.org/a/331891.svg)](https://asciinema.org/a/331891)

``gendiff --format plain <firstFilePath> <secondFilePath>`` to generate differences in plain style:

[![asciicast](https://asciinema.org/a/331890.svg)](https://asciinema.org/a/331890)