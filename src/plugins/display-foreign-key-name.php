<?php

/**
 * Adminer plugin that display the first CHAR/VARCHAR column of the foreign key
 *
 * @category Plugin
 * @link http://www.adminer.org/plugins/#use
 * @author Bruno VIBERT <http://www.netapsys.fr>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 *
 * modify by Kwanpon Wattanaklang @ November 2019
 */
class AdminerDisplayForeignKeyName
{

    protected static $_valueCache = array();

    /**
     * Get a cache entry
     */
    protected static function _getCache($key)
    {
        if (array_key_exists($key, self::$_valueCache)) {
            return self::$_valueCache[$key];
        }

        return false;
    }

    /**
     * Set a cache entry
     */
    protected static function _setCache($key, $value)
    {
        self::$_valueCache[$key] = $value;
    }


    /**
     * Render a foreign key value
     */
    function selectVal($val, $link, $field, $original)
    {
        $return = ($val === null ? "<i>NULL</i>" : (preg_match("~char|binary~", $field["type"]) && !preg_match("~var~", $field["type"]) ? "<code>$val</code>" : $val));
        if (preg_match('~blob|bytea|raw|file~', $field["type"]) && !is_utf8($val)) {
            $return = lang('%d byte(s)', strlen($original));
        } else {
            parse_str(substr($link, 1), $params);

            if (true == is_array($params) && true == array_key_exists('where', $params)) {
                $where = array();
                foreach ($params['where'] as $param) {
                    $where[] = join(' ', $param);
                }

                $pkIsChar = in_array($field['type'], array('varchar', 'char'));
                if ($pkIsChar) {
                    $whereChar = array();
                    foreach ($where as $w) {
                        $whereChar[] = str_replace(" = ", " = '", $w)."'";
                    }
                    $where = $whereChar;
                }

                // Find the first char/varchar field to display
                $fieldName = false;
                $fi = 0;
                foreach (fields($params['select']) as $field) {
                    if (true == in_array($field['type'], array('varchar', 'char')) && $field['length'] >= 25) {
                        $fi++;
                        if ($pkIsChar && $fi == 1) {
                            continue;
                        }
                        $fieldName = $field['field'];
                        break;
                    }
                }

                if (false !== $fieldName) {
                    $query = sprintf("SELECT %s FROM `%s` WHERE %s LIMIT 1", $fieldName, $params['select'], join(' AND ', $where));
                    $return = self::_getCache(md5($query));
                    if (false === $return) {
                        $result = connection()->query($query);
                        if ($result->num_rows == 1) {
                            $row = $result->fetch_assoc();
                            $value = $row[$fieldName];
                            $length = (isset($_GET['text_length'])) ? (int)$_GET['text_length'] / 2 : 30;
                            if (extension_loaded('mbstring')) {
                                if (mb_strlen($value, 'utf-8') > $length) {
                                    $value = mb_substr($value, 0, $length, 'utf-8') . '...';
                                }
                            }
                            $return = sprintf('%s%s', $original, $value == null ? '' : '  >>  ' . $value);
                            self::_setCache(md5($query), $return);
                        } else {
                            $return = $original;
                        }
                    }
                }
            }
        }

        return ($link ? "<a href='" . h($link) . "'" . (is_url($link) ? " rel='noreferrer'" : "") . ">$return</a>" : $return);
    }
}
