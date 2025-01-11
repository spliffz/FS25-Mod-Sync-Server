[Changelog]

[v1.1.3]
- If you're updating from 1.1.2 you need to do this:
    - Run PHPMyAdmin (or your preferred tool) and do the following:
    - import the following .sql file `INSTALL\IMPORT\update_v113.sql`

**OR**

In Table: `settings`
Add: 
```
`ftp_host` varchar(255) NOT NULL DEFAULT '',
`ftp_port` int NOT NULL DEFAULT '21',
`ftp_user` varchar(255) NOT NULL DEFAULT '',
`ftp_pass` varchar(255) NOT NULL DEFAULT '',
`ftp_path` varchar(255) NOT NULL DEFAULT '/profile/mods',
`fs_restapi_careerSavegame` varchar(255) NOT NULL DEFAULT ''
```   

Until I fix an auto-update or another update method you'll have to do these manually.   
Sorry bout that.
