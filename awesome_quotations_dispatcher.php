<?php

/**
 * Plugin Name: Awesome Quotations Dispatcher
 * Description: Expédition de devis personnalisé pour les sites jecroquebio.com et vracjecroquebio.com
 * Version: 1.0.0
 * Author: Laëtitia
 */

if (!class_exists('Awesome_quotations_dispatcher')) {
    class Awesome_quotations_dispatcher
    {
        protected $plugin_name;
        protected $version;

        /**
         * Awesome_quotations_dispatcher constructor.
         */
        public function __construct()
        {
            if (defined('PLUGIN_NAME_VERSION')) {
                $this->version = PLUGIN_NAME_VERSION;
            } else {
                $this->version = '1.0.0';
            }
            $this->plugin_name = 'awesome_quotations_dispatcher';

            add_action('admin_menu', array($this, 'init_awesome_quotations_dispatcher'));

            register_activation_hook(__FILE__,array($this, 'aqd_activate'));
            register_deactivation_hook(__FILE__, array($this, 'deleteTable_aqd_producers'));

            add_action('plugin_loaded', [$this, 'aqd_includes']);
        } // Fin Constructeur

        public function aqd_activate(){
            include_once plugin_dir_path(__FILE__) . 'includes/db/class_aqd_db.php';
        }

        public function aqd_includes(){
            include_once plugin_dir_path(__FILE__) . 'includes/class_aqd_front_hook_action_filter.php';
        }

        public function init_awesome_quotations_dispatcher()
        {
            if(function_exists('add_options_page')) {
                $emailprodpage = add_options_page("Email Producteur", 'Email Producteur', 'administrator', __FILE__, array($this, 'admin_page_awesome_quotations_dispatcher'));
                add_action('load-'.$emailprodpage, array($this, 'admin_producers_email_js_css'));
            }
        }

        public function admin_producers_email_js_css(){
            wp_register_style('admin_producers_email_css', plugins_url('css/admin_producers_email.css', __FILE__));
            wp_enqueue_style('admin_producers_email_css');
            wp_enqueue_script('admin_producers_email_js', plugins_url('js/admin_producers_email.js', __FILE__), array('jquery'), '1.0', true);
        }

        public function admin_page_awesome_quotations_dispatcher()
        {
            $page = isset($_GET['p']) ? $_GET['p'] : null;
            switch ($page) {
                case 'produceremail' :
                    require_once('templates/aqd_updateProducersEmail_template.php');
                    break;
                default:
                    require_once('templates/aqd_addProducersEmail_template.php');
                    break;
            }

            if (isset($_GET['action'])) {

                if ($_GET['action'] == 'createTabProducersEmailsCat') {

                    if ((trim($_POST['name']) != '') && (trim($_POST['email']) != '') && (trim($_POST['term_id']) != '')) {

                        $insertAqdProducers = $this->insertDate_aqd_producers($_POST['name'], filter_var($_POST['email'], FILTER_VALIDATE_EMAIL), $_POST['term_id']);

                        if ($insertAqdProducers == true) echo
                            '<script> window.location =
                            "' . get_bloginfo('url') . '/wp-admin/options-general.php?page=awesome_quotations_dispatcher/awesome_quotations_dispatcher.php&produceremail=ok' . '"; </script>';
                        else echo '<p> Une erreur est survenue</p>';

                    } else {
                        echo '<p style="color:red;">Veuillez remplir tous les champs</p>';
                    }
                } else if ($_GET['action'] == 'updateTabProducersEmailsCat') {
                    if ((trim($_POST['name']) != '') && (trim($_POST['email']) != '') && (trim($_POST['term_id']) != '') && (trim($_POST['id']) != '')) {

                        $updateAqdProducers = $this->update_aqd_producers($_POST['id'], $_POST['name'], $_POST['email'], $_POST['term_id']);

                        if ($updateAqdProducers == true) echo
                            '<script> window.location =
                            "' . get_bloginfo('url') . '/wp-admin/options-general.php?page=awesome_quotations_dispatcher/awesome_quotations_dispatcher.php&p=produceremail&id=' . $_POST['id'] . '&produceremail=ok' . '";</script>';
                        else echo '<p> Une erreur est survenue</p>';

                    } else {
                        echo '<p style="color:red;">Veuillez remplir tous les champs</p>';
                    }
                    if (isset($_GET['promail'])) {
                        if ($_GET['promail'] == 'ok') {
                            echo "Le mail a bien été enregistrée";
                        }
                    }
                } else if($_GET['action']=='deletemap'){
                    if(trim($_POST['id'])!=''){
                        $deleteprodmail = $this->delete_aqd_producers($_POST['id']);

                        if($deleteprodmail==true) echo
                        '<script> window.location =
                            "' . get_bloginfo('url') . '/wp-admin/options-general.php?page=awesome_quotations_dispatcher/awesome_quotations_dispatcher.php&produceremail=deleteok' . '";</script>';
                        else echo '<p> Une erreur est survenue</p>';
                    }
                }

            }
        } // Fin function



        function insertDate_aqd_producers($name, $email, $term_id)
        {
            global $wpdb;

            $table_producers_cat = $wpdb->prefix . 'aqd_producers';

            $sql = $wpdb->prepare(
                "
                INSERT INTO " . $table_producers_cat . "
                (name, email, term_id)
                VALUES (%s, %s, %d)
                ",
                $name,
                $email,
                $term_id
            );
            $wpdb->query($sql);

            if (!$sql) $insertaqdproducers = false;
            else $insertaqdproducers = true;

            return $insertaqdproducers;
        }

        public function getData_aqd_producers()
        {
            global $wpdb;

            $table_sel_producers = $wpdb->prefix . 'aqd_producers';

            $sql = "SELECT * FROM " . $table_sel_producers;
            $tab_prod_cat = $wpdb->get_results($sql);

            return $tab_prod_cat;
        }

        public function getid_aqd_producers($id)
        {
            global $wpdb;

            $tabpromail = $wpdb->prefix . 'aqd_producers';

            $sql = $wpdb->prepare("SELECT * FROM " . $tabpromail . " WHERE id='%d' LIMIT 1", $id);
            $tablepromail = $wpdb->get_results($sql);

            return $tablepromail;
        }

        public function update_aqd_producers($id, $name, $email, $term_id){
            global $wpdb;

            $table_aqd_produce = $wpdb->prefix . 'aqd_producers';

            $sql = $wpdb->prepare(
                "
                UPDATE " . $table_aqd_produce . "
                SET name=%s, email=%s, term_id=%d WHERE id=%d
                ",
                $name,
                $email,
                $term_id,
                $id
            );
            $wpdb->query($sql);
            if (!$sql) $up_aqd_producers = false;
            else $up_aqd_producers = true;

            return $up_aqd_producers;
        }

        public function aqd_get_child_producer_category_id()
        {
            global $wpdb;

            $sql = $wpdb->prepare("SELECT ter.term_id, ter.name FROM {$wpdb->prefix}terms ter ;");

            $cat_producers = $wpdb->get_results($sql);

            return $cat_producers;
        }

        public function delete_aqd_producers($id){
            global $wpdb;

            $tab_producermail = $wpdb->prefix . 'aqd_producers';

            $sql = $wpdb->prepare("DELETE FROM " . $tab_producermail . " WHERE id='%d' LIMIT 1", $id);
            $table_producermail = $wpdb->get_results($sql);

            return $table_producermail;
        }

        public function deleteTable_aqd_producers()
        {
            global $wpdb;

            $table_producers = $wpdb->prefix . 'aqd_producers';
            if ($wpdb->get_var("SHOW TABLES LIKE '$table_producers'") == $table_producers)
            {
                $sql = "DROP TABLE `$table_producers`";
                $wpdb->query($sql);
            }
        }

    } // Fin class
} // Fin if class exists
new Awesome_quotations_dispatcher();
