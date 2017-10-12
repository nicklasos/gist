#!/usr/bin/env bash

REGEX="\sdd\((.*)\);|\/\/\sREMOVE"

DD=$(egrep -r ${REGEX} ./app)

if [[ ${DD} ]]
then
    echo "$DD"
    exit 1
fi
