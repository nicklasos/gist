<?php
/**
 *
 * $ex = [
 *     InvalidArgumentException::class,
 *     ClientException::class,
 * ];
 *
 * retry_exception($ex, 3, function () {
 *     dump('try');
 *     throw new InvalidArgumentException();
 * });
 *
 * @param array $exceptions What exceptions need to be retried
 * @param $times
 * @param callable $callback
 * @param int $sleep
 * @return mixed
 * @throws Exception
 */
function retry_exception(array $exceptions, int $times, callable $callback, int $sleep = 0)
{
    $times--;

    beginning:
    try {
        return $callback();
    } catch (Exception $e) {
        $any = array_filter($exceptions, function ($ex) use ($e) {
            return $e instanceof $ex;
        });

        if (!$any || !$times) {
            throw $e;
        }

        $times--;

        if ($sleep) {
            usleep($sleep * 1000);
        }

        goto beginning;
    }
}

/**
 * Inline profiler :)
 *
 *  $time = s();
 *  for ($i = 0; $i < 100000; $i++) {
 *      $j = $i + 1;
 *  }
 *  s($time);
 *
 * @param bool|int $time
 * @return mixed
 */
function s($time = false)
{
    if ($time) {
        return number_format(microtime(true) - $time, 4) . 's';
    } else {
        return microtime(true);
    }
}

/**
 * $myObject = new MyClass();
 * callPrivateMethod($myObject, 'hello', ['world']);
 */
function call_private_method($object, $method, $args)
{
    $classReflection = new \ReflectionClass(get_class($object));

    $methodReflection = $classReflection->getMethod($method);
    $methodReflection->setAccessible(true);

    $result = $methodReflection->invokeArgs($object, $args);

    $methodReflection->setAccessible(false);

    return $result;
}


/**
 * Generate a random string with our specific charset, which conforms to the
 * RFC 4648 standard for BASE32 encoding.
 *
 * @return string
 */
function noise()
{
    return substr(
        str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz234567', 16)),
        0,
        32
    );
}

/**
 * @param DateTime $date Date that is to be checked if it falls between $startDate and $endDate
 * @param DateTime $startDate Date should be after this date to return true
 * @param DateTime $endDate Date should be before this date to return true
 * @return bool
 */
function is_date_between_dates(DateTime $date, DateTime $startDate, DateTime $endDate): bool
{
    return $date > $startDate && $date < $endDate;
}

/**
 * Build url from parse_url result
 *
 * $info = parse_url('http://localhost/foo');
 * $info['path'] = '/en' . $info['path'];
 * build_url($info); // => http://localhost/en/foo
 *
 * @param array $e
 * @return string
 */
function build_url(array $e): string
{
    return
        (isset($e['host']) ? (
            (isset($e['scheme']) ? "{$e['scheme']}://" : '//') .
            (isset($e['user']) ? $e['user'] . (isset($e['pass']) ? ":{$e['pass']}" : '') . '@' : '') .
            $e['host'] .
            (isset($e['port']) ? ":{$e['port']}" : '')
        ) : '') .
        (isset($e['path']) ? $e['path'] : '/') .
        (isset($e['query']) ? '?' . (is_array($e['query']) ? http_build_query($e['query'], '',
                '&') : $e['query']) : '') .
        (isset($e['fragment']) ? "#{$e['fragment']}" : '');
}

/**
 * $data = date_range(
 *    'midnight 29 days ago',
 *    'tomorrow',
 *    '+1 day',
 *    function (DateTime $date) use ($data) {
 *       return $this->doSomething(
 *          $date->getTimestamp(),
 *          $date->modify('+1 day')->getTimestamp()
 *       );
 *    }
 * );
 *
 * var_dump($data);
 *
 * @param string $from
 * @param string $to
 * @param string $step
 * @param callable $callback
 * @return array
 */
function date_range($from, $to, $step, callable $callback): array
{
    return array_map($callback, iterator_to_array(new DatePeriod(
        new DateTime($from, new DateTimeZone('UTC')),
        DateInterval::createFromDateString($step),
        new DateTime($to, new DateTimeZone('UTC'))
    )));
}

/**
 * Interactively prompts for input without echoing to the terminal.
 * Requires a bash shell or Windows and won't work with
 * safe_mode settings (Uses `shell_exec`)
 *
 * @see http://us.php.net/manual/en/function.ncurses-noecho.php
 * @see http://us.php.net/manual/en/function.ncurses-getch.php
 *
 * Works only on normal OS, not in windows.
 */
function prompt_silent(string $prompt = "Enter Password: "): ?string
{
    $command = "/usr/bin/env bash -c 'echo OK'";
    if (rtrim(shell_exec($command)) !== 'OK') {
        trigger_error("Can't invoke bash");

        return null;
    }

    $command =
        "/usr/bin/env bash -c 'read -s -p \"" .
        addslashes($prompt) .
        "\" mypassword && echo \$mypassword'";
    $password = rtrim(shell_exec($command));

    return $password;
}

/**
 * Convert seconds to human readable text.
 * Found at: http://csl.sublevel3.org/php-secs-to-human-text/
 */
function secs_to_h($secs)
{
    $units = [
        "week"   => 7*24*3600,
        "day"    =>   24*3600,
        "hour"   =>      3600,
        "minute" =>        60,
        "second" =>         1,
    ];
    // specifically handle zero
    if ( $secs == 0 ) return "0 seconds";
    $s = "";
    foreach ( $units as $name => $divisor ) {
        if ( $quot = intval($secs / $divisor) ) {
            $s .= "$quot $name";
            $s .= (abs($quot) > 1 ? "s" : "") . ", ";
            $secs -= $quot * $divisor;
        }
    }
    return substr($s, 0, -2);
}


function array_to_csv($data, $delimiter = ',', $enclosure = '"')
{
    $handle = fopen('php://temp', 'r+');
    foreach ($data as $line) {
        fputcsv($handle, $line, $delimiter, $enclosure);
    }
    rewind($handle);
    $contents = '';
    while (!feof($handle)) {
        $contents .= fread($handle, 8192);
    }
    fclose($handle);

    return $contents;
}

/**
 * $data = [
 *   ['name' => 'foo', 'id' => 1, 'title' => 'first'],
 *   ['name' => 'foo', 'id' => 1, 'title' => 'second'],
 *   ['name' => 'foo', 'id' => 1, 'title' => 'third'],
 *   ['name' => 'bar', 'id' => 2, 'title' => 'first'],
 *   ['name' => 'bar', 'id' => 2, 'title' => 'second'],
 *   ['name' => 'bar', 'id' => 2, 'title' => 'third'],
 *   ['name' => 'zoo', 'id' => 3, 'title' => 'first'],
 *   ['name' => 'zoo', 'id' => 3, 'title' => 'second'],
 * ];
 *
 * $groupBy = [
 *   'name' => ['name', 'id'],
 * ];
 *
 * $result = array_to_clean_csv($data, $groupBy);
 *
 * // result:
 * [
 *   ['name' => 'foo', 'id' => 1, 'title' => 'first'],
 *   ['name' => '', 'id' => '', 'title' => 'second'],
 *   ['name' => '', 'id' => '', 'title' => 'third'],
 *   ['name' => 'bar', 'id' => 2, 'title' => 'first'],
 *   ['name' => '', 'id' => '', 'title' => 'second'],
 *   ['name' => '', 'id' => '', 'title' => 'third'],
 *   ['name' => 'zoo', 'id' => 3, 'title' => 'first'],
 *   ['name' => '', 'id' => '', 'title' => 'second'],
 * ];
 *
 * @param array $data
 * @param array $groupBy
 */
function clear_array(array $data, array $groupByToRemove)
{
    for ($i = count($data) - 1; $i >= 0; $i--) {
        foreach ($groupByToRemove as $groupKey => $removeFields) {
            if (isset($data[$i - 1][$groupKey]) && $data[$i][$groupKey] === $data[$i - 1][$groupKey]) {
                foreach ($removeFields as $removeField) {
                    $data[$i][$removeField] = '';
                }
            }
        }
    }

    return $data;
}

/**
 * $result = [
 *  ['title' => '...', 'locale' => '...', ...],
 *  ['title' => '...', 'locale' => '...', ...],
 *  ...
 * ];
 *
 * array_to_clean_csv(storage_path('clean.csv'), $result, [
 *  'title' => ['title', 'locale', 'url', 'description', 'meta_description'],
 *  'question' => ['question', 'question_description'],
 * ]);
 *
 * @param string $file
 * @param array $data
 * @param array $groupByToRemove
 */
function array_to_clean_csv(string $file, array $data, array $groupByToRemove)
{
    // Add headers
    $data = array_merge(
        [array_keys($data[0])],
        $data
    );

    $data = clear_array($data, $groupByToRemove);

    $csv = array_to_csv($data);

    file_put_contents($file, $csv);
}


function break_long_words(string $text, string $size = 20, string $delimiter = ' ')
{
    return preg_replace('/([^\s]{'.$size.'})(?=[^\s])/u', '$1' . $delimiter, $text);
}

/**
 * convert
 *
 * id, name, genre
 * 1, mario, platformer
 * 2, splatoon, shooter
 *
 * to
 *
 * [['id' => 1, 'name' => 'mario', 'genre' => 'platformer'], ...]
 *
 * @param string $path example: base_path('stuff/geotargets.csv')
 * @return array
 */
function load_csv_to_array(string $path): array
{
    $csv = array_map('str_getcsv', file($path));
    array_walk($csv, function (&$a) use ($csv) {
        $a = array_combine($csv[0], $a);
    });
    array_shift($csv);

    return $csv;
}

/**
 * [$result, $assigned] = ab_test('ab-test-name');
 * $result = 'old' / 'new';
 * $assigned = bool
 * 
 * @param string $test
 * @return array
 */
function ab_test(string $test)
{
    $tests = [
        'ab-test-name' => ['old', 'new'],
    ];

    $assigned = false;

    $result = $_COOKIE['ab-' . $test] ?? false;

    if (!$result) {
        $result = $tests[$test][mt_rand(0, count($tests[$test]) - 1)];

        setcookie('ab-' . $test, (string) $result, time() + 10 * 365 * 24 * 60 * 60, '/');

        $assigned = true;
    }

    return [$result, $assigned];
}
