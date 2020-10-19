<?php

class ShoptetUserRoles {

    const SHOPTET_ADMIN_ROLE_VERSION = 1;

    static function init() {
        add_action( 'init', [ get_called_class(), 'add_shoptet_admin_role' ] );
        add_filter( 'editable_roles', [ get_called_class(), 'editable_roles' ] );
        add_filter( 'acf/settings/show_admin', [ get_called_class(), 'acf_show_admin' ] );
        add_filter( 'w3tc_capability_menu', [ get_called_class(), 'w3tc_change_cap' ] );
    }

    static function add_shoptet_admin_role() {
        $current_version = get_option('shoptet_administrator_role_version');
        if ( $current_version >= self::SHOPTET_ADMIN_ROLE_VERSION ) return;
        
        $role = get_role('shoptet_administrator');
        if ( NULL === $role ) {
            $role = add_role( 'shoptet_administrator', __( 'Shoptet Administrator', 'shoptet' ), get_role('administrator')->capabilities );
        }

        $role->remove_cap('activate_plugins');
        $role->remove_cap('update_core');
        $role->remove_cap('update_plugins');
        $role->remove_cap('update_themes');
        $role->remove_cap('install_plugins');
        $role->remove_cap('install_themes');
        $role->remove_cap('delete_themes');
        $role->remove_cap('delete_plugins');
        $role->remove_cap('edit_plugins');
        $role->remove_cap('edit_themes');
        $role->remove_cap('edit_files');
        $role->remove_cap('switch_themes');
        $role->remove_cap('customize');
        $role->remove_cap('delete_site');

        update_option( 'shoptet_administrator_role_version', self::SHOPTET_ADMIN_ROLE_VERSION );
    }

    static function editable_roles( $roles ) {
        if ( isset($roles['administrator']) && !current_user_can('administrator') ){
            unset($roles['administrator']) ;
        }
        return $roles;
    }

    static function acf_show_admin( $show ) {
        if ( !current_user_can('administrator') ) {
            $show = false;
        }
        return $show;
    }

    static function w3tc_change_cap( $cap ) {
        return 'activate_plugins';
    }
}
