<?php
/**
 * Plugin Name: Task Manager
 * Plugin URI: https://yourwebsite.com
 * Description: A custom WordPress plugin to manage daily tasks.
 * Version: 1.0.0
 * Author: Hamza Naeem
 * Author URI: https://yourwebsite.com
 * License: GPL2
 */
if(!defined("ABSPATH"))
    {
        exit;
    }
class TMPlugin{
    public function __construct()
    {
        $this->define_constants();
        $this->init_hooks();
        $this->includes();
    }

    private function define_constants()
    {
        define("TMPLUGIN_VERSION", "1.0");
        define("TMPLUGIN_DIR_PATH", plugin_dir_path(__FILE__));
        define("TMPLUGIN_DIR_URL", plugin_dir_url(__FILE__));
    }

    private function init_hooks()
    {
        register_activation_hook(__FILE__, array($this, "activate"));
        register_deactivation_hook(__FILE__, array($this, "deactivate"));
    }

    private function includes()
    {
        require_once TMPLUGIN_DIR_PATH . "includes/class_task_manager_form_plugin.php";
        new TMFrontend();
    }

    public function activate()
    {
        flush_rewrite_rules();
    }

    public function deactivate()
    {
        flush_rewrite_rules();
    }
}

function task_manager_plugin_init()
{
    return new TMPlugin();
}
task_manager_plugin_init();