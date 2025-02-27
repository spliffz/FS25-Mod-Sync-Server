# FS25 Mod Sync Server - readme.md
###### v1.1.5

**Farming Simulator 25 Mod Sync Server**

A Web Application for use in combination with the [FS25 Sync Tool](https://github.com/spliffz/FS25-Sync-Tool).

![FS25 Mod Sync Tool by Spliffz](http://fs25.rotjong.xyz/githubpage/FS25-mss-02.png)   

---

#### Discord: [https://discord.gg/cxs9hcE2X6](https://discord.gg/cxs9hcE2X6)   


[<img src="https://cdn.buymeacoffee.com/buttons/v2/default-yellow.png">](https://www.buymeacoffee.com/Spliffz)

### [Features]
 - ## **Also for use with Farming Simulator 22 (FS22)!**
 - Easy, lightweight Admin Interface
 - Drag and Drop mod uploads
 - Import your mods directly from your GPortal server!
 - Upload new mods also directly your GPortal server.
 - My everlasting gratitude for using my software!

### [How It Works]
This is the backend for [FS25 Sync Tool](https://github.com/spliffz/FS25-Sync-Tool).   
This will allow you to upload, manage and synchronize your Farming Simulator mods amongst your friends or users.     
If the FS25-Sync-Tool finds new or updated mods it downloads them from the server synchronizing both mod folders.   
Every added mod will be indexed and ready for sync.   
Every deleted mod will not be deleted on the client/user. This is by design so it won't corrupt any savegames.   

### [Requirements]
  - If you already run a dedicated/vps for FS25/22 dedicated server you can run this next to it.
  - If you run a hosted FS25/22 server solution you need to run this on a seperate server.
  - A webserver with PHP 8.2 and MySQL on a VPS, dedicated server or Docker instance.
  I recommend docker. I've included a simple docker setup, located in `/INSTALL/DOCKER`. Edit as needed.
  - Enough space to host all the mods you want.


### [Installation (Based on a Linux Webserver)]
 * Download or clone the repo to your server/docker instance.
   It can be in a directory or under a subdomain.
   Aslong as it can be visited from the internet.
 * Edit `core/includes/config.inc.php`. This is your SQL Config.
 * Edit `core/includes/defines.inc.php`. This is the rest config.
 * Edit `core/js/main.js`, change the `baseUrlDomain` value. This should reflect your domainname/ip.
 * Give write permissions to the following folders:   
 `/mods`   
 `/layout/cache`   
 `/layout/templates_c`   
 `/temp`   
```
root@f9891079ea0b:/var/www/html# chown -R www-data:www-data mods/
root@f9891079ea0b:/var/www/html# chmod -R 775 mods/
```
[Thanks dsmitty166](https://github.com/spliffz/FS25-Mod-Sync-Server/issues/1#issuecomment-2568100652)

### Docker Installation (Based on a Linux Webserver)

1. Clone the repository: `git clone https://github.com/spliffz/FS25-Mod-Sync-Server.git`
2. Navigate to the Docker Compose files: `cd FS25-Mod-Sync-Server/INSTALL/DOCKER`
3. Edit configuration files as needed:
   - Edit Docker Compose: `nano fs25-sync-storage-server.yaml` (Pay attention to the volume mounts)
   - SQL configuration: `nano core/includes/config.inc.php`
   - General configuration: `nano core/includes/defines.inc.php`
   - Update the `baseUrlDomain` in `core/js/main.js` to match your domain or IP.
4. Start the Docker containers: `docker compose -f fs25-sync-storage-server.yaml up -d`
5. Create required folders: `mkdir -p /opt/FS25-Mod-Sync-Server/layout/cache /opt/FS25-Mod-Sync-Server/layout/templates_c`
6. Set write permissions:
```
docker exec -it fs25-php-apache chown -R www-data:www-data mods
docker exec -it fs25-php-apache chown -R www-data:www-data layout/cache
docker exec -it fs25-php-apache chown -R www-data:www-data layout/templates_c
docker exec -it fs25-php-apache chown -R www-data:www-data temp
docker exec -it fs25-php-apache chmod -R 775 mods
docker exec -it fs25-php-apache chmod -R 775 layout/cache
docker exec -it fs25-php-apache chmod -R 775 layout/templates_c
docker exec -it fs25-php-apache chmod -R 775 temp
```

7. Stop and Start Docker
```
docker compose -f fs25-sync-storage-server.yaml down && docker compose -f fs25-sync-storage-server.yaml up -d
```
8. Open `YOURWEBSERVERDOMAIN.COM/acp` in your browser and follow the installation steps. Check and edit the info where needed. Click `Install` when ready.   
 * After Installing open `YOURWEBSERVERDOMAIN.COM/acp` in your browser and log in with `admin // changeme`. If you put it in a subfolder then just include it like so `YOURWEBSERVERDOMAIN.COM/fs25Mods/acp` or `fs25mods.YOURWEBSERVERDOMAIN.COM`
    - ### **Don't forget to update the password once you're done!**

 9. Set up a cronjob for automated indexing:   
```
*/5 * * * * docker exec -it fs25-php-apache php -f /var/www/html/check.php
```
 where PATH_TO_YOUR_MODSERVER is something like `/var/www/html` or `/public_html`.

10. If you want to upload large files then make sure these php.ini variables are configured properly:   
`upload_max_filesize`, `post_max_size`
   - Edit docker compose uncomment mountpoint for custom-uploads.ini `/usr/local/etc/php/conf.d/custom-uploads.ini`
   - Create `custom-uploads.ini`
```
nano /opt/FS25-Mod-Sync-Server/custom-uploads.ini```
```
```
upload_max_filesize = 4096
post_max_size = 4096
max_file_uploads = 50
```
**It might be that php.ini doesn't exist yet on a default installation.**   
**If it doesn't exist you need to:**   
```
cd /usr/local/etc/php
cp php.ini-production php.ini
nano php.ini
```
We've included a basic production ready php.ini with all the right values for handling large files.   

### [To Update:]
- Download or clone the repo as usual. If downloaded then unzip the file into your webserver folder where the modserver is located.
- You might have to update the MySQL/MariaDB Database.
  Check the changelog of the corresponding version to see what needs to be done. See `changelog.md`.
   
Until I fix an auto-update or another update method you'll have to do these manually.
Sorry bout that.

### [Endpoints]
 * `/ajax.php?getModList` - Return: Array
 * `/ajax.php?checkMod&modname=MOD_NAMEmodhash=HASH_HERE&modsize=SIZE_HERE` - Return: Array   
 * `/check.php` - Runs Indexer. Return: Array

### [Build with]
 * PHP
 * Smarty.net template parser
 * JQuery & Bootstrap



### [Changelog]
[v1.1.5]
- added favicon!
- some garbage collected. unneeded functions are unneeded

[v1.1.4]
- New feature: Upload to GPortal on mod upload. When uploading new mods to the server you can now specify if you also want it to upload to your GPortal Server. Upload Once, Save Twice ;)
- Increased the max files for uploading to 10.
- Increased the max file size for uploading file to 4096MB per file.

[v1.1.3]
- New Feature: Import from GPortal. You can now import all your active mods directly from your GPortal server!
- Added FS RestAPI CareerSavegame Link form input, so you can just set it in the GUI instead of the php file.
- Added Standalone GPortal Importer scripts: `importer.php`. Run and set it up like check.php with cronjob.

[v1.1.2]
 - added index page (index.tpl/index.php)
