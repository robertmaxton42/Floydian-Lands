# Floydian-Lands
Forever wandering minds play IF together.

TODO:

  Enumerate TODOs in
    process.php
    chat.js
    index.php
  Add admin controls - clear logs, backup logs.
    (saves us from having to chown the logs every time)

For deploy: set up remote at	ssh://root@vps50031.vps.ovh.ca/root/Floydian-Lands/site.git
Pushing to this remote will copy the files to another directory on the server (using post-receive)
The web server runs from this directory. In theory.
