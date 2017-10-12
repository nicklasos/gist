#!/bin/bash

function valid_ip()
{
    local  ip=$1
    local  stat=1

    if [[ $ip =~ ^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$ ]]; then
        OIFS=$IFS
        IFS='.'
        ip=($ip)
        IFS=$OIFS
        [[ ${ip[0]} -le 255 && ${ip[1]} -le 255 \
            && ${ip[2]} -le 255 && ${ip[3]} -le 255 ]]
        stat=$?
    fi
    return $stat
}

# Make sure only root can run our script
if [ "$(id -u)" != "0" ]; then
   echo "This script must be run as root"
   exit 1
fi

ip=$1
if valid_ip $ip; then {
        sed -i "/DROP/i -A INPUT -s $ip   -i eth0 -m state --state NEW,ESTABLISHED -j ACCEPT" /etc/iptables/rules.v4
        service iptables-persistent reload
        }
        else echo "ERROR: $ip is not a valid IP."
fi
echo $stat