<?php

/**
 * Summary of Parser
 */
class Parser
{
  /**
   * Summary of html
   * @var string
   */
  private static string $html;

  /**
   * Summary of get_html
   * @param string $url
   * @return string
   */
  private static function get_html(string $url): string
  {
    return file_get_contents($url);
  }

  /**
   * Summary of parse
   * @param string $url
   * @return array
   */
  public static function parse(string $url): array
  {
    self::$html = self::get_html($url);

    $tags = array();

    preg_match_all('/<([a-z]+)[^>]*>/i', self::$html, $matches);

    foreach ($matches[1] as $tag) {
      if (array_key_exists($tag, $tags)) {
        $tags[$tag]++;
      } else {
        $tags[$tag] = 1;
      }
    }

    arsort($tags);

    return $tags;
  }
}