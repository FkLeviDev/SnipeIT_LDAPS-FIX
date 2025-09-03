<?php
/**
 * Ensure LDAPS Configuration Persistence
 * This script ensures LDAPS settings are maintained after XAMPP restarts
 */

// Load configuration
$config = require_once 'ldaps_config.php';

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Setting;

echo "=== LDAPS Configuration Persistence Check ===\n";
echo "Server: " . $config['server'] . "\n";
echo "Domain: " . $config['domain'] . "\n\n";

// Get current settings
$settings = Setting::getSettings();

if (!$settings) {
    echo "❌ No settings found! Creating new settings...\n";
    $settings = new Setting();
}

// Check if LDAPS configuration is correct
$needs_fix = false;
$issues = [];

echo "Checking LDAPS configuration...\n";
echo "===============================\n";

// Check LDAP enabled
if (!$settings->ldap_enabled) {
    $needs_fix = true;
    $issues[] = "LDAP not enabled";
}

// Check server configuration
if ($settings->ldap_server !== $config['server']) {
    $needs_fix = true;
    $issues[] = "Server not set to '" . $config['server'] . "'";
}

// Check port
if ($settings->ldap_port != $config['port']) {
    $needs_fix = true;
    $issues[] = "Port not set to " . $config['port'] . " (LDAPS)";
}

// Check certificate ignore
if (!$settings->ldap_server_cert_ignore && $config['cert_ignore']) {
    $needs_fix = true;
    $issues[] = "Certificate validation not disabled";
}

// Check username field case
if (strtolower($settings->ldap_username_field) !== strtolower($config['username_field'])) {
    $needs_fix = true;
    $issues[] = "Username field not set to '" . $config['username_field'] . "'";
}

// Check auth filter
if ($settings->ldap_auth_filter_query !== $config['auth_filter']) {
    $needs_fix = true;
    $issues[] = "Auth filter not set to '" . $config['auth_filter'] . "'";
}

// Check base DN
if ($settings->ldap_basedn !== $config['base_dn']) {
    $needs_fix = true;
    $issues[] = "Base DN not set to '" . $config['base_dn'] . "'";
}

// Check AD settings
if (!$settings->is_ad) {
    $needs_fix = true;
    $issues[] = "Active Directory mode not enabled";
}

if ($settings->ad_domain !== $config['domain']) {
    $needs_fix = true;
    $issues[] = "AD domain not set to '" . $config['domain'] . "'";
}

// Check admin credentials
if (!$settings->ldap_uname || !$settings->ldap_pword) {
    $needs_fix = true;
    $issues[] = "Admin credentials not set";
}

if ($needs_fix) {
    echo "❌ Configuration issues found:\n";
    foreach ($issues as $issue) {
        echo "   - " . $issue . "\n";
    }
    
    echo "\nApplying LDAPS fix...\n";
    echo "====================\n";
    
    // Apply the complete fix
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
        echo "✅ LDAPS configuration fixed and saved!\n";
    } else {
        echo "❌ Failed to save LDAPS configuration!\n";
        exit(1);
    }
} else {
    echo "✅ LDAPS configuration is correct!\n";
}

// Test the connection
echo "\nTesting LDAPS connection...\n";
echo "===========================\n";

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
            echo "✅ LDAPS connection test successful!\n";
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
    echo "❌ LDAPS connection test error: " . $e->getMessage() . "\n";
}

echo "\n=== LDAPS Persistence Check Complete ===\n";
echo "Configuration will persist after XAMPP restarts.\n";
?>
