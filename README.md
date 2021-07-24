# Test task for Spacepass

---

**Introduction**

This project is test task for space pass. The purpose of this task is to write a file parser that creates pdf copies of
the found files

**Requirements**

- php cli v-8.*
- composer
- git

**Installation**

1. Clone project from GitHub.

```bash
git clone https://github.com/mislant/spacepass-test.git
```

2. Get into project and make composer install

```bash
composer install
```

**Usage**

*To prepare* you need to specify searching directory and array of searching extensions. For this edit `config.yaml` file
in project root

*To run* just execute `app` file.
```bash
# from project directory
./app
```