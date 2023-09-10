# Sportradar test task

My implementation of Sportradar test task seems to be a bit overwhelming. 
Nevertheless, I broke KISS rule intentionally as I've tried to show my skills in OOP, SOLID, some design patterns, TDD, etc.
Additionally, I prepared the task in the form of CLI. I hope you will like it.

# Possible improvements

If I had more time I would make the following improvements:
1. Docker environment.
2. PHPDocs.
3. More tests. Including data providers and more specific test cases.
4. MySql database instead of JSON files and doctrine ORM to handle this.
5. More static analysis tools. For instance, PHPStan.
6. Maybe some more design patterns. For instance, template method or strategy.
7. Help section in CLI.
8. Better data validation.
9. Captain Hook to run tests before commit and for some other checks.

# Installation

Just put it in your working directory and run:
```bash
composer install
```

All that you need is PHP 8.1 and composer.

# Usage

There are the following CLI commands:
1. Start a new game:
```bash
php sportradar-cli start-game Poland Germany
```
just replace `Poland` and `Germany` with your teams.

2. Finish game:
```bash
php sportradar-cli finish-game 1
```
replace `1` with your game id. You can find game id in the `data/collection.json` file
or by using `php sportradar-cli get-scoreboard` command. Remember that Scoreboard doesn't provide finished games info.

3. Update score:
```bash
php sportradar-cli update-score 1 1 0
```
replace `1` `1` `0` with your game id, home team score, and away team score.

3. Get scoreboard:
```bash
php sportradar-cli get-scoreboard
```
The Scoreboard provides only ongoing games info.

# Unit tests
Just run:
```bash
phpunit
```

# Example

This sample output shows how to use the CLI commands to reproduce scenario from the task description.

```bash
 php sportradar-cli.php start-game Mexico Canada
```
Game started. Game id: 1.

```bash
php sportradar-cli.php update-score 1 0 5
```
Game 1 score updated.

```bash
php sportradar-cli.php start-game Spain Brazil
```
Game started. Game id: 2.

```bash
php sportradar-cli.php update-score 2 10 2
```
Game 2 score updated.

```bash
php sportradar-cli.php start-game Germany France
```
Game started. Game id: 3.

```bash
php sportradar-cli.php update-score 3 2 2
```
Game 3 score updated.

```bash
php sportradar-cli.php start-game Uruguay Italy
```
Game started. Game id: 4.

```bash
php sportradar-cli.php update-score 4 6 6
```
Game 4 score updated.

```bash
php sportradar-cli.php start-game Argentina Australia
```
Game started. Game id: 5.

```bash
php sportradar-cli.php update-score 5 3 1
```
Game 5 score updated.

```bash
php sportradar-cli.php get-scoreboard
```
You should get sorted results.