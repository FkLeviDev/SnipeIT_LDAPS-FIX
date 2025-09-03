<?php
/**
 * Auto LDAPS Startup Script
 * Run this script after XAMPP starts to ensure LDAPS is working
 */

// Load configuration
$config = require_once 'ldaps_config.php';

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Setting;

echo "=== Auto LDAPS Startup ===\n";
echo "Timestamp: " . date('Y-m-d H:i:s') . "\n";
echo "Server: " . $config['server'] . "\n";
echo "Domain: " . $config['domain'] . "\n\n";

// Get current settings
$settings = Setting::getSettings();

if (!$settings) {
    echo "❌ No settings found! Creating new settings...\n";
    $settings = new Setting();
}

// Always ensure LDAPS configuration is correct
echo "Ensuring LDAPS configuration...\n";

$settings->ldap_enabled = 1;
$settings->ldap_server = $config['server'];
$settings->ldap_port = $config['port'];
$settings->ldap_tls = $config['tls'] ? 1 : 0;
$settings->ldap_server_cert_ignore = $config['cert_ignore'] ? 1 : 0;
$settings->ldap_basedn = $config['base_dn'];
$settings->ldap_username_field = $config['username_field'];
$settings->ldap_auth_filter_query = $config['auth_filter'];
$settings->ldap_version = $config['ldap_version'];
$settings->is_ad = 1;
$settings->ad_domain = $config['domain'];
$settings->ldap_uname = $config['admin_username'];
$settings->ldap_pword = encrypt($config['admin_password']);

// Set field mappings
$settings->ldap_fname_field = $config['field_mappings']['first_name'];
$settings->ldap_lname_field = $config['field_mappings']['last_name'];
$settings->ldap_email = $config['field_mappings']['email'];
$settings->ldap_phone_field = $config['field_mappings']['phone'];
$settings->ldap_jobtitle = $config['field_mappings']['job_title'];
$settings->ldap_dept = $config['field_mappings']['department'];
$settings->ldap_manager = $config['field_mappings']['manager'];
$settings->ldap_location = $config['field_mappings']['location'];
$settings->ldap_country = $config['field_mappings']['country'];
$settings->ldap_emp_num = $config['field_mappings']['employee_number'];
$settings->ldap_filter = $config['filter'];
$settings->ldap_pw_sync = $config['password_sync'] ? 1 : 0;

if ($settings->save()) {
    echo "✅ LDAPS configuration applied!\n";
} else {
    echo "❌ Failed to apply LDAPS configuration!\n";
    exit(1);
}

// Test the connection
echo "Testing LDAPS connection...\n";

try {
    // Test basic LDAP connection with configured settings
    // For LDAPS, use ldaps:// URL format
    $ldapUrl = 'ldaps://' . $config['server'] . ':' . $config['port'];
    $ldapConnection = ldap_connect($ldapUrl);
    
    if ($ldapConnection) {
        // Set LDAP options
        ldap_set_option($ldapConnection, LDAP_OPT_PROTOCOL_VERSION, $config['ldap_version']);
        ldap_set_option($ldapConnection, LDAP_OPT_REFERRALS, $config['referrals']);
        ldap_set_option($ldapConnection, LDAP_OPT_NETWORK_TIMEOUT, $config['network_timeout']);
        
        // Enable LDAPS (SSL/TLS)
        if ($config['port'] == 636) {
            ldap_set_option($ldapConnection, LDAP_OPT_X_TLS_REQUIRE_CERT, LDAP_OPT_X_TLS_NEVER);
        }
        
        // Try to bind with admin credentials
        $bind = ldap_bind($ldapConnection, $config['admin_username'], $config['admin_password']);
        
        if ($bind) {
            echo "✅ LDAPS connection successful!\n";
            echo "Message: Connected to " . $config['server'] . " on port " . $config['port'] . "\n";
        } else {
            echo "❌ LDAPS bind failed!\n";
            echo "Error: " . ldap_error($ldapConnection) . "\n";
        }
        
        ldap_close($ldapConnection);
    } else {
        echo "❌ LDAPS connection failed!\n";
        echo "Error: Cannot connect to " . $config['server'] . " on port " . $config['port'] . "\n";
    }
} catch (Exception $e) {
    echo "❌ LDAPS connection error: " . $e->getMessage() . "\n";
}

echo "\n=== Auto LDAPS Startup Complete ===\n";
?>
