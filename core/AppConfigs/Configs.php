<?php
    /**
     * Created by User: gurjot
     */

    namespace App\Core\AppConfigs;

    class Configs
    {
        protected const SMTP_CONFIG = [
            'smtp_host'         =>  'mail host name',
            'smtp_port'         =>  2525,
            'smtp_username'     =>  'user@example.com',
            'smtp_password'     =>  'secret',
            'smtp_encryption'   =>  'tls'
        ];

        protected const SITE_URLS = [
            'development_url'   =>  'https://localhost',
            'production_url'    =>  'https://siteurl.com'
        ];

        public static function getSmtpConfig() {
            return self::SMTP_CONFIG;
        }

        public static function getSiteUrl() {
            return self::SITE_URLS;
        }
    }