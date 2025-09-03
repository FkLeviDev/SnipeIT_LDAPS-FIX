<?php
/**
 * LDAPS Configuration Example File
 * Másold át ldaps_config.php néven és szerkeszd a saját beállításaidhoz
 */

return [
    // LDAPS Szerver Beállítások
    'server' => 'your-domain-controller.company.com',  // Szerver címe vagy IP
    'port' => 636,                                      // LDAPS port (általában 636)
    'base_dn' => 'DC=company,DC=com',                  // Base DN (pl: DC=company,DC=com)
    
    // Active Directory Beállítások
    'domain' => 'company.com',                          // AD domain név
    'admin_username' => 'admin@company.com',           // Admin felhasználó (teljes név)
    'admin_password' => 'YourSecurePassword123!',      // Admin jelszó
    
    // LDAP Beállítások
    'username_field' => 'sAMAccountName',              // Felhasználónév mező
    'auth_filter' => 'sAMAccountName=',                // Auth szűrő
    'ldap_version' => 3,                               // LDAP verzió
    'tls' => false,                                    // TLS használata (LDAPS esetén false)
    'cert_ignore' => true,                             // Tanúsítvány ellenőrzés kihagyása
    
    // Mező Leképezések
    'field_mappings' => [
        'first_name' => 'givenName',
        'last_name' => 'sn',
        'email' => 'mail',
        'phone' => 'telephoneNumber',
        'job_title' => 'title',
        'department' => 'department',
        'manager' => 'manager',
        'location' => 'physicalDeliveryOfficeName',
        'country' => 'c',
        'employee_number' => 'employeeNumber',
    ],
    
    // Egyéb Beállítások
    'filter' => '(objectClass=user)',                  // LDAP szűrő
    'password_sync' => true,                           // Jelszó szinkronizálás
    'timeout' => 30,                                   // Kapcsolat timeout (másodperc)
    'network_timeout' => 30,                           // Hálózati timeout (másodperc)
    'referrals' => 0,                                  // LDAP referrals
    
    // SSL/TLS Beállítások
    'tls_require_cert' => 'never',                     // TLS tanúsítvány követelmény
    'tls_ca_cert' => '',                               // CA tanúsítvány útvonala (üres = nincs)
    
    // Alkalmazás Beállítások
    'app_name' => 'Snipe-IT',                          // Alkalmazás neve
    'app_url' => 'http://localhost',                   // Alkalmazás URL
    'app_env' => 'production',                         // Környezet (production/development)
    'app_debug' => false,                              // Debug mód
    
    // Adatbázis Beállítások
    'db_host' => '127.0.0.1',                         // MySQL szerver
    'db_port' => 3306,                                 // MySQL port
    'db_database' => 'snipeit',                        // Adatbázis név
    'db_username' => 'root',                           // MySQL felhasználó
    'db_password' => '',                               // MySQL jelszó
    
    // Email Beállítások
    'mail_from_address' => 'admin@yourcompany.com',    // Email küldő címe
    'mail_from_name' => 'Snipe-IT',                    // Email küldő neve
];
?>
