<?php
/**
 * LDAPS Configuration File
 * Szerkeszd ezt a fájlt a saját szerver beállításaidhoz
 */

return [
    // LDAPS Szerver Beállítások
    'server' => 'ldaps://YOUR_SERVER_IP',        // Szerver URL (LDAPS formátum - IP cím)
    'port' => 636,                                // LDAPS port (636 - LDAP over SSL!)
    'base_dn' => 'DC=YOUR_DOMAIN,DC=LOCAL',      // Base DN (pl: DC=company,DC=com)
    
    // Active Directory Beállítások
    'domain' => 'YOUR_DOMAIN.LOCAL',             // AD domain név
    'admin_username' => 'Admin@YOUR_DOMAIN.LOCAL', // Admin felhasználó (email formátum)
    'admin_password' => 'YOUR_ADMIN_PASSWORD',    // Admin jelszó
    
    // LDAP Beállítások
    'username_field' => 'samaccountname',         // Felhasználónév mező (kisbetű!)
    'auth_filter' => 'samaccountname=',           // Auth szűrő (kisbetű!)
    'ldap_version' => 3,                          // LDAP verzió
    'tls' => false,                               // TLS használata (LDAPS esetén false)
    'cert_ignore' => true,                        // Tanúsítvány ellenőrzés kihagyása
    
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
    'filter' => '&(cn=*)',                       // LDAP szűrő (cn=* formátum!)
    'password_sync' => true,                      // Jelszó szinkronizálás
    'timeout' => 30,                              // Kapcsolat timeout (másodperc)
    'network_timeout' => 30,                      // Hálózati timeout (másodperc)
    'referrals' => 0,                             // LDAP referrals
    
    // SSL/TLS Beállítások
    'tls_require_cert' => 'never',                // TLS tanúsítvány követelmény
    'tls_ca_cert' => '',                          // CA tanúsítvány útvonala (üres = nincs)
    
    // Alkalmazás Beállítások
    'app_name' => 'Snipe-IT',                     // Alkalmazás neve
    'app_url' => 'http://localhost',              // Alkalmazás URL
    'app_env' => 'production',                    // Környezet (production/development)
    'app_debug' => false,                         // Debug mód
    
    // Adatbázis Beállítások
    'db_host' => '127.0.0.1',                    // MySQL szerver
    'db_port' => 3306,                           // MySQL port
    'db_database' => 'snipeit',                  // Adatbázis név
    'db_username' => 'root',                     // MySQL felhasználó
    'db_password' => '',                         // MySQL jelszó
    
    // Email Beállítások
    'mail_from_address' => 'admin@yourcompany.com', // Email küldő címe
    'mail_from_name' => 'Snipe-IT',              // Email küldő neve
];
?>
