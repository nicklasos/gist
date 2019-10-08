#!/usr/bin/env bash

db_file_name="GeoLite2-Country.mmdb"
tmp_db_file_name="GeoLite2-Country.mmdb.tmp"

download_file="GeoLite2-Country.mmdb.gz"
download_url="http://geolite.maxmind.com/download/geoip/database/${download_file}"

swap() {
    local tmp_file=tmp.$$
    mv "$1" ${tmp_file}
    mv "$2" "$1"
    mv ${tmp_file} "$2"
}

rm_file() {
    [[ -f ${1} ]] && rm ${1}
}

wget -q -O ${download_file} ${download_url}
if [[ $? -ne 0 ]]; then
    echo "Failed to download geo db file"
    rm_file ${download_file}
    exit 1;
fi

gunzip -c -q ${download_file} > ${tmp_db_file_name}
if [[ $? -ne 0 ]]; then
    echo "Failed to extract geo db file"
    rm_file ${download_file}
    rm_file ${tmp_db_file_name}
    exit 1;
fi

if [[ -f "$db_file_name" ]]; then
    swap ${tmp_db_file_name} ${db_file_name}
else
    mv ${tmp_db_file_name} ${db_file_name}
fi

rm_file ${download_file}
rm_file ${tmp_db_file_name}
