import subprocess
import time

print("Fiscalization Watcher started");

while True:
    process = subprocess.Popen("/usr/local/phpfarm/inst/php-8.1.21/bin/php artisan app:fiscalize", shell=True)
    process.wait()

    time.sleep(1)
