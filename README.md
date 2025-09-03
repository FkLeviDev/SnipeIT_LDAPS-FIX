# Snipe-IT LDAPS Fix

A Snipe-IT rendszer LDAPS (LDAP over SSL) kapcsolatának javítására szolgáló csomag Active Directory környezetben.

## 🚀 Gyors Kezdés

1. **Töltsd le** az összes fájlt
2. **Másold** a fájlokat a Snipe-IT gyökér mappájába
3. **Szerkeszd** a `ldaps_config.php` fájlt a saját beállításaiddal
4. **Futtasd** a `snipe_ldaps_complete_setup.bat` fájlt

## 📁 Fájlok

- `ldaps_config.php` - Fő konfigurációs fájl
- `ldaps_config_example.php` - Példa konfiguráció
- `complete_ldaps_setup.php` - Teljes beállítás script
- `auto_ldaps_startup.php` - Automatikus indítás script
- `ensure_ldaps_persistence.php` - Persisztencia ellenőrzés
- `snipe_ldaps_complete_setup.bat` - Teljes beállítás batch fájl
- `snipe_ldaps_startup.bat` - Automatikus indítás batch fájl
- `LDAPS_HASZNÁLATI_ÚTMUTATÓ.md` - Részletes használati útmutató (magyarul)

## ⚙️ Konfiguráció

Szerkeszd a `ldaps_config.php` fájlt:

```php
return [
    'server' => 'ldaps://YOUR_SERVER_IP',        // Szerver IP címe
    'port' => 636,                               // LDAPS port
    'base_dn' => 'DC=YOUR_DOMAIN,DC=LOCAL',     // Base DN
    'domain' => 'YOUR_DOMAIN.LOCAL',            // AD domain
    'admin_username' => 'Admin@YOUR_DOMAIN.LOCAL', // Admin felhasználó
    'admin_password' => 'YOUR_ADMIN_PASSWORD',   // Admin jelszó
    // ... további beállítások
];
```

## 🎯 Funkciók

- ✅ Automatikus LDAPS konfiguráció
- ✅ Active Directory integráció
- ✅ SSL/TLS tanúsítvány kezelés
- ✅ Automatikus indítás XAMPP után
- ✅ Persisztencia ellenőrzés
- ✅ Részletes hibakeresés
- ✅ Magyar nyelvű dokumentáció

## 📋 Előfeltételek

- XAMPP telepítve
- Snipe-IT telepítve
- Active Directory szerver elérhető
- MySQL és Apache szolgáltatások futnak

## 🔧 Használat

1. **Első beállítás**: `snipe_ldaps_complete_setup.bat`
2. **Automatikus indítás**: `snipe_ldaps_startup.bat`
3. **Részletes útmutató**: `LDAPS_HASZNÁLATI_ÚTMUTATÓ.md`

## 🐛 Hibakeresés

Ha problémák merülnek fel:

1. Ellenőrizd a hálózati kapcsolatot
2. Nézd meg a napló fájlokat
3. Teszteld a LDAP kapcsolatot
4. Ellenőrizd a tűzfal beállításokat

## 📄 Licenc

Ez a projekt nyílt forráskódú. Használd szabadon!

## 🤝 Közreműködés

Ha javításokat vagy fejlesztéseket szeretnél:

1. Fork-old a repository-t
2. Hozz létre egy feature branch-et
3. Commit-old a változtatásaidat
4. Push-old a branch-et
5. Nyiss egy Pull Request-et

## 📞 Támogatás

Ha segítségre van szükséged, nézd meg a `LDAPS_HASZNÁLATI_ÚTMUTATÓ.md` fájlt részletes útmutatással.
