# 📅 Laravel Calendar App

Un'applicazione di **Calendario** realizzata con **Laravel**, progettata per la gestione di eventi e appuntamenti in modo semplice ed efficiente.

## 🎥 Demo Online
🔗 **[Guarda la Demo](https://calendar.simonebuccolieri.com)**

---

## 📦 Installazione e Configurazione

### **1️⃣ Clonare il Repository**
```sh
git clone https://github.com/simonebuccolieri/laravel-calendar.git
cd laravel-calendar
```
### **2️⃣ Installare le Dipendenze**
```sh
composer install
npm install
```
### **3️⃣ Configurare il File .env**
```sh
cp .env.example .env
```
*Modificare il file .env*
```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=calendar_db
DB_USERNAME=root
DB_PASSWORD=rootpassword

```
### **4️⃣ Generare la Chiave dell'App**
```sh
php artisan key:generate
```
### **5️⃣ Creare il Database e le Tabelle**
```sh
php artisan migrate --seed
```
### **6️⃣ Build Frontend**
```sh
npm run build
```
## 🚀 Avvio dell'Applicazione

### **Avvia il Server Laravel (Locale)**
Se vuoi testare il progetto in locale, esegui:
```sh
php artisan serve
```
Ora puoi accedere all'app su: http://127.0.0.1:8000.

## 🛠️ Tecnologie Utilizzate
- **Laravel 10** ⚙️ - Framework PHP potente per il backend
- **MySQL** 🗄️ - Database per la gestione degli eventi
- **Tailwind CSS** ✨ - Stile moderno e responsive
- **Nginx** 🌍 - Web server ottimizzato per la produzione
- **Vite** ⚡ - Build tool ultra veloce per il frontend

## 🚀 Funzionalità
✅ **Gestione eventi**: Creazione, modifica e cancellazione eventi  
✅ **Vista settimanale/mensile**: Navigazione intuitiva tra settimane e mesi  
✅ **Colori personalizzati**: Associa colori distintivi agli eventi  
✅ **Autenticazione**: Login e gestione utenti con Laravel Breeze/Sanctum  
✅ **Notifiche**: Invio di promemoria via e-mail *(Work in progress)*  
✅ **Ottimizzato per la produzione**: Cache, minificazione asset e configurazione server  
