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
 * @return
 * @throws Exception
 */
function retry_exception(array $exceptions, $times, callable $callback, $sleep = 0)
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
function isDateBetweenDates(DateTime $date, DateTime $startDate, DateTime $endDate): bool
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
