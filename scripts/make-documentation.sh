#!/bin/bash

set -e

REPOSITORY_ROOT="$(dirname $0)/../"
BUILD_ROOT="${REPOSITORY_ROOT}/build"

function downloadRelease() {
    rm -f "${BUILD_ROOT}/doctum.phar"
    curl -# -o "${BUILD_ROOT}/doctum.phar" -O https://doctum.long-term.support/releases/5.1/doctum.phar
}

function checkRelease() {
    if [ -f "${BUILD_ROOT}/doctum.phar" ]; then
        curl -s -o "${BUILD_ROOT}/doctum.phar.sha256" -O https://doctum.long-term.support/releases/5.1/doctum.phar.sha256
        cd "${BUILD_ROOT}/"
        sha256sum --check --strict doctum.phar.sha256
        cd - > /dev/null
        if [ "$?" != "0" ]; then
            downloadRelease
        else
            echo 'You are using the latest 5.1 release of Doctum.'
        fi
    else
        downloadRelease
    fi
}

function buildDocumentation() {
    php "${BUILD_ROOT}/doctum.phar" update --ignore-parse-errors -vvv --force "${REPOSITORY_ROOT}/scripts/doctum.php"
    find "${REPOSITORY_ROOT}doc" -type f -name ".delete-me" -delete
    rm "${REPOSITORY_ROOT}doc/renderer.index"
    rm "${REPOSITORY_ROOT}doc/PROJECT_VERSION"
    rm "${REPOSITORY_ROOT}doc/DOCTUM_VERSION"
}

checkRelease

buildDocumentation