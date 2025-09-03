# Snipe-IT LDAPS Javítási Útmutató

## Áttekintés

Ez az útmutató segít a Snipe-IT rendszer LDAPS (LDAP over SSL) kapcsolatának javításában Active Directory környezetben. A megoldás automatikusan konfigurálja a szükséges beállításokat és teszteli a kapcsolatot.

## Előfeltételek

- **XAMPP** telepítve és működőképes
- **Snipe-IT** telepítve a XAMPP htdocs mappájában
- **Active Directory szerver** elérhető
- **MySQL** és **Apache** szolgáltatások futnak
- **PHP** parancssor elérhető

## 📁 Fájlok Elhelyezése

**FONTOS**: Minden fájlt a **Snipe-IT gyökér mappájába** kell helyezni!

### Telepítési Mappa
```
[SNIPE-IT_GYÖKÉR_MAPPA]\
├── ldaps_config.php                    ← Konfigurációs fájl
├── ldaps_config_example.php            ← Példa konfiguráció
├── auto_ldaps_startup.php              ← Auto indítás script
├── complete_ldaps_setup.php            ← Teljes beállítás script
├── ensure_ldaps_persistence.php        ← Persisztencia ellenőrzés
├── snipe_ldaps_complete_setup.bat      ← Teljes beállítás batch
├── snipe_ldaps_startup.bat             ← Auto indítás batch
├── LDAPS_HASZNÁLATI_ÚTMUTATÓ.md        ← Használati útmutató
└── [snipeit egyéb fájljai...]
```

### Fájlok Másolása
```bash
# Navigálj a Snipe-IT mappába
cd [SNIPE-IT_GYÖKÉR_MAPPA]

# Másold át az összes fájlt ide
copy "[LDAP_FIX_MAPPA]\*.php" .
copy "[LDAP_FIX_MAPPA]\*.bat" .
copy "[LDAP_FIX_MAPPA]\*.md" .
```

### ⚠️ Fontos Megjegyzések
- ❌ **NE** helyezd a fájlokat almappákba
- ❌ **NE** változtasd meg a fájlneveket
- ✅ **MINDEN** fájlt a Snipe-IT gyökérbe
- ✅ **Apache** olvasási jogosultság szükséges
- ✅ **PHP** futtatási jogosultság szükséges

## ⚙️ Konfigurációs Fájl Beállítása

**FONTOS**: A scriptek futtatása előtt szerkeszd a `ldaps_config.php` fájlt a saját szerver beállításaidhoz!

### 1. Lépés: Konfigurációs Fájl Szerkesztése

Nyisd meg a `ldaps_config.php` fájlt és módosítsd a következő értékeket:

```php
// LDAPS Szerver Beállítások
'server' => 'your-server.domain.com',        // Szerver címe vagy IP
'port' => 636,                               // LDAPS port (általában 636)
'base_dn' => 'DC=yourcompany,DC=com',       // Base DN

// Active Directory Beállítások
'domain' => 'yourcompany.com',               // AD domain név
'admin_username' => 'admin@yourcompany.com', // Admin felhasználó
'admin_password' => 'YourPassword123',       // Admin jelszó

// Adatbázis Beállítások (ha szükséges)
'db_host' => '127.0.0.1',                   // MySQL szerver
'db_database' => 'snipeit',                  // Adatbázis név
'db_username' => 'root',                     // MySQL felhasználó
'db_password' => '',                         // MySQL jelszó
```

### 2. Lépés: Konfiguráció Ellenőrzése

A batch fájlok automatikusan ellenőrzik, hogy a konfigurációs fájl létezik-e és helyesen van-e beállítva.

### 3. Lépés: Fájl Elhelyezés Ellenőrzése

```bash
# Navigálj a Snipe-IT mappába
cd [SNIPE-IT_GYÖKÉR_MAPPA]

# Ellenőrizd, hogy minden fájl a helyén van
dir ldaps_config.php
dir auto_ldaps_startup.php
dir complete_ldaps_setup.php
dir ensure_ldaps_persistence.php
dir snipe_ldaps_complete_setup.bat
dir snipe_ldaps_startup.bat

# Ha hiányzik valami, másold át:
copy "C:\Users\leven\Desktop\ldap_fix\*.php" .
copy "C:\Users\leven\Desktop\ldap_fix\*.bat" .
```

## Gyors Javítás (Egyszerű Használat)

### 1. Automatikus LDAPS Beállítás

Ha teljesen új beállítást szeretnél, futtasd ezt a parancsot:

```batch
snipe_ldaps_complete_setup.bat
```

Ez a script:
- Ellenőrzi és létrehozza a `.env` fájlt
- Beállítja az összes LDAPS konfigurációt
- Teszteli a kapcsolatot
- Megjeleníti a bejelentkezési utasításokat

### 2. Gyors LDAPS Indítás

Ha már volt beállítás, de újra kell indítani XAMPP után:

```batch
snipe_ldaps_startup.bat
```

## Részletes Javítási Lépések

### 1. Lépés: Környezet Ellenőrzése

```bash
# Navigálj a Snipe-IT mappába
cd [SNIPE-IT_GYÖKÉR_MAPPA]

# Ellenőrizd, hogy a szükséges fájlok léteznek
dir *.php
dir *.bat
```

### 2. Lépés: Teljes LDAPS Beállítás Futtatása

```bash
php complete_ldaps_setup.php
```

Ez a script a következőket végzi el:

#### A) .env Fájl Ellenőrzése és Létrehozása
- Ellenőrzi a `.env` fájl létezését
- Ha nincs, létrehozza a megfelelő LDAPS beállításokkal
- Beállítja az Active Directory kapcsolatot

#### B) APP_KEY Generálása
- Ellenőrzi az alkalmazás kulcsot
- Ha szükséges, jelzi a generálás szükségességét

#### C) Konfigurációs Cache Törlése
- Törli a Laravel konfigurációs cache-t
- Biztosítja, hogy az új beállítások érvénybe lépjenek

#### D) LDAPS Beállítások Alkalmazása
- Beállítja az adatbázisban tárolt LDAPS konfigurációt
- Konfigurálja az Active Directory mezőket

#### E) Kapcsolat Tesztelése
- Teszteli a LDAPS kapcsolatot
- Megjeleníti a kapcsolat állapotát

### 3. Lépés: Automatikus Indítás Beállítása

```bash
php auto_ldaps_startup.php
```

Ez a script:
- Ellenőrzi a jelenlegi LDAPS beállításokat
- Ha szükséges, javítja a konfigurációt
- Teszteli a kapcsolatot

### 4. Lépés: Persisztencia Ellenőrzése

```bash
php ensure_ldaps_persistence.php
```

Ez a script:
- Ellenőrzi, hogy a beállítások megmaradnak-e újraindítás után
- Javítja a problémákat, ha vannak
- Teszteli a kapcsolat stabilitását

## Konfigurációs Paraméterek

### LDAPS Szerver Beállítások
- **Szerver**: Konfigurációs fájlból (`ldaps_config.php`)
- **Port**: `636` (LDAPS) - konfigurálható
- **TLS**: `false` (LDAPS használata) - konfigurálható
- **Tanúsítvány ellenőrzés**: `ignorálva` - konfigurálható
- **Base DN**: Konfigurációs fájlból

### Active Directory Beállítások
- **AD Domain**: Konfigurációs fájlból
- **Admin felhasználó**: Konfigurációs fájlból
- **Felhasználónév mező**: `sAMAccountName` - konfigurálható
- **Auth szűrő**: `sAMAccountName=` - konfigurálható

### Mező Leképezések
- **Keresztnév**: `givenName`
- **Vezetéknév**: `sn`
- **Email**: `mail`
- **Telefon**: `telephoneNumber`
- **Beosztás**: `title`
- **Osztály**: `department`
- **Menedzser**: `manager`
- **Helyszín**: `physicalDeliveryOfficeName`
- **Ország**: `c`
- **Alkalmazotti szám**: `employeeNumber`

## Bejelentkezési Utasítások

### Felhasználói Bejelentkezés
A felhasználók a következő módon jelentkezhetnek be:

1. **Nyisd meg a Snipe-IT weboldalt**: `http://localhost/snipe-it`
2. **Használd az Active Directory felhasználónevedet**:
   - `Administrator`
   - `admin`
   - `[bármely érvényes AD felhasználónév]`
3. **Add meg az AD jelszavadat**

### Rendszer Működése
- A rendszer LDAPS-en keresztül kapcsolódik (konfigurált port)
- Figyelmen kívül hagyja az SSL tanúsítvány validációt (konfigurálható)
- Keres a teljes konfigurált domainben
- Megjeleníti a felhasználókat a megfelelő nevekkel és attribútumokkal

## Hibaelhárítás

### Gyakori Problémák

#### 1. "LDAPS connection failed" vagy "Can't contact LDAP server" hiba
**Megoldás**:
```bash
# Ellenőrizd a hálózati kapcsolatot
ping YOUR_SERVER_IP

# Teszteld a LDAP kapcsolatot részletesen
php test_ldap_connection.php

# Ellenőrizd a MySQL szolgáltatást
# XAMPP Control Panel -> MySQL -> Start

# Ellenőrizd a konfigurációs fájlt
# Szerkeszd a ldaps_config.php fájlt

# Futtasd újra a teljes beállítást
php complete_ldaps_setup.php
```

**Gyakori okok**:
- ❌ Szerver nem elérhető a hálózaton
- ❌ Tűzfal blokkolja a 636-os portot
- ❌ LDAP szolgáltatás nem fut a szerveren
- ❌ Hibás admin felhasználónév/jelszó
- ❌ Hibás szerver cím vagy port

#### 2. "No settings found" hiba
**Megoldás**:
```bash
# Ellenőrizd az adatbázis kapcsolatot
# XAMPP Control Panel -> MySQL -> Start

# Futtasd a teljes beállítást
php complete_ldaps_setup.php
```

#### 3. "APP_KEY needs to be generated" figyelmeztetés
**Megoldás**:
```bash
php artisan key:generate
php complete_ldaps_setup.php
```

#### 4. Bejelentkezési problémák
**Ellenőrizd**:
- A felhasználónév helyes-e (sAMAccountName)
- Az AD jelszó helyes-e
- A felhasználó létezik-e az Active Directoryban
- A felhasználó aktív-e

#### 5. "The system cannot find the path specified" hiba
**Megoldás**:
```bash
# Ellenőrizd, hogy a fájlok a helyes mappában vannak
cd [SNIPE-IT_GYÖKÉR_MAPPA]
dir *.php
dir *.bat

# Ha hiányoznak, másold át:
copy "C:\Users\leven\Desktop\ldap_fix\*.php" .
copy "C:\Users\leven\Desktop\ldap_fix\*.bat" .

# Ellenőrizd a Snipe-IT telepítést
dir vendor\autoload.php
dir bootstrap\app.php
```

#### 6. "ldaps_config.php not found" hiba
**Megoldás**:
```bash
# Másold át a konfigurációs fájlt
copy ldaps_config_example.php ldaps_config.php

# Szerkeszd a beállításokat
notepad ldaps_config.php
```

### Naplófájlok Ellenőrzése

```bash
# Laravel naplók
tail -f storage/logs/laravel.log

# Apache hiba naplók
tail -f [XAMPP_PATH]\apache\logs\error.log

# MySQL hiba naplók
tail -f [XAMPP_PATH]\mysql\data\*.err
```

## Automatikus Indítás Beállítása

### Windows Feladatütemező

1. **Nyisd meg a Feladatütemezőt** (Task Scheduler)
2. **Hozz létre egy új feladatot**:
   - **Név**: "Snipe-IT LDAPS Startup"
   - **Trigger**: "At startup" vagy "At log on"
   - **Action**: "Start a program"
   - **Program**: `[SNIPE-IT_PATH]\snipe_ldaps_startup.bat`

### XAMPP Indítási Script

Hozz létre egy `xampp_startup.bat` fájlt:

```batch
@echo off
echo Starting XAMPP services...
[XAMPP_PATH]\xampp_start.exe

echo Waiting for services to start...
timeout /t 30

echo Running LDAPS startup...
cd /d "[SNIPE-IT_PATH]"
php auto_ldaps_startup.php

echo XAMPP and LDAPS startup complete!
pause
```

## Biztonsági Megjegyzések

### Tanúsítvány Kezelés
- A jelenlegi beállítás figyelmen kívül hagyja az SSL tanúsítvány validációt
- Éles környezetben javasolt a megfelelő tanúsítványok használata

### Jelszó Biztonság
- Az admin jelszó titkosítva van tárolva
- Rendszeres jelszó váltás javasolt
- Használj erős jelszavakat

### Hálózati Biztonság
- Győződj meg róla, hogy a 636-os port biztonságosan elérhető
- Használj tűzfal szabályokat
- Rendszeres biztonsági frissítések

## Támogatás és Hibaelhárítás

### További Segítség
Ha problémák merülnek fel:

1. **Ellenőrizd a hibaüzeneteket** a futtatott scriptekben
2. **Nézd meg a naplófájlokat** a fenti útmutatás szerint
3. **Teszteld a hálózati kapcsolatot** a szerverrel
4. **Futtasd újra a teljes beállítást** ha szükséges

### Script Futtatási Sorrend
1. `complete_ldaps_setup.php` - Teljes beállítás
2. `auto_ldaps_startup.php` - Gyors indítás
3. `ensure_ldaps_persistence.php` - Persisztencia ellenőrzés

### Sikeresség Ellenőrzése
A scriptek sikeres futtatása után látnod kell:
- ✅ zöld pipákat a konfigurációs lépéseknél
- ✅ "LDAPS connection test successful!" üzenetet
- ✅ Bejelentkezési utasításokat

---

## 📝 Konfigurációs Fájl Teljes Listája

A `ldaps_config.php` fájlban a következő beállításokat módosíthatod:

### Szerver Beállítások
- `server` - LDAP szerver címe vagy IP
- `port` - LDAPS port (általában 636)
- `base_dn` - Base DN (pl: DC=company,DC=com)
- `domain` - Active Directory domain név

### Admin Beállítások
- `admin_username` - Admin felhasználó teljes neve
- `admin_password` - Admin jelszó

### LDAP Beállítások
- `username_field` - Felhasználónév mező (általában sAMAccountName)
- `auth_filter` - Auth szűrő
- `ldap_version` - LDAP verzió (általában 3)
- `tls` - TLS használata (LDAPS esetén false)
- `cert_ignore` - Tanúsítvány ellenőrzés kihagyása

### Mező Leképezések
- `field_mappings` - Active Directory mezők leképezése

### Adatbázis Beállítások
- `db_host` - MySQL szerver
- `db_database` - Adatbázis név
- `db_username` - MySQL felhasználó
- `db_password` - MySQL jelszó

### Alkalmazás Beállítások
- `app_name` - Alkalmazás neve
- `app_url` - Alkalmazás URL
- `app_env` - Környezet (production/development)
- `app_debug` - Debug mód

---

**Fontos**: Szerkeszd a `ldaps_config.php` fájlt a saját szerver és domain beállításaidhoz a scriptek futtatása előtt!
