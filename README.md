# Olimp Sport — trgovina za sportsku opremu

Projekt iz kolegija **Programiranje web aplikacija**. 
Web sjedište trgovine sportskom opremom


### Pokretanje aplikacije (XAMPP)

1. Instaliraj i pokreni **XAMPP** (Apache + MySQL).
2. Cijelu mapu projekta kopiraj u `C:\xampp\htdocs\sportoprema`.
3. Slike su već u mapi `img/`. Provjeri da Apache ima pravo pisanja u `img/`
   (zbog uploada novih slika kroz formu).
4. Otvori **phpMyAdmin** (`http://localhost/phpmyadmin`) → kartica **Import** →
   odaberi `baza.sql` → **Go**. Time se kreira baza `olimp_sport`, tablice
   `vijesti` i `korisnik`, te početni podaci.
5. U pregledniku otvori: `http://localhost/sportoprema/index.php`

> Ako koristiš drugo ime baze ili lozinku za MySQL, izmijeni podatke u
> `connect.php`.

---

## Prijava u administraciju

Na stranici **Administracija** koristi jedan od početnih računa iz baze:

| Korisničko ime | Lozinka  | Razina | Što vidi                         |
|----------------|----------|--------|----------------------------------|
| `admin`        | `admin123` | 1 (admin) | uređivanje i brisanje proizvoda |
| `pero`         | `user123`  | 0 (običan) | poruku da nema ovlasti        |

Novi korisnici registriraju se na stranici **registracija.php** (dobivaju razinu 0).
Da bi novi korisnik postao administrator, promijeni mu `razina` na `1` direktno u bazi.



## Kategorije

Trgovina koristi tri kategorije proizvoda: **Nogomet**, **Košarka**, **Fitness**.
Kategorije se pojavljuju u navigaciji i vode na `kategorija.php`. Proizvodi
označeni kao *arhivirani* (`arhiva = 1`) spremaju se u bazu, ali se NE prikazuju
na naslovnici ni na stranici kategorije (vidljivi su samo u administraciji).
