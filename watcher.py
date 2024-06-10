import subprocess
import time

print("Fiscalization Watcher started");

while True:
    process = subprocess.Popen("php-8.1 artisan app:fiscalize", shell=True)
    process.wait()

    time.sleep(1)
