# Linux

Show biggest folders
```bash
cd /var/www
du -hsx * | sort -rh | head -10
```

Grep with awk
```bash
tail -f /var/log/nginx/access.log | awk '/200/ {print $9" "$7}'
```

Set vim as default ediotr
```bash
sudo update-alternatives --config editor
```
<br>

Find all files with chmod not 0777
```bash
find . -type d \! \( -perm 0777 \)
```
<br>

Recur rename file extensions
```bash
for X in `find . -name "*.caf"` 
do
 mv $X ${X/.caf/.aac}
done
```
<br>

Count files in folder
```bash
find . -type f | wc -l
```
<br>

Set timezone
```bash
cp /usr/share/zoneinfo/Europe/Kiev /etc/localtime
```
<br>

Show size of folder in folder
```bash
/var/www/Backend/storage# du -sh ./*

1.8G	./files
4.7G	./offline
11G	./releases
1016M	./screenshots
3.7M	./tmp
1.3G	./trash
```
<br>

Format disk
```bash
fdisk -l
cfdisk /dev/sdb
mkfs.ext4 /dev/sdb1
mkdir /disk2
blkid
echo "UUID=359d90df-f17a-42f6-ab13-df13bf356de7 /disk2 ext4 errors=remount-ro 0 1" >> /etc/fstab
mount /disk2
```

Show config
```bash
cat /etc/fstab
UUID=a4ad2b8b-0613-4230-9eb9-a82945cc16cf / ext4 defaults 1 1
UUID=51cc388c-fd08-4182-998f-a4c979648a08 /data xfs defaults,noatime 0 2
```
<br>

Mount disk
```bash
mount -t ext4 /dev/sdc1 /data2
```
<br>

Run multiple commands in background and terminate all on Ctrl+C
```bash
php -S localhost:3001 -t public/ & php -S localhost:3000 -t scripts/proxy/ & redis-server; fg
```
<br>

Group logs by
```bash
cat /home/root/.pm2/logs/error.log | grep -oP 'There was an error (.*)'
```

History commands count
```bash
history | awk '{print $2}' | sort | uniq -c | sort -rn | head
```
