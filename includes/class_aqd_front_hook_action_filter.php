<?php

if (!defined('ABSPATH')){
    die;
}

class class_aqd_front_hook_action_filter
{
    function woocommerce_changer_text_ajouter_panier()
    {
        return __('Ajouter au devis', 'woocommerce');
    }

    function woocommerce_changer_bouton_ajouter_panier()
    {
        return __('Ajouter au devis', 'woocommerce');
    }

    public function aqd_added_to_cart_message(){
        return __('Ajouté à la demande de devis', 'woocommerce');
    }

    function aqd_add_field_form_checkout($fields)
    {
        $fields['billing']['billing_siret'] = array(
            'type' => 'tel',
            'length=14',
            'label' => __('Numéro de Siret','woocommerce'),
            'class' => array('form-row-wide'),
            'required' => true,
            'priority' => 1,
            'clear' => true
        );
        return $fields;
    }

    function aqd_saving_siret_checkout_data($order_id)
    {
        update_post_meta($order_id, "billing_siret", sanitize_text_field($_POST['billing_siret']));
    }
}
if(class_exists('class_aqd_front_hook_action_filter')) {
    $aqd_front_hook_action_filter = new class_aqd_front_hook_action_filter();
}

if(isset($aqd_front_hook_action_filter)){
    add_filter('woocommerce_product_add_to_cart_text', array($aqd_front_hook_action_filter, 'woocommerce_changer_text_ajouter_panier'));

    add_filter('woocommerce_product_single_add_to_cart_text', array($aqd_front_hook_action_filter, 'woocommerce_changer_bouton_ajouter_panier'));

    add_filter('wc_add_to_cart_message_html', array($aqd_front_hook_action_filter, 'aqd_added_to_cart_message'));

    add_filter('woocommerce_checkout_fields', array($aqd_front_hook_action_filter, 'aqd_add_field_form_checkout'));

    add_action(‘woocommerce_checkout_update_order_meta’, array($aqd_front_hook_action_filter, ‘aqd_saving_siret_checkout_data’));
}
