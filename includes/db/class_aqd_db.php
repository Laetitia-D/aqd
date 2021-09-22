<?php

if (!defined('ABSPATH')){
    die;
}

if (!class_exists('class_aqd_db')) {
    class class_aqd_db
    {
        public function __construct()
        {
            $this->createTable_aqd_producers();
        }

        public function createTable_aqd_producers()
        {
            global $wpdb;

            $table_producers = $wpdb->prefix . 'aqd_producers';
            if ($wpdb->get_var("SHOW TABLES LIKES '$table_producers'") != $table_producers)
            {
                $charset_collate = $wpdb->get_charset_collate();

                $sql = "CREATE TABLE `$table_producers` (
                    `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
                    `name` VARCHAR(32) NOT NULL,
                    `email` VARCHAR(32) NOT NULL UNIQUE,
                    `term_id` BIGINT(20) NULL,
                    PRIMARY KEY (`id`),
                    CONSTRAINT FK_term_name_aqd FOREIGN KEY (`name`)                        
                    REFERENCES {$wpdb->prefix}terms(`name`)
                    ON UPDATE CASCADE
                    ON DELETE CASCADE,
                    CONSTRAINT FK_term_id_aqd FOREIGN KEY (`term_id`)                        
                    REFERENCES {$wpdb->prefix}terms(`term_id`)
                    ON UPDATE CASCADE
                    ON DELETE CASCADE 
                    )$charset_collate;";

                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                dbDelta($sql);
            }
        }
    }
}
$aqd_db = new class_aqd_db();
