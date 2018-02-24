<?php

namespace Lib;

/**
 * Classe que contem os métodos que iram
 * filtrar as entradas enviadas via GET e POST
 *
 * @filesource
 * @author      Pedro Elsner <pedro.elsner@gmail.com>
 * @license     http://creativecommons.org/licenses/by/3.0/br/ Creative Commons 3.0
 * @abstract
 * @version     1.0
 */
abstract class Sanitize
{

    /**
     * Filter
     *
     * @param  mixed $value
     * @param  array $modes
     * @return mixed
     * @static
     * @since  1.0
     */
    public static function filter($value, $modes = array('sql', 'html'))
    {
        if (!is_array($modes)) {
            $modes = array($modes);
        }

        if (is_string($value)) {
            foreach ($modes as $type) {
                $value = self::_doFilter($value, $type);
            }
            return $value;
        }

        foreach ($value as $key => $toSanatize) {
            if (is_array($toSanatize)) {
                $value[$key]= self::filter($toSanatize, $modes);
            } else {
                foreach ($modes as $type) {
                    $value[$key] = self::_doFilter($toSanatize, $type);
                }
            }
        }

        return $value;
    }

    /**
     * DoFilter
     *
     * @param  mixed $value
     * @param  array $modes
     * @return mixed
     * @static
     * @since  1.0
     */
    protected static function _doFilter($value, $mode)
    {
        switch ($mode) {
            case 'html':
                $value = trim($value);
                $value = $value == '' ? null : $value;

                if (!is_null($value)) {
                    $config['abs_url'] = '0';
                    $config['anti_link_spam'] = '0';
                    $config['anti_mail_spam'] = '0';
                    $config['anti_mail_spam1'] = 'NO@SPAM';
                    $config['balance'] = '1';
                    $config['base_url'] = '';
                    $config['clean_ms_char'] = '0';
                    $config['css_expression'] = '1';
                    $config['deny_attribute'] = '0';
                    $config['elements'] = '*+iframe';
                    $config['hexdec_entity'] = '1';
                    $config['hook'] = '';
                    $config['hook_tag'] = '';
                    $config['keep_bad'] = '6';
                    $config['lc_std_val'] = '1';
                    $config['named_entity'] = '1';
                    $config['no_deprecated_attr'] = '1';
                    $config['parent'] = 'div';
                    $config['safe'] = '1';
                    $config['schemes'] = 'href: aim, feed, file, ftp, gopher, http, https, irc, mailto, news, nntp, sftp, ssh, telnet; *:file, http, https';
                    $config['style_pass'] = '1';
                    $config['tidy'] = '0';
                    $config['unique_ids'] = '1';
                    $config['show_setting'] = 'hlcfg';
                    $spec = 'iframe=-*,height,width,type,src(match="`^https?://(www\.)?((youtube)|(dailymotion)|(vimeo))\.com/`i")';

                    $value = \Htmlawed::filter($value, $config, $spec);
                    $value = str_replace('&amp;', '&', $value);
                    $value = trim($value);
                    $value = $value == '' ? null : $value;
                }
            break;

            case 'sql':
                $value = preg_replace('/(from|select|insert|delete|where|drop table|show tables|#|\*| |\\\\)/i', '', $value);
                $value = trim($value);
            break;
        }

        return $value;
    }
}
