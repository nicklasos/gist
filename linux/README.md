# Linux

Show biggest folders
```bash
cd /var/www
du -hsx * | sort -rh | head -10
```

Remove files from subfolders
```bash
find . -name "*.png" -type f -delete
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

## Fail2Ban
Status
```bash
fail2ban-client status nginx-limit-req
```

Iptables banned amount of ip
```bash
iptables -S | grep 'limit-req -s' | wc -l
```

Nginx
```
# http section
limit_req_zone $binary_remote_addr zone=lr_zone:10m rate=10r/s;
limit_req_status 444;

# location
limit_req zone=lr_zone burst=10 nodelay;

# mobile detect
set $mobile_rewrite do_not_perform;
 
## chi http_user_agent for mobile / smart phones ##
if ($http_user_agent ~* "(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino") {
  set $mobile_rewrite perform;
}
 
if ($http_user_agent ~* "^(1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-)") {
  set $mobile_rewrite perform;
}
 
## redirect to m.example.com ##
if ($mobile_rewrite = perform) {
  rewrite ^ http://m.example.com$request_uri? redirect;
  break;
}
```
